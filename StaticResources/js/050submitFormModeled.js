function submitFormModeled(form) {

	var error = false;
	var errorNode = document.getElementsByClassName("errorMsg")[0];

	if (errorNode == undefined) {
		errorNode = document.createElement("div");
		errorNode.classList.add("errorMsg");
	}

	if (form.modeler != undefined) {

		var inputData = {};

		for (var i = form.modeler.fields.length; --i >= 0; ) {

			var field = form.modeler.fields[i];

			if (!field.valid) {
				error = true;
				errorNode.innerHTML = messageGeneric["oneFieldIsInvalid"];
			}
			
		}

	}
	else {
		console.log("Error");
	}

	if (error) {
		form.appendChild(errorNode);
	}

	return false;
};
