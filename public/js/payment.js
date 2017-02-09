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
		}
	});
		
});