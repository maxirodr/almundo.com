(function($) {
	"use strict";
	$(document).ready(function() {
		ui__onlyonenav();
		ui__tooltip();
		ui__sg_resize_body();
		ui__sg_center_form();
		ui__sg_hidesearch();
		ui__pd_slide();

		show_login();

		// Only publish
		publish();

		$(window).resize(function() {
			ui__sg_resize_body();
			ui__sg_center_form();
		});
	});
})(jQuery);

var user = {
	navigation: {
		site: $('section.site').data('site')
	},
	session: {
		active: true
	}
}

var site = {
	ui: {
		button: {
			login: $('.button.open_login .bb'),
		},
		other: {
			loginbox: $('.button.open_login .panel_opened'),
		},
	},
}

var SaveData = {}

function ui__onlyonenav(){
	$('.navbar').on('show.bs.collapse', function () {
		var actives = $(this).find('.collapse.in'),
			hasData;
		
		if (actives && actives.length) {
			hasData = actives.data('collapse')
			if (hasData && hasData.transitioning) return
			actives.collapse('hide')
			hasData || actives.data('collapse', null)
		}
	});
}

function ui__tooltip(){
	$('[data-toggle="tooltip"]').tooltip({html: true}); 
}

function show_login(){
	if (!(typeof site.ui.button.login === "undefined")){
		$(document).click(function(event){
			if(!$(event.target).closest('.button.open_login .panel_opened').length) {
				if (site.ui.other.loginbox.is(":visible")){
					site.ui.other.loginbox.fadeOut(150);
				}
				else {
					if ($(event.target).closest('.button.open_login .bb').length){
						site.ui.other.loginbox.fadeIn(150);
					}
				}
			}
		});

		$('form.login').submit(function(event) {
			event.preventDefault();
			var dataSend = {
				username: $('form.login input#email').val(),
				password: $('form.login input#pwd').val()
			}

			loading(true);
			
			$.ajax({
				url: $('form.login').attr('action'),
				type: 'POST',
				dataType:"json",
				data: dataSend,
				success: function(data) {
					if (data.error == 0){
						location.reload();
					}
					else {
						loading(false);
						$('form.login .error').show(0).text(data.error);
					}
				},
				error: function(jqXHR, textStatus, error) {
					alert( "error: " + jqXHR.responseText);
					location.reload();
				}
			}); 

		});
	}

	function loading(start){
		var load = $('.button.open_login .panel_opened');
		if (start)
			load.addClass('loading')
		else
			load.removeClass('loading')
	}
}

/* ====================
/* SIGNUP
/* ==================== */

function ui__sg_resize_body(){
	var contentHeight = $('header').outerHeight() + $('nav').outerHeight() + $('footer').outerHeight(),
		container = $('section.signup'),
		wHeight = $(window).height(),
		height = wHeight-contentHeight;

	$(container).css({ 'min-height' : height+'px' });
}

function ui__sg_center_form(){
	var container = $('.signup'),
		form = $('.signup-form'),
		padding = 20;

	if ( (form.height() + padding) >= container.height() ) {
		container.css({ 'padding' : padding+'px 0' });
		form.css({ 'margin-top' : '0px'});
	}
	else {
		var margin = (container.height() - form.height()) / 2;
		container.css({ 'padding' : '0'});
		form.css({ 'margin-top' : margin+'px'})
	}
}

function ui__sg_hidesearch(){
	if (user.navigation.site == 'signup')
		$('.search-fixed').hide();
}

/* ====================
/* PRODUCTS
/* ==================== */

function ui__pd_slide(){
	var each = $('.product-photo'),
		show = $('.product-principal-photo'),
		colors = $('.sm-colors .colors .c1');

	show.attr('src', $(each).first().attr('src'));

	each.click(function(){
		show.attr('src', $(this).attr('src'));
	});

	colors.click(function(){
		show.attr('src', $(this).data('img'));
	});


}

/* ====================
/* ADS
/* ==================== */

function ui__ads_setsizerightpanel(){
	var element = $('.panel-ad.right');

	set();

	$(window).resize(function(){
		set();
	});

	function set(){
		var wWidth = $(window).width(),
		hWidth = $(window).height();

		if (wWidth <= 1250)
			element.hide()
		else 
			element.show().css({ 'height': hWidth+'px', 'width' : wWidth*0.14+'px' });
	}

	setTimeout(function(){
		element.fadeOut(300);
	}, 15000);
}

/* ====================
/* EFFECTS
/* ==================== */

function roulette(){
	var Roulette = {
		spin: {
			button: $('.spin'),
			disabled: false,
			type: getRandomInt(1,3),
			duration: 4500,
		},
		element: {
			roulette: $('.roulette'),
			turn: $('.circle .rl'),
			arrow: $('.arrow'),
			prize: {
				element: $('.prize'),
				t: $('.prize p strong'),
				image: $('.prize img')
			},
		},
		config: {
			laps: 2
		},
	}

	if (!Roulette.spin.disabled){
		$(Roulette.spin.button).click(function(){
			Roulette.spin.disabled = true;
			disable_spinbutton();

			$.ajax({
				type: 'POST',
				url: '//tarjetealo.com/basic/data/roulette.php',
				dataType: 'json',
				success: function(data) {
					var turnTo = -((data-1)*30 + (5+(Roulette.spin.type-1)*10)),
						time = (((-1)*turnTo)/360 * Roulette.spin.duration) + Roulette.spin.duration*Roulette.config.laps,
						adLaps = turnTo - Roulette.config.laps*360;

					set_prize(data);

					Roulette.element.turn.animate(
						{ 'text-indent' : adLaps+'px' },
						{ 
							step: function(now)
								{
									$(this).css({
										'-moz-transform' : 'rotate('+now+'deg)',
										'-webkit-transform' : 'rotate('+now+'deg)',
										'-o-transform' : 'rotate('+now+'deg)',
										'-ms-transform' : 'rotate('+now+'deg)',
										'transform' : 'rotate('+now+'deg)',
									})

									if ((((now/30)-Math.floor(now/30))<0.1) && !(now==0)){

										$(Roulette.element.arrow).addClass('effect');

										if ( $(Roulette.element.arrow).hasClass('effect') )
											setTimeout(function(){
												$(Roulette.element.arrow).removeClass('effect');
											}, 200);
									}

									if (now == adLaps) {
										animate_paperrain();

										console.log(Roulette.element.prize.element)

										setTimeout(function(){
											Roulette.element.roulette.animate({'opacity':'0'}, 200, 'linear');
											Roulette.element.prize.element.animate({'opacity':'1'}, 200, 'linear');
										}, 500);
									}
								},
							duration: time
						},
						$.bez([0.000, 2, 0.000, 2])
					);

				},
				error: function(jqXHR, textStatus, error) {
					// alert( "error: " + jqXHR.responseText)
					alert('Hubo un error. Por favor actualizá la página e intentá de nuevo.');
				}

			});
		});
	}

	function disable_spinbutton(){
		Roulette.spin.button.addClass('disabled');
	}

	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	function set_prize(num){
		Roulette.element.prize.image.attr('src', 'http://placehold.it/700x700/ff1744/fff/?text=Premio '+num+'')
		Roulette.element.prize.t.text('premio '+num+'')
	}
}

function roulette_height(){
	var container = $('.site[data-site="roulette"]'),
		menuHeight = $('header').outerHeight() + $('.navbar.home').outerHeight(),
		search = $('.search-fixed');

	search.hide(0);
	height();

	$(window).resize(function(){ height(); });

	function height(){
		var wHeight = $(window).height();
		if (!( menuHeight+$(container).height() >=$(window).height()))
			container.css({ 'height' : (wHeight-menuHeight)+'px' })
		else
			container.css({ 'height' : 'auto' })
	}
}

function animate_paperrain(){
	var parent = $('.paper-rain'),
		wHeight = $(window).height(),
		duration = { max: 4000, min: 1500 },
		papers = 100;

	for (i=1;i<=papers;i++)
		parent.append('<div class="p"></div>');

	var paper = $('.paper-rain .p');

	paper.each(function(index){
		var perspective = getRandomArbitrary(0,300),
			rotate = getRandomArbitrary(0,360),
			willRY = getRandomArbitrary(-5,5);

		$(this).css( {
			'top' : getRandomArbitrary(-450,-50)+'px',
			'left' : getRandomArbitrary(0,parent.width())+'px',
			'-webkit-perspective' : perspective+'px',
			'perspective' : perspective+'px',
			'-webkit-transform' : 'rotate('+rotate+'deg)',
			'transform' : 'rotate('+rotate+'deg)'
		} );

		$(this).animate({ 'top':	(wHeight-50)+'px' }, {
			step: function(now,fx) {
				$(this).css({
					'transform' : 'rotate('+(now/10)*2+'deg) rotateY('+(now/10)*willRY+'deg)',
					'-webkit-transform' : 'rotate('+(now/10)*2+'deg) rotateY('+(now/10)*willRY+'deg)'
				})
			},
			duration: getRandomArbitrary(duration.min,duration.max),
			easing: 'linear',
			done: function(){ $(this).fadeOut(100); }
		});
	});


	function getRandomArbitrary(min, max) {
		return Math.random() * (max - min) + min;
	}

	function getRotationDegrees(element) {
		var matrix = element.css("-webkit-transform") ||
		element.css("-moz-transform")	||
		element.css("-ms-transform")	||
		element.css("-o-transform")		||
		element.css("transform");
		if(matrix !== 'none') {
			var values = matrix.split('(')[1].split(')')[0].split(',');
			var a = values[0];
			var b = values[1];
			var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
		} else { var angle = 0; }
		return (angle < 0) ? angle + 360 : angle;
	}
}

(function(factory) {
	if (typeof exports === "object") {
		factory(require("jquery"));
	} else if (typeof define === "function" && define.amd) {
		define(["jquery"], factory);
	} else {
		factory(jQuery);
	}
}(function($) {
	$.extend({ bez: function(encodedFuncName, coOrdArray) {
		if ($.isArray(encodedFuncName)) {
			coOrdArray = encodedFuncName;
			encodedFuncName = 'bez_' + coOrdArray.join('_').replace(/\./g, 'p');
		}
		if (typeof $.easing[encodedFuncName] !== "function") {
			var polyBez = function(p1, p2) {
				var A = [null, null], B = [null, null], C = [null, null],
						bezCoOrd = function(t, ax) {
							C[ax] = 3 * p1[ax], B[ax] = 3 * (p2[ax] - p1[ax]) - C[ax], A[ax] = 1 - C[ax] - B[ax];
							return t * (C[ax] + t * (B[ax] + t * A[ax]));
						},
						xDeriv = function(t) {
							return C[0] + t * (2 * B[0] + 3 * A[0] * t);
						},
						xForT = function(t) {
							var x = t, i = 0, z;
							while (++i < 14) {
								z = bezCoOrd(x, 0) - t;
								if (Math.abs(z) < 1e-3) break;
								x -= z / xDeriv(x);
							}
							return x;
						};
				return function(t) {
					return bezCoOrd(xForT(t), 1);
				}
			};
			$.easing[encodedFuncName] = function(x, t, b, c, d) {
				return c * polyBez([coOrdArray[0], coOrdArray[1]], [coOrdArray[2], coOrdArray[3]])(t/d) + b;
			}
		}
		return encodedFuncName;
	}});
}));

/* ====================
/* BUY
/* ==================== */

function select_shipping_date(){
	$('#select_shipping_date').datepicker({ minDate: +2, maxDate: "+10D", dateFormat: "dd' de 'MM"});
}

( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {

datepicker.regional.es = {
	closeText: "Cerrar",
	prevText: "&#x3C;Ant",
	nextText: "Sig&#x3E;",
	currentText: "Hoy",
	monthNames: [ "enero","febrero","marzo","abril","mayo","junio",
	"julio","agosto","septiembre","octubre","noviembre","diciembre" ],
	monthNamesShort: [ "ene","feb","mar","abr","may","jun",
	"jul","ago","sep","oct","nov","dic" ],
	dayNames: [ "domingo","lunes","martes","miércoles","jueves","viernes","sábado" ],
	dayNamesShort: [ "dom","lun","mar","mié","jue","vie","sáb" ],
	dayNamesMin: [ "do","lu","ma","mi","ju","vi","sa" ],
	weekHeader: "Sm",
	dateFormat: "dd/mm/yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.es );

return datepicker.regional.es;

} ) );

/* PUBLISH */

function publish(){
	if (user.navigation.site == 'publish'){
		publish_cat_select();
		publish_navigation();
		publish_next_button();
	}
}

function publish_cat_select(){
	var box = function(level){ return $('.box-sec[data-level="'+level+'"]')},
		button = $('.button-continue[data-next="descripcion"]');

	SaveData.category = {}

	$('body').on('click', '.box-sec .list-item', function () {
		var level = parseInt($(this).parent().data('level')),
			cat   = $(this).data('cat');

		clearObj(level);
		SaveData.category[level] = cat;

		$('.box-sec[data-level="'+level+'"] .list-item').removeClass('selected');
		$(this).addClass('selected');

		var sendData = {
			type: (level+1),
			id_cat: cat
		}

		ajax(sendData, false);
	});

	// First load
	ajax({type: 1, id_cat: 1}, true);

	function clearObj(level){
		for (var i=level;i<=4;i++){
			delete SaveData.category[i];
		}
	}

	function ajax(sendData, firstload){
		button.removeClass('can-continue');
		if (sendData.type == 2) { box(2).html(''); box(3).html(''); box(4).html(''); }
		if (sendData.type == 3) { box(3).html(''); box(4).html(''); }

		$.ajax({
			url: '/basic/ajax/publicar_cats.php',
			type: 'POST',
			// dataType: 'json',
			data: sendData,
			success: function(data) {
				if (firstload){
					box(1).html(data);
				}
				else {
					if (data != 0){
						box(sendData.type).html(data);
						if (sendData.type == 5) { button.addClass('can-continue'); }
					}
					else {
						button.addClass('can-continue');
					}
				}
			},
			error: function(jqXHR, textStatus, error) {
				console.log( "error: " + jqXHR.responseText);
			}
		});
	}
}

function publish_navigation(){
	if (window.location.hash == '#categoria') hashchange('#categoria')
	else window.location.hash = 'categoria';

	$(window).on('hashchange', function() {
		var hash = window.location.hash;
		hashchange(hash);
	});

	function hashchange(hash){
		var allBlocks = $('.publish-carousel .item'),
			findBlock = function(hash){ return $('.publish-carousel .item'+hash); };

		allBlocks.fadeOut(200, function(){
			findBlock(hash).fadeIn(200);
		});

		if (hash == '#descripcion'){}
		else if (hash == '#envio'){}
		else if (hash == '#publicacion'){}
		else {
			if (hash != '#categoria') window.location.hash = 'categoria';
			window.scrollTo(0, 0);
		}
	}
}

function publish_next_button(){
	$('body').on('click', '.button-continue', function () {
		var hash = {
			actual: '#'+$(this).data('actual'),
			next: $(this).data('next')
		}
		if (hash.actual == 'categoria' || $(this).hasClass('can-continue')){
			window.location.hash = hash.next;
		}
		window.scrollTo(0, 0);
	});
}