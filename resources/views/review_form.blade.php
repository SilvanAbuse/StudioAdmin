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
						<h2>Добавить отзыв</h2>
					@else
						<h2>Редактировать отзыв</h2> 
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/users">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/reviews">Отзывы</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить отзыв</strong>
							@else
								<strong>Редактировать отзыв</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_radd') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@else
				<form action="{{ route('admin_redit', $id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			@endif		
			@csrf
			<div class="row">
				<div class="col-lg-12">
					@if ($errors->has('user_id'))
						<div class="alert alert-danger">{{ $errors->first('user_id') }}</div>
					@endif	
					@if ($errors->has('studio_id'))
						<div class="alert alert-danger">{{ $errors->first('studio_id') }}</div>
					@endif			
					@if ($errors->has('comment'))
						<div class="alert alert-danger">{{ $errors->first('comment') }}</div>
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
								<label class="col-sm-2 control-label">Дата и время <span class="req">*</span></label>
								<div class="col-sm-10">
									<input type="datetime-local" name="created_at" value="{{ date('d.m.Y H:i', strtotime(old('created_at', $rec->recall_date))) }}" class="form-control">
								</div>
                            </div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Пользователь <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="user_id" class="form-control">
										@if ($users->count())
											@foreach ($users as $user)
												<option value="{{ $user->id }}" @if (old('user_id', $rec->user_id) == $user->id) selected @endif>{{ $user->name }} ({{ $user->email }})</option>
											@endforeach
										@endif
									</select>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Студия <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="studio_id" class="form-control">
										@if ($studios->count())
											@foreach ($studios as $st)
												<option value="{{ $st->id }}" @if (old('studio_id', $rec->studio_id) == $st->id) selected @endif>{{ $st->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
                            </div>						
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Комментарий <span class="req">*</span></label>
								<div class="col-sm-10">
									<textarea rows="10" name="comment" class="form-control">{{ old('comment', $rec->comment) }}</textarea>
								</div>
                            </div>
							<div class="hr-line-dashed"></div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Рейтинг <span class="req">*</span></label>
								<div class="col-sm-10">
									<input type="hidden" name="rating" value="5">
									<div class="rate_select">
										@if (!isset($id))
											<a href="javascript:void(0);" data-stars="1"><i class="fa fa-star"></i></a>
											<a href="javascript:void(0);" data-stars="2"><i class="fa fa-star"></i></a>
											<a href="javascript:void(0);" data-stars="3"><i class="fa fa-star"></i></a>
											<a href="javascript:void(0);" data-stars="4"><i class="fa fa-star"></i></a>
											<a href="javascript:void(0);" data-stars="5"><i class="fa fa-star"></i></a>
										@else
											<?php $last = 0; ?>
											@for ($a = 0; $a < $rec->rating; $a++)
												<a href="javascript:void(0);" data-stars="{{ $a + 1 }}"><i class="fa fa-star"></i></a>
												<?php $last++; ?>
											@endfor
											@for ($a = $last; $a < (5 - $rec->rating + $last); $a++)
												<a href="javascript:void(0);" data-stars="{{ $a + 1 }}"><i class="fa fa-star-o"></i></a>
											@endfor
										@endif
									</div>
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
