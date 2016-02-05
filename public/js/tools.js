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

function productAdded(data) {
	$('#cart_price').html(data.pf);
	$('#cart_count').html(data.c);
}

function addProductToCart(id) {
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