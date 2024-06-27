function hideElement (elem) {
	if (elem.style.display !== 'none') {
		elem.style.display = 'none';

		return true;
	}

	return false;
}

function showElement (elem, displayType) {
	if (elem.style.display !== displayType) {
		elem.style.display = displayType;

		return true;
	}

	return false;
}

function hideNotification() {
	notification.classList.remove('show');
	document.removeEventListener('click', hideNotificationOnClick);
}

function hideNotificationOnClick() {
  hideNotification();
}

function showNotification (message) {
	notification.textContent = message;
	notification.classList.add('show');

	// Удаляем уведомление при щелчке мыши по странице с небольшой задержкой
	setTimeout(function() {
		document.addEventListener('click', hideNotificationOnClick);
	}, 100); // Задержка в 100 миллисекунд

	// Убираем уведомление через 3 секунды, если не было клика по странице
	setTimeout(hideNotification, 3000);
}

function sendPost (data, url, hendlerFunction) {

	return fetch(url, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	})
	.then(response => response.json())
	.then(data => {
		hendlerFunction(data);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}

function showResponseJsonErrorsForUser (errors) {
	console.log(errors);
}
