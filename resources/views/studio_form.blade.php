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
      <h2>Добавить студию</h2>
      @else
      <h2>Редактировать студию</h2>
      @endif
      <ol class="breadcrumb">
        <li>
          <a href="/admin/users">Панель администратора</a>
        </li>
        <li>
          <a href="/admin/studios">Студии</a>
        </li>
        <li class="active">
          @if (!isset($id))
          <strong>Добавить студию</strong>
          @else
          <strong>Редактировать студию</strong>
          @endif
        </li>
      </ol>
    </div>
    <div class="col-lg-2">

    </div>
  </div>
  <div class="wrapper wrapper-content animated fadeInRight ecommerce">
    @if (!isset($id))
    <form action="{{ route('admin_sadd') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
      @else
      <form action="{{ route('admin_sedit', $id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
        @endif
        @csrf
        @if(Auth::user()->role_id == 2)
          <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          @endif
          <div class="row">
            <div class="col-lg-12">
              @if ($errors->has('name'))
              <div class="alert alert-danger">{{ $errors->first('name') }}</div>
              @endif
              @if ($errors->has('desc'))
              <div class="alert alert-danger">{{ $errors->first('desc') }}</div>
              @endif
              @if ($errors->has('phone'))
              <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
              @endif
              @if ($errors->has('price'))
              <div class="alert alert-danger">{{ $errors->first('price') }}</div>
              @endif
              @if ($errors->has('address'))
              <div class="alert alert-danger">{{ $errors->first('address') }}</div>
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
                    <label class="col-sm-2 control-label">Категории <span class="req">*</span></label>
                    <div class="col-sm-10">
                      <select name="cat_ids[]" multiple class="form-control">
                        @if ($cats->count())
                        @foreach ($cats as $cat)
                        <option value="{{ $cat->id }}" @if (isset($id))
                        @if (in_array($cat->id, $cat_ids)) selected
                        @endif
                        @endif>{{ $cat->name }}</option>
                          @endforeach
                          @endif
                      </select>
                    </div>
                  </div>
                  <div class="hr-line-dashed"></div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Название <span class="req">*</span></label>
                    <div class="col-sm-10"><input type="text" name="name" value="{{ old('name', $rec->name) }}" class="form-control"></div>
                  </div>
                  @if(Auth::user()->role_id == 1)
                    <div class="form-group">
                      <label class="col-sm-2 control-label">ID юзера, которому принадлежит студия <span class="req">*</span></label>
                      <div class="col-sm-10"><input type="text" name="user_id" value="{{ old('user_id', $rec->user_id) }}" class="form-control"></div>
                    </div>
                    @endif
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Описание <span class="req">*</span></label>
                      <div class="col-sm-10"><textarea rows="6" name="desc" class="form-control">{{ old('desc', $rec->description) }}</textarea></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Телефон <span class="req">*</span></label>
                      <div class="col-sm-10"><input type="text" name="phone" value="{{ old('phone', $rec->phone) }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Телефон 2 <span class="req"></span></label>
                      <div class="col-sm-10"><input type="text" name="phone2" value="{{ old('phone2', $rec->phone2 ?? '') }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Цена занятий</label>
                      <div class="col-sm-10"><input type="text" name="price" value="{{ old('price', $rec->price) }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Сайт</label>
                      <div class="col-sm-10"><input type="text" name="site" value="{{ old('site', $rec->site) }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Instagram</label>
                      <div class="col-sm-10"><input type="text" name="instagram" value="{{ old('instagram', $rec->instagram) }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Фото (несколько)</label>
                      <div class="col-sm-10">
                        <input type="file" name="photo[]" multiple class="form-control">
                        <?php

									$photos = json_decode($rec->photo);
									if (is_array($photos)) {
										foreach ($photos as $ph) {
											echo '<div class="avatar margin"><img src="/public/'.$ph.'"></div>';
										}
									}

									?>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="ibox float-e-margins">
                <div class="ibox-title">
                  <h5>График работы</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  @if (!isset($id))
                  @foreach ($dates as $day_n => $day)
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ $day['name'] }} <span class="req">*</span></label>
                    <div class="col-sm-4">
                      <p>В этот день работает?</p>
                      <select name="dates[active][{{ $day_n }}]" class="dates_a form-control">
                        <option value="true">Да, работает в этот день</option>
                        <option value="false">Не работает</option>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <p>Со скольки?</p>
                      <input type="text" name="dates[opens][{{ $day_n }}]" value="{{ $day['opens'] }}" class="form-control time_mask">
                    </div>
                    <div class="col-sm-3">
                      <p>До скольки?</p>
                      <input type="text" name="dates[closes][{{ $day_n }}]" value="{{ $day['closes'] }}" class="form-control time_mask">
                    </div>
                  </div>
                  <div class="hr-line-dashed"></div>
                  @endforeach
                  @else
                  @foreach ($dates as $day_n => $day)
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ $day['name'] }} <span class="req">*</span></label>
                    <div class="col-sm-4">
                      <p>В этот день работает?</p>
                      <select name="dates[active][{{ $day_n }}]" class="dates_a form-control">
                        <option value="true" @if ($day['active'] == 'true') selected @endif>Да, работает в этот день</option>
                          <option value="false" @if ($day['active'] == 'false') selected @endif>Не работает</option>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <p>Со скольки?</p>
                      <input type="text" name="dates[opens][{{ $day_n }}]" value="{{ $day['opens'] }}" class="form-control time_mask">
                    </div>
                    <div class="col-sm-3">
                      <p>До скольки?</p>
                      <input type="text" name="dates[closes][{{ $day_n }}]" value="{{ $day['closes'] }}" class="form-control time_mask">
                    </div>
                  </div>
                  <div class="hr-line-dashed"></div>
                  @endforeach
                  @endif
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="ibox float-e-margins">
                <div class="ibox-title">
                  <h5>Местоположение</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Адрес <span class="req">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" name="address" value="{{ old('address', $rec->address) }}" class="form-control">
                    </div>
                  </div>
                  <div class="hr-line-dashed"></div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Координаты <span class="req">*</span></label>
                    <div class="col-sm-10">
                      @if (isset($id))
                      <input id="loc1" type="hidden" value="{{ $rec->GPS }}">
                      @endif
                      <input type="text" name="gps" value="{{ old('gps', $rec->GPS) ?? '55.753709, 37.619813' }}" readonly class="form-control">
                    </div>
                  </div>
                  <div class="hr-line-dashed"></div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Метка на карте</label>
                    <div class="col-sm-10">
                      <div id="map"></div>
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
