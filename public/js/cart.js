function cartUpdate() {
	var total_products_price, total_price;
	
	total_products_price = parseFloat($('#cart_total_price').val());
	
	var selected_delivery = delivery_types[$('#delivery_type_id').val()];
	var selected_payment = payment_types[$('#payment_type_id').val()];
	
	if (!selected_delivery) {
		selected_delivery = delivery_types[1];
	}
	
	if (!selected_payment) {
		selected_payment = payment_types[1];
	}
	
	if (!_includes(selected_delivery.allowed, selected_payment.payment_type_id)) {		
		selected_payment = payment_types[selected_delivery.allowed[0]];
	}
	
	cartSelectPayment(selected_payment.payment_type_id);
	
	total_price = total_products_price + parseFloat(selected_delivery.delivery_type_price) + parseFloat(selected_payment.payment_type_price);
	
	$('#order_total_price').html(total_price);
}

function cartSelectDelivery(id) {
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

function cartSelectPayment(id) {
	$('.payment-types > a').removeClass('active');
	$('.payment-types input[type="radio"]').prop('checked', false);
	$('.payment-types > [data-id="' + id + '"]').addClass('active');
	$('.payment-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
	$('#payment_type_id').val(id);
}

$(function() {

	$('.delivery-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			cartSelectDelivery(this.dataset.id);
			cartUpdate();
		}
	});
	
	$('.payment-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			cartSelectPayment(this.dataset.id);
			cartUpdate();
		}
	});
	
});