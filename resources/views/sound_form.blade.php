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
						<h2>Добавить звук</h2>
					@else
						<h2>Редактировать звук</h2>
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/sounds/">Каталог звуков</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить звук</strong>
							@else
								<strong>Редактировать звук</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_sadd') }}" method="POST" class="form-horizontal">
			@else
				<form action="{{ route('admin_sedit', $id) }}" method="POST" class="form-horizontal">
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">				
					@if ($errors->has('name'))
						<div class="alert alert-danger">{{ $errors->first('name') }}</div>
					@endif	
					@if ($errors->has('dandzy'))
						<div class="alert alert-danger">{{ $errors->first('dandzy') }}</div>
					@endif
					@if ($errors->has('duration'))
						<div class="alert alert-danger">{{ $errors->first('duration') }}</div>
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
                            <div class="form-group"><label class="col-sm-2 control-label">Название <span class="req">*</span></label>
								<div class="col-sm-10"><input type="text" name="name" value="{{ old('name', $rec->name) }}" class="form-control"></div>
                            </div>						      
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Расшифровка с дэндзи на хирогану <span class="req">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="dandzy" value="{{ old('dandzy', $rec->dandzy) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div> 
							<div class="form-group">
								<label class="col-sm-2 control-label">Статус <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="status" class="form-control">
										<option value="active" @if (old('status', $rec->status) == 'active') selected @endif>Активный</option>
										<option value="none" @if (old('status', $rec->status) == 'none') selected @endif>Неактивный</option>
									</select>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Длина звука (из 5 волн)</label>
								<div class="col-sm-10">
									<input type="text" name="duration" value="{{ old('duration', $rec->duration) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Wave 1</label>
								<div class="col-sm-10">
									<input type="text" name="hz1" value="{{ old('hz1', $rec->hz1) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Wave 2</label>
								<div class="col-sm-10">
									<input type="text" name="hz2" value="{{ old('hz2', $rec->hz2) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Wave 3</label>
								<div class="col-sm-10">
									<input type="text" name="hz3" value="{{ old('hz3', $rec->hz3) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Wave 4</label>
								<div class="col-sm-10">
									<input type="text" name="hz4" value="{{ old('hz4', $rec->hz4) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Wave 5</label>
								<div class="col-sm-10">
									<input type="text" name="hz5" value="{{ old('hz5', $rec->hz5) }}" class="form-control">
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