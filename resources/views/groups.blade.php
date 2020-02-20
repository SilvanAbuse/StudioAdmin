@extends('layouts.admin.main')

@section('content')
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
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
                <div class="col-lg-8">
                    <h2>Список групп</h2>
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
                            <a href="/admin/groups/">Группы</a>
                        </li>
                        <li class="active">
                            <strong>Список групп</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4 text-right">
					@if (Auth::user()->has_right('groups/add'))
					<a href="/admin/groups/add" class="btn btn-danger" style="margin-top: 30px;">Создать группу</a>
					@endif
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			<form action="{{ route('admin_cats') }}" method="GET">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">ID</th>
									<th data-toggle="true">Название</th>
									<th data-toggle="true">Кто создал</th>
									<th data-toggle="true">Статус</th>
									<th data-toggle="true">Дата создания</th>
									<th data-toggle="true">Дата изменения</th>
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if (Auth::user()->has_right('groups') or Auth::user()->has_right('groups/'))
									@if ($list->count())
										@foreach ($list as $key => $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ ($key+1) }}</td>												
												<td class="footable-visible"><a href="/admin/groups/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible">
													@if ($record->created_by == 15)
														<a href="/admin/emp/info/5">Тест (Администратор)</a>
													@else
														{!! $record->created_by_ !!}
													@endif
												</td>
												<td class="footable-visible">
													@if ($record->status == 'active')
														<span class="badge badge-success">Активная</span>
													@endif
													@if ($record->status == 'pause')
														<span class="badge badge-warning">На паузе</span>
													@endif
													@if ($record->status == 'deleted')
														<span class="badge badge-danger">Удалена</span>
													@endif													
												</td>
												<td class="footable-visible">
													{{ date('d.m.Y - H:i', strtotime($record->created_at)) }}
												</td>
												<td class="footable-visible">
													{{ date('d.m.Y - H:i', strtotime($record->updated_at)) }}
												</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group">
														<a href="/admin/groups/edit/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-pencil"></i></a>
														<a href="/admin/delete_record/groups/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-close"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif
									@else
										<tr><td>Нет прав!</td></tr>
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
				<div class="col-lg-12">
					
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