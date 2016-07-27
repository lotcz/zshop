function cartUpdate() {
	var total_products_price, delivery_price, payment_price;
	
}

function cartSelectDelivery(id) {
	$('.delivery-types > a').removeClass('active');
	$('.delivery-types input[type="radio"]').prop('checked', false);
	$('.delivery-types > [data-id="' + id + '"]').addClass('active');
	$('.delivery-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
}

function cartSelectPayment(id) {
	$('.payment-types > a').removeClass('active');
	$('.payment-types input[type="radio"]').prop('checked', false);
	$('.payment-types > [data-id="' + id + '"]').addClass('active');
	$('.payment-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
}

$(function() {

	$('.delivery-types > a').click(function() {
		cartSelectDelivery(this.dataset.id);
	});
	
	$('.payment-types > a').click(function() {
		cartSelectPayment(this.dataset.id);
	});
	
});