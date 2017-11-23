if (typeof Modeler === 'undefined') {
	var Modeler = {


	};

	Modeler.getLocale = function() {

		// Get the locale form the URL
		var locale = window.location.pathname.split("/")[1];

		return locale;
	};

	Modeler.getHostAddress = function() {

		return window.location.origin;
	};

}
else {
	alert('Error: namespace "Modeler" already exist');
}
