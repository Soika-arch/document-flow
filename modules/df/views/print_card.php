<?php

// Сторінка роздруківки картки документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');
$get = rg_Rg()->get('Get')->get;

e('<!DOCTYPE html>');
e('<html lang="uk">');
	e('<head>');
		e('<meta charset="UTF-8">');
		e('<meta name="viewport" content="width=device-width, initial-scale=1">');
		e('<link rel="stylesheet" type="text/css" href="'. url('/css') .'/print_card.css">');
		e("<title>". SiteName ." - друк картки документа</title>");
	e('</head>');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

$directionNames = [
	'inc' => 'Вхідний документ',
	'out' => 'Вихідний документ',
	'int' => 'Внутрішній документ'
];

// dd($d['Doc'], __FILE__, __LINE__,1);
e('<div class="print-card">');

	e('<div class="elem">');
		e('<h1>'. $directionNames[$d['cardData'][0]] .' - '. $d['Doc']->displayedNumber .'</h1>');
		e('<div class="elem-content">'. $d['Doc']->DocumentTitle->_title .'</div>');
	e('</div>');

	e('<div class="elem">');
		e('<h2>Тип</h2>');
		e('<div class="elem-content">'. $d['Doc']->DocumentType->_name .'</div>');
	e('</div>');

	if ($d['Doc']->Description->_description) {
		e('<div class="elem">');
			e('<h2>Опис</h2>');
			e('<div class="elem-content">'. $d['Doc']->Description->_description .'</div>');
		e('</div>');
	}

	if ($d['Doc']->CarrierType->_name) {
		e('<div class="elem">');
			e('<h2>Тип носія документа</h2>');
			e('<div class="elem-content">'. $d['Doc']->CarrierType->_name .'</div>');
		e('</div>');
	}

	e('<div class="elem">');
		e('<h2>Реєстратор</h2>');
		e('<div class="elem-content">'. $d['Doc']->Registrar->_login .'</div>');
	e('</div>');

	if ($d['Doc']->_document_date) {
		e('<div class="elem">');
			e('<h2>Дата документа</h2>');
			e('<div class="elem-content">'. date('d.m.Y', strtotime($d['Doc']->_document_date)) .'</div>');
		e('</div>');
	}

	e('<div class="elem">');
		e('<h2>Дата реєстрації документа</h2>');
		e('<div class="elem-content">'. date('d.m.Y', strtotime($d['Doc']->_add_date)) .'</div>');
	e('</div>');

	if (isset($d['Doc']->dbRow['idr_id_outgoing_number']) && $d['Doc']->_id_outgoing_number) {
		e('<div class="elem">');
			e('<h2>Відповідний вихідний</h2>');

			e('<div class="elem-content">'. date('d.m.Y', strtotime($d['Doc']->_id_outgoing_number)) .
				'</div>');

		e('</div>');
	}

	if (isset($d['Doc']->dbRow['odr_id_incoming_number']) && $d['Doc']->_id_incoming_number) {
		e('<div class="elem">');
			e('<h2>Відповідний вхідний</h2>');

			e('<div class="elem-content">'. date('d.m.Y', strtotime($d['Doc']->_id_incoming_number)) .
				'</div>');

		e('</div>');
	}

	if ($d['Doc']->_id_document_location) {
		e('<div class="elem">');
			e('<h2>Фізичне місцезнаходження документа</h2>');

			e('<div class="elem-content">'. $d['Doc']->DocumentLocation->_name .'</div>');

		e('</div>');
	}

	if (isset($d['Doc']->dbRow['idr_id_sender']) && $d['Doc']->Sender->_name) {
		e('<div class="elem">');
			e('<h2>Відправник</h2>');

			e('<div class="elem-content">'. $d['Doc']->Sender->_name .'</div>');

		e('</div>');
	}
	else if (isset($d['Doc']->dbRow['inr_id_initiator']) && $d['Doc']->InitiatorUser->_login) {
		e('<div class="elem">');
			e('<h2>Ініціатор</h2>');

			e('<div class="elem-content">'. $d['Doc']->InitiatorUser->_login .'</div>');

		e('</div>');
	}

	if ($d['Doc']->ExecutorUser->_login) {
		e('<div class="elem">');
			e('<h2>Виконавець</h2>');
			e('<div class="elem-content">'. $d['Doc']->ExecutorUser->_login .'</div>');
		e('</div>');
	}

	e('<script>');
		e('window.print();');
	e('</script>');

e('</div>');

		e("<footer>");
		e("</footer>");
	e("</body>");
e("</html>");
