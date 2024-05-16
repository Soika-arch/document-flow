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
			e('<label for="dtIncomingDate">Дата вхідного</label>');
			e('<input type="date" name="dtIncomingDate" value="'. date('Y-m-d') .'">');
		e('</div>');

		if (isset($d['incomingData']['dt']) && $d['incomingData']['dt']) {
			e('<div class="label_block">');
				e('<label for="documentType">Тип документа</label>');
				e('<select name="documentType">');

					foreach ($d['incomingData']['dt'] as $dtRow) {
						e('<option value="'. $dtRow['dt_id'] .'">'.  $dtRow['dt_name'] .'</option>');
					}

				e('</select>');
			e('</div>');
		}

		e('<div class="label_block">');
			e('<label for="dtDescription">Опис</label>');
			e('<div>');
				e('<textarea name="dtDescription"></textarea>');
			e('</div>');
		e('</div>');

		e('<div class="bt_add">');
			e('<button type="submit" name="bt_add">Зареєструвати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
