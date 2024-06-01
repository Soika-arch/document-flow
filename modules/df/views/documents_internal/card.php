<?php

// Вид сторінки карточки внутрішнього документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

/** @var internal_documents_registry */
$Doc = $d['Doc'];
$docNumber = $Doc->_number;
$displayedNumber = $Doc->displayedNumber;

e('<form name="int_card_action" class="fm document-card" action="'.
	url('/df/documents-internal/card-action?n='. $docNumber) .'" method="POST">');

	if (isset($d['documentTypes']) && $d['documentTypes']) {
		$DocumentType = $Doc->DocumentType ? $Doc->DocumentType : '';

		$dIdDocumentType = $DocumentType ? $DocumentType->_id : '';

		e('<div class="label_block">');

			// Права на редагування тільки у адміна і реєстратора.

			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdDocumentType">Тип документа</label>');
				e('<select id="dIdDocumentType" name="dIdDocumentType">');

					foreach ($d['documentTypes'] as $row) {
						if ($row['dt_id'] === $dIdDocumentType) {
							e('<option value="'. $row['dt_id'] .'" selected>'.  $DocumentType->_name .'</option>');
						}
						else {
							e('<option value="'. $row['dt_id'] .'">'.  $row['dt_name'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<h3>Тип документа</h3>');
				e('<div>'. ($DocumentType ? $DocumentType->_name : 'Відсутній') .'</div>');
			}

		e('</div>');
	}

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
				e('<label for="dIdDescription">Опис або короткий зміст документа</label>');
				e('<div>'. $dDescription .'</div>');
				e('<select id="dIdDescription" name="dIdDescription">');

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

	if (! ($additionalNumber = $Doc->_additional_number)) $additionalNumber = '';

	e('<div class="label_block">');
		if ($d['isRegistrarRights'] || $d['isAdminRights']) {
			e('<label for="dAdditionalNumber">Додатковий номер документа</label>');
			e('<input type="text" id="dAdditionalNumber" name="dAdditionalNumber" value="'.
				$additionalNumber .'">');
		}
		else {
			e('<h3>Додатковий номер документа</h3>');
			e('<div>'. ($additionalNumber ? $additionalNumber : 'Відсутній') .'</div>');
		}

	e('</div>');

	e('<div class="label_block">');

		$dCarrierType = $Doc->CarrierType ? $Doc->CarrierType->_name : '';

		if ($d['isRegistrarRights'] || $d['isAdminRights']) {
			if (isset($d['carrierTypes']) && $d['carrierTypes']) {
				e('<label for="dIdCarrierType">Тип носія документа</label>');
				e('<select id="dIdCarrierType" name="dIdCarrierType">');

					$idCarrierType = $Doc->CarrierType->_id;

					foreach ($d['carrierTypes'] as $row) {
						if ($row['cts_id'] === $idCarrierType) {
							e('<option value="'. $row['cts_id'] .'" selected>'. $row['cts_name'] .'</option>');
						}
						else {
							e('<option value="'. $row['cts_id'] .'">'.  $row['cts_name'] .'</option>');
						}
					}

				e('</select>');
			}
		}
		else {
			e('<h3>Тип носія документа</h3>');
			e('<div>'. ($dCarrierType ? $dCarrierType : 'Відсутній') .'</div>');
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

			e('<input id="dDate" type="date" name="dDate" value="'.
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

			e('<input id="dRegistrationDate" type="date" name="dRegistrationDate" value="'.
				$DRegistrationDate->format('Y-m-d') .'">');
		}
		else {
			e('<h3>Дата реєстрації документа</h3>');
			e('<div>'. $DRegistrationDate->format('d.m.Y') .'</div>');
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
				$documentLocationName = $Doc->getDocumentLocationName();

				e('<h3>Фізичне місцезнаходження документа</h3>');
				e('<div>'. ($documentLocationName ? $documentLocationName : 'Відсутнє') .'</div>');
			}

		e('</div>');
	}

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');

			$Initiator = $Doc->InitiatorUser;

			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdInitiator">Ініціатор</label>');
				e('<select id="dIdInitiator" name="dIdInitiator">');

					foreach ($d['users'] as $row) {
						if ($Initiator && ($row['us_id'] === $Initiator->_id)) {
							e('<option value="'. $row['us_id'] .'" selected>'. $row['us_login'] .'</option>');
						}
						else {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$initiatorLogin = $Initiator ? $Initiator->_login : 'Відсутній';

				e('<h3>Ініціатор</h3>');
				e('<div>'. $initiatorLogin .'</div>');
			}

		e('</div>');
	}

	if (isset($d['senders']) && $d['senders']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdSender">Відправник</label>');
				e('<select id="dIdSender" name="dIdSender">');

					$Sender = $Doc->Sender;

					foreach ($d['senders'] as $row) {
						if ($Sender && ($row['dss_id'] === $Sender->_id)) {
							e('<option value="'. $row['dss_id'] .'" selected>'. $row['dss_name'] .'</option>');
						}
						else {
							e('<option value="'. $row['dss_id'] .'">'.  $row['dss_name'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				$senderName = $Doc->Sender ? $Doc->Sender->_name : 'Відсутній';

				e('<h3>Відправник</h3>');
				e('<div>'. $senderName .'</div>');
			}

		e('</div>');
	}

	if (isset($d['users']) && $d['users']) {
		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdRecipient">Отримувач користувач</label>');
				e('<select id="dIdRecipient" name="dIdRecipient">');

					$Recipient = $Doc->Recipient;

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
				$recipientUserLogin = $Doc->Recipient ? $Doc->Recipient->_login : 'Відсутній';

				e('<h3>Отримувач користувач</h3>');
				e('<div>'. $recipientUserLogin .'</div>');
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
				$executorUserLogin = $Doc->ExecutorUser ? $Doc->ExecutorUser->_login : 'Відсутній';

				e('<h3>Виконавець користувач</h3>');
				e('<div>'. $executorUserLogin .'</div>');
			}

		e('</div>');
	}

	e('<div class="label_block">');

		if ($Doc->_date_of_receipt_by_executor) {
			$ReceivedExecutorUserDate = tm_getDatetime($Doc->_date_of_receipt_by_executor);
		}
		else {
			$ReceivedExecutorUserDate = '';
		}

		if ($d['isAdminRights']) {
			e('<label for="dIsReceivedExecutorUser">Отримано виконавцем користувачем</label>');

			e('<input id="dIsReceivedExecutorUser" type="date" name="dIsReceivedExecutorUser" value="'.
				($ReceivedExecutorUserDate ? $ReceivedExecutorUserDate->format('Y-m-d') : '') .'">');
		}
		else {
			e('<h3>Отримано виконавцем користувачем</h3>');

			e('<div>'. ($ReceivedExecutorUserDate ?
				$ReceivedExecutorUserDate->format('d.m.Y H:i') : 'Не отримано') .'</div>');
		}

	e('</div>');

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

	e('<div class="label_block">');

		if ($Doc->_execution_date) {
			$ExecutionDate = tm_getDatetime($Doc->_execution_date);
		}
		else {
			$ExecutionDate = '';
		}

		if ($d['isRegistrarRights'] || $d['isAdminRights']) {
			e('<label for="dExecutionDate">Дата виконання</label>');

			e('<input type="date" id="dExecutionDate" name="dExecutionDate" value="'.
				($ExecutionDate ? $ExecutionDate->format('Y-m-d') : '') .'">');
		}
		else {
			e('<h3>Дата виконання</h3>');
			e('<div>'. ($ExecutionDate ? $ExecutionDate->format('d.m.Y') : 'Не встановлено') .'</div>');
		}

	e('</div>');

	if (isset($d['users']) && $d['users']) {
		$ResponsibleUser = $Doc->ResponsibleUser ? $Doc->ResponsibleUser : '';

		e('<div class="label_block">');
			// Права на редагування у адміна і реєстратора.
			if ($d['isRegistrarRights'] || $d['isAdminRights']) {
				e('<label for="dIdResponsibleUser">Відповідальний за виконання</label>');
				e('<select id="dIdResponsibleUser" name="dIdResponsibleUser">');

					foreach ($d['users'] as $row) {
						if ($ResponsibleUser && ($row['us_id'] === $ResponsibleUser->_id)) {
							e('<option value="'. $row['us_id'] .'" selected>'. $row['us_login'] .'</option>');
						}
						else {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}
					}

				e('</select>');
			}
			else {
				e('<h3>Відповідальний за виконання</h3>');
				e('<div>'. ($ResponsibleUser ? $ResponsibleUser->_login : 'Відсутній') .'</div>');
			}

		e('</div>');
	}

	e('<div class="label_block">');

		e('<h3>Дата останньої зміни реєстраціїного запису</h3>');
		e('<div>'. tm_getDatetime($Doc->_change_date)->format('d.m.Y H:i') .'</div>');

	e('</div>');

	e('<div class="label_block">');
		e('<h3>Завантажити документ</h3>');

		$downloadLink = '<a class="file-downloadLink" href="'. url('/df/document-download?n='.
			strtolower($displayedNumber)) .'" target="_blank">'. $displayedNumber .'.'.
			$Doc->_file_extension .'</a>';

		e('<div>'. $downloadLink .'.</div>');
	e('</div>');

	if ($Us->Status->_access_level < 4) {
		e('<div>');
			e('<button type="submit" name="bt_edit">Змінити</button>');
		e('</div>');
	}

e('</form>');

require $this->getViewFile('/inc/footer');
