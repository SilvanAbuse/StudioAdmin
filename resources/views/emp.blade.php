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
					@if (Route::current()->getName() == 'admin_emp')
						<h2>Список сотрудников</h2>
					@else
						<h2>Список пользователей</h2>
					@endif
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
							@if (Route::current()->getName() == 'admin_emp')
								<strong>Список сотрудников</strong>
							@else
								<strong>Список пользователей</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
					@if (Auth::user()->has_right('emp/add'))
					<a href="/admin/emp/add" class="btn btn-danger" style="margin-top: 30px;">Создать сотрудника</a>
					@endif
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
				<div class="col-lg-12">
					<form action="/admin/emp" class="form form-inline">
						<div class="form-group">
							<input type="text" name="nr" placeholder="Имя, E-mail..." value="{{ $search }}" class="form-control">
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
                                    <th data-toggle="true">
										#										
									</th>
									<th data-toggle="true">
										Имя
										@if (isset($order_by))
											@if ($order_by == 'name')
												@if ($order == 'desc')
													<a href="?order_by=name&order=asc">&darr;</a>
												@else
													<a href="?order_by=name&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=name&order={{ $order }}">&uarr;</a>
											@endif
										@endif											
									</th>
									<th data-toggle="true">Роль
                                        @if (isset($order_by))
                                            @if ($order_by == 'role_id')
                                                @if ($order == 'desc')
                                                    <a href="?order_by=role_id&order=asc">&darr;</a>
                                                @else
                                                    <a href="?order_by=role_id&order=desc">&uarr;</a>
                                                @endif
                                            @else
                                                <a href="?order_by=role_id&order={{ $order }}">&uarr;</a>
                                            @endif
                                        @endif
                                    </th>
									<th data-toggle="true">
										E-mail
										@if (isset($order_by))
											@if ($order_by == 'email')
												@if ($order == 'desc')
													<a href="?order_by=email&order=asc">&darr;</a>
												@else
													<a href="?order_by=email&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=email&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th> 
									<th data-toggle="true">
										Статус
										@if (isset($order_by))
											@if ($order_by == 'emp_status')
												@if ($order == 'desc')
													<a href="?order_by=emp_status&order=asc">&darr;</a>
												@else
													<a href="?order_by=emp_status&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=emp_status&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th>
									<th data-toggle="true">Кто дал доступ</th>
									<th data-toggle="true">
										Когда предоставлен доступ
										@if (isset($order_by))
											@if ($order_by == 'created_at')
												@if ($order == 'desc')
													<a href="?order_by=created_at&order=asc">&darr;</a>
												@else
													<a href="?order_by=created_at&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=created_at&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th>
									<th data-toggle="true">Код сотрудника</th>
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if (Auth()->user()->isAdmin())
									<tr class="footable-odd">
										<td class="footable-visible">1</td>
										<td class="footable-visible"><a href="/admin/emp/info/15">ADMINISTRATOR</a></td>
										<td class="footable-visible">[0] ADMINISTRATOR</td>
										<td class="footable-visible">{{ Auth::user()->email }}</td>
										<td class="footable-visible"><span class="badge badge-success">Активный</span></td>
										<td class="footable-visible"><a href="/admin/emp/info/15">ADMINISTRATOR</a></td>
										<td class="footable-visible"></td>
										<td class="footable-visible">[0][000][0000]</td>
										<td class="footable-visible"><a href="/admin/emp/edit/15"><i class="fa fa-pencil"></i></a></td>
									</tr>
									@else
									<tr class="footable-odd">
										<td class="footable-visible">1</td>
										<td class="footable-visible"><a href="/admin/emp/info/{{ Auth()->user()->id }}">{{ Auth()->user()->name }}</a></td>
										<td class="footable-visible">{{ $my_role->name }}</td>
										<td class="footable-visible">{{ Auth::user()->email }}</td>
										<td class="footable-visible"><span class="badge badge-success">Активный</span></td>
										<td class="footable-visible">
											{!! $created_by !!}
										</td>
										<td class="footable-visible"></td>
										<td class="footable-visible">[{{ $_role['id'] }}][{{ Auth()->user()->invite_id }}][{{ Auth()->user()->unique_id }}]</td>
										<td class="footable-visible"><a href="/admin/emp/edit/15"><i class="fa fa-pencil"></i></a></td>
									</tr>
									@endif
									@if (Auth::user()->has_right('emp') or Auth::user()->has_right('emp/'))
									@if ($list->count())
										@foreach ($list as $key => $record)
											@if ($record->role_id == 6)
												@continue
											@endif
											@if ($record->id == 15)
												@continue;
											@endif
											<tr class="footable-odd">
												<td class="footable-visible">{{ ($key+2) }}</td>		
												<td class="footable-visible"><a href="/admin/emp/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible">{{ $opts[$record->id]['role'] }}</td>
												<td class="footable-visible">{{ $record->email }}</td>
												<td class="footable-visible">
													@if ($record->emp_status == 'active')
														<span class="badge badge-success">Активный</span>
													@endif
													@if ($record->emp_status == 'pause')
														<span class="badge badge-warning">На паузе</span>
													@endif
													@if ($record->emp_status == 'deleted')
														<span class="badge badge-danger">Удалён</span>
													@endif
												</td>
												<td>
													@if ($record->created_by == 15)
														<a href="/admin/emp/info/15">ADMINISTRATOR</a>
													@else
														{!! $opts[$record->id]['invited'] !!}
													@endif
												</td>
												<td>{{ date('d.m.Y - H:i', strtotime($record->created_at)) }}</td>
												<td>{{ $opts[$record->id]['code'] }}</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group"> 
														<a href="/admin/emp/edit/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-pencil"></i></a>
														<a style="display: none;" href="/admin/delete_record/emp/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-close"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
					
									@endif
									@else
										<tr><td colspan="9">Нет прав!</td></tr>
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
