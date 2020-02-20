@extends('layouts.admin.main')

@section('content')
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
			</div>		
            <ul class="nav navbar-top-links navbar-right">		
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-language"></i>
                    </a>
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
						<h2>Добавить объявление</h2>
					@else
						<h2>Редактировать объявление</h2> 
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/users">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/ads">Объявления</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить объявление</strong>
							@else
								<strong>Редактировать объявление</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_aadd') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
			@else
				<form action="{{ route('admin_aedit', $id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">
					@if ($errors->has('user_id'))
						<div class="alert alert-danger">{{ $errors->first('user_id') }}</div>
					@endif
					@if ($errors->has('category_id'))
						<div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
					@endif				
					@if ($errors->has('title'))
						<div class="alert alert-danger">{{ $errors->first('title') }}</div>
					@endif					
					@if ($errors->has('full'))
						<div class="alert alert-danger">{{ $errors->first('full') }}</div>
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
								<label class="col-sm-2 control-label">От имени пользователя <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="user_id" class="form-control">
										<option value="">Выберите</option>
										@if ($users->count())
											@foreach ($users as $user)
												<option value="{{ $user->id }}" @if (old('user_id', $rec->user_id) == $user->id) selected @endif>{{ $user->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Категория <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="category_id" class="form-control">
										<option value="">Выберите</option>
										@if ($categories->count())
											@foreach ($categories as $cat)
												<option value="{{ $cat->id }}" @if (old('category_id', $rec->category_id) == $cat->id) selected @endif>{{ $cat->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
                            </div>						
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Заголовок <span class="req">*</span></label>
                                <div class="col-sm-10"><input type="text" name="title" value="{{ old('title', $rec->title) }}" class="form-control"></div>
							</div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Краткий текст</label>
								<div class="col-sm-10">
									<textarea name="short" class="form-control summernote">{{ old('short', $rec->short) }}</textarea>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Полный текст <span class="req">*</span></label>
								<div class="col-sm-10">
									<textarea name="full" class="form-control summernote">{{ old('full', $rec->full) }}</textarea>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>													
                            <div class="form-group">
								<label class="col-sm-2 control-label">Размещение <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="paid" class="form-control">
										<option value="1" @if (old('paid', $rec->paid) == 1) selected @endif>Оплачено</option>
										<option value="0" @if (old('paid', $rec->paid) == 0) selected @endif>Нет, размещение стандартное</option>
									</select>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Статус <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="status" class="form-control">
										<option value="vip" @if (old('status', $rec->status) == 'vip') selected @endif>VIP</option>
										<option value="waiting" @if (old('status', $rec->status) == 'waiting') selected @endif>На одобрении</option>
										<option value="active" @if (old('status', $rec->status) == 'active') selected @endif>Активно</option>
										<option value="expires" @if (old('status', $rec->status) == 'expires') selected @endif>Истекает срок</option>
										<option value="deleted" @if (old('status', $rec->status) == 'deleted') selected @endif>Удалено</option>
									</select>
								</div>
                            </div>							
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">В каталоге до <span class="req"></span></label>
                                <div class="col-sm-10"><input type="text" name="date_until" value="{{ old('date_until', $rec->date_until) }}" placeholder="ДД.ММ.ГГГГ" class="form-control"></div>
							</div>							
                        </div>
                    </div>				
				</div>
				<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Логотип</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>	
						<div class="ibox-content">
							<div class="form-group">
								<label class="col-sm-2 control-label">Логотип</label>
								<div class="col-sm-10">
									<input type="file" name="logo" class="form-control">
									@if (isset($id))
										@if ($rec->logo)
											<img src="/{{ $rec->logo }}" style="max-width: 100px; margin: 5px 2px;">
										@endif
									@endif
								</div>
							</div>
                        </div>
                    </div>				
				</div>
				<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Фото</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>	
						<div class="ibox-content">
							<div class="form-group">
								<label class="col-sm-2 control-label">Галерея фото</label>
								<div class="col-sm-10">
									<input type="file" name="photos[]" multiple class="form-control">
									@if (isset($id))
										@if ($rec->photos))
											<?php
										
											$photos = json_decode($rec->photos, true);
											if (sizeof($photos) > 0) {
												foreach ($photos as $photo) {
													echo '<img src="/'.$photo.'" style="max-width: 100px; margin: 5px 2px;">';
												}
											}
										
											?>
										@endif
									@endif
								</div>
							</div>
                        </div>
                    </div>				
				</div>
				<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Видео</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>	
						<div class="ibox-content">
							<?php
							
							$videos = [
							
								0 => '',
								1 => '',
								2 => '',
							
							];
							
							if (isset($id)) {
								$videos = json_decode($rec->videos, true);								
							}
							
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ссылка на YouTube #1</label>
								<div class="col-sm-10">
									<input type="text" name="videos[]" value="{{ $videos[0] }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ссылка на YouTube #2</label>
								<div class="col-sm-10">
									<input type="text" name="videos[]" value="{{ $videos[1] }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ссылка на YouTube #3</label>
								<div class="col-sm-10">
									<input type="text" name="videos[]" value="{{ $videos[2] }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>							
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
