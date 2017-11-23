var resizing = null;
var resizingNodeAdded = false;

var modelerBody = null;

var resizingNode = document.createElement("div");

resizingNode.appendChild(document.createTextNode(messageGeneric['resizing']));
resizingNode.setAttribute("id", "resizing");

window.onload = function() {

	// Get body node
	var body = document.getElementsByTagName("body")[0];

	// Add input node to allow user to complete the forms
	inflateForms();

	// Create ...
	modelerBody = new Modeler.Screen(body.childNodes[2]);

	// Positions all elements into the page
	modelerBody.modelize();

	// Remove Loading message
	body.childNodes[1].remove();

};

window.onresize = function() {

	// Get body node
	var body = document.getElementsByTagName("body")[0];

	// Add Resizing message if not already there
	if (resizingNodeAdded === false) {
		body.insertBefore(resizingNode, body.childNodes[0]);
		resizingNodeAdded = true;
	}

	if (resizing != null) {
		clearTimeout(resizing);
	}

	// Wait 1 second without resizing to exectute this function
	resizing = setTimeout(function() {

		// Clear all css style computed
		resetCssStyle(body);

		// Positions all elements into the page
		modelerBody.modelize();

		// Remove resizing message
		body.childNodes[0].remove();
		resizingNodeAdded = false;

	}, 1000);

};
