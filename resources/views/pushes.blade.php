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
                <div class="col-lg-8">
                    <h2>Список пушей</h2>
					@if (session('error'))
						<div class="alert alert-danger">{{ session('error') }}</div>
					@endif
					@if (session('success'))
						<div class="alert alert-danger">{{ session('success') }}</div>
					@endif					
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin/users">Панель администратора</a>
                        </li>
                        <li>
                            <a href="/admin/pushes">Пуши</a>
                        </li>
                        <li class="active">
                            <strong>Список пушей</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4 text-right">
					<a href="{{ route('admin_puadd') }}" class="btn btn-danger" style="margin-top: 30px;">Добавить</a>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">		
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">#</th>
									<th data-toggle="true">Дата и время</th>
									<th data-toggle="true">Фото</th>
									<th data-toggle="true">Название</th>
									<th data-toggle="true">Кол-во пользователей</th>
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if ($list->count())
										@foreach ($list as $key => $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ $record->id }}</td>
												<td class="footable-visible">{{ date('d.m.Y - H:i:s', strtotime($record->delivery)) }}</td>
												<td class="footable-visible">
													@if (!$record->photo)
														<div class="avatar avatar_empty"></div>
													@else
														<div class="avatar"><img src="/public/{{ $record->photo }}"></div>
													@endif
												</td>
												<td class="footable-visible">{{ $record->name }}</td>
												<td class="footable-visible">{{ $record->count }}</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group">
														<a href="/admin/pushes/edit/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-pencil"></i></a>
														<a href="/admin/delete_record/pushes/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-close"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr><td colspan="6">Нет данных</td></tr>
									@endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="10">
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