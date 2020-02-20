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
					@if (!isset($id))
						<h2>Добавить купон / подписку</h2>
					@else
						<h2>Редактировать купон / подписку</h2>
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/coupon/">Список курсов</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить купон / подписку</strong>
							@else
								<strong>Редактировать купон / подписку</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_couadd') }}" method="POST" class="form-horizontal">
			@else
				<form action="{{ route('admin_couedit', $id) }}" method="POST" class="form-horizontal">
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">				
					@if ($errors->has('coupon_id'))
						<div class="alert alert-danger">{{ $errors->first('coupon_id') }}</div>
					@endif
					@if ($errors->has('user_id'))
						<div class="alert alert-danger">{{ $errors->first('user_id') }}</div>
					@endif	
					@if (isset($_GET['ex']))
						<div class="alert alert-danger">У данного пользователя уже есть купон</div>
					@endif					
				</div>
				<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Общая информация</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
								<label class="col-sm-2 control-label">Какой купон <span class="req">*</span></label>
								<div class="col-sm-10">
									<input id="coupons_id" type="text" name="coupon_id[]" value="@if (isset($rec->list)) {{ implode(', ', json_decode($rec->list, true)) }} @endif" class="form-control">
								</div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Срок действия <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="date_expires" class="form-control">
										<option value="day" @if ($rec->expires == 'day') selected @endif>День</option>
										<option value="week" @if ($rec->expires == 'week') selected @endif>Неделя</option>
										<option value="month" @if ($rec->expires == 'month') selected @endif>Месяц</option>
										<option value="year" @if ($rec->expires == 'year') selected @endif>Год</option>
									</select>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Пользователь</label>
								<div class="col-sm-10">
									<select id="select_user" name="user_id" class="form-control">
										<option value="">Выберите</option>
										@if ($users->count())
											@foreach ($users as $user1)
												<option value="{{ $user1->id }}" data-email="{{ $user1->email }}" @if (isset($_GET['user_id'])) @if ($_GET['user_id'] == $user1->id) selected @endif @endif @if (old('user_id', $rec->user_id) == $user1->id) selected @endif>{{ $user1->name }} ({{ $user1->address }})</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Статус</label>
								<div class="col-sm-10">
									<select name="status" class="form-control">
										<option value="pause" @if (old('status', $rec->status) == 'pause') selected @endif>На паузе</option>
										<option value="active" @if (old('status', $rec->status) == 'active') selected @endif>Активен</option>
										<option value="na" @if (old('status', $rec->status) == 'na') selected @endif>Неактивен</option>
										<option value="ended" @if (old('status', $rec->status) == 'ended') selected @endif>Закончен</option>
									</select>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">E-mail</label>
								<div class="col-sm-10">
									<input id="selected_user" type="text" value="@if (isset($user)) {{ $user->email }} @endif" readonly class="form-control">
									<p style="font-style: italic; color: gray;">* Заполняется автоматически при выборе пользователя</p>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label"># купона</label>
								<div class="col-sm-10">
									@if (isset($id))
										<input id="coupon_nr" type="text" name="number" value="{{ $rec->number }}" readonly class="form-control">
									@else
										<input id="coupon_nr" type="text" name="number" value="{{ $code }}" readonly class="form-control">
									@endif
									<p style="font-style: italic; color: gray;">* Сгенерирован автоматически</p>
								</div>
							</div>							
                        </div>
                    </div>				
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<div class="col-sm-4">
							@if (!isset($id))
								<button class="btn btn-primary" type="submit">Добавить</button>
							@else
								<button class="btn btn-primary" type="submit">Сохранить</button>
							@endif
						</div>
					</div>				
				</div>
			</div>
			</form>
        </div>
        <div class="footer">
            <div class="pull-right">
                
            </div>
            <div>
            </div>
        </div>
        </div>
@endsection