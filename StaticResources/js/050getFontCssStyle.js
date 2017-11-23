function getFontCssStyle(element, fontSize) {
	// Get the font style
	var style = window.getComputedStyle(element),

		fFamily = style.getPropertyValue('font-family'),
		fSize = fontSize || style.getPropertyValue('font-size'),
		fStyle = style.getPropertyValue('font-style'),
		fVariant = style.getPropertyValue('font-variant'),
		fWeight = style.getPropertyValue('font-weight'),

		// Recreate the right css rule
		font = fStyle+" "+fVariant+" "+fWeight+" "+fSize+" "+fFamily;

	return font;
};
