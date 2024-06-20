<?php

// Вид сторінки списка cron задач адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="cron-list">');

	$num = 1;

	foreach ($d['crons'] as $cronRow) {
		e('<div class="cron-block">');
			e('<span class="cron-num">'. $num++ .'</span>');

			$runURL = url('/crons/'. $cronRow['crt_task_name']);

			$runLink = '<a href="'. $runURL .'" target="_blank" title="Змінити">'.
				$cronRow['crt_task_name'] .'</a>';

			e('<span class="cron-method">'. $runLink .'</span>');
			e('<span class="cron-description">'. $cronRow['crt_description'] .'</span>');
			e('<span class="cron-schedule">'. $cronRow['crt_schedule'] .'</span>');
			e('<span class="cron-is_active">'. $cronRow['crt_is_active'] .'</span>');

			e('<span class="cron-last_run">'. date('d.m.Y H:i', strtotime($cronRow['crt_last_run'])) .
				'</span>');

			e('<span class="cron-next_run">'. date('d.m.Y H:i', strtotime($cronRow['crt_next_run'])) .
				'</span>');

			$runURL = url('/ap/crons/list?m='. $cronRow['crt_task_name']);

			$runLink = '<a href="'. $runURL .'" title="Виконати"><img class="img-button" src="'.
				URLHome .'/img/update.png"></a>';

			e('<span class="cron-task_menu">'. $runLink .'</span>');

		e('</div>');
	}

e('</div>');

require $this->getViewFile('/inc/footer');
