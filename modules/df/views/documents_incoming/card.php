<?php

// Вид сторінки карточки вхідного документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

/** @var incoming_documents_registry|outgoing_documents_registry|internal_documents_registry */
$Doc = $d['Doc'];
$docNumber = $Doc->_number;
$displayedNumber = $Doc->displayedNumber;

e('<form name="inc_card_action" class="fm document-card" action="'.
	url('/df/documents-incoming/card-action?n='. $docNumber) .'" method="POST">');

	if (isset($d['dTitles']) && $d['dTitles']) {
		$docTitle = getOrDefault($Doc->DocumentTitle->_title, '');

		e('<div class="label_block">');
			e('<label for="dTitle">Назва</label>');

			// Права на редагування тільки у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<select id="dTitle" name="dTitle">');

					foreach ($d['dTitles'] as $row) {
						if ($row['dts_title'] === $docTitle) {
							e('<option value="'. $row['dts_id'] .'" selected>'.  $docTitle .'</option>');
						}
						else {
							e('<option value="'. $row['dts_id'] .'">'.  $row['dts_title'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<input type="text" name="dTitle" value="'. $docTitle .'" readonly>');
			}

		e('</div>');
	}

	// Права на редагування тільки у адміна.
	e('<div class="label_block">');
		e('<label for="dNumber">Номер документа</label>');
		e('<input type="text" id="dNumber" name="dNumber" value="'. $displayedNumber .'"'.
			($d['isAdminRights'] ? '' : ' readonly') .'>');
	e('</div>');

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');
			e('<label for="dRegistrar">Реєстратор</label>');

			// Права на редагування тільки у адміна.
			if ($d['isAdminRights']) {
				e('<select id="dRegistrar" name="dRegistrar">');
					$registrarId = $Doc->Registrar->_id;

					foreach ($d['users'] as $row) {
						if ($row['us_id'] === $registrarId) {
							e('<option value="'. $row['us_id'] .'" selected>'. $row['us_login'] .'</option>');
						}
						else {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<input type="text" name="dRegistrar" value="'. $Doc->getRegistrarLogin() .'" readonly>');
			}

		e('</div>');
	}

	if ($Doc->OutgoingDocument) {
		$docOutURL = $Doc->OutgoingDocument->cardURL;
		$displayedNumberOut = $Doc->OutgoingDocument->displayedNumber;

		$docOutLink = '<a href="'. $docOutURL .'" target="_blank">'. $displayedNumberOut .'</a>';
	}
	else {
		$docOutLink = '';
		$displayedNumberOut = '';
	}

	// Права на редагування тільки у адміна.
	e('<div class="label_block">');
		e('<label for="dOutNumber">Відповідний вихідний</label>');

		e('<input type="text" id="dOutNumber" name="dOutNumber" value="'. $displayedNumberOut .
			'"'. ($d['isAdminRights'] ? '' : ' readonly') .'>');

		if (isset($docOutURL)) {
			e('<div><a href="'. $docOutURL .'" target="_blank">Картка відповідного вихідного</a></div>');
		}

	e('</div>');

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');
			e('<label for="dExecutorUser">Виконавець користувач</label>');

			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<select id="dExecutorUser" name="dExecutorUser">');

					$ExecutorUser = $Doc->ExecutorUser;

					if (! $ExecutorUser) e('<option></option>');

					foreach ($d['users'] as $row) {
						if ($ExecutorUser && ($row['us_id'] === $Doc->ExecutorUser->_id)) {
							e('<option value="'. $row['us_id'] .'" selected>'. $row['us_login'] .'</option>');
						}
						else {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$executorUserLogin = $Doc->ExecutorUser ? $Doc->ExecutorUser->_login : '';

				e('<input type="text" name="dExecutorUser" value="'. $executorUserLogin .
					'" readonly>');
			}

		e('</div>');
	}

	e('<div class="label_block">');
		e('<label for="dIsReceivedExecutorUser">Отримано виконавцем користувачем</label>');

		if ($Doc->_date_of_receipt_by_executor) {
			$ReceivedExecutorUserDate = date('Y-m-d', strtotime($Doc->_date_of_receipt_by_executor));
		}
		else {
			$ReceivedExecutorUserDate = '';
		}

		e('<input type="date" id="dIsReceivedExecutorUser" name="dIsReceivedExecutorUser" value="'.
			$ReceivedExecutorUserDate .'"'. ($d['isAdminRights'] ? '' : ' readonly') .'>');

	e('</div>');

	e('<div>');
		$downloadLink = '<a href="'. url('/df/document-download?n='. strtolower($displayedNumber)) .
			'" target="_blank">Завантажити документ</a>';

		e('<span class="card-registrar">'. $downloadLink .'.</span>');
	e('</div>');

	e('<div>');
		e('<button type="submit" name="bt_edit">Змінити</button>');
	e('</div>');

e('</form>');

require $this->getViewFile('/inc/footer');
