function computeTextWidth(text, font) {
	// re-use canvas object for better performance
	var canvas = computeTextWidth.canvas || (computeTextWidth.canvas = document.createElement("canvas"));
	var context = canvas.getContext("2d");
	context.font = font;
	var metrics = context.measureText(text);
	return metrics.width;
};
