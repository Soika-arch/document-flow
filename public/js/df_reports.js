var incomingDocuments = document.getElementById('incomingDocuments');
var outgoingDocuments = document.getElementById('outgoingDocuments');
var internalDocuments = document.getElementById('internalDocuments');

var notification = document.getElementById('notification');

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

function hideNotification() {
	notification.classList.remove('show');
	document.removeEventListener('click', hideNotificationOnClick);
}

function hideNotificationOnClick() {
  hideNotification();
}

incomingDocuments.style.display = 'none';
outgoingDocuments.style.display = 'none';
internalDocuments.style.display = 'none';

document.getElementById('documentDirection').addEventListener('change', function() {
	incomingDocuments.style.display = 'none';

	if (this.value === '') {
		incomingDocuments.style.display = 'none';
		outgoingDocuments.style.display = 'none';
		internalDocuments.style.display = 'none';
	}
	else if (this.value.indexOf('inc') >= 0) {
		incomingDocuments.style.display = 'inline';
		outgoingDocuments.style.display = 'none';
		internalDocuments.style.display = 'none';
	}
	else if (this.value.indexOf('out') >= 0) {
		outgoingDocuments.style.display = 'inline';
		incomingDocuments.style.display = 'none';
		internalDocuments.style.display = 'none';
	}
	else if (this.value.indexOf('int') >= 0) {
		internalDocuments.style.display = 'inline';
		outgoingDocuments.style.display = 'none';
		incomingDocuments.style.display = 'none';
	}
});

function hideElement (elem, v) {
	if (elem.style.display !== v) elem.style.display = v;
}
