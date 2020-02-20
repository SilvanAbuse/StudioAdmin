@extends('layouts.admin.main')

@section('content')
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
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
                    <h2>Добавить группу</h2>
                @else
                    <h2>Редактировать группу</h2>
                @endif
                <ol class="breadcrumb">
                    <li>
                        <a href="/admin/">Панель администратора</a>
                    </li>
                    <li>
                        <a href="/admin/groups/">Группы</a>
                    </li>
                    <li class="active">
                        @if (!isset($id))
                            <strong>Добавить группу</strong>
                        @else
                            <strong>Редактировать группу</strong>
                        @endif
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            @if (!isset($id))
                <form id="gform" action="{{ route('admin_gadd') }}" method="POST" class="form-horizontal">
                    @else
                        <form id="gform" action="{{ route('admin_gedit', $id) }}" method="POST" class="form-horizontal">
                            @endif
                            @csrf
                            <div class="row">
                                <input type="hidden" name="users[]" id="users">
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
                                                <label class="col-sm-2 control-label">Название <span
                                                            class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" value="{{ old('name', $rec->name) }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Статус <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="status" class="form-control">
                                                        <option value="active"
                                                                @if (old('status', $rec->status) == 'active') selected @endif>
                                                            Активная
                                                        </option>
                                                        <option value="pause"
                                                                @if (old('status', $rec->status) == 'pause') selected @endif>
                                                            На паузе
                                                        </option>
                                                        <option value="deleted"
                                                                @if (old('status', $rec->status) == 'deleted') selected @endif>
                                                            Удалена
                                                        </option>
                                                    </select>
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
										<a href="javascript:void(0);" data-toggle="modal" data-target="#addmember"
                                                   class="btn btn-success">Добавить участника</a>
                                            @if (!isset($id))
                                                <button class="btn btn-primary" type="submit">Добавить</button>
                                            @else
                                                <button class="btn btn-primary" type="submit">Сохранить</button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
							@if (!isset($id))
							<div class="row">
								<div class="col-lg-12">
									<div class="ibox">
										<div class="ibox-content">
											<h4>Будут добавлены участники</h4>
											<table class="members footable table table-stripped toggle-arrow-tiny" data-page-size="15">
											<thead>
												<tr>
													<th data-toggle="true">Имя</th>
												</tr>
											</thead>
											<tbody>
											
											</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							@else
							<div class="row">
								<div class="col-lg-12">
									<div class="ibox">
										<div class="ibox-content">
											<h4>Текущие участники</h4>
											<table class="members already footable table table-stripped toggle-arrow-tiny" data-page-size="15">
											<thead>
												<tr>
													<th data-toggle="true">Имя</th>
													<th data-toggle="true" class="text-right">Действия</th>
												</tr>
											</thead>
											<tbody>
												@if ($list1->count())
													@foreach ($list1 as $u)
														<tr>
															<td class="footable-visible">
																<a href="/admin/users/info/{{ $u->id }}">
																	{{ $u->last_name }} {{ $u->name }}
																</a>
															</td>
															<td class="footable-visible text-right">
																<a href="/admin/deletefg/{{ $id }}/{{ $u->id }}"class="btn-white btn btn-xs"><i class="fa fa-close"></i></a>
															</td>
														</tr>
													@endforeach
												@endif
											</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>								
							@endif
                            <div class="modal fade" id="addmember" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Добавить участника в группу</h4>
                                        </div>
                                            <form action="{{ route('admin_gadd') }}" method="POST"
                                                  class="form-horizontal">
                                                <input id="gadd" type="hidden" name="method" value="addm">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" name="method" value="addm">
                                                            <select id="user_id" name="user_id" class="form-control">
                                                                <option value="0">Выберите</option>
                                                                @foreach ($usersToAddInGroup as $user)
                                                                    <option value="{{ $user->id }}" data-name="{{ $user->last_name }} {{ $user->name }}">{{ $user->last_name }} {{ $user->name }}</option>
                                                                @endforeach
                                                                <select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            @if (!isset($id))
                                                                <button id="gaddf1" type="button"
                                                                        class="btn btn-default">Добавить
                                                                </button>
                                                            @else
                                                                <button id="gaddf1" type="button" class="btn btn-default">
                                                                    Добавить
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Отмена
                                                            </button>
                                                    </form>
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