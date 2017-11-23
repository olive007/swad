function formFieldFactory(field) {

	function initFunctionTab() {

		var tab = [];

		tab["submit"] = function (field) {

			// Create a new line for the element
			var lineNode = document.createElement("div");
			var buttonNode = document.createElement("button");

			// Add the text into the button
			buttonNode.appendChild(document.createTextNode(field["label"]));

			// Add the button into the line
			lineNode.appendChild(buttonNode);

			return lineNode;
		}

		tab["string"] = function (field) {

			// Create a new line for the element
			var lineNode = document.createElement("div");
			field.node = lineNode;
			// Create a label
			var labelNode = document.createElement("label");

			// Add the text into the label
			labelNode.appendChild(document.createTextNode(field["label"]+" :"));

			// Create the input
			var inputNode = document.createElement("input");
			// Set the type of the input
			inputNode["type"] = "text";
			inputNode.setAttribute("pattern", field.pattern);
			inputNode["id"] = field.id;

			if (field.validator != undefined) {

				inputNode.addEventListener('change', function(event) {

					event.target.value = event.target.value.trim();
					field.valid = false;

					var inputData = event.target.value;

					postJson(event.target.form.modeler.baseUrl+"/field/"+field.id, inputData, function (input, statusCode, xhr) {

						var result = JSON.parse(xhr || "{}");
						field.resetError();

						if (statusCode == 200) {
							field.showError(result.message);
						}
						else if (statusCode == 204) {
							field.valid = true;
						}
						else {
							field.showError(messageGeneric["unavailableServer"]);
						}

					});
				}, false);
			}

			inputNode.oninvalid = function(e) {
				e.target.setCustomValidity("");
				e.preventDefault();
			};

			inputNode.oninput = function(e) {
				e.target.setCustomValidity(" ");
			};

			// Add both node into the line
			lineNode.appendChild(labelNode);
			lineNode.appendChild(inputNode);

			return lineNode
		}

		return tab;
	}

	var functionTab = (formFieldFactory.functionTab || initFunctionTab());



	// Get the type of the field to call right factory method
	var type = field["type"];

	field.valid = false;

	field.showError = function(msg, severity) {

		severity = severity || 1;
		//console.log("Error: "+msg);


		var messageNode = document.createElement("p");

		messageNode.classList.add("errMsg");

		messageNode.appendChild(document.createTextNode(msg));

		field.node.appendChild(messageNode);

		field.node.getElementsByTagName("input")[0].classList.add("error");

	}

	field.resetError = function() {

		var messageNodes = this.node.getElementsByClassName("errMsg");

		if (messageNodes.length > 0) {
			field.node.getElementsByTagName("input")[0].classList.remove("error");
		}

		for (var i = messageNodes.length; --i >= 0; ) {
			messageNodes[i].remove();
		}

	}

	return functionTab[type](field);

};
