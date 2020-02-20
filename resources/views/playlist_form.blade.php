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
						<h2>Добавить плейлист</h2>
					@else
						<h2>Редактировать плейлист</h2>
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/">Пользователи</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить плейлист</strong>
							@else
								<strong>Редактировать плейлист</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				@if (isset($user_id))
					<form action="{{ route('admin_padd', $user_id) }}" method="POST" class="form-horizontal">
				@else
					<form action="{{ route('admin_padd1') }}" method="POST" class="form-horizontal">
				@endif
			@else
				@if (isset($user_id))
					<form action="{{ route('admin_pedit', [$id, $user->id]) }}" method="POST" class="form-horizontal">
				@else
					<form action="{{ route('admin_pedit1', $id) }}" method="POST" class="form-horizontal">
				@endif
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">				
					@if ($errors->has('name'))
						<div class="alert alert-danger">{{ $errors->first('name') }}</div>
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
							<div class="form-group" @if (isset($id)) style="display: none;" @endif>
								<label class="col-sm-2 control-label">Пользователь</label>
								<div class="col-sm-10">
									@if (isset($user))
									<select name="user_id" class="form-control">
										<option value="">Выберите</option>
										@if ($list->count())
											@foreach ($list as $u)
												<option value="{{ $u->id }}" @if (isset($_GET['user_id']) && (int)$_GET['user_id'] == $u->id) selected @endif @if ($u->id == $user->id) selected @endif>{{ $u->name }} ({{ $u->address }})</option>
											@endforeach
										@endif
									</select>
									@else
										<select name="user_id" class="form-control">
											<option value="">Выберите</option>
											@if ($list->count())
												@foreach ($list as $u)
													@if (isset($rec->user_id))
														<option value="{{ $u->id }}" @if (isset($_GET['user_id']) && (int)$_GET['user_id'] == $u->id) selected @endif @if ($u->id == $rec->user_id) selected @endif>{{ $u->name }} ({{ $u->email }})</option>
													@else
														<option value="{{ $u->id }}" @if (isset($_GET['user_id']) && (int)$_GET['user_id'] == $u->id) selected @endif>{{ $u->name }} ({{ $u->email }})</option>
													@endif
												@endforeach
											@endif
										</select>										
									@endif
								</div>
							</div>
							<div class="hr-line-dashed" @if (isset($id)) style="display: none;" @endif></div>
                            <div class="form-group"><label class="col-sm-2 control-label">Название <span class="req">*</span></label>
								<div class="col-sm-10"><input type="text" name="name" value="{{ old('name', $rec->name) }}" class="form-control"></div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Статус <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="status" class="form-control">
										<option value="active" @if ($rec->status == 'active') selected @endif>Активный</option>
										<option value="pause" @if ($rec->status == 'pause') selected @endif>На паузе</option>
										<option value="deleted" @if ($rec->status == 'deleted') selected @endif>Удалён</option>
									</select>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Звуки, которые хотим прикрепить к плейлисту <span class="req">*</span></label>
								<div class="col-sm-10">
									<input id="sounds_input" type="text" name="sounds[]" value="@if (isset($id)) {{ implode(',', json_decode($my_sounds, true)) }} @endif" class="form-control">
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