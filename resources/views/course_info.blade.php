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
                    <h2>Курс {{ $rec->name }}</h2>
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
                            <a href="/admin/courses">Курсы</a>
                        </li>
                        <li class="active">
                            <strong>Курс {{ $rec->name }}</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-content">
							<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
							<tr>
								<td>Название категории</td>
								@if (isset($category))
									<td><a href="/admin/cats/info/{{ $category->id }}">{{ $category->name }}</a></td>
								@else
									<td>
									@if ($cats->count())
										@foreach ($cats as $cat)
											<a href="/admin/cats/info/{{ $cat->id }}">{{ $cat->name }}</a>, 
										@endforeach
									@else
										пусто
									@endif
									</td>
								@endif
							</tr>
							<tr>
								<td>Название курса</td>
								<td>{{ $rec->name }}</td>
							</tr>
							<tr>
								<td>Кто создал</td>
								@if ($rec->official == 'on')
									<td><a href="/admin/emp/info/15">ADMINISTRATOR</a></td>
								@else
									<td>{!! $created_user_name !!}</td>
								@endif
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
									@if ($rec->status == 'none')
										<span class="badge badge-primary">Неактивный</span>
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
					<a href="/admin/courses/add" class="btn btn-success">Создать курс</a>
					<a href="/admin/courses/edit/{{ $rec->id }}" class="btn btn-primary">Изменить курс</a>
					<a href="/admin/delete_record/courses/{{ $rec->id }}" class="btn btn-danger">Удалить курс</a>
					<br /><br />
				</div>
				<form action="/admin/courses/info/{{ $rec->id }}" method="POST">
				@csrf
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-content">
							<h3>Звуки</h3>
                            <table class="sortable footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">ID</th>
									<th data-toggle="true">Порядок</th>
                                    <th data-toggle="true">Название звука</th>
									<th data-toggle="true">Расшифровка</th> 
									<th data-toggle="true">Дата добавления</th> 
                                </tr>
                                </thead>
                                <tbody>
									@if ($list->count())
										@foreach ($list as $k => $r)
											<tr>
												<td>{{ $k + 1 }}</td>
												<td>
													<input type="text" name="pos[{{ $r->id }}]" value="{{ $r->pos }}" style="width: 120px;" class="form-control">
												</td>
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
				<div class="col-lg-12">
					<button type="submit" class="btn btn-primary">Сохранить сортировку</button>
				</div>
				</form>
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