function cartUpdate() {
	var total_price;	
	total_price = parseFloat($('#cart_total_price').val());
	$('#order_total_price').html(formatPrice(total_price));
}

function getItemCount(id) {
	return parseInt($('#prod_count_'+id).val());
}

function setItemCount(id, cnt) {
	return $('#prod_count_'+id).val(parseInt(cnt));
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