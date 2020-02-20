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
                <div class="col-lg-10">
                    <h2>Плейлист {{ $rec->name }}</h2>
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
                            <a href="/admin/playlist">Плейлисты</a>
                        </li>
                        <li class="active">
                            <strong>Плейлист {{ $rec->name }}</strong>
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
							<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
							<tr>
								<td>Название плейлиста</td>
								<td>{{ $rec->name }}</td>
							</tr>
							<tr>
								<td>Кто создал</td>
								<td>{!! $created_user_name !!}</td>
							</tr>
							<tr>
								<td>Статус</td>
								<td>
									@if ($rec->status == 'active')
										<span class="badge badge-success">Активный</span>
									@endif
									@if ($rec->status == 'pause')
										<span class="badge badge-warning">На паузе</span>
									@endif
									@if ($rec->status == 'deleted')
										<span class="badge badge-danger">Удалён</span>
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
								<td>Дата создания</td>
								<td>{{ date('d.m.Y - H:i', strtotime($rec->created_at)) }}</td>
							</tr>
							<tr>
								<td>Дата изменения</td>
								<td>{{ date('d.m.Y - H:i', strtotime($rec->updated_at)) }}</td>
							</tr>
							</table>
                        </div>
                    </div>
                </div>
				<div class="col-lg-12">
                    <a href="/admin/playlist/add/" class="btn btn-primary" style="background-color: #3c8dbb;border-color: #3c8dbb;">Создать плейлист</a>
					<a href="/admin/playlist/edit/{{ $rec->id }}" class="btn btn-primary">Изменить плейлист</a>
					<a href="/admin/delete_record/playlist/{{ $rec->id }}" class="btn btn-danger">Удалить плейлист</a>
					<br /><br />
				</div>
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-content">
							<h3>Звуки</h3>
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">#</th>
                                    <th data-toggle="true">Название звука</th>
									<th data-toggle="true">Расшифровка</th> 
									<th data-toggle="true">Дата добавления</th> 
                                </tr>
                                </thead>
                                <tbody>
									@if ($list->count())
										@foreach ($list as $key => $r)
											<tr>
												<td>{{ ($key + 1) }}</td>
												<td><a href="/admin/sounds/info/{{ $r->id }}">{{ $r->name }}</a></td>
												<td>{{ $r->dandzy }}</td>
												<td>{{ date('d.m.Y - H:i', strtotime($r->created_at)) }}</td>
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