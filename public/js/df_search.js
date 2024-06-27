// https://chatgpt.com/c/2014cd59-c6a0-46c8-817b-d6daca1ce883

var divSenderUser = document.getElementById('divSenderUser');
var divSenderExternal = document.getElementById('divSenderExternal');
var divRecipientExternal = document.getElementById('divRecipientExternal');
var divRecipientUser = document.getElementById('divRecipientUser');
var btSearch = document.getElementById('bt_search');

var notification = document.getElementById('notification');
var documentDirection = document.getElementById('documentDirection');
var searchData = document.getElementById('searchData');

var CorrectnessIndicator = {
	dNumber: {
		isValueCorrect: true,
		errorMessage: 'Некоректний номеру документа'
	},
	dAge: {
		isValueCorrect: true,
		errorMessage: 'Некоректний формат року'
	},
	dMonth: {
		isValueCorrect: true,
		errorMessage: 'Некоректний формат місяця'
	},
	dDay: {
		isValueCorrect: true,
		errorMessage: 'Некоректний формат номера дня місяця'
	}
};

searchData.style.display = 'none';

documentDirection.addEventListener('change', function(event) {
	if (clearSelectValues()) {
		showNotification('Деякі обрані значення фільтрів були очищені!');
	}
});

divSenderUser.style.display = 'none';
divSenderExternal.style.display = 'none';
divRecipientExternal.style.display = 'none';
divRecipientUser.style.display = 'none';

function processFieldForCorrectness (elem, regexpString, idElem) {
	if ((elem.value === '') || elem.value.match(regexpString)) {
		CorrectnessIndicator[idElem].isValueCorrect = true;

		return true;
	} else {
		CorrectnessIndicator[idElem].isValueCorrect = false;
		console.log(idElem + ': перевірка не пройдена!');
		showNotification(CorrectnessIndicator[idElem].errorMessage);
	}

	return false;
}

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

documentDirection.addEventListener('change', function() {
	divSenderUser.style.display = 'none';
	divSenderExternal.style.display = 'none';
	divRecipientExternal.style.display = 'none';
	divRecipientUser.style.display = 'none';

	if (this.value !== '') searchData.style.display = 'block';
	else searchData.style.display = 'none';

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

var datePeriod = document.getElementById('datePeriod');
var dateApart = document.getElementById('dateApart');

btSearch.addEventListener('click', function(event) {
	console.log('click');
	if (! processFieldForCorrectness(dNumber, /^(INC_|OUT_|INT_)\d{8}$/, 'dNumber', this) ||
			! processFieldForCorrectness(dAge, /^(199\d|20\d\d|2100)$/, 'dAge', this) ||
			! processFieldForCorrectness(dMonth, /^(1[0-2]|[1-9])$/, 'dMonth', this) ||
			! processFieldForCorrectness(dDay, /^([1-9]|[12][0-9]|3[01])$/, 'dDay', this)) {

		console.log('Заборонено!');
		event.preventDefault(); // Запобігає відправці форми
	}
	else {
		console.log('Дозволено');
	}
});

document.getElementById('dNumber').addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(datePeriod);

		if (! this.value.match(/^(INC_|OUT_|INT_)\d{8}$/)) this.style = 'background-color:#ffe6e6;';
		else this.style = '';
	}
	else {
		showElement(datePeriod, 'block');
		this.style = ''
	}
});

document.getElementById('dAge').addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(datePeriod);

		if (! this.value.match(/^(199\d|20\d\d|2100)$/)) this.style = 'background-color:#ffe6e6;';
		else this.style = '';
	}
	else {
		showElement(datePeriod, 'block');
		this.style = '';
	}
});

document.getElementById('dMonth').addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(datePeriod);

		if (! this.value.match(/^(1[0-2]|[1-9])$/)) this.style = 'background-color:#ffe6e6;';
		else this.style = '';
	}
	else {
		showElement(datePeriod, 'block');
		this.style = '';
	}
});

document.getElementById('dDay').addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(datePeriod);

		if (! this.value.match(/^([1-9]|[12][0-9]|3[01])$/)) this.style = 'background-color:#ffe6e6;';
		else this.style = '';
	}
	else {
		showElement(datePeriod, 'block');
		this.style = '';
	}
});

var dDateFrom = document.getElementById('dDateFrom');
var dDateUntil = document.getElementById('dDateUntil');

dDateFrom.addEventListener('input', function() {
	if (this.value !== '') {
		hideElement(dateApart);
	}
	else {
		if ((this.value === '') && (dDateUntil.value === '')) {
			showElement(dateApart, 'block');
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
		hideElement(dateApart);
	}
	else {
		showElement(dateApart, 'block');
		dateApart.scrollIntoView({ behavior: 'smooth' });
		// Используем setTimeout для корректировки позиции прокрутки после scrollIntoView
		setTimeout(function() {
			window.scrollBy({ top: 70, left: 0, behavior: 'smooth' });
		}, 500); // Задержка 500 мс для завершения scrollIntoView
	}
});

