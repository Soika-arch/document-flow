// https://chatgpt.com/c/2014cd59-c6a0-46c8-817b-d6daca1ce883

var divSenderUser = document.getElementById('divSenderUser');
var divSenderExternal = document.getElementById('divSenderExternal');
var divRecipientExternal = document.getElementById('divRecipientExternal');
var divRecipientUser = document.getElementById('divRecipientUser');

var notification = document.getElementById('notification');

document.getElementById('documentDirection').addEventListener('change', function(event) {
	if (clearSelectValues()) {
		showNotification('Увага! Деякі обрані значення фільтрів були очищені!');
	}
});

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

divSenderUser.style.display = 'none';
divSenderExternal.style.display = 'none';
divRecipientExternal.style.display = 'none';
divRecipientUser.style.display = 'none';

function clearSelectValues () {
	let isClear = false;

	let elem = divSenderUser.querySelector('#dSenderUser');

	if (elem.value !== '') {
		isClear = true;
		elem.value = '';
	}

	elem = divSenderExternal.querySelector('#dSenderExternal');

	if (elem.value !== '') {
		isClear = true;
		elem.value = '';
	}

	elem = divRecipientExternal.querySelector('#dRecipientExternal');

	if (elem.value !== '') {
		isClear = true;
		elem.value = '';
	}

	elem = divRecipientUser.querySelector('#dRecipientUser');

	if (elem.value !== '') {
		isClear = true;
		elem.value = '';
	}

	return isClear;
}

document.getElementById('documentDirection').addEventListener('change', function() {
	divSenderUser.style.display = 'none';
	divSenderExternal.style.display = 'none';
	divRecipientExternal.style.display = 'none';
	divRecipientUser.style.display = 'none';

	clearSelectValues();

	if (this.value === '') {
		divSenderUser.style.display = 'none';
		divSenderExternal.style.display = 'none';
		divRecipientExternal.style.display = 'none';
		divRecipientUser.style.display = 'none';
	}
	else if (this.value.indexOf('/df/documents-incoming/list') >= 0) {
		divSenderExternal.style.display = 'inline';
		divRecipientUser.style.display = 'inline';
	}
	else if (this.value.indexOf('/df/documents-outgoing/list') >= 0) {
		divSenderUser.style.display = 'inline';
		divRecipientExternal.style.display = 'inline';
	}
	else if (this.value.indexOf('/df/documents-internal/list') >= 0) {
		divSenderUser.style.display = 'inline';
		divRecipientUser.style.display = 'inline';
	}
});

function hideElement (elem, v) {
	if (elem.style.display !== v) elem.style.display = v;
}

var datePeriod = document.getElementById('datePeriod');
var dateApart = document.getElementById('dateApart');

document.getElementById('dAge').addEventListener('input', function() {
	let v = this.value;

	if (v !== '') {
		hideElement(datePeriod, 'none');

		if (! v.match(/^(199\d|20\d\d|2100)$/)) showNotification('Увага! Некоректний формат року');
	}
	else {
		hideElement(datePeriod, 'block');
	}
});

document.getElementById('dMonth').addEventListener('input', function() {
	let v = this.value;

	if (v !== '') {
		hideElement(datePeriod, 'none');

		if (! v.match(/^(1[0-2]|[1-9])$/)) showNotification('Увага! Некоректний формат місяця');
	}
	else {
		hideElement(datePeriod, 'block');
	}
});

document.getElementById('dDay').addEventListener('input', function() {
	let v = this.value;

	if (v !== '') {
		hideElement(datePeriod, 'none');

		if (! v.match(/^([1-9]|[12][0-9]|3[01])$/)) {
			showNotification('Увага! Некоректний формат числа місяця');
		}
	}
	else {
		hideElement(datePeriod, 'block');
	}
});

var dDateFrom = document.getElementById('dDateFrom');
var dDateUntil = document.getElementById('dDateUntil');

dDateFrom.addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(dateApart, 'none');
	}
	else {
		if ((this.value === '') && (dDateUntil.value === '')) {
			hideElement(dateApart, 'block');
			dateApart.scrollIntoView({ behavior: 'smooth' });
			// Используем setTimeout для корректировки позиции прокрутки после scrollIntoView
			setTimeout(function() {
				window.scrollBy({ top: 70, left: 0, behavior: 'smooth' });
			}, 500); // Задержка 500 мс для завершения scrollIntoView
		}
	}
});

dDateUntil.addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(dateApart, 'none');
	}
	else {
		hideElement(dateApart, 'block');
		dateApart.scrollIntoView({ behavior: 'smooth' });
		// Используем setTimeout для корректировки позиции прокрутки после scrollIntoView
		setTimeout(function() {
			window.scrollBy({ top: 70, left: 0, behavior: 'smooth' });
		}, 500); // Задержка 500 мс для завершения scrollIntoView
	}
});
