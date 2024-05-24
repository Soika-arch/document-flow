<?php

// Вид головної сторінки пошуку документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="fm">');

	e('<form name="search_1" action="'. url('/df/search/handler') .'" method="POST">');

		e('<input type="hidden" name="targetURL" value="'. $d['targetURL'] .'">');

		e('<div>');
			e('<label for="dAge">Рік документа<label>');
			e('<input type="number" name="dAge">');
		e('</div>');

		e('<div>');
			e('<label for="dMonth">Місяць документа<label>');
			e('<input type="number" name="dMonth">');
		e('</div>');

		e('<div>');
			e('<label for="dDay">Число місяця документа<label>');
			e('<input type="number" name="dDay">');
		e('</div>');

		if (isset($d['sendersUsers']) && $d['sendersUsers']) {
			e('<div class="label_block">');
				e('<label for="dRecipientUser">Відправник</label>');
				e('<select name="dRecipientUser">');

					e('<option value=""></option>');

					foreach ($d['sendersUsers'] as $mtRow) {
						e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['sendersExternal']) && $d['sendersExternal']) {
			e('<div class="label_block">');
				e('<label for="dSenderExternal">Відправник</label>');
				e('<select name="dSenderExternal">');

					e('<option value=""></option>');

					foreach ($d['sendersExternal'] as $mtRow) {
						e('<option value="'. $mtRow['dss_id'] .'">'.  $mtRow['dss_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['recipientsExternal']) && $d['recipientsExternal']) {
			e('<div class="label_block">');
				e('<label for="dRecipientExternal">Отримувач</label>');
				e('<select name="dRecipientExternal">');

					e('<option value=""></option>');

					foreach ($d['recipientsExternal'] as $mtRow) {
						e('<option value="'. $mtRow['dss_id'] .'">'.  $mtRow['dss_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['recipientsUsers']) && $d['recipientsUsers']) {
			e('<div class="label_block">');
				e('<label for="dRecipientUser">Отримувач</label>');
				e('<select name="dRecipientUser">');

					e('<option value=""></option>');

					foreach ($d['recipientsUsers'] as $mtRow) {
						e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		if (isset($d['departaments']) && $d['departaments']) {
			e('<div class="label_block">');
				e('<label for="dLocation">Фізичне місцезнаходження оригінала</label>');
				e('<select name="dLocation">');

					e('<option value=""></option>');

					foreach ($d['departaments'] as $mtRow) {
						e('<option value="'. $mtRow['dp_id'] .'">'.  $mtRow['dp_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		e('<div>');
			e('<button type="submit" name="bt_search">Шукати</button>');
		e('</div>');

	e('<form>');

e('</div>');

require $this->getViewFile('/inc/footer');
