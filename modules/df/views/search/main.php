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

e('<div id="notification" class="notification"></div>');

e('<div class="fm">');

	e('<form name="search_1" action="'. url('/df/search/handler') .'" method="POST">');

		e('<div class="label_block">');
			e('<label for="documentDirection">Типи документів</label>');
			e('<select id="documentDirection" name="documentDirection">');
				e('<option value=""></option>');
				e('<option value="'. url('/df/documents-incoming/list') .'">Вхідні</option>');
				e('<option value="'. url('/df/documents-outgoing/list') .'">Вихідні</option>');
				e('<option value="'. url('/df/documents-internal/list') .'">Внутрішні</option>');
			e('</select>');
		e('</div>');

		e('<div id="searchData">');

			e('<div id="dateApart">');

				e('<div class="label_block">');
					e('<label for="dNumber">Номер документа<label>');
					e('<input id="dNumber" type="text" name="dNumber">');
				e('</div>');

				e('<div class="label_block">');
					e('<label for="dAge">Рік документа<label>');
					e('<input id="dAge" type="text" name="dAge">');
				e('</div>');

				e('<div class="label_block">');
					e('<label for="dMonth">Номер місяця документа<label>');
					e('<input id="dMonth" type="text" name="dMonth">');
				e('</div>');

				e('<div class="label_block">');
					e('<label for="dDay">Число місяця документа<label>');
					e('<input id="dDay" type="text" name="dDay">');
				e('</div>');

			e('</div>');

			e('<div id="datePeriod">');
				e('<hr>');
				e('<h3>Період дати документу</h3>');

				e('<div class="label_block">');
					e('<label for="dDateFrom">Від<label>');
					e('<input id="dDateFrom" type="date" name="dDateFrom">');
				e('</div>');

				e('<div class="label_block">');
					e('<label for="dDateUntil">До<label>');
					e('<input id="dDateUntil" type="date" name="dDateUntil">');
				e('</div>');

				e('<hr>');
			e('</div>');

			if (isset($d['users']) && $d['users']) {
				e('<div id="divSenderUser" class="label_block">');
					e('<label for="dSenderUser">Відправник</label>');
					e('<select id="dSenderUser" name="dSenderUser">');

						e('<option value=""></option>');

						foreach ($d['users'] as $row) {
							e('<option value="'. $row['us_id'] .'">'.  $row['us_login'] .'</option>');
						}

					e('</select>');
				e('</div>');
			}

			if (isset($d['documentSenders']) && $d['documentSenders']) {
				e('<div id="divSenderExternal" class="label_block">');
					e('<label for="dSenderExternal">Відправник</label>');
					e('<select id="dSenderExternal" name="dSenderExternal">');

						e('<option value=""></option>');

						foreach ($d['documentSenders'] as $mtRow) {
							e('<option value="'. $mtRow['dss_id'] .'">'.  $mtRow['dss_name'] .'</option>');
						}

					e('</select>');
				e('</div>');
			}

			if (isset($d['documentSenders']) && $d['documentSenders']) {
				e('<div id="divRecipientExternal" class="label_block">');
					e('<label for="dRecipientExternal">Отримувач</label>');
					e('<select id="dRecipientExternal" name="dRecipientExternal">');

						e('<option value=""></option>');

						foreach ($d['documentSenders'] as $mtRow) {
							e('<option value="'. $mtRow['dss_id'] .'">'.  $mtRow['dss_name'] .'</option>');
						}

					e('</select>');
				e('</div>');
			}

			if (isset($d['users']) && $d['users']) {
				e('<div id="divRecipientUser" class="label_block">');
					e('<label for="dRecipientUser">Отримувач</label>');
					e('<select id="dRecipientUser" name="dRecipientUser">');

						e('<option value=""></option>');

						foreach ($d['users'] as $mtRow) {
							e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
						}

					e('</select>');
				e('</div>');
			}

			if (isset($d['users']) && $d['users']) {
				e('<div class="label_block">');
					e('<label for="dRegistrar">Реєстратор</label>');
					e('<select id="dRegistrar" name="dRegistrar">');

						e('<option value=""></option>');

						foreach ($d['users'] as $mtRow) {
							e('<option value="'. $mtRow['us_id'] .'">'.  $mtRow['us_login'] .'</option>');
						}

					e('</select>');
				e('</div>');
			}

			if (isset($d['departments']) && $d['departments']) {
				e('<div class="label_block">');
					e('<label for="dLocation">Фізичне місцезнаходження оригінала</label>');
					e('<select id="dLocation" name="dLocation">');

						e('<option value=""></option>');

						foreach ($d['departments'] as $mtRow) {
							e('<option value="'. $mtRow['dp_id'] .'">'.  $mtRow['dp_name'] .'</option>');
						}

					e('</select>');
				e('</div>');
			}

		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_search">Шукати</button>');
		e('</div>');

	e('<form>');

e('</div>');

e('<script src="/js/main.js"></script>');
e('<script src="/js/df_search.js"></script>');

require $this->getViewFile('/inc/footer');
