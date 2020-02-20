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
						<h2>Добавить роль</h2>
					@else
						<h2>Редактировать роль</h2> 
					@endif
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/roles/">Роли и права</a>
                        </li>
                        <li class="active">
							@if (!isset($id))
								<strong>Добавить роль</strong>
							@else
								<strong>Редактировать роль</strong>
							@endif
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
			@if (!isset($id))
				<form action="{{ route('admin_radd') }}" method="POST" class="form-horizontal">
			@else
				<form action="{{ route('admin_redit', $id) }}" method="POST" class="form-horizontal">
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
							@if (isset($id))
								<div class="form-group">
									<label class="col-sm-2 control-label">Код</label>
									<div class="col-sm-10">
										<input type="text" value="{{ $rec->unique_id }}" readonly class="form-control">
									</div>
								</div>
								<div class="hr-line-dashed"></div>
							@endif
							<div class="form-group">
								<label class="col-sm-2 control-label">Роль <span class="req">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="name" value="{{ old('name', $rec->name) }}" class="form-control">
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Права <span class="req">*</span></label>
								<div class="col-sm-10">
									@if ($rights)
										@foreach ($rights as $key => $value)
											<div class="i-check1s">
												<label>
													<input type="checkbox" name="rights[]" value="{{ $key }}" @if (in_array($key, $this_rights)) checked @endif>
													{{ $value }} 
												</label>
											</div>
										@endforeach
									@endif
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Кого может создать: <span class="req">*</span></label>
								<div class="col-sm-10">
									<select name="can_create[]" size="10" multiple class="form-control">
										@if ($roles->count())
											@foreach ($roles as $role)
												<option value="{{ $role->id }}" @if (isset($can_create)) @if (in_array($role->id, $can_create)) selected @endif @endif>{{ $role->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
                        </div>
                    </div>				
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-content">
							<h3>Сотрудники прикреплённые к роли</h3>
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">#</th>
                                    <th data-toggle="true">Имя</th>
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if (isset($list1))
									@if ($list1->count())
										@foreach ($list1 as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>	
												<td class="footable-visible"><a href="/admin/emp/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group">
														<!-- <a href="/admin/users/delete_role/{{ $record->id }}" class="btn-white btn btn-xs">Удалить из группы</a> -->
													</div>
												</td>
											</tr>
										@endforeach
									@endif
									@endif
								</tbody>
							</table>
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
@endsection2">

                </div>
            </div>
        </div>
@endsection