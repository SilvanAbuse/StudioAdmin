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
						<h2>Добавить услугу</h2>
					@else
						<h2>Редактировать услугу</h2>
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/users">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/studios">Студии</a>
                        </li>
						<li>
							<a href="/admin/studios/info/{{ $studio->id }}">Студия {{ $studio->name }}</a>
						</li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить услугу</strong>
							@else
								<strong>Редактировать услугу</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_seadd', $studio->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
			@else
				<form action="{{ route('admin_seedit', [$studio->id, $id]) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
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
							<div class="form-group">
								<label class="col-sm-2 control-label">Название <span class="req">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="name" value="{{ old('name', $rec->name) }}" class="form-control">
								</div>
							</div>													
                        </div>
                    </div>				
					<a href="javascript:void(0);" title="Добавить занятие" class="btn btn-info nr_add">Добавить занятие</a>
					<br /><br />
				</div>
				<div class="col-lg-12 sample_rate" style="display: none;">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Тариф</h5>
                            <div class="ibox-tools">
								<a href="javascript:void(0);" title="Удалить тариф" class="btn btn-xs nr_remove"><i class="fa fa-close"></i></a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">						
							<div class="form-group">
								<label class="col-sm-2 control-label">Занятие</label>
								<div class="col-sm-10">
									<input type="text" name="name_rate[name][]" value="" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Стоимость</label>
								<div class="col-sm-10">
									<input type="text" name="name_rate[price][]" value="" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Описание занятия</label>
								<div class="col-sm-10">
									<textarea name="name_rate[text][]" class="form-control"></textarea>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Картинка</label>
								<div class="col-sm-10">
									<input type="file" name="name_rate[img][]" class="form-control">
								</div>
							</div>
                        </div>
                    </div>				
				</div>
				@if (sizeof($json) > 0)
					@foreach ($json as $tar)
						<div class="col-lg-12 sample_rate">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>{{ $tar['name'] }}</h5>
									<div class="ibox-tools">
										<a href="javascript:void(0);" title="Удалить занятие" class="btn btn-xs nr_remove"><i class="fa fa-close"></i></a>
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">						
									<div class="form-group">
										<label class="col-sm-2 control-label">Занятие</label>
										<div class="col-sm-10">
											<input type="text" name="name_rate[name][]" value="{{ $tar['name'] }}" class="form-control">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Стоимость</label>
										<div class="col-sm-10">
											<input type="text" name="name_rate[price][]" value="{{ $tar['price'] }}" class="form-control">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Описание тарифа</label>
										<div class="col-sm-10">
											<textarea name="name_rate[text][]" class="form-control">{{ $tar['text'] }}</textarea>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Картинка тарифа</label>
										<div class="col-sm-10">
											<input type="file" name="name_rate[img][]" class="form-control">
											@if (!empty($tar['img']))
												<a href="/{{ $tar['img']}}">
													<img src="/{{ $tar['img'] }}" style="margin: 20px; max-width: 200px; height: auto;">
												</a>
											@endif
										</div>
									</div>
								</div>
							</div>				
						</div>				
					@endforeach
				@endif
				<div class="col-lg-12 sample_rate" style="display: none;">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Тариф</h5>
                            <div class="ibox-tools">
								<a href="javascript:void(0);" title="Удалить тариф" class="btn btn-xs nr_remove"><i class="fa fa-close"></i></a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">						
							<div class="form-group">
								<label class="col-sm-2 control-label">Тариф</label>
								<div class="col-sm-10">
									<input type="text" name="name_rate[name][]" value="" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Стоимость</label>
								<div class="col-sm-10">
									<input type="text" name="name_rate[price][]" value="" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Описание тарифа</label>
								<div class="col-sm-10">
									<textarea name="name_rate[text][]" class="form-control"></textarea>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Описание тарифа</label>
								<div class="col-sm-10">
									<input type="file" name="name_rate[img][]" class="form-control">
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