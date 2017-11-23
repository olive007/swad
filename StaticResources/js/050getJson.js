function getJson(url, data, callback) {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', url, true);
	xhr.responseType = 'json';
	xhr.onload = function() {
		var status = xhr.status;
		if (status == 200) {
			callback(data, 200, xhr.response);
		}
		else {
			callback(data, status, xhr.response);
		}
	};
	xhr.send();
};
