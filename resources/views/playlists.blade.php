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
                    <h2>Все плейлисты</h2>
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
                            <a href="/admin/playlist">Плейлисты</a>
                        </li>
                        <li class="active">
                            <strong>Все плейлисты</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
					<a href="/admin/playlist/add/" class="btn btn-danger" style="margin-top: 30px;">Создать плейлист</a>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
				<div class="col-lg-12">
					<form action="/admin/playlist" class="form form-inline">
						<div class="form-group">
							<input type="text" name="nr" placeholder="Название плейлиста..." value="{{ $search }}" class="form-control">
							<button type="submit" class="btn btn-default">Поиск</button>
						</div>
					</form>
					<br />
				</div>				
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th data-toggle="true">
										ID											
									</th>
									<th data-toggle="true">
										Название плейлиста
										@if ($order_by == 'name')
											@if ($order == 'desc')
												<a href="?order_by=name&order=asc">&#8595;</a>
											@else
												<a href="?order_by=name&order=desc">&#8593;</a>
											@endif
										@else
											<a href="?order_by=name&order=desc">&#8593;</a>
										@endif											
									</th>
									<th data-toggle="true">
										Пользователь
										@if ($order_by == 'user_id')
											@if ($order == 'desc')
												<a href="?order_by=user_idorder=asc">&#8595;</a>
											@else
												<a href="?order_by=user_id&order=desc">&#8593;</a>
											@endif
										@else
											<a href="?order_by=user_id&order=desc">&#8593;</a>
										@endif	
									</th>
									<th data-toggle="true">
										Статус
										@if ($order_by == 'status')
											@if ($order == 'desc')
												<a href="?order_by=status&order=asc">&#8595;</a>
											@else
												<a href="?order_by=status&order=desc">&#8593;</a>
											@endif
										@else
											<a href="?order_by=status&order=desc">&#8593;</a>
										@endif											
									</th>
									<th data-toggle="true">
										Дата создания
										@if ($order_by == 'created_at')
											@if ($order == 'desc')
												<a href="?order_by=created_at&order=asc">&#8595;</a>
											@else
												<a href="?order_by=created_at&order=desc">&#8593;</a>
											@endif
										@else
											<a href="?order_by=created_at&order=desc">&#8593;</a>
										@endif										
									</th>
									<th data-toggle="true">
										Дата изменения
										@if ($order_by == 'updated_at')
											@if ($order == 'desc')
												<a href="?order_by=updated_at&order=asc">&#8595;</a>
											@else
												<a href="?order_by=updated_at&order=desc">&#8593;</a>
											@endif
										@else
											<a href="?order_by=updated_at&order=desc">&#8593;</a>
										@endif											
									</th>
                                    <th class="text-right" data-sort-ignore="true">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
									@if (Auth::user()->has_right('playlist') or Auth::user()->has_right('playlist/'))
									@if ($list->count())
										@foreach ($list as $key => $record)
											<tr class="footable-odd">
												<td class="footable-visible">{{ ($key+1) }}</td>	
												<td class="footable-visible"><a href="/admin/playlist/info/{{ $record->id }}">{{ $record->name }}</a></td>
												<td class="footable-visible">
													@if ($opts[$record->id]['created_user_id'] !== 'не указан')
														<a href="/admin/users/info/{{ $opts[$record->id]['created_user_id'] }}">{{ $opts[$record->id]['created_user_name'] }}</a>
													@else
														не указан
													@endif
												<td class="footable-visible">
													@if ($record->status == 'active')
														<span class="badge badge-success">Активный</span>
													@endif
													@if ($record->status == 'pause')
														<span class="badge badge-warning">На паузе</span>
													@endif							
													@if ($record->status == 'deleted')
														<span class="badge badge-danger">Удалён</span>
													@endif												
												</td>
												<td class="footable-visible">{{ date('d.m.Y - H:i', strtotime($record->created_at)) }}</td>
												<td class="footable-visible">{{ date('d.m.Y - H:i', strtotime($record->updated_at)) }}</td>
												<td class="text-right footable-visible footable-last-column">
													<div class="btn-group">
														<a href="/admin/playlist/edit/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-pencil"></i></a>
														<a href="/admin/delete_record/playlist/{{ $record->id }}" class="btn-white btn btn-xs"><i class="fa fa-close"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>Нет данных!</td>
										</tr>
									@endif
									@else
										<tr><td>Нет прав!</td></tr>
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
				<div class="col-lg-12">
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