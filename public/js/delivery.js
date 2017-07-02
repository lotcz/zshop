function selectDelivery(id) {
	$('.delivery-types > a').removeClass('active');
	$('.delivery-types input[type="radio"]').prop('checked', false);
	$('.delivery-types > [data-id="' + id + '"]').addClass('active');
	$('.delivery-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
	
	$('#field_customer_delivery_type_id').val(id);
		
}

function validateDeliveryForm() {
	var frm = new formValidation('form_delivery');
	frm.add('customer_name', 'length', '1');
	
	frm.add('customer_ship_name', 'length', '1');
	frm.add('customer_ship_name', 'maxlen', '50');
	frm.add('customer_ship_city', 'maxlen', '50');
	frm.add('customer_ship_street', 'maxlen', '50');
	frm.add('customer_ship_zip', 'integer', '1');
	frm.submit();
}		
		
$(function() {

	$('.delivery-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			selectDelivery(this.dataset.id);

		}
	});	

});