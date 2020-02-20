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
                    <a href="javascript:void(0);" class="logout_do">
                        <i class="fa fa-sign-out"></i> Выйти
                    </a>
                </li>
            </ul>
        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Список студий</h2>
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
                            <a href="/admin/studios">Студии</a>
                        </li>
                        <li class="active">
                            <strong>Список студий</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4 text-right">
					<a href="{{ route('admin_sadd') }}" class="btn btn-danger" style="margin-top: 30px;">Добавить</a>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
				<div class="col-lg-12">
					<form action="{{ route('admin_studios') }}" class="form form-inline">
						<div class="form-group">
							<input type="text" name="query" placeholder="Название, Телефон, Адрес..." value="{{ $search }}" class="form-control">
							<button type="submit" class="btn btn-default">Поиск</button> 
						</div>
					</form>
					<br />
				</div>			
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">#</th>
									<th data-toggle="true">Фото</th>
									<th data-toggle="true">Название</th>
									<th data-toggle="true">Телефон</th>
									<th data-toggle="true">Адрес</th>
									<th data-toggle="true">Сайт</th>
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if ($list->count())
										@foreach ($list as $key => $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>
												<td class="footable-visible">
													@if (!$record->photo)
														<div class="avatar avatar_empty"></div>
													@else
														<div class="avatar"><img src="/public/{{ $record->photo }}"></div>
													@endif
												</td>												
												<td class="footable-visible"><a href="/admin/studios/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible">{{ $record->phone }}</td>
												<td class="footable-visible">{{ $record->address }}</td>
												<td class="footable-visible">
													@if ($record->site)
														<a href="{{ $record->site }}" target="_blank">{{ $record->site }}</a>
													@else
														не указан
													@endif
												</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group">
														<a href="/admin/studios/edit/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-pencil"></i></a>
														<a href="/admin/delete_record/studios/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-close"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr><td colspan="5">Нет данных</td></tr>
									@endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="10">
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