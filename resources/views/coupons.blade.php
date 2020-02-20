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
                    <h2>Список купонов / подписок</h2>
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
                            <strong>Список купонов / подписок</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4 text-right">
					@if (Auth::user()->has_right('coupon/add'))
					<a href="/admin/coupon/add" class="btn btn-danger" style="margin-top: 30px;">Создать купон</a>
					@endif
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
				<div class="col-lg-12">
					<form action="/admin/coupon" class="form form-inline">
						<div class="form-group">
							<input type="text" name="nr" placeholder="" value="{{ $search }}" class="form-control">
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
										Номер
										@if (isset($order_by))
											@if ($order_by == 'number')
												@if ($order == 'desc')
													<a href="?order_by=number&order=asc">&darr;</a>
												@else
													<a href="?order_by=number&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=number&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th>
									<th data-toggle="true">
										E-mail
										@if (isset($order_by))
											@if ($order_by == 'id')
												@if ($order == 'desc')
													<a href="?order_by=id&order=asc">&darr;</a>
												@else
													<a href="?order_by=id&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=id&order={{ $order }}">&uarr;</a>
											@endif
										@endif											
									</th> 
									<th data-toggle="true">
										Цена
										@if (isset($order_by))
											@if ($order_by == 'id')
												@if ($order == 'desc')
													<a href="?order_by=id&order=asc">&darr;</a>
												@else
													<a href="?order_by=id&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=id&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th> 
									<th data-toggle="true">
										Пользователь
										@if (isset($order_by))
											@if ($order_by == 'id')
												@if ($order == 'desc')
													<a href="?order_by=id&order=asc">&darr;</a>
												@else
													<a href="?order_by=id&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=id&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th> 
									<th data-toggle="true">
										Дата действ.
										@if (isset($order_by))
											@if ($order_by == 'date_expires')
												@if ($order == 'desc')
													<a href="?order_by=date_expires&order=asc">&darr;</a>
												@else
													<a href="?order_by=date_expires&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=date_expires&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th> 
									<th data-toggle="true">
										Посл. вход
										@if (isset($order_by))
											@if ($order_by == 'id')
												@if ($order == 'desc')
													<a href="?order_by=id&order=asc">&darr;</a>
												@else
													<a href="?order_by=id&order=desc">&uarr;</a>
												@endif
											@else
												<a href="?order_by=id&order={{ $order }}">&uarr;</a>
											@endif
										@endif										
									</th> 
									<th data-toggle="true">Купон</th> 
									<th data-toggle="true">Статус</th> 
									<th data-toggle="true">Дата актив.</th> 
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if (Auth::user()->has_right('coupon') or Auth::user()->has_right('coupon/'))
									@if ($list->count())
										@foreach ($list as $key => $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ ($key+1) }}</td>	
												<td class="footable-visible"><a href="/admin/coupon/info/{{ $record->id }}">{{ $record->number }}</a></td>
												<td class="footable-visible">{{ $opts[$record->id]['email'] }}</td>
												<td class="footable-visible">{{ $opts[$record->id]['price'] }}</td>
												<td class="footable-visible">
													@if (!is_null($record->user_id))
														<a href="/admin/users/info/{{ $record->user_id }}">{{ $opts[$record->id]['user'] }}</a>
													@else
														{{ $opts[$record->id]['user'] }}
													@endif
												</td>
												<td class="footable-visible">
													@if (strtotime($record->date_expires))
														{{ date('d.m.Y - H:i', strtotime($record->date_expires)) }}
													@else
														&mdash;
													@endif
												</td>
												<td class="footable-visible">{{ $opts[$record->id]['last'] }}</td>
												<td class="footable-visible">
													@if (isset($opts[$record->id]['names']))
													@if (is_array($opts[$record->id]['names']))
														@foreach ($opts[$record->id]['names'] as $pack)
															<span class="badge badge-info">{{ $pack }}</span>
														@endforeach
													@endif
													@endif
												</td>
												<td class="footable-visible set_st{{ $record->id }}">
													@if ($record->status == 'active')
														<span class="badge badge-success">Активный</span>
													@endif
													@if ($record->status == 'pause')
														<span class="badge badge-warning">На паузе</span>
													@endif							
													@if ($record->status == 'expires')
														<span class="badge badge-danger">Истекает</span>
													@endif
													@if ($record->status == 'na')
														<span class="badge badge-primary">Неактивен</span>
													@endif
													@if ($record->status == 'ended')
														<span class="badge badge-danger">Закончен</span>
													@endif
												</td>
												<td class="footable-visible set_st{{ $record->id }}_act">
													@if (strtotime($record->date_activated))
														{{ date('d.m.Y - H:i', strtotime($record->date_activated)) }}
													@else
														&mdash;
													@endif
												</td>
												<td class="text-right footable-visible footable-last-column">
													@if ($record->status == 'active')
														<div class="btn-group">
															<a href="/admin/coupon/pause/{{ $record->id }}" data-id="{{ $record->id }}" data-st="На паузе" class="btn-white btn btn-xs coupon_action">Остановить</a>
															<a href="/admin/coupon/start/{{ $record->id }}" data-id="{{ $record->id }}" data-st="Активный" class="btn-white btn btn-xs coupon_action" style="display: none;">Активировать</a>
														</div>
													@else
														<div class="btn-group">
															<a href="/admin/coupon/start/{{ $record->id }}" data-id="{{ $record->id }}" data-st="Активный" class="btn-white btn btn-xs coupon_action">Активировать</a>
															<a href="/admin/coupon/pause/{{ $record->id }}" data-id="{{ $record->id }}" data-st="На паузе" class="btn-white btn btn-xs coupon_action" style="display: none;">Остановить</a>
														</div>														
													@endif
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