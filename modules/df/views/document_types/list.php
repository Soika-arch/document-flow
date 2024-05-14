<?php

// Вид сторінки списка типів документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['DTData']) && $d['DTData']) {
	e('<div class="df-dt_list">');

		if (isset($d['DTData']['pagin']) && $d['DTData']['pagin']) {
			e('<div class="menu-pagin">');

				foreach ($d['DTData']['pagin'] as $pagin) {
					$sccClass = $pagin['isCurrent'] ? ' class="current"' : '';

					e('<span'. $sccClass .'><a href="'. url('', ['pg' => $pagin['num']]) .'">'.
						$pagin['num'] .'</a></span>');
				}

			e('</div>');
		}

		foreach ($d['DTData']['dt'] as $usRow) {
			e('<div class="dt-data">');

				$profileURL = url('');
				$delURL = url('', ['del_type' => $usRow['dt_id']]);
				$delIMG = url('/img/delete.png');

				e('<div class="dt-name">');
					e('<a href="'. $profileURL .'">'. $usRow['dt_name'] .'</a>');
				e('</div>');

				e('<div class="dt-control-buttons">');
					e('<a href="'. $delURL .'"><img class="img-button" src="'. $delIMG .
						'" title="Видалити тип документа"></a>');
				e('</div>');

			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');
