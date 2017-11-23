function postJson(url, data, callback) {

	var xhr = new XMLHttpRequest();

	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json');
	xhr.onload = function () {
		callback(data, xhr.status, xhr.response);
	};
	xhr.send(JSON.stringify(data));

};
