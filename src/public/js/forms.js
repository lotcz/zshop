function showFieldValidation(field_name) {
	$('#' + field_name + '_validation').show();
}

function hideFieldValidation(field_name) {
	$('#' + field_name + '_validation').hide();
}

function processFieldValidation(field_name, isValid) {
	if (isValid) {
		hideFieldValidation(field_name);
	} else {
		showFieldValidation(field_name);
	}
	return isValid;
}

// plain validation for required fields, any value validates except empty string
function validateField(field_name) {
	var v = document.forms[0][field_name].value;
	return processFieldValidation(field_name, (v.length > 0));
}

function validateEmailField(field_name) {
	var email = document.forms[0][field_name].value;
	var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return processFieldValidation(field_name, re.test(email));
}