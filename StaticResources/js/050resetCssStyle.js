function resetCssStyle(container) {

	// Loop thru all children to remove all computed css style
	container.childNodes.forEach(function (child) {
		resetCssStyle(child);
	});

	// Remove all css style computed of this element
	container.style = null;

};
