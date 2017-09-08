function selectDelivery(id) {
	$('.delivery-types > a').removeClass('active');
	$('.delivery-types input[type="radio"]').prop('checked', false);
	$('.delivery-types > [data-id="' + id + '"]').addClass('active');
	$('.delivery-types [data-id="' + id + '"] input[type="radio"]').prop('checked', true);
	
	$('#field_customer_delivery_type_id').val(id);
		
}

function useShippingAddress() {
	return $('#customer_use_ship_address').prop('checked');
}

function updateShippingAddressForm() {
	if (useShippingAddress()) {
		$('.shipping-address-form input').prop('disabled', false);
	} else {
		$('.shipping-address-form input').prop('disabled', true);
	}
}

function validateDeliveryForm() {
	var frm = new formValidation('form_delivery');
	frm.add('customer_name', 'name');
	frm.add('customer_address_city', 'length', '2');
	frm.add('customer_address_street', 'length', '2');
	frm.add('customer_address_zip', 'zip');
	frm.add('customer_email', 'email');
	
	if (useShippingAddress()) {
		frm.add('customer_ship_name', 'name');	
		frm.add('customer_ship_city', 'length', '2');
		frm.add('customer_ship_street', 'length', '2');
		frm.add('customer_ship_zip', 'zip');
	}
	frm.submit();
}

$(function() {

	$('.delivery-types > a').click(function() {
		if (!$(this).hasClass('disabled')) {
			selectDelivery(this.dataset.id);
		}
	});	
	
	$('#customer_use_ship_address').change(function(e) {                                           
		updateShippingAddressForm();
	});
	
});