function deliveryUpdate() {
	var total_products_price, total_price;
	
	total_products_price = parseFloat($('#cart_total_price').val());
	
	var selected_delivery = delivery_types[$('#delivery_type_id').val()];
	
	if (!selected_delivery) {
		selected_delivery = delivery_types[1];
	}
	
	total_price = total_products_price + convertPrice(selected_delivery.delivery_type_price) + convertPrice(selected_payment.payment_type_price);
	
	$('#order_total_price').html(formatPrice(total_price));
}

function selectDelivery(id) {
	$('.delivery-types > a').removeClass('active');
	$('.delivery-types input[type="radio"]').prop('checked', false);
	$('.delivery-types > [data-id="' + id + '"]').addClass('active');
	$('.delivery-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
	
	$('#delivery_type_id').val(id);
	
	// update possible payments
	$('.payment-types > a').addClass('disabled');
	
	var delivery = delivery_types[id];
	for (var i = 0, max = delivery.allowed.length; i < max; i++) {
		$('.payment-types > #link_payment_type_' + delivery.allowed[i]).removeClass('disabled');
	}		
}

$(function() {

	$('.delivery-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			selectDelivery(this.dataset.id);
			deliveryUpdate();
		}
	});	
		
});