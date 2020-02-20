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
                        <a href="javascript:void(0);" class="logout_do">
                            <i class="fa fa-sign-out"></i> Выйти
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Пользователь {{ $rec->name }}</h2>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-danger">{{ session('success') }}</div>
                @endif
                <ol class="breadcrumb">
                    <li>
                        <a href="/admin/users">Панель администратора</a>
                    </li>
                    <li>
                        <a href="/admin/users">Пользователи</a>
                    </li>
                    <li class="active">
                        <strong>Пользователь {{ $rec->name }}</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2 text-right">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <form action="" method="GET">
                <div class="row">
					<div class="col-lg-12">
						<div class="ava_block">
						<h3>Аватар</h3>
											@if ($rec->avatar)
												<div class="avatar"><img src="/public/{{ $rec->avatar }}"></div>
											@else
												<div class="avatar avatar_empty"></div>
											@endif
						</div>
					</div>
                    <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <tr>
                                        <td>Имя пользователя</td>
                                        <td>{{ $rec->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td>
                                        <td>
                                            <a href="mailto:{{ $rec->email }}">{{ $rec->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Телефон</td>
                                        <td>{{ $rec->phone }}</td>
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
                                        <td>Дата регистрации</td>
                                        <td>
                                            @if (strtotime($rec->registration_date))
                                                {{ date('d.m.Y - H:i', strtotime($rec->registration_date)) }}
                                            @else
                                                неизвестно
                                            @endif
                                        </td>
                                    </tr>								
                                    <tr>
                                        <td><strong>Токен</strong></td>
                                        <td>{{ $rec->token }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
						<a href="/admin/users/add" class="btn btn-success">Добавить пользователя</a>
                        <a href="/admin/users/edit/{{ $rec->id }}" class="btn btn-primary">Изменить пользователя</a>
                        <a href="/admin/delete_record/users/{{ $rec->id }}" class="btn btn-danger">Удалить</a>
                        <br/><br/>
                    </div>
					<div class="col-lg-12">
						<div class="ibox">
							<div class="ibox-content">
								<h3>Отзывы оставленные пользователем</h3>
								<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
									<tr>
										<th data-toggle="true">ID</th>
										<th data-toggle="true">Дата</th>
										<th data-toggle="true">Студия</th>
										<th data-toggle="true">Текст</th>
										<th data-toggle="true">Оценка</th>
									</tr>
									</thead>
									<tbody>
										@if ($list->count())
											@foreach ($list as $key => $record)
												<tr class="footable-odd">
													<td class="footable-visible">{{ $record->id }}</td>		
													<td class="footable-visible">{{ date('d.m.Y - H:i', strtotime($record->recall_date)) }}</td>
													<td class="footable-visible">{!! $record->studio !!}</td>
													<td class="footable-visible"><a href="/admin/reviews/edit/{{ $record->id }}">{{ $record->comment }}</a></td>
													<td class="footable-visible">
														<div class="rate_sel">
															@for ($a = 0; $a < $record->rating; $a++)
																<i class="fa fa-star"></i>
															@endfor
															@for ($a = 0; $a < $record->empty_stars; $a++)
																<i class="fa fa-star-o"></i>
															@endfor
														</div>
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
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
