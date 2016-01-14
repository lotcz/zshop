// set cookie value
function setCookie(cname, cvalue, exdays, path) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = 'expires='+d.toUTCString();
    document.cookie = cname + '=' + cvalue + '; ' + expires + ';path=' + path;
}

// change language
function setLang(lang) {
	setCookie('language', lang, 365, '/');
	document.location = document.location;
}

function productAdded() {
	
}

function addProductToCart(id) {
	var cnt = $('#prod_count_' + id).val();
	$.get('/ajax/cart_add', 
			{
				product_id: id,
				count: cnt
			},
			productAdded
		);
	return false;
}