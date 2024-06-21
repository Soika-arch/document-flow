<?php

// Ініціалізація стилю та атрибуту title для виводу номера документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

if ($Doc->_date_of_receipt_by_executor) {
	$docNumStyle = 'border:solid 2px #0eff0e;border-radius:7px;';
	$docNumTitle = "Отримано виконавцем;\n";
}
else {
	$docNumStyle = 'border:solid 2px red;border-radius:7px;';
	$docNumTitle = "Не отримано виконавцем;\n";
}

if ($docNumStyle) $docNumStyle = ' style="'. $docNumStyle .'"';
