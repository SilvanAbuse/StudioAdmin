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
					<h2>Корзина</h2>
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
                        <li class="active">Корзина</li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			<div class="row">
			<div class="col-lg-12">
				<div class="tabs-container">
					<ul class="nav nav-tabs" role="tablist">
						<li>
							<a href="#emp" data-toggle="tab" class="nav-link active" aria-expanded="true">Сотрудники</a>
						</li>
						<li>
							<a href="#users" data-toggle="tab" class="nav-link">Пользователи</a>
						</li>		
						<li>
							<a href="#coupon" data-toggle="tab" class="nav-link">Купоны / Подписки</a>
						</li>
						<li>
							<a href="#cats" data-toggle="tab" class="nav-link">Категории</a>
						</li>
						<li>
							<a href="#courses" data-toggle="tab" class="nav-link">Курсы</a>
						</li>
						<li>
							<a href="#sounds" data-toggle="tab" class="nav-link">Звуки</a>
						</li>
						<li>
							<a href="#playlist" data-toggle="tab" class="nav-link">Плейлисты</a>
						</li>
						<li>
							<a href="#groups" data-toggle="tab" class="nav-link">Группы</a>
						</li>				
					</ul>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="tab-content">
					<div id="emp" role="tabpanel" class="tab-pane active">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Имя</th>
											<th data-toggle="true">E-mail</th>
											<th data-toggle="true">Действия</th>
										</tr>
									</thead>
									<tbody>
									@if ($emp->count())
										@foreach ($emp as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/emp/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible">{{ $record->email }}</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/users/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/users/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="users" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Имя</th>
											<th data-toggle="true">E-mail</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($users->count())
										@foreach ($users as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/users/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible">{{ $record->email }}</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/users/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/users/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="coupon" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Номер</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($coupon->count())
										@foreach ($coupon as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/coupon/info/{{ $record->id }}">{{ $record->number }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/coupon/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/coupon/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="cats" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Категория</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($cats->count())
										@foreach ($cats as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/cats/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/cats/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/cats/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="courses" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Название</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($courses->count())
										@foreach ($courses as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/courses/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/courses/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/courses/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="sounds" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Название звука</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($sounds->count())
										@foreach ($sounds as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/sounds/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/sounds/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/sounds/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
						</div>
					</div>		
					<div id="playlist" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Название плейлиста</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($playlist->count())
										@foreach ($playlist as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/playlist/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/playlist/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/playlist/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="groups" role="tabpanel" class="tab-pane">
						<div class="panel-body">
							<div class="ibox">
								<div class="ibox-content">
									<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
										<tr>
											<th data-toggle="true">#</th>
											<th data-toggle="true">Название</th>
											<th data-toggle="true">Действия</th>
										</tr>
										</thead>
									<tbody>
									@if ($groups->count())
										@foreach ($groups as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>		
												<td class="footable-visible"><a href="/admin/groups/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/trash/restore/groups/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-undo"></i></a>
														<a href="/admin/trash/delete/groups/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-trash"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif									
									</tbody>										
									</table>
								</div>
							</div>
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
<script>

</script>
@endsection