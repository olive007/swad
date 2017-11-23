function inflateForms() {

	var forms = document.getElementsByTagName("form");

	for (var i = forms.length; --i >= 0;) {

		// Initialize var
		forms[i].modeler = {};

		// Format the url with data found previously
		forms[i].modeler.baseUrl = Modeler.getHostAddress()+"/api/"+Modeler.getLocale()+"/"+forms[i].getAttribute("link");

		// Send the request to get the data of the form
		getJson(forms[i].modeler.baseUrl+"/form", forms[i], function (form, statusCode, xhr) {

			if (statusCode == 200) {

				form.modeler.fields = [];
				// Loop all field
				for (var j = 0; j < xhr["fields"].length; j++) {

					// Call factory to create the new field 
					var fieldNode = formFieldFactory(xhr["fields"][j]);
					form.modeler.fields.push(xhr["fields"][j]);

					// Add it into the form
					form.appendChild(fieldNode);

				}

			}

		});

		forms[i].onsubmit = function(form) {return submitFormModeled(this);};
	}

};
