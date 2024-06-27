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
	e('<form class="fm_ad-incoming-document" enctype="multipart/form-data"'.
		' name="fm_addIncomingDocument" action="'. url('') .'-add" method="post">');

		e('<div class="label_block">');
			e('<label for="dIncomingDate">Дата вхідного</label>');
			e('<input id="dIncomingDate" type="date" name="dIncomingDate" value="'.
				date('Y-m-d') .'" required>');
		e('</div>');

		if (isset($d['documentTypes']) && $d['documentTypes']) {
			e('<div class="label_block">');
				e('<label for="dType">Тип документа</label>');
				e('<select name="dType" required>');

					e('<option value="" disabled selected>Оберіть опцію</option>');

					foreach ($d['documentTypes'] as $dtRow) {
						e('<option value="'. $dtRow['dt_id'] .'">'.  $dtRow['dt_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['carrierTypes']) && $d['carrierTypes']) {
			e('<div class="label_block">');
				e('<label for="dCarrierType">Тип носія документа</label>');
				e('<select name="dCarrierType" required>');

					e('<option value="" disabled selected>Оберіть опцію</option>');

					foreach ($d['carrierTypes'] as $mtRow) {
						e('<option value="'. $mtRow['cts_id'] .'">'.  $mtRow['cts_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['departments']) && $d['departments']) {
			e('<div class="label_block">');
				e('<label for="dLocation">Фізичне місцезнаходження оригінала</label>');
				e('<select name="dLocation">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['departments'] as $mtRow) {
						e('<option value="'. $mtRow['dp_id'] .'">'.  $mtRow['dp_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['titles']) && $d['titles']) {
			e('<div class="label_block">');
				e('<label for="dTitle">Назва чи заголовок документа</label>');
				e('<select name="dTitle" required>');

					e('<option value="" disabled selected>Оберіть опцію</option>');

					foreach ($d['titles'] as $mtRow) {
						e('<option value="'. $mtRow['dts_id'] .'">'.  $mtRow['dts_title'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['descriptions']) && $d['descriptions']) {
			e('<div class="label_block">');
				e('<label for="dDescription">Опис або короткий зміст документа</label>');
				e('<select name="dDescription">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['descriptions'] as $mtRow) {
						e('<option value="'. $mtRow['dds_id'] .'">'. mb_substr($mtRow['dds_description'], 0, 53) .
							' ...</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['documentStatuses']) && $d['documentStatuses']) {
			e('<div class="label_block">');
				e('<label for="dStatus">Статус документа</label>');
				e('<select name="dStatus" required>');

					e('<option value="" disabled selected>Оберіть опцію</option>');

					foreach ($d['documentStatuses'] as $mtRow) {
						e('<option value="'. $mtRow['dst_id'] .'">'.  $mtRow['dst_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		e('<div class="label_block">');
			e('<label for="dOutgoingNumber">Номер відповідного вихідного документа</label>');
			e('<div>');
				e('<input type="text" name="dOutgoingNumber" pattern="^(OUT_\d{8})?$">');
			e('</div>');
		e('</div>');

		if (isset($d['senders']) && $d['senders']) {
			e('<div class="label_block">');
				e('<label for="dSender">Відправник документа</label>');
				e('<select name="dSender" required>');

					e('<option value="" disabled selected>Оберіть опцію</option>');

					foreach ($d['senders'] as $mtRow) {
						e('<option value="'. $mtRow['dss_id'] .'">'.  $mtRow['dss_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['users']) && $d['users']) {
			e('<div class="label_block">');
				e('<label for="dRecipientUser">Отримувач документа</label>');
				e('<select name="dRecipientUser">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['users'] as $mtRow) {
						e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['users']) && $d['users']) {
			e('<div class="label_block">');
				e('<label for="dResponsibleUser">Відповідальний за виконання</label>');
				e('<select name="dResponsibleUser">');

					e('<option value="" disabled selected>- - -</option>');

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

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['users'] as $mtRow) {
						e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['departments']) && $d['departments']) {
			e('<div class="label_block">');
				e('<label for="dAssignedDepartament">Відділ, якому призначено на виконання</label>');
				e('<select name="dAssignedDepartament">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['departments'] as $mtRow) {
						e('<option value="'. $mtRow['dp_id'] .'">'.  $mtRow['dp_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['resolutions']) && $d['resolutions']) {
			e('<div class="label_block">');
				e('<label for="dResolution">Резолюція</label>');
				e('<select name="dResolution">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['resolutions'] as $mtRow) {
						e('<option value="'. $mtRow['drs_id'] .'">'.  $mtRow['drs_content'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['controlTypes']) && $d['controlTypes']) {
			e('<div class="label_block">');
				e('<label for="dControlType">Контроль виконання</label>');
				e('<select id="dControlType" name="dControlType">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['controlTypes'] as $mtRow) {
						e('<option value="'. $mtRow['dct_id'] .'">'.  $mtRow['dct_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['terms']) && $d['terms']) {
			e('<div id="dControlTerm" class="label_block hide_by-d_control_type">');
				e('<label for="dControlTerm">Терміни виконання</label>');
				e('<select name="dControlTerm">');

					e('<option value="" disabled selected>- - -</option>');

					foreach ($d['terms'] as $mtRow) {
						e('<option value="'. $mtRow['toe_id'] .'">'.  $mtRow['toe_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		e('<div class="label_block">');
			e('<label for="dFile">Документ</label>');
			e('<input type="file" name="dFile" value="" required>');
		e('</div>');

		e('<div class="bt_add">');
			e('<button type="submit" name="bt_add">Зареєструвати</button>');
		e('</div>');

	e('</form>');
e('</div>');

e('<script src="/js/df.js"></script>');

require $this->getViewFile('/inc/footer');
