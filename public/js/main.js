document.getElementById('dControlType').addEventListener('change', function() {
	var secondSelect = document.getElementById('dControlTerm');
	if (this.value !== 'Без контролю') {
		secondSelect.style.display = 'inline';
	} else {
		secondSelect.style.display = 'none';
	}
});
