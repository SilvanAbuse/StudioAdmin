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
						<h2>Добавить пользователя</h2>
					@else
						<h2>Редактировать пользователя</h2>
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/users">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/users">Пользователи</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить пользователя</strong>
							@else
								<strong>Редактировать пользователя</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_uadd') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@else
				<form action="{{ route('admin_uedit', $id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@endif
			@csrf
			<div class="row">
				<div class="col-lg-12">
					@if ($errors->has('token'))
						<div class="alert alert-danger">{{ $errors->first('token') }}</div>
					@endif
					@if ($errors->has('name'))
						<div class="alert alert-danger">{{ $errors->first('name') }}</div>
					@endif
					@if ($errors->has('email'))
						<div class="alert alert-danger">{{ $errors->first('email') }}</div>
					@endif
					@if ($errors->has('phone'))
						<div class="alert alert-danger">{{ $errors->first('phone') }}</div>
					@endif
					@if ($errors->has('password'))
						<div class="alert alert-danger">{{ $errors->first('password') }}</div>
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
								<label class="col-sm-2 control-label">Токен <span class="req">*</span></label>
								<div class="col-sm-10"><input type="text" name="token" value="{{ old('token', $rec->token) }}" class="form-control"></div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Имя <span class="req">*</span></label>
                                <div class="col-sm-10"><input type="text" name="name" value="{{ old('name', $rec->name) }}" class="form-control"></div>
							</div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">E-mail <span class="req">*</span><span class="req"></span></label>
								<div class="col-sm-10"><input type="text" name="email" value="{{ old('email', $rec->email) }}" class="form-control"></div>
                            </div>
                            {{-- /***   --}}
                            <div class="hr-line-dashed"></div>
                                          <div class="form-group">
              								<label class="col-sm-2 control-label">Роль <span class="req">*</span><span class="req"></span></label>
              								<div class="col-sm-10">
                                <select class="form-control" name="role_id">
                                  <option value="0" @if(isset($rec->role_id) and !$rec->role_id) selected @endif>Не указана</option>
                                  <option value="1" @if(isset($rec->role_id) and $rec->role_id == 1) selected @endif>Администратор</option>
                                  <option value="2" @if(isset($rec->role_id) and $rec->role_id == 2) selected @endif>Студия</option>
                                </select>
                              </div>
                                          </div>
                            {{-- /***   --}}
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Телефон <span class="req">*</span></label>
								<div class="col-sm-10"><input type="text" name="phone" value="{{ old('phone', $rec->phone) }}" class="form-control"></div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Аватар</label>
								<div class="col-sm-10">
									<input type="file" name="avatar" class="form-control">
									@if ($rec->avatar)
										<div class="avatar margin"><img src="/public/{{ $rec->avatar }}"></div>
									@endif
								</div>
							</div>
                        </div>
                    </div>
				</div>
				<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Пароль для входа</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
						<div class="ibox-content">
							@if (isset($id))
								<div class="alert alert-info">Если Вы не хотите менять пароль пользователя, просто оставьте поле ниже пустым!</div>
							@endif
							<div class="form-group">
								<label class="col-sm-2 control-label">Пароль @if (!isset($id)) <span class="req">*</span> @endif</label>
								<div class="col-sm-10">
									<input type="text" name="password" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ещё раз @if (!isset($id)) <span class="req">*</span> @endif</label>
								<div class="col-sm-10">
									<input type="text" name="password_confirmation" class="form-control">
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
