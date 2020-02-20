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
                    <h2>Добавить сотрудника</h2>
                @else
                    <h2>Редактировать сотрудника</h2>
                @endif
                <ol class="breadcrumb">
                    <li>
                        <a href="/admin/">Панель администратора</a>
                    </li>
                    <li>
                        <a href="/admin/emp/">Сотрудники</a>
                    </li>
                    <li class="active">
                        @if (!isset($id))
                            <strong>Добавить сотрудника</strong>
                        @else
                            <strong>Редактировать сотрудника</strong>
                        @endif
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            @if (!isset($id))
                <form action="{{ route('admin_eadd') }}" method="POST" enctype="multipart/form-data"
                      class="form-horizontal">
                    @else
                        <form action="{{ route('admin_eedit', $id) }}" method="POST" enctype="multipart/form-data"
                              class="form-horizontal">
                            @endif
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                    @if ($errors->has('password'))
                                        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                    @if ($errors->has('emp_name'))
                                        <div class="alert alert-danger">{{ $errors->first('emp_name') }}</div>
                                    @endif
                                    @if ($errors->has('emp_status'))
                                        <div class="alert alert-danger">{{ $errors->first('emp_status') }}</div>
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
                                            @if (isset($rec->avatar))
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Аватар </label>
                                                    <div class="col-sm-10">
                                                        <p style="text-align: center;"><img
                                                                    src="/{{ old('avatar', $rec->avatar) }}"
                                                                    style="width: 250px;height: 250px;">
                                                            <br>
                                                            <input type="file" name="avatar" class="form-control"></p>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                            @else
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Аватар </label>
                                                    <div class="col-sm-10">
                                                        <input type="file" name="avatar" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                            @endif
											@if (isset($id) && $id !== '15' or !isset($id))                                                                                                                                                                                 
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Роль <span
                                                            class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="role_id" class="form-control">
														<option value=""></option>
                                                        @if ($roles->count())
                                                            @foreach ($roles as $role)
                                                                @if (!in_array($role->id, $can_create))
                                                                    @continue;
                                                                @endif
                                                                <option value="{{ $role->id }}" @if ($role->id == $rec->role_id) selected @endif>{{ $role->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            {{--
											@if (Auth()->user()->id == 15)
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Ветка <span
                                                                class="req">*</span></label>
                                                    <div class="col-sm-10">
                                                        <select name="invite_id" class="form-control">
    														@if (isset($invites))
                                                            @if ($invites)
                                                                @foreach ($invites as $invite)
                                                                    <option value="{{ $invite }}" @if ($invite == $rec->invite_id) selected @endif>{{ $invite }}</option>
                                                                @endforeach
                                                            @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
											@endif

                                            --}}

											@endif
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Группа <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="group_id" class="form-control">
														<option value=""></option>
                                                        @if ($groups->count())
                                                            @foreach ($groups as $group)
                                                                <option value="{{ $group->id }}"
                                                                        @if (old('group_id', $rec->group_id) == $group->id) selected @endif>{{ $group->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed" style="display: none;"></div>
                                            <div class="form-group" style="display: none;">
                                                <label class="col-sm-2 control-label">Город <span
                                                            class="req">*</span></label>
                                                <div class="col-sm-10"><input type="text" name="city_id" value="n/a"
                                                                              class="form-control"></div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Адрес <span
                                                            class="req">*</span></label>
                                                <div class="col-sm-10"><input type="text" name="address"
                                                                              placeholder="Адрес, город, страна"
                                                                              value="{{ old('address', $rec->address) }}"
                                                                              class="form-control"></div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Имя <span
                                                            class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" value="{{ old('name', $rec->name) }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">E-mail <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="email"
                                                           value="{{ old('email', $rec->email) }}" class="form-control">
                                                </div>
                                            </div>
                                            <input type="hidden" name="emp_name" value="Администратор">
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Статус <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="emp_status" class="form-control">
                                                        <option value="active"
                                                                @if (old('emp_status', $rec->emp_status) == 'active') selected @endif>
                                                            Активный
                                                        </option>
                                                        <option value="pause"
                                                                @if (old('emp_status', $rec->emp_status) == 'pause') selected @endif>
                                                            На паузе
                                                        </option>
                                                        <option value="deleted"
                                                                @if (old('emp_status', $rec->emp_status) == 'deleted') selected @endif>
                                                            Удалён
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Пароль @if (!isset($id))<span
                                                            class="req">*</span>@endif</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="password" value="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Ещё раз пароль @if (!isset($id))
                                                        <span class="req">*</span>@endif</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="password_confirmation" value=""
                                                           class="form-control">
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
