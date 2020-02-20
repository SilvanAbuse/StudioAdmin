@extends('layouts.admin.main')

@section('content')
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="/admin/trash"><i class="fa fa-trash"></i> Корзина</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-language"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li><a href="javascript:void(0);">Русский</a></li>
                            <li><a href="javascript:void(0);">English</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="logout_do">
                            <i class="fa fa-sign-out"></i> Выйти
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Сотрудник {{ $rec->name }}</h2>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-danger">{{ session('success') }}</div>
                @endif
                <ol class="breadcrumb">
                    <li>
                        <a href="/admin/">Панель администратора</a>
                    </li>
                    <li>
                        <a href="/admin/emp/">Сотрудники</a>
                    </li>
                    <li class="active">
                        <strong>Сотрудник {{ $rec->name }}</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <form action="{{ route('admin_cats') }}" method="GET">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                @if ($rec->avatar)
                                    <p style="text-align: center;"><img src="/{{ $rec->avatar }}" style="width: 250px;height: 250px;"></p>
                                @endif
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <tr>
                                        <td>Имя</td>
                                        <td>{{ $rec->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Роль в программе</td>
                                        <td>{{ $role }}</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td>
                                        <td><a href="mailto:{{ $rec->email }}">{{ $rec->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Кто дал доступ</td>
                                        <td>
											@if ($rec->created_by === '15')
                                                ADMINISTRATOR
											@else
                                                {!! $rec->invite_user_name !!}
											@endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <tr>
                                        <td>Статус</td>
                                        <td>
                                            @if ($rec->emp_status == 'active')
                                                <span class="badge badge-success">Активный</span>
                                            @endif
                                            @if ($rec->emp_status == 'pause')
                                                <span class="badge badge-warning">На паузе</span>
                                            @endif
                                            @if ($rec->emp_status == 'deleted')
                                                <span class="badge badge-danger">Удалён</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Доступ предоставлен</td>
                                        <td>{{ date('d.m.Y - H:i', strtotime($rec->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Личный код</td>
										@if ($rec->id == 15)
											<td>[0][000][0000]</td>
										@else
											<td>[{{ $_role['id'] }}][{{ $rec->invite_id }}][{{ $rec->unique_id }}]</td>
										@endif
                                    </tr>
									<tr>
										<td>Адрес</td>
										<td>{{ $rec->address }}</td>
									</tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="padding-bottom: 20px;">
                        <a href="/admin/emp/add" class="btn btn-success">Добавить сотрудника</a>
                        <a href="/admin/emp/edit/{{ $rec->id }}" class="btn btn-primary">Изменить информацию</a>
                    </div>


                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <thead>
                                    <tr>
                                        <th data-toggle="true">
                                            #
                                        </th>
                                        <th data-toggle="true">
                                            Имя
                                        </th>
                                        <th data-toggle="true">
                                            E-mail
                                        </th>
                                        <th data-toggle="true">Купон</th>
                                        <th data-toggle="true">Статус купона</th>
                                        <th data-toggle="true">Дата активации</th>
                                        <th data-toggle="true">Дата регистрации</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (Auth::user()->has_right('emp') or Auth::user()->has_right('emp/'))
                                        @if ($list->count())
                                            @foreach ($list as $key => $record)
												@continue;
                                                <tr class="footable-odd">
                                                    <td class="footable-visible">{{ ($key+1) }}</td>
                                                    <td class="footable-visible"><a
                                                                href="/admin/users/info/{{ $record->id }}">{{ $record->name }}</a>
                                                    </td>
                                                    <td class="footable-visible">{{ $record->email }}</td>
                                                    <td class="footable-visible">
                                                        @if (is_array($opts[$record->id]['names']))
                                                            @foreach ($opts[$record->id]['names'] as $pack)
                                                                <span class="badge badge-info">{{ $pack }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="footable-visible">
                                                        @if ($opts[$record->id]['coupon_status'] == 'active')
                                                            <span class="badge badge-success">Активный</span>
                                                        @endif
                                                        @if ($opts[$record->id]['coupon_status'] == 'pause')
                                                            <span class="badge badge-warning">На паузе</span>
                                                        @endif
                                                        @if ($opts[$record->id]['coupon_status'] == 'deleted')
                                                            <span class="badge badge-danger">Удалён</span>
                                                        @endif
                                                        @if ($opts[$record->id]['coupon_status'] == 'na')
                                                            <span class="badge badge-primary">Неактивен</span>
                                                        @endif
                                                        @if ($opts[$record->id]['coupon_status'] == 'ended')
                                                            <span class="badge badge-danger">Закончен</span>
                                                        @endif															
                                                    </td>
                                                    <td>
                                                        @if (strtotime($opts[$record->id]['date_activated']))
                                                        {{ date('d.m.Y - H:i', strtotime($opts[$record->id]['date_activated'])) }}
                                                        @else
                                                        &mdash;
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d.m.Y - H:i', strtotime($record->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>Нет данных!</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td>Нет прав!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


        </div>
        <div class="footer">
            <div class="pull-right">

            </div>
            <div>

            </div>
        </div>
    </div>
@endsection
