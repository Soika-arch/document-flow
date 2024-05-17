<?php

// Вид сторінки реєстрації вхідного документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

$url = url('/df');

e('<div class="fm">');
	e('<form name="fm_addIncomingDocument" action="'. url('') .'-register" method="post">');

		e('<div class="label_block">');
			e('<label for="dIncomingDate">Дата вхідного</label>');
			e('<input type="date" name="dIncomingDate" value="'. date('Y-m-d') .'">');
		e('</div>');

		if (isset($d['incomingData']['documentTypes']) && $d['incomingData']['documentTypes']) {
			e('<div class="label_block">');
				e('<label for="dType">Тип документа</label>');
				e('<select name="dType">');

					foreach ($d['incomingData']['documentTypes'] as $dtRow) {
						e('<option value="'. $dtRow['dt_id'] .'">'.  $dtRow['dt_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['incomingData']['carrierTypes']) && $d['incomingData']['carrierTypes']) {
			e('<div class="label_block">');
				e('<label for="dCarrierType">Тип носія документа</label>');
				e('<select name="dCarrierType">');

					foreach ($d['incomingData']['carrierTypes'] as $mtRow) {
						e('<option value="'. $mtRow['cts_id'] .'">'.  $mtRow['cts_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		e('<div class="label_block">');
			e('<label for="dTitle">Назва чи заголовок документа</label>');
			e('<div>');
				e('<textarea name="dTitle"></textarea>');
			e('</div>');
		e('</div>');

		e('<div class="label_block">');
			e('<label for="dDescription">Опис або короткий зміст документа</label>');
			e('<div>');
				e('<textarea name="dDescription"></textarea>');
			e('</div>');
		e('</div>');

		if (isset($d['incomingData']['documentStatuses']) && $d['incomingData']['documentStatuses']) {
			e('<div class="label_block">');
				e('<label for="dStatus">Статус документа</label>');
				e('<select name="dStatus">');

					foreach ($d['incomingData']['documentStatuses'] as $mtRow) {
						e('<option value="'. $mtRow['dst_id'] .'">'.  $mtRow['dst_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['users']) && $d['users']) {
			e('<div class="label_block">');
				e('<label for="dResponsibleUser">Відповідальний за виконання</label>');
				e('<select name="dResponsibleUser">');

					e('<option value=""></option>');

					foreach ($d['users'] as $mtRow) {
						e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['users']) && $d['users']) {
			e('<div class="label_block">');
				e('<label for="dAssignedUser">Відповідальний за обробку документа</label>');
				e('<select name="dAssignedUser">');

					e('<option value=""></option>');

					foreach ($d['users'] as $mtRow) {
						e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['incomingData']['assignedDepartaments']) &&
				$d['incomingData']['assignedDepartaments']) {
			e('<div class="label_block">');
				e('<label for="dAssignedDepartaments">Відділ, якому призначено на виконання</label>');
				e('<select name="dAssignedDepartaments">');

					e('<option value=""></option>');

					foreach ($d['incomingData']['assignedDepartaments'] as $mtRow) {
						e('<option value="'. $mtRow['dp_id'] .'">'.  $mtRow['dp_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['incomingData']['resolutions']) && $d['incomingData']['resolutions']) {
			e('<div class="label_block">');
				e('<label for="dResolution">Резолюція</label>');
				e('<select name="dResolution">');

					e('<option value=""></option>');

					foreach ($d['incomingData']['resolutions'] as $mtRow) {
						e('<option value="'. $mtRow['drs_id'] .'">'.  $mtRow['drs_content'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['incomingData']['documentControlTypes']) &&
				$d['incomingData']['documentControlTypes']) {
			e('<div class="label_block">');
				e('<label for="dControlType">Контроль виконання</label>');
				e('<select name="dControlType">');

					e('<option value=""></option>');

					foreach ($d['incomingData']['documentControlTypes'] as $mtRow) {
						e('<option value="'. $mtRow['dct_id'] .'">'.  $mtRow['dct_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		e('<div class="label_block">');
			e('<label for="dExecutionDeadline">Дедлайн виконання</label>');
			e('<input type="date" name="dExecutionDeadline" value="">');
		e('</div>');

		e('<div class="bt_add">');
			e('<button type="submit" name="bt_add">Зареєструвати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
