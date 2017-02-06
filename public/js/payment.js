function paymentUpdate() {
	var total_products_price, total_price;
	
	total_products_price = parseFloat($('#cart_total_price').val());
	
	var selected_delivery = delivery_types[$('#delivery_type_id').val()];
	var selected_payment = payment_types[$('#payment_type_id').val()];
		
	if (!selected_payment) {
		selected_payment = payment_types[1];
	}
	
	if (!_includes(selected_delivery.allowed, selected_payment.payment_type_id)) {		
		selected_payment = payment_types[selected_delivery.allowed[0]];
	}
	
	cartSelectPayment(selected_payment.payment_type_id);
	
	total_price = total_products_price + convertPrice(selected_delivery.delivery_type_price) + convertPrice(selected_payment.payment_type_price);
	
	$('#order_total_price').html(formatPrice(total_price));
}

function selectPayment(id) {
	$('.payment-types > a').removeClass('active');
	$('.payment-types input[type="radio"]').prop('checked', false);
	$('.payment-types > [data-id="' + id + '"]').addClass('active');
	$('.payment-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
	$('#payment_type_id').val(id);
}

$(function() {
	
	$('.payment-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			selectPayment(this.dataset.id);
			paymentUpdate();
		}
	});
		
});