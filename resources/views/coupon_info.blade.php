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
                    <h2>Купон {{ $rec->number }}</h2>
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
                            <a href="/admin/coupon/">Купоны / Подписки</a>
                        </li>
                        <li class="active">
                            <strong>Купон {{ $rec->number }}</strong>
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
								<td>№ купона</td>
								<td>{{ $rec->number }}</td>
							</tr>
							<tr>
								<td>Какой купон</td>
								<td>
									@if (is_array($opts['names']))
										@foreach ($opts['names'] as $pack)
											<span class="badge badge-info">{{ $pack }}</span>
										@endforeach
									@endif								
								</td>
							</tr>
							<tr>
								<td>Цена</td>
								<td>{{ $opts['price'] }} руб.</td>
							</tr>
							<tr>
								<td>Кто купил</td>
								<td><a href="/admin/users/info/{{ $rec->user_id }}">{{ $opts['user'] }}</a></td>
							</tr>
							<tr>
								<td>Статус купона</td>
								<td>
									@if ($rec->status == 'active')
										<span class="badge badge-success">Активный</span>
									@endif
									@if ($rec->status == 'pause')
										<span class="badge badge-warning">На паузе</span>
									@endif							
									@if ($rec->status == 'expires')
										<span class="badge badge-danger">Истекает</span>
									@endif
									@if ($rec->status == 'na')
										<span class="badge badge-primary">Неактивен</span>
									@endif
									@if ($rec->status == 'ended')
										<span class="badge badge-danger">Закончен</span>
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
								<td>E-mail</td>
								<td>{{ $opts['email'] }}</td>
							</tr>
							<tr>
								<td>До какого числа действителен</td>
								<td>
									@if (strtotime($rec->date_expires))
										{{ date('d.m.Y - H:i', strtotime($rec->date_expires)) }}
									@else
										неизвестно
									@endif							
								</td>
							</tr>
							<tr>
								<td>Последний вход в систему</td>
								<td>
									@if (strtotime($opts['last']))
										{{ date('d.m.Y - H:i', strtotime($opts['last'])) }}
									@else
										неизвестно
									@endif								
								</td>
							</tr>
							<tr>
								<td>Дата активации</td>
								<td>
									@if (strtotime($rec->date_activated))
										{{ date('d.m.Y - H:i', strtotime($rec->date_activated)) }}
									@else
										неизвестно
									@endif								
								</td>
							</tr>
							</table>
                        </div>
                    </div>
                </div>
				<div class="col-lg-12">
					<a href="/admin/coupon/add" class="btn btn-success">Создать купон</a>
					<a href="/admin/coupon/edit/{{ $rec->id }}" class="btn btn-primary">Изменить купон</a>
					<a href="/admin/delete_record/coupon/{{ $rec->id }}" class="btn btn-danger">Удалить купон</a>
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