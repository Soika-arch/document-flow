document.getElementById('dControlType').addEventListener('change', function() {
	var secondSelect = document.getElementById('dControlTerm');

	if (this.value === '') {
		secondSelect.style.display = 'none';
	} else {
		secondSelect.style.display = 'inline';
	}
});
