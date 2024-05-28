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

			// Права на редагування тільки у адміна і реєстратора.

			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdTitle">Назва</label>');
				e('<select id="dIdTitle" name="dIdTitle">');

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
				e('<label for="dIdTitle">Назва</label>');
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

			// Права на редагування тільки у адміна.
			if ($d['isAdminRights']) {
				e('<label for="dIdRegistrar">Реєстратор</label>');
				e('<select id="dIdRegistrar" name="dIdRegistrar">');
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
				e('<label for="dRegistrar">Реєстратор</label>');
				e('<input type="text" name="dRegistrar" value="'. $Doc->getRegistrarLogin() .'" readonly>');
			}

		e('</div>');
	}

	e('<div class="label_block">');
		e('<label for="dDate">Дата документа</label>');

		if ($Doc->_document_date) {
			$documentDate = tm_getDatetime($Doc->_document_date)->format('Y-m-d');
		}
		else {
			$documentDate = '';
		}

		e('<input type="date" id="dDate" name="dDate" value="'.
			$documentDate .'"'. ($d['isRegistrarRights'] ? '' : ' readonly') .'>');

	e('</div>');

	e('<div class="label_block">');
		e('<label for="dRegistrationDate">Дата реєстрації документа</label>');

		$dRegistrationDate = tm_getDatetime($Doc->_add_date)->format('Y-m-d');

		if ($d['isAdminRights']) {
			e('<input type="date" id="dRegistrationDate" name="dRegistrationDate" value="'.
				$dRegistrationDate .'">');
		}
		else {
			e('<div>'. $dRegistrationDate .'</div>');
		}

	e('</div>');

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
			'"'. (($d['isRegistrarRights'] || $d['isAdminRights']) ? '' : ' readonly') .'>');

		if (isset($docOutURL)) {
			e('<div><a href="'. $docOutURL .'" target="_blank">Картка відповідного вихідного</a></div>');
		}

	e('</div>');

	if (isset($d['departments']) && $d['departments']) {
		e('<div class="label_block">');

			if ($d['isAdminRights'] || $d['isRegistrarRights']) {
				e('<label for="dIdDocumentLocation">Фізичне місцезнаходження документа</label>');
				e('<select id="dIdDocumentLocation" name="dIdDocumentLocation">');

					if (! $Doc->_id_document_location) e('<option></option>');

					foreach ($d['departments'] as $row) {
						if ($row['dp_id'] === $Doc->_id_document_location) {
							e('<option value="'. $row['dp_id'] .'" selected>'. $row['dp_name'] .'</option>');
						}
						else {
							e('<option value="'. $row['dp_id'] .'">'.  $row['dp_name'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<label for="dIdDocumentLocation">Фізичне місцезнаходження документа</label>');

				e('<input type="text" name="dIdDocumentLocation" value="'. $Doc->getDocumentLocationName() .
					'" readonly>');
			}

		e('</div>');
	}

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdRecipient">Отримувач користувач</label>');
				e('<select id="dIdRecipient" name="dIdRecipient">');

					if (! ($Recipient = $Doc->Recipient)) e('<option></option>');

					foreach ($d['users'] as $row) {
						if ($Recipient && ($row['us_id'] === $Recipient->_id)) {
							e('<option value="'. $row['us_id'] .'" selected>'. $row['us_login'] .'</option>');
						}
						else {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$recipientUserLogin = $Doc->Recipient ? $Doc->Recipient->_login : '';

				e('<label for="dRecipient">Отримувач користувач</label>');
				e('<input type="text" name="dRecipient" value="'. $recipientUserLogin .
					'" readonly>');
			}

		e('</div>');
	}

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdExecutorUser">Виконавець користувач</label>');
				e('<select id="dIdExecutorUser" name="dIdExecutorUser">');

					if (! ($ExecutorUser = $Doc->ExecutorUser)) e('<option></option>');

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

				e('<label for="dExecutorUser">Виконавець користувач</label>');
				e('<input type="text" name="dExecutorUser" value="'. $executorUserLogin .
					'" readonly>');
			}

		e('</div>');
	}

	e('<div class="label_block">');
		e('<label for="dIsReceivedExecutorUser">Отримано виконавцем користувачем</label>');

		if ($Doc->_date_of_receipt_by_executor) {
			$ReceivedExecutorUserDate = tm_getDatetime($Doc->_date_of_receipt_by_executor)->format('Y-m-d');
		}
		else {
			$ReceivedExecutorUserDate = '';
		}

		if ($d['isAdminRights']) {
			e('<input type="date" id="dIsReceivedExecutorUser" name="dIsReceivedExecutorUser" value="'.
				$ReceivedExecutorUserDate .'">');
		}
		else {
			e('<div>'. ($ReceivedExecutorUserDate ? $ReceivedExecutorUserDate : 'Не отримано') .'</div>');
		}

	e('</div>');

	e('<div class="label_block">');
		e('<label for="dDueDateBefore">Термін виконання до</label>');

		if ($Doc->_control_date) {
			$dueDateBefore = tm_getDatetime($Doc->_control_date)->format('Y-m-d');
		}
		else {
			$dueDateBefore = '';
		}

		e('<input type="date" id="dDueDateBefore" name="dDueDateBefore" value="'.
			$dueDateBefore .'"'. ($d['isRegistrarRights'] ? '' : ' readonly') .'>');

	e('</div>');

	if (isset($d['resolutions']) && $d['resolutions']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdRresolution">Резолюція</label>');
				e('<select id="dIdRresolution" name="dIdRresolution">');

					if (! ($Resolution = $Doc->Resolution)) e('<option></option>');

					foreach ($d['resolutions'] as $row) {
						if ($Resolution && ($row['drs_id'] === $Resolution->_id)) {
							e('<option value="'. $row['drs_id'] .'" selected>'. $row['drs_content'] .'</option>');
						}
						else {
							e('<option value="'. $row['drs_id'] .'">'.  $row['drs_content'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$resolutionContent = $Doc->Resolution ? $Doc->Resolution->_content : '';

				e('<label for="dIdRresolution">Резолюція</label>');
				e('<input type="text" name="dIdRresolution" value="'. $resolutionContent .
					'" readonly>');
			}

		e('</div>');
	}

	e('<div class="label_block">');
		e('<label for="dChangeDate">Дата останньої зміни реєстраціїного запису</label>');

		e('<div>'. tm_getDatetime($Doc->_change_date)->format('d.m.Y H:i') .'</div>');

	e('</div>');

	e('<div>');
		$downloadLink = '<a href="'. url('/df/document-download?n='. strtolower($displayedNumber)) .
			'" target="_blank">Завантажити документ</a>';

		e('<span class="card-registrar">'. $downloadLink .'.</span>');
	e('</div>');

	if ($Us->Status->_access_level < 4) {
		e('<div>');
			e('<button type="submit" name="bt_edit">Змінити</button>');
		e('</div>');
	}

e('</form>');

require $this->getViewFile('/inc/footer');
