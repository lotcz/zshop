function selectDelivery(id) {
	$('.delivery-types > a').removeClass('active');
	$('.delivery-types input[type="radio"]').prop('checked', false);
	$('.delivery-types > [data-id="' + id + '"]').addClass('active');
	$('.delivery-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
	
	$('#delivery_type_id').val(id);
	
		
}

$(function() {

	$('.delivery-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			selectDelivery(this.dataset.id);

		}
	});	

});