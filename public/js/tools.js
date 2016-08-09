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

// CART

function updateCart(data) {
	$('.cart-total-price').html(data.pf);
	$('#cart_total_price').val(data.pc);
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
	$.getJSON('/ajax/cart/add', 
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
	$.getJSON('/ajax/cart/update', 
		{
			product_id: id,
			count: cnt
		},
		productUpdated
	);
}