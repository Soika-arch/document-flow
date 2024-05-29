<?php

// Вид сторінки карточки вихідного документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

/** @var outgoing_documents_registry */
$Doc = $d['Doc'];
$docNumber = $Doc->_number;
$displayedNumber = $Doc->displayedNumber;

e('<form name="out_card_action" class="fm document-card" action="'.
	url('/df/documents-outgoing/card-action?n='. $docNumber) .'" method="POST">');

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
				e('<h3>Назва</h3>');
				e('<div>'. $docTitle .'</div>');
			}

		e('</div>');
	}

	if (isset($d['descriptions']) && $d['descriptions']) {
		$dDescription = $Doc->Description ? $Doc->Description->_description : 'Відсутній';

		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dDescription">Опис або короткий зміст документа</label>');
				e('<div>'. $dDescription .'</div>');
				e('<select id="dDescription" name="dDescription">');

					foreach ($d['descriptions'] as $row) {
						$subStr = mb_substr($row['dds_description'], 0, 53) .' ...';

						if ($Doc->Description && ($row['dds_id'] === $Doc->Description->_id)) {
							e('<option value="'. $row['dds_id'] .'" selected>'. $subStr .'</option>');
						}
						else {
							e('<option value="'. $row['dds_id'] .'">'.  $subStr .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<h3>Опис або короткий зміст документа</h3>');
				e('<div>'. $dDescription .'</div>');
			}

		e('</div>');
	}

	// Права на редагування тільки у адміна.
	e('<div class="label_block">');
		if ($d['isAdminRights']) {
			e('<label for="dNumber">Номер документа</label>');
			e('<input type="text" id="dNumber" name="dNumber" value="'. $displayedNumber .'">');
		}
		else {
			e('<h3>Номер документа</h3>');
			e('<div>'. $displayedNumber .'</div>');
		}

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
				e('<h3>Реєстратор</h3>');
				e('<div>'. $Doc->getRegistrarLogin() .'</div>');
			}

		e('</div>');
	}

	e('<div class="label_block">');

		if ($Doc->_document_date) {
			$DocumentDate = tm_getDatetime($Doc->_document_date);
		}
		else {
			$DocumentDate = '';
		}

		if ($d['isRegistrarRights'] || $d['isAdminRights']) {
			e('<label for="dDate">Дата документа</label>');

			e('<input type="date" id="dDate" name="dDate" value="'.
				($DocumentDate ? $DocumentDate->format('Y-m-d') : '') .'">');
		}
		else {
			e('<h3>Дата документа</h3>');
			e('<div>'. ($DocumentDate ? $DocumentDate->format('d.m.Y') : 'Відсутня') .'</div>');
		}

	e('</div>');

	e('<div class="label_block">');

		$DRegistrationDate = tm_getDatetime($Doc->_add_date);

		if ($d['isAdminRights']) {
			e('<label for="dRegistrationDate">Дата реєстрації документа</label>');

			e('<input type="date" id="dRegistrationDate" name="dRegistrationDate" value="'.
				$DRegistrationDate->format('Y-m-d') .'">');
		}
		else {
			e('<h3>Дата реєстрації документа</h3>');
			e('<div>'. $DRegistrationDate->format('d.m.Y') .'</div>');
		}

	e('</div>');

	if ($Doc->IncomingDocument) {
		$docOutURL = $Doc->IncomingDocument->cardURL;
		$docOutTitle = $Doc->IncomingDocument->DocumentTitle->_title;
		$displayedNumberOut = $Doc->IncomingDocument->displayedNumber;

		$docOutLink = '<a href="'. $docOutURL .'" target="_blank">'. $displayedNumberOut .'</a>';
	}
	else {
		$docOutLink = '';
		$displayedNumberOut = '';
	}

	e('<div class="label_block">');

		if ($d['isRegistrarRights'] || $d['isAdminRights']) {
			e('<label for="dIncNumber">Відповідний вхідний</label>');
			e('<input type="text" id="dIncNumber" name="dIncNumber" value="'. $displayedNumberOut .'">');
		}
		else {
			e('<h3>Відповідний вхідний</h3>');
			e('<div>'. ($displayedNumberOut ? $displayedNumberOut : 'Відсутній') .'</div>');
		}

		if (isset($docOutURL)) {
			e('<div><a href="'. $docOutURL .'" target="_blank">'. $docOutTitle .'</a></div>');
		}

	e('</div>');

	if (isset($d['departments']) && $d['departments']) {
		e('<div class="label_block">');

			if ($d['isAdminRights'] || $d['isRegistrarRights']) {
				e('<label for="dIdDocumentLocation">Фізичне місцезнаходження оригінала</label>');
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
				$documentLocationName = $Doc->getDocumentLocationName();

				e('<h3>Фізичне місцезнаходження документа</h3>');
				e('<div>'. ($documentLocationName ? $documentLocationName : 'Відсутнє') .'</div>');
			}

		e('</div>');
	}

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdSender">Відправник користувач</label>');
				e('<select id="dIdSender" name="dIdSender">');

					$Sender = $Doc->Sender;

					foreach ($d['users'] as $row) {
						if ($Sender && ($row['us_id'] === $Sender->_id)) {
							e('<option value="'. $row['us_id'] .'" selected>'. $row['us_login'] .'</option>');
						}
						else {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$senderUserLogin = $Doc->Sender ? $Doc->Sender->_login : 'Відсутній';

				e('<h3>Відправник користувач</h3>');
				e('<div>'. $senderUserLogin .'</div>');
			}

		e('</div>');
	}

	if (isset($d['senders']) && $d['senders']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdRecipient">Отримувач</label>');
				e('<select id="dIdRecipient" name="dIdRecipient">');

					$Recipient = $Doc->Recipient;

					foreach ($d['senders'] as $row) {
						if ($Recipient && ($row['dss_id'] === $Recipient->_id)) {
							e('<option value="'. $row['dss_id'] .'" selected>'. $row['dss_name'] .'</option>');
						}
						else {
							e('<option value="'. $row['dss_id'] .'">'.  $row['dss_name'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$recipientName = $Doc->Recipient ? $Doc->Recipient->_name : 'Відсутній';

				e('<h3>Отримувач</h3>');
				e('<div>'. $recipientName .'</div>');
			}

		e('</div>');
	}

	if (isset($d['controlTypes']) && $d['controlTypes']) {
		$controlType = $Doc->ControlType ? $Doc->ControlType->_name : 'Відсутній';

		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdControlType">Тип контролю за виконанням</label>');
				e('<select id="dIdControlType" name="dIdControlType">');

					foreach ($d['controlTypes'] as $row) {
						if ($Doc->ControlType && ($row['dct_id'] === $Doc->ControlType->_id)) {
							e('<option value="'. $row['dct_id'] .'" selected>'. $row['dct_name'] .'</option>');
						}
						else {
							e('<option value="'. $row['dct_id'] .'">'.  $row['dct_name'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<h3>Тип контролю за виконанням</h3>');
				e('<div>'. $controlType .'</div>');
			}

		e('</div>');
	}

	e('<div class="label_block">');

		if ($Doc->_control_date) {
			$DueDateBefore = tm_getDatetime($Doc->_control_date);
		}
		else {
			$DueDateBefore = '';
		}

		if ($d['isRegistrarRights'] || $d['isAdminRights']) {
			e('<label for="dDueDateBefore">Термін виконання до</label>');

			e('<input type="date" id="dDueDateBefore" name="dDueDateBefore" value="'.
				($DueDateBefore ? $DueDateBefore->format('Y-m-d') : '') .'">');
		}
		else {
			e('<h3>Отримано виконавцем користувачем</h3>');
			e('<div>'. ($DueDateBefore ? $DueDateBefore->format('d.m.Y') : 'Не встановлено') .'</div>');
		}

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
				$resolutionContent = $Doc->Resolution ? $Doc->Resolution->_content : 'Не накладена';

				e('<h3>Резолюція</h3>');
				e('<div>'. $resolutionContent .'</div>');
			}

		e('</div>');
	}

	e('<div class="label_block">');

		e('<h3>Дата останньої зміни реєстраціїного запису</h3>');
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
