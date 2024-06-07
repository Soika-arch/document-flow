<?php

// Вид сторінки адмін-панель - безпека - відвідувачі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use \core\User;

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['visitors']) && $d['visitors']) {
	e('<div class="visitors-list">');

		if ($d['Pagin']->getNumPages() > 1) {
			$htmlPagin = $d['Pagin']->toHtml();
			e($htmlPagin);
		}

		e('<table>');

			e('<thead>');
				e('<tr>');
					e('<th>№</th>');
					e('<th>Відвідувач</th>');
					e('<th>IP-адреса</th>');
					e('<th>URI</th>');
					e('<th>USER-AGENT</th>');
					e('<th>DB queries count</th>');
					e('<th>Час виконання скрипта</th>');
					e('<th>Початок виконання скрипта</th>');
				e('</tr>');
			e('</thead>');

			$num = $d['Pagin']->getCurrentPageFirstItem();

			e('<tbody>');

				foreach ($d['visitors'] as $visitRow) {
					$UsTemp = new User($visitRow['vr_id_user']);

					// dd($visitRow, __FILE__, __LINE__,1);
					e('<tr>');
						e('<td class="num">'. $num++ .'</td>');
						e('<td>'. $UsTemp->_login .'</td>');
						e('<td class="ip">'. $visitRow['vr_ip'] .'</td>');
						e('<td>'. $visitRow['vr_uri'] .'</td>');
						e('<td>'. $visitRow['vr_user_agent'] .'</td>');
						e('<td class="queries-count">'. $visitRow['vr_queries_count'] .'</td>');
						e('<td class="execution-time">'. $visitRow['vr_execution_time'] .'</td>');

						e('<td class="add-date">'. date('d.m.Y H:i:s', strtotime($visitRow['vr_add_date'])) .
							'</td>');

					e('</tr>');
				}

			e('</tbody>');

		e('<table>');

		if (isset($htmlPagin)) e($htmlPagin);

	e('</div>');
}

require $this->getViewFile('/inc/footer');
