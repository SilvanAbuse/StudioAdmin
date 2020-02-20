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
                    <h2>Плейлисты пользователя {{ $user->email }}</h2>
					@if (session('error'))
						<div class="alert alert-danger">{{ session('error') }}</div>
					@endif
					@if (session('success'))
						<div class="alert alert-danger">{{ session('success') }}</div>
					@endif					
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/">Пользователи</a>
                        </li>
                        <li class="active">
                            <strong>Плейлисты пользователя {{ $user->email }}</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
							<a href="/admin/playlist/add/{{ $user->id }}" class="btn btn-primary">Добавить плейлист</a>
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">ID</th>
									<th data-toggle="true">Название плейлиста</th>
									<th data-toggle="true">Кол-во звуков</th> 
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if ($list->count())
										@foreach ($list as $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>	
												<td class="footable-visible">{{ $record->name }}</td>
												<td class="footable-visible">{{ $opts[$record->id]['sounds'] }}</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group">
														<a href="/admin/playlist/edit/{{ $record->id }}/{{ $user->id }}" class="btn-white btn btn-xs">Изменить</a>
														<a href="/admin/delete_record/playlist/{{ $record->id }}" class="btn-white btn btn-xs">Удалить</a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="footer">
            <div class="pull-right">
                
            </div>
            <div>
                
            </div>
        </div>
        </div>
@endsection