function _includes(arr,obj) {
    return (arr.indexOf(obj) != -1);
}

Number.prototype.formatMoney = function(c, d, t) {
	var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "," : d, 
    t = t == undefined ? "." : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}


// COOKIES CHECK

$(function() {
  if (!checkCookies()) {
		$('#cookies_disabled').show();
	}
});

function checkCookies() {
	if (navigator.cookieEnabled) return true;
	document.cookie = "cookietest=1";
	var ret = document.cookie.indexOf("cookietest=") != -1;
	document.cookie = "cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";
	return ret;	
}

// set cookie value
function setCookie(cname, cvalue, exdays, path) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = 'expires='+d.toUTCString();
    document.cookie = cname + '=' + cvalue + '; ' + expires + ';path=' + path;
}

function getCookie(cname) {
    var name = cname + '=';
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return '';
} 

// change language
function setLang(lang) {
	setCookie('language', lang, 365, '/');
	document.location = document.location;
}

function setCurrency(curr) {
	setCookie('currency', curr, 365, '/');
	document.location = document.location;
}

// AJAX LOADER

function showAjaxLoaders() {
	$('.ajax-loader').animate({opacity:1});
}

function hideAjaxLoaders() {
	$('.ajax-loader').animate({opacity:0});
}

// SIDE MENU

function sideMenuUpdateToggle(caller) {
	var id = String.substr(caller.id, 15);
	var state = $(caller).hasClass('in');
	var toggle = $('#zmenu-toggle-' + id);
	toggle.removeClass('glyphicon-triangle-right');
	toggle.removeClass('glyphicon-triangle-bottom');
	
	if (state) {
		toggle.addClass('glyphicon-triangle-bottom');
	} else {
		toggle.addClass('glyphicon-triangle-right');
	}
}

$('.zmenu-collapse').on('show.bs.collapse', function () {
	sideMenuUpdateToggle(this);
});
$('.zmenu-collapse').on('hide.bs.collapse', function () {
	sideMenuUpdateToggle(this);
});
$('.zmenu-collapse').on('shown.bs.collapse', function () {
	sideMenuUpdateToggle(this);
});
$('.zmenu-collapse').on('hidden.bs.collapse', function () {
	sideMenuUpdateToggle(this);
});

// CART

function updateCart(data) {
	$('.cart-total-price').html(data.total_cart_price_formatted);
	$('#cart_total_price').val(data.total_cart_price_converted);
	if (typeof cartUpdate == 'function') {
		cartUpdate();
	}
}

function productAdded(data) {
	updateCart(data);
	hideAjaxLoaders();
}

function addProductToCart(id) {
	showAjaxLoaders();
	var cnt = $('#prod_count_' + id).val();
	$.getJSON('/json/default/json-cart/add', 
		{
			product_id: id,
			count: cnt
		},
		productAdded
	);
}

function productUpdated(data) {
	updateCart(data);	
	$('#item_total_price_'+data.ii).html(data.ip);
	hideAjaxLoaders();
}

function updateProductInCart(id) {
	showAjaxLoaders();
	var cnt = $('#prod_count_' + id).val();
	$.getJSON('/json/default/json-cart/update', 
		{
			product_id: id,
			count: cnt
		},
		productUpdated
	);
}