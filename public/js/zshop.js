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

// CART preview

function updateCartPreview(data) {
	$('.cart-total-price').html(data.total_cart_price_formatted);
	$('#cart_total_price').val(data.total_cart_price_converted);
}

function productAdded(data) {
	productUpdated(data);
	hideAjaxLoaders();

  //render product fragment and show modal dialog
  $.get('/fragment/default/added-item',
    {
      product_id: data.product_id
    },
    productFragmentRendered
  );
}

function addProductToCart(id) {
  //update cart preview
	showAjaxLoaders();
	$.getJSON('/json/default/json-cart/add',
		{
			product_id: id,
			count: 1
		},
		productAdded
	);

}

function productFragmentRendered(data) {
  var addPanel = $("div#modal-added");
  $('#modal-added-item', addPanel).html(data);
  addPanel.modal("show");
}

function productUpdated(data) {
	updateCartPreview(data);
	if (typeof updateCartPage == 'function') {
		updateCartPage();
	}
	$('#item_total_price_'+data.product_id).html(data.item_price_formatted);
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

// CART page and added product modal

function getItemCount(id) {
	return parseInt($('#prod_count_'+id).val());
}

function setItemCount(id, cnt) {
	$('#prod_count_'+id).val(parseInt(cnt));

  // update amount already in cart in product preview
  if (cnt > 0) {
    $('#already_in_cart_'+id).removeClass('hidden');
  } else {
    $('#already_in_cart_'+id).addClass('hidden');
  }
  $('#in_cart_prod_count_'+id).html(parseInt(cnt));
}

function minusItem(id) {
	var c = getItemCount(id)-1;
	if (c < 1) {
		removeItem(id);
	} else {
		setItemCount(id, c);
		updateProductInCart(id);
	}
}

function plusItem(id) {
	var c = getItemCount(id)+1;
	setItemCount(id, c);
	updateProductInCart(id);
	if (c == 1) {
		reviveItem(id);
	}
}

function removeItem(id) {
	if (getItemCount(id) > 0) {
		setItemCount(id, 0);
		$('#cart_prod_'+id).addClass('removed');
	} else {
		reviveItem(id);
	}
	updateProductInCart(id);
}

function reviveItem(id) {
	setItemCount(id, 1);
	$('#cart_prod_'+id).removeClass('removed');
}
