/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.7.1
 *
 */

$(document).ready(function () {
		
$(function(){
  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  $('.nav-tabs a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });
});
	
	/* DatePicker */
	$('.datepicker').datepicker();
	
	/* Предпросмотр фото */
	function preview_image(input, append_to) {
		
		if (input.files && input.files[0]) {
		
			var reader = new FileReader();
			reader.onload = function(e) {
				$(append_to).html('<img src="'+(e.target.result)+'">');
			}
			
			reader.readAsDataURL(input.files[0]);
		
		}
		
	}
	
	/* Загрузка фото */
	$('.photo_container').click(function() {
		$(this).prev().click();
	});
	$(document).on('change', '.pc_input', function() {
		
		var append_to = $(this).data('append_to');
		append_to = $('#'+append_to);

		if (!append_to) {
			
			alert('Произошла ошибка!');
			return false;
			
		}
		
		preview_image(this, append_to);
		$(append_to).addClass('nohint');
		
	});

	/* Подгрузка районов города */
	$(document).on('change', '#city_id', function() {
		
		var city_id = $(this).val();
		city_id = parseInt(city_id);
		
		if (city_id == 0) {
			
			$('#region_id').attr('disabled', 'disabled');
			return false;
		
		}
		
		$.ajax({
			
			url: '/get_city_regions/?city_id='+city_id,
			type: 'get',
			dataType: 'json',
			success: function(response) {
				
				if (response.status == 'ok') {
					
					$('#region_id').removeAttr('disabled');
					$('#region_id').html(response.html);
					$('#region_id').find('option').first().remove();
					$('#region_id').find('option').each(function() {
						
						if ($(this).val() == $('#region_id_old').val()) {
							$(this).attr('selected', 'selected');
						}
						
					});
					
				}
				
			}
			
		});
		
	});
	
	if ($('#city_id').length) {
		$('#city_id').change();
	}

	$(document).on('click', '.logout_do', function() {
		$('#logout_form').submit();
	});
	
	$(document).on('click', '.update_pack', function() {
		
		var this_block = $(this).find('span');
		var pack_id = $(this).data('id');
		var method = $(this).data('method');
		var value = $(this).attr('data-value');
		
		$.ajax({
			
			url: '/admin/packs/'+method,
			type: 'post',
			data: 'id='+pack_id+'&value='+value,
			dataType: 'json',
			success: function(response) {
				
				if (response.status == 'error') {
					alert(response.msg);
				}
				if (response.status == 'ok') {
					
					if (value == '0') {
						
						$(this_block).parent().attr('data-value', '1');
						$(this_block).removeClass('label-primary').addClass('label-danger').text('Нет');
						
					}
					else {
						
						$(this_block).parent().attr('data-value', '0');
						$(this_block).removeClass('label-danger').addClass('label-primary').text('Да');
						
					}
					
				}
				
			}
			
		});
		
		return false;
		
	});
	
	$(document).on('click', '.update_user', function() {
		
		var this_block = $(this).find('span');
		var user_id = $(this).data('id');
		var method = $(this).data('method');
		var value = $(this).attr('data-value');
		
		$.ajax({
			
			url: '/admin/users/'+method,
			type: 'post',
			data: 'user_id='+user_id+'&value='+value,
			dataType: 'json',
			success: function(response) {
				
				if (response.status == 'error') {
					alert(response.msg);
				}
				if (response.status == 'ok') {
					
					if (value == '0') {
						
						$(this_block).parent().attr('data-value', '1');
						$(this_block).removeClass('label-primary').addClass('label-danger').text('Блок');
						
					}
					else {
						
						$(this_block).parent().attr('data-value', '0');
						$(this_block).removeClass('label-danger').addClass('label-primary').text('Активен');
						
					}
					
				}
				
			}
			
		});
		
		return false;
		
	});
	
	$(document).on('click', '.update_ads', function() {
		
		var this_block = $(this).find('span');
		var ads_id = $(this).data('id');
		var method = $(this).data('method');
		var value = $(this).attr('data-value');
		
		$.ajax({
			
			url: '/admin/ads/'+method,
			type: 'post',
			data: 'ads_id='+ads_id+'&value='+value,
			dataType: 'json',
			success: function(response) {
				
				if (response.status == 'error') {
					alert(response.msg);
				}
				if (response.status == 'ok') {
					
					if (value == '0') {
						
						$(this_block).parent().attr('data-value', '1');
						$(this_block).removeClass('label-primary').addClass('label-danger').text('Нет');
						
					}
					else {
						
						$(this_block).parent().attr('data-value', '0');
						$(this_block).removeClass('label-danger').addClass('label-primary').text('Да');
						
					}
					
				}
				
			}
			
		});
		
		return false;
		
	});
	
	$(document).on('click', '.update_page', function() {
		
		var this_block = $(this).find('span');
		var page_id = $(this).data('id');
		var method = $(this).data('method');
		var value = $(this).attr('data-value');
		
		$.ajax({
			
			url: '/admin/pages/'+method,
			type: 'post',
			data: 'id='+page_id+'&value='+value,
			dataType: 'json',
			success: function(response) {
				
				if (response.status == 'error') {
					alert(response.msg);
				}
				if (response.status == 'ok') {
					
					if (value == '0') {
						
						$(this_block).parent().attr('data-value', '1');
						$(this_block).removeClass('label-primary').addClass('label-danger').text('Нет');
						
					}
					else {
						
						$(this_block).parent().attr('data-value', '0');
						$(this_block).removeClass('label-danger').addClass('label-primary').text('Да');
						
					}
					
				}
				
			}
			
		});
		
		return false;
		
	});
	
	$(document).on('click', '.update_post', function() {
		
		var this_block = $(this).find('span');
		var post_id = $(this).data('id');
		var method = $(this).data('method');
		var value = $(this).attr('data-value');
		
		$.ajax({
			
			url: '/admin/posts/'+method,
			type: 'post',
			data: 'id='+post_id+'&value='+value,
			dataType: 'json',
			success: function(response) {
				
				if (response.status == 'error') {
					alert(response.msg);
				}
				if (response.status == 'ok') {
					
					if (value == '0') {
						
						$(this_block).parent().attr('data-value', '1');
						$(this_block).removeClass('label-primary').addClass('label-danger').text('Нет');
						
					}
					else {
						
						$(this_block).parent().attr('data-value', '0');
						$(this_block).removeClass('label-danger').addClass('label-primary').text('Да');
						
					}
					
				}
				
			}
			
		});
		
		return false;
		
	});
	
	$(document).on('click', '.logout_do', function() {
		$('#logout_form').submit();
	});

    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetisMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.children('.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').on('click', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Run menu of canvas
    $('body.canvas-menu .sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').on('click', function () {
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').on('click', function () {
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').on('click', function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // Append config box / Only for demo purpose
    // Uncomment on server mode to enable XHR calls
    //$.get("skin-config.html", function (data) {
    //    if (!$('body').hasClass('no-skin-config'))
    //        $('body').append(data);
    //});

    // Minimalize menu
    $('.navbar-minimalize').on('click', function (event) {
        event.preventDefault();
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Tooltips demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });


    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebar-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarheight = $('nav.navbar-default').height();
        var wrapperHeight = $('#page-wrapper').height();

        if (navbarheight > wrapperHeight) {
            $('#page-wrapper').css("min-height", navbarheight + "px");
        }

        if (navbarheight < wrapperHeight) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarheight > wrapperHeight) {
                $('#page-wrapper').css("min-height", navbarheight + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function () {
    if (localStorageSupport()) {

        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        var body = $('body');

        if (fixedsidebar == 'on') {
            body.addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }

        if (collapse == 'on') {
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }

            }
        }

        if (fixednavbar == 'on') {
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            body.addClass('fixed-nav');
        }

        if (boxedlayout == 'on') {
            body.addClass('boxed-layout');
        }

        if (fixedfooter == 'on') {
            $(".footer").addClass('fixed');
        }
    }
});

// check if browser support HTML5 local storage
function localStorageSupport() {
    return (('localStorage' in window) && window['localStorage'] !== null)
}

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //wait for animation to finish before removing classes
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8
        })
        .disableSelection();
}


