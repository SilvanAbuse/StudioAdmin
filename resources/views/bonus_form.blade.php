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
                            <a href="/admin/bonus">Каталог бонусов</a>
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
				<form action="{{ route('admin_badd') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@else
				<form action="{{ route('admin_bedit', $id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">
					@if ($errors->has('caption'))
						<div class="alert alert-danger">{{ $errors->first('caption') }}</div>
					@endif			
					@if ($errors->has('desc'))
						<div class="alert alert-danger">{{ $errors->first('desc') }}</div>
					@endif
					@if ($errors->has('cnt'))
						<div class="alert alert-danger">{{ $errors->first('cnt') }}</div>
					@endif
					@if ($errors->has('phone'))
						<div class="alert alert-danger">{{ $errors->first('phone') }}</div>
					@endif
					@if ($errors->has('site'))
						<div class="alert alert-danger">{{ $errors->first('site') }}</div>
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
								<label class="col-sm-2 control-label">Название <span class="req">*</span></label>
                                <div class="col-sm-10"><input type="text" name="caption" value="{{ old('caption', $rec->caption) }}" class="form-control"></div>
							</div>							
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Описание <span class="req">*</span></label>
								<div class="col-sm-10"><textarea rows="6" name="desc" class="form-control">{{ old('desc', $rec->description) }}</textarea></div>
                            </div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Кол-во спотов <span class="req">*</span></label>
								<div class="col-sm-10"><input type="text" name="cnt" value="{{ old('cnt', $rec->cnt) }}" class="form-control"></div>
                            </div>	
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Доступно <span class="req">*</span></label>
								<div class="col-sm-10"><input type="text" name="available" value="{{ old('available', $rec->available) }}" class="form-control"></div>
                            </div>	
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Промокод</label>
								<div class="col-sm-10"><input type="text" name="promo" value="{{ old('promo', $rec->promo) }}" class="form-control"></div>
                            </div>								
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Телефон <span class="req"></span></label>
								<div class="col-sm-10"><input type="text" name="phone" value="{{ old('phone', $rec->phone) }}" class="form-control"></div>
                            </div>					
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Сайт</label>
								<div class="col-sm-10"><input type="text" name="site" value="{{ old('site', $rec->site) }}" class="form-control"></div>
                            </div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Фото</label>
								<div class="col-sm-10">
									<input type="file" name="photo" value="" class="form-control">
									@if ($rec->photo)
										<div class="avatar margin"><img src="/public/{{ $rec->photo }}"></div>
									@endif									
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
