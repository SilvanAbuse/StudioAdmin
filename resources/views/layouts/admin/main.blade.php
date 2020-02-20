<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-translate-customization" content="b6703fd8b1d84044-bd4dd2611d59f8dc-g6a8fe920a18c8f60-d"></meta>
    <title>{{ $page_title }}</title>
    <link href="/adm/css/bootstrap.min.css" rel="stylesheet">
    <link href="/adm/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/adm/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/adm/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
    <link href="/adm/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/adm/css/animate.css" rel="stylesheet">
    <link href="/adm/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.tagsinput-revisited.css">
    <link rel="stylesheet" type="text/css" href="/adm/css/bootstrap-datetimepicker-build.css">
</head>

<body class="">
    <div id="google_translate_element"></div>
    <form id="logout_form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
								STUDIO
							</strong>
                             </span>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            ST+
                        </div>
                    </li>
                    @if(Auth::user()->role_id == 1)
					<li @if (Route::current()->getName() == 'admin_users' or Route::current()->getName() == 'admin_uadd' or Route::current()->getName() == 'admin_uedit') class="active" @endif>
                        <a href="/admin/users"><i class="fa fa-user"></i> <span class="nav-label">Пользователи</span></a>
                    </li>
                  @endif
                    @if(Auth::user()->role_id == 1)
					<li @if (Route::current()->getName() == 'admin_categories' or Route::current()->getName() == 'admin_catadd' or Route::current()->getName() == 'admin_catedit') class="active" @endif>
                        <a href="/admin/categories"><i class="fa fa-database"></i> <span class="nav-label">Категории</span></a>
                    </li>
                  @endif
					<li @if (Route::current()->getName() == 'admin_studios' or Route::current()->getName() == 'admin_sadd' or Route::current()->getName() == 'admin_sedit') class="active" @endif>
                        <a href="/admin/studios"><i class="fa fa-home"></i> <span class="nav-label">Студии</span></a>
                    </li>
                    @if(Auth::user()->role_id == 1)
					<li @if (Route::current()->getName() == 'admin_reviews' or Route::current()->getName() == 'admin_radd' or Route::current()->getName() == 'admin_redit') class="active" @endif>
                        <a href="/admin/reviews"><i class="fa fa-envelope"></i> <span class="nav-label">Отзывы</span></a>
                    </li>
                  @endif
                    @if(Auth::user()->role_id == 1)
					<li @if (Route::current()->getName() == 'admin_bonus' or Route::current()->getName() == 'admin_badd' or Route::current()->getName() == 'admin_bedit') class="active" @endif>
                        <a href="/admin/bonus"><i class="fa fa-list"></i> <span class="nav-label">Каталог бонусов</span></a>
                    </li>
                  @endif
                    @if(Auth::user()->role_id == 1)
					<li @if (Route::current()->getName() == 'admin_bon' or Route::current()->getName() == 'admin_boadd' or Route::current()->getName() == 'admin_boedit') class="active" @endif>
						<a href="/admin/bon"><i class="fa fa-money"></i> <span class="nav-label">История бонусов</span></a>
					</li>
        @endif
          @if(Auth::user()->role_id == 1)
					<li @if (Route::current()->getName() == 'admin_pushes' or Route::current()->getName() == 'admin_puadd' or Route::current()->getName() == 'admin_puedit') class="active" @endif>
						<a href="/admin/pushes"><i class="fa fa-comment"></i> <span class="nav-label">Пуши</span></a>
					</li>
        @endif
                </ul>
            </div>
        </nav>
        @yield('content')
    </div>
    <script src="/adm/js/jquery-3.1.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="/adm/js/bootstrap.min.js"></script>
    <script src="/adm/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/adm/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/adm/js/inspinia.js"></script>
    <script src="/adm/js/plugins/pace/pace.min.js"></script>
    <script src="/adm/js/plugins/summernote/summernote.min.js"></script>
    <script src="/adm/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="/adm/js/jquery.maskedinput.js"></script>
    <script src="/adm/js/moment.min.js"></script>
	<script src="/adm/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU&apikey=e2f1ed2f-0736-45e7-bcbf-e1d6f7db4572" type="text/javascript"></script>
	<script>
		$(document).ready(function() {

function getDayOfWeek(dayofWeek) {
	var days = [
  	"Воскресенье",
    "Понедельник",
    "Вторник",
    "Среда",
    "Четверг",
    "Пятница",
    "Суббота"
  ];
  
  return days[dayofWeek];

}

function getMonthName(monthNumber) {
	var monthNames = [
  	"Января",
    "Февраля",
    "Марта",
    "Апреля",
    "Мая",
    "Июня",
    "Июля",
    "Августа",
    "Сентября",
    "Октября",
    "Ноября",
    "Декабря"
  ];
  
  return monthNames[monthNumber];

}
			
			$(document).on('click', '.btn_addc', function() {
				
				$.ajax({
					
					url: $('#add_s').attr('action'),
					type: 'post',
					data: $('#add_s').serialize(),
					dataType: 'json',
					success: function(response) {
						
						if (response.status == 'error') {
							alert(response.msg);
						}
						else {
							
							$('#add_s')[0].reset();
							alert('Занятие добавлено!');
							ajax_c_events();
							
						}
						
					}
					
				});
				
			});
			
			function ajax_c_events() {
				
				var call_url = $('#call_change').val();
				var sel_date = $('#sel_date').val();
				call_url += '/'+sel_date;
				
				$.ajax({
					
					url: call_url,
					type: 'get',
					dataType: 'json',
					beforeSend: function() {
						
						$('.cal_body').html('Загрузка...');
						$('.cal_body').show();
						
					},
					success: function(response) {
						
						if (response.status == 'error') {
							alert(response.msg);
						}
						else {
							
							$('.cal_body').html(response.msg);
							$('.cal_body').show();
							
						}
						
					}
					
				});
				
				return false;
				
			}
			
			$(document).on('click', '.del_s', function() {
				
				var tp = $(this).parent();
				var this_id = $(this).data('id');
				this_id = parseInt(this_id);
				
				$.ajax({
					
					url: '/admin/studios/cdelete/'+this_id,
					type: 'get',
					dataType: 'json',
					success: function(response) {
						
						if (response.status == 'error') {
							alert(response.msg);
						}
						else {
							$(tp).remove();
						}
						
					}
					
				});
				
			});

			var picker = $('.cal_dp').datepicker({
				format: 'dd/mm/yyyy',
				autoClose: true,
				todayHighlight: true
			});
			picker.on('changeDate', function(e) {
				
				var this_d = e.date.getDate();
				var this_month = getMonthName(e.date.getMonth());
				var this_day = getDayOfWeek(e.date.getDay());
				
				console.log(e.date.getDay());
				var this_html = this_day+', '+e.date.getDate()+' '+this_month;
				$('.cal_dp').html(this_html+'<span></span>');
				
				this_d = ("0" + e.date.getDate()).slice(-2);
				this_m = ("0" + (e.date.getMonth() + 1)).slice(-2);
				$('#sel_date').val(this_d+'-'+this_m+'-'+e.date.getFullYear());
				$('#date_start').val($('#sel_date').val());
				ajax_c_events();
				
			});
			
			$(document).on('change', '#sel_date', function() {
				picker.changeDate();
			});
			
			$(document).on('click', '.nr_add', function() {
				
				var sample_html = '<div class="col-lg-12 sample_rate">'+$('.sample_rate').first().html()+'</div>';
				$(sample_html).insertAfter($('.sample_rate').last());
				$('.sample_rate').last().find('h5').text('Занятие №'+($('.sample_rate').length - 1));
				return false;
				
			});
			$(document).on('click', '.nr_remove', function() {
				
				$(this).parent().parent().parent().parent().remove();
				return false;
				
			});

			$('.datetime').datetimepicker();

			$(document).on('click', '#select_users', function() {

				$('#select_us').find('option').each(function() {
					$(this).prop('selected', true);
				});

			});

			$('.dates_a').each(function() {

				if ($(this).val() == 'false') {
					$(this).parent().parent().find('input').attr('disabled', 'disabled');
				}

			});

			$(document).on('change', '.dates_a', function() {

				var this_val = $(this).val();
				if (this_val == 'false') {
					$(this).parent().parent().find('input').attr('disabled', 'disabled');
				}
				else {
					$(this).parent().parent().find('input').removeAttr('disabled');
				}

			});

			$(document).on('click', '.rate_select a', function() {

				var stars = $(this).data('stars');
				stars = parseInt(stars);

				$('.rate_select').find('a').find('i').each(function() {
					$(this).removeClass('fa-star').addClass('fa-star-o');
				});

				for (var i = 0; i < stars; i++) {
					$('.rate_select').find('a').eq(i).find('i').removeClass('fa-star-o').addClass('fa-star');
				}

				$('input[name=rating]').val(stars);

			});

			$('input[name=phone]').mask('+7 (999) 999-99-99');
			$('.time_mask').mask('99:99');

			var ymap;
			var splace;

			ymaps.ready(init_map);

			function createPlacemark(coords) {

				return new ymaps.Placemark(coords, {
					iconCaption: 'поиск...'
				}, {
					preset: 'islands#violetDotIconWithCaption',
					draggable: false,
				});

			}

			function getAddress(coords) {
				splace.properties.set('iconCaption', 'поиск...');
				ymaps.geocode(coords).then(function (res) {
					var firstGeoObject = res.geoObjects.get(0);

					$('input[name=address]').val(firstGeoObject.getAddressLine());

					splace.properties
						.set({
							iconCaption: [
								firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
								firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
							].filter(Boolean).join(', '),
							balloonContent: firstGeoObject.getAddressLine()
						});
				});
			}

			var obj;

			function init_map() {

				$('#map').css('width', '100%');
				$('#map').css('height', '450px');

				if ($('#loc').length) {

					var this_coord = $('#loc').val();
					this_coord = this_coord.split(',');
					var coords = [parseFloat(this_coord[0]), parseFloat(this_coord[1])];

					var ymap = new ymaps.Map("map", {
						center: coords,
						zoom: 12
					});

					obj = new ymaps.Placemark(coords, {
						iconCaption: 'Расположение студии'
					}, {
						preset: 'islands#violetDotIconWithCaption',
						draggable: false,
					});
					ymap.geoObjects.add(obj);

				}
				else {

					if ($('#loc1').length) {

						var this_coord = $('#loc1').val();
						this_coord = this_coord.split(',');
						var coords = [parseFloat(this_coord[0]), parseFloat(this_coord[1])];

						var ymap = new ymaps.Map("map", {
							center: coords,
							zoom: 12
						});

						splace = new ymaps.Placemark(coords, {
							iconCaption: 'Расположение студии'
						}, {
							preset: 'islands#violetDotIconWithCaption',
							draggable: false,
						});
						ymap.geoObjects.add(splace);

						ymap.events.add('click', function(e) {

							var coords = e.get('coords');
							$('input[name=gps]').val(coords);

							if (splace) {
								splace.geometry.setCoordinates(coords);
							}
							else {

								splace = createPlacemark(coords);
								ymap.geoObjects.add(splace);

							}

							getAddress(coords);

						});

					}
					else {

						var ymap = new ymaps.Map("map", {
							center: [55.76, 37.64],
							zoom: 7
						}, {
                searchControlProvider: 'yandex#search'
            });

						ymap.events.add('click', function(e) {

							var coords = e.get('coords');
							$('input[name=gps]').val(coords);

							if (splace) {
								splace.geometry.setCoordinates(coords);
							}
							else {

								splace = createPlacemark(coords);
								ymap.geoObjects.add(splace);

							}

							getAddress(coords);

						});

					}

				}

			}

		});
	</script>
</body>
</html>
