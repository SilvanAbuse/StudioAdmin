@extends('layouts.admin.main')

@section('content')
		<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Добавить занятие</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">Выберите занятие из списка и введите время!</div>
		<form id="add_s" action="{{ route('ajax_add', $rec->id) }}" method="POST" onsubmit="return false();">
			@csrf
			<p>Занятие:</p>
			<select name="service_id" class="form-control">
				@if ($services->count())
					@foreach ($services as $serv)
						<option value="{{ $serv->id }}">{{ $serv->name }}</option>
					@endforeach
				@endif
			</select>
			<p>Дата:</p>
			<input id="date_start" type="text" name="date_start" value="<?php echo date('d.m.Y'); ?>" class="form-control">
			<p>Время:</p>
			<input type="text" name="time_start" value="" placeholder="ЧЧ:ММ" class="form-control">
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary btn_addc">Добавить событие</button>
      </div>
    </div>
  </div>
</div>
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
                <h2>Студия {{ $rec->name }}</h2>
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
                        <strong>Студия {{ $rec->name }}</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2 text-right">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <form action="" method="GET">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <tr>
                                        <td>Название</td>
                                        <td>{{ $rec->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Адрес</td>
                                        <td>{{ $rec->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Телефон</td>
                                        <td>{{ $rec->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Описание</td>
                                        <td>{{ $rec->desc ?? '—' }}</td>
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
                                        <td>Сайт</td>
                                        <td>
											@if ($rec->site)
												<a href="{{ $rec->site }}" target="_blank">{{ $rec->site }}</a>
											@else
												не указан
											@endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Цена занятий</td>
                                        <td>{{ number_format($rec->price, 2, '.', '') }} руб.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
						<a href="/admin/studios/services/{{ $rec->id }}" class="btn btn-info">Услуги</a>
						{{-- <a href="/admin/studios/add" class="btn btn-success">Добавить студию</a> --}}
                        <a href="/admin/studios/edit/{{ $rec->id }}" class="btn btn-primary">Изменить студию</a>
                        <a href="/admin/delete_record/studios/{{ $rec->id }}" class="btn btn-danger">Удалить</a>
                        <br/><br/>
                    </div>
					<div class="col-lg-12">
						<div class="ibox">
							<div class="ibox-content">
								<h3>Расписание занятий (календарь)</h3>
								<input id="sel_date" type="hidden" value="<?php echo date('d-m-Y'); ?>">
								<input id="call_change" type="hidden" value="/admin/studios/calendar/{{ $rec->id }}">
								<div class="cal_c">
									<div class="cal_head">
										<div class="cal_left">
											<a href="javascript:void(0);" class="cal_dp">Выберите дату<span></span></a>
										</div>
										<div class="cal_right">
											<a href="javacript:void(0);" data-toggle="modal" data-target="#addModal" class="cal_btn cal_add">Добавить занятие</a>
										</div>
									</div>
									<div class="cal_body" style="display: none;">
										Загрузка...
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="ibox">
							<div class="ibox-content">
								<h3>Где студия?</h3>
								<input id="loc" type="hidden" value="{{ $rec->GPS }}">
								<div id="map"></div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="ibox">
							<div class="ibox-content">
								<h3>Отзывы о студии</h3>
								<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
									<thead>
									<tr>
										<th data-toggle="true">ID</th>
										<th data-toggle="true">Дата</th>
										<th data-toggle="true">Пользователь</th>
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
													<td class="footable-visible">{!! $record->user !!}</td>
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
