// plain validation for text fields
function validate_length(value, param) {		
	return value && (value.length >= parseInt(param));
}

// checks if password fields match
function validate_match(value, param) {
	return (value == param);
}

// checks if password fields match
function validate_ip(value) {
	return validate_length(value, 5);
}

// checks if password fields match
function validate_date(value, param) {
	return validate_length(value, 5);
}

// simple email validation
function validate_email(value) {		
	var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(value);
}

function validate_integer(n) {
	return  (+n===parseInt(n));
}

function validate_min(n, param) {
	return  (parseFloat(n) > parseFloat(param));
}

function validate_decimal(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function validate_price(value) {
	return validate_decimal(value);
}

function formValidation(frm) {	
	this.frm = $('#' + frm);
	this.is_valid = true;
	this.fields = [];
	
	this.submit = function() {
		this.is_valid = true;
		for (var i = 0, max = this.fields.length; i < max; i++) {
			this.is_valid = this.validate(this.fields[i]) && this.is_valid;
		}
		if (this.is_valid) {
			this.frm.submit();
		}
	}
	
	this.add = function(field_name, validation, param) {
		this.fields.push(new formField(field_name, validation, param));
	}
	
	this.val = function (field_name) {
		return $("input[name='" + field_name + "']", this.frm).val();
	}
	
	this.show_validation = function(field_name, validation, is_valid) {
		if (is_valid) {
			$('#' + field_name + '_validation_' + validation, this.frm).hide();		
		} else {
			$('#' + field_name + '_validation_' + validation, this.frm).show();
		}
	}
	
	this.validate = function(field) {
		var is_valid = true;
		var value = this.val(field.name);
		switch (field.validation) {
			case 'confirm':
				var value2 = this.val(field.param);
				is_valid = validate_match(value, value2);
			break;
			default:
				is_valid = window['validate_' + field.validation](value, field.param);
		}		
		this.show_validation(field.name, field.validation, is_valid);
		return is_valid;
	}
	
}

function formField(field_name, validation, param) {
	this.name = field_name;
	this.validation = validation || 'length';
	this.param = param || 1;	
}