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

// AJAX LOADER

function showAjaxLoaders() {
	$('.ajax-loader').animate({opacity:1});
}

function hideAjaxLoaders() {
	$('.ajax-loader').animate({opacity:0});
}

// CART

function updateCart(data) {
	$('.cart-total-price').html(data.pf);
}

function productAdded(data) {
	updateCart(data);
	hideAjaxLoaders();
}

function addProductToCart(id) {
	showAjaxLoaders();
	var cnt = $('#prod_count_' + id).val();
	$.getJSON('/ajax/cart/add', 
			{
				product_id: id,
				count: cnt
			},
			productAdded
		);
	return false;
}

function productUpdated(data) {
	updateCart(data);	
	$('#item_total_price_'+data.ii).html(data.ip);
	hideAjaxLoaders();
}

function updateProductInCart(id) {
	showAjaxLoaders();
	var cnt = $('#prod_count_' + id).val();
	$.getJSON('/ajax/cart/update', 
			{
				product_id: id,
				count: cnt
			},
			productUpdated
		);
	return false;
}