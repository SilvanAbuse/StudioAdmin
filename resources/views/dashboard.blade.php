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
                    <h2>Основная информация</h2>
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
                        <li class="active">
                            <strong>Основная информация</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
					@if (Auth()->user()->id == 15)
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">&nbsp;</strong>
                             </span> <span class="text-muted text-xs block btn btn-danger" style="color: white; margin-top: 10px;">Купоны <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
							<li><a href="/admin/coupon">Список купонов</a></li>
							<li><a href="/admin/coupon/add">Создать купон</a></li>
							<li><a href="/admin/coupon/settings">Настройка цен</a></li>
                        </ul>
					@endif
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">			
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
										Пользователь
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
									<th data-toggle="true">
										№ купона
										@if (isset($order_by))
											@if ($order_by == 'number')
												@if ($order == 'desc')
													<a href="?order_by=number&order=asc&dop=true">&darr;</a>
												@else
													<a href="?order_by=number&order=desc&dop=true">&uarr;</a>
												@endif
											@else
												<a href="?order_by=number&order={{ $order }}&dop=true">&uarr;</a>
											@endif
										@endif										
									</th>
									<th data-toggle="true">
										Купон
										@if (isset($order_by))
											@if ($order_by == 'names')
												@if ($order == 'desc')
													<a href="?order_by=names&order=asc&dop=true">&darr;</a>
												@else
													<a href="?order_by=names&order=desc&dop=true">&uarr;</a>
												@endif
											@else
												<a href="?order_by=names&order={{ $order }}&dop=true">&uarr;</a>
											@endif
										@endif											
									</th>
									<th data-toggle="true">
										Цена купона
										@if (isset($order_by))
											@if ($order_by == 'price')
												@if ($order == 'desc')
													<a href="?order_by=price&order=asc&dop=true">&darr;</a>
												@else
													<a href="?order_by=price&order=desc&dop=true">&uarr;</a>
												@endif
											@else
												<a href="?order_by=price&order={{ $order }}&dop=true">&uarr;</a>
											@endif
										@endif											
									</th>
									<th data-toggle="true">
										Срок. действ. купона
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
										Статус купона / скидки
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
									<th data-toggle="true">Кто пригласил</th>
									<th data-toggle="true">
										Дата активации купона / подписки
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
                                </tr>
                                </thead>
                                <tbody>
									@if ($list->count())
										<?php $count = 0; ?>
										@foreach ($list as $key => $record)
											@if ($opts[$record->id]['price'] == 0)
												@continue
											@endif
											@if (empty($opts[$record->id]['coupon_status']))
												@continue
											@endif
											<?php $count++; ?>
											<tr class="footable-odd">
												<td class="footable-visible">{{ $count }}</td>		
												<td class="footable-visible"><a href="/admin/users/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible"><a href="/admin/coupon/info/{{ $opts[$record->id]['coupon_id'] }}">{{ $opts[$record->id]['coupon_nr'] }}</a></td>
												<td class="footable-visible">
													@if (is_array($opts[$record->id]['names']))
														@foreach ($opts[$record->id]['names'] as $pack)
															<span class="badge badge-info">{{ $pack }}</span>
														@endforeach
													@endif												
												</td>
												<td class="footable-visible">{{ $opts[$record->id]['price'] }}</td>
												<td>
													@if (strtotime($opts[$record->id]['date_expires']))
														{{ date('d.m.Y - H:i', strtotime($opts[$record->id]['date_expires'])) }}
													@else
														&mdash;
													@endif
												</td>
												<td>
													@if ($opts[$record->id]['coupon_status'] == 'active')
														<span class="badge badge-success">Активен</span>
													@endif
													@if ($opts[$record->id]['coupon_status'] == 'pause')
														<span class="badge badge-warning">На паузе</span>
													@endif
													@if ($opts[$record->id]['coupon_status'] == 'expires')
														<span class="badge badge-danger">Истекает</span>
													@endif
													@if ($opts[$record->id]['coupon_status'] == 'na')
														<span class="badge badge-primary">Неактивен</span>
													@endif		
													@if ($opts[$record->id]['coupon_status'] == 'ended')
														<span class="badge badge-danger">Закончен</span>
													@endif														
												</td>
												<td>{!! $opts[$record->id]['invited'] !!}</td>																								
												<td>
													@if (strtotime($opts[$record->id]['date_activated']))
														{{ date('d.m.Y - H:i', strtotime($opts[$record->id]['date_activated'])) }}
													@else
														&mdash;
													@endif
												</td>											
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="15">Нет данных!</td>
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