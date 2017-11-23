function round(value, precision) {
	var multiplier = Math.pow(10, precision || 2);
	return Math.round(value * multiplier) / multiplier;
};
