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
						<h2>Добавить бонус</h2>
					@else
						<h2>Редактировать бонус</h2> 
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/users">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/bon">История бонусов</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить бонус</strong>
							@else
								<strong>Редактировать бонус</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_boadd') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@else
				<form action="{{ route('admin_boedit', $id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">
					@if ($errors->has('type'))
						<div class="alert alert-danger">{{ $errors->first('type') }}</div>
					@endif			
					@if ($errors->has('summ'))
						<div class="alert alert-danger">{{ $errors->first('summ') }}</div>
					@endif
					@if ($errors->has('text'))
						<div class="alert alert-danger">{{ $errors->first('text') }}</div>
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
								<label class="col-sm-2 control-label">Пользователь <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="user_id" class="form-control">
										@if ($users->count())
											@foreach ($users as $user)
												<option value="{{ $user->id }}" @if (old('user_id', $rec->user_id) == $user->id) selected @endif>{{ $user->name }} ({{ $user->phone }})</option>
											@endforeach
										@endif
									</select>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>						
							<div class="form-group">
								<label class="col-sm-2 control-label">Тип <span class="req">*</span></label>
                                <div class="col-sm-10">
									<select name="type" class="form-control">
										<option value="Зачисление" @if (old('type', $rec->type) == 'Зачисление') selected @endif>Зачисление</option>
										<option value="Трата" @if (old('type', $rec->type) == 'Трата') selected @endif>Трата</option>
									</select>
								</div>
							</div>							
							<div class="hr-line-dashed"></div>							
							<div class="form-group">
								<label class="col-sm-2 control-label">Сумма <span class="req">*</span></label>
                                <div class="col-sm-10"><input type="text" name="summ" value="{{ old('summ', $rec->summ) }}" class="form-control"></div>
							</div>							
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Комментарий <span class="req">*</span></label>
								<div class="col-sm-10"><textarea rows="6" name="text" class="form-control">{{ old('text', $rec->text) }}</textarea></div>
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
