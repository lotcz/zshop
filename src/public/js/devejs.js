//
// AUTO RELOADER FOR DEVELOPMENT
//

var myTimer;

function autoreload(i) {
	myTimer = setInterval(
		function() { 
			clearInterval(myTimer);
			location.reload();		
		}, 
		i*1000, 
		true
	);
}

document.addEventListener(
	'keyup', 
	function (e) {
		var key = e.keyCode ? e.keyCode : e.charCode;
		
		switch(key) {
			case 65:
				var i = getCookie('autoreload');
				if (i > 0) {
					setCookie('autoreload', 0, 365, '/');
					clearInterval(myTimer);
				} else {
					setCookie('autoreload', 2, 365, '/');
					autoreload(0);
				}				
				break;
			case 10:
				
				break;
			default:
				console.log("key:" + key);
		}			
	}
);

var i = getCookie('autoreload');
if (i > 0) {
	autoreload(parseInt(i));
}