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
                    <h2>Добавить курс</h2>
                @else
                    <h2>Редактировать курс</h2>
                @endif
                <ol class="breadcrumb">
                    <li>
                        <a href="/admin/">Панель администратора</a>
                    </li>
                    <li>
                        <a href="/admin/courses/">Список курсов</a>
                    </li>
                    <li class="active">
                        @if (!isset($id))
                            <strong>Добавить курс</strong>
                        @else
                            <strong>Редактировать курс</strong>
                        @endif
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            @if (!isset($id))
                <form action="{{ route('admin_coadd') }}" method="POST" class="form-horizontal">
                    @else
                        <form action="{{ route('admin_coedit', $id) }}" method="POST" class="form-horizontal">
                            @endif
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                    @if ($errors->has('cat_id'))
                                        <div class="alert alert-danger">{{ $errors->first('cat_id') }}</div>
                                    @endif
                                    @if ($errors->has('sounds_id'))
                                        <div class="alert alert-danger">{{ $errors->first('sounds_id') }}</div>
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
                                            <div class="form-group"
                                                 @if (isset($_GET['user_id'])) style="display: none;" @endif>
                                                <label class="col-sm-2 control-label">Пользователь</label>
                                                <div class="col-sm-10">
                                                    <select name="user_id" class="form-control">
														<option value=""></option>
                                                        @if ($users->count())
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                        @if (old('user_id', $rec->user_id) == $user->id) selected @endif>{{ $user->name }}
                                                                    ({{ $user->address }})
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            {{--
                                            @if (Auth()->user()->isAdmin())
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group"
                                                     @if (Auth()->user()->email != 'admin@admin.com') style="display: none;" @endif>
                                                    <label class="col-sm-2 control-label">Официальная</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" name="official"
                                                                    @if (old('official', $rec->official) == 'on')
                                                                    checked
                                                                    @endif
                                                        >
                                                    </div>
                                                </div>
                                            @endif
                                            --}}
                                            <div class="hr-line-dashed"
                                                 @if (isset($_GET['user_id'])) style="display: none;" @endif></div>
                                            <div class="form-group"><label class="col-sm-2 control-label">Название <span
                                                            class="req">*</span></label>
                                                <div class="col-sm-10"><input type="text" name="name"
                                                                              value="{{ old('name', $rec->name) }}"
                                                                              class="form-control"></div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Официальный?</label>
												<div class="col-sm-10">
													<input type="checkbox" name="official" value="1" @if ($rec->official) checked @endif>&nbsp;Да
												</div>
											</div>
											<div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Категория курса <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="cat_id" class="form-control">
                                                        <option value="">Выберите</option>
                                                        @if ($categories->count())
                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->id }}"
                                                                        @if (old('category_id', $rec->cat_id) == $cat->id) selected @endif>{{ $cat->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Звуки, которые хотим прикрепить к
                                                    курсу <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <input id="add_tags" type="hidden">
													@if (isset($id))
                                                    <input id="sounds_input" type="text" name="sounds_id[]"
                                                           value="{{ implode(',', json_decode($sound_ids, true)) }}"
                                                           class="form-control">
													@else
                                                    <input id="sounds_input" type="text" name="sounds_id[]"
                                                           value=""
                                                           class="form-control">														
													@endif
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Статус <span class="req">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="status" class="form-control">
                                                        <option value="active"
                                                                @if (old('status', $rec->status) == 'active') selected @endif>
                                                            Активный
                                                        </option>
                                                        <option value="none"
                                                                @if (old('status', $rec->status) == 'none') selected @endif>
                                                            Неактивный
                                                        </option>
                                                        <option value="pause"
                                                                @if (old('status', $rec->status) == 'pause') selected @endif>
                                                            На паузе
                                                        </option>
                                                        <option value="deleted"
                                                                @if (old('status', $rec->status) == 'deleted') selected @endif>
                                                            Удалён
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