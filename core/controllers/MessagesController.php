<?php

namespace core\controllers;

use \core\controllers\MainController;
use \core\Get;
use core\Post;

/**
 * Контроллер cron-завдань.
 */
class MessagesController extends MainController {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, ['SuperAdmin', 'Admin', 'User', 'Viewer'])) {

			return;
		}

		$Get = new Get([
			'pn' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			]
		]);

		$pageNum = isset($Get->get['pn']) ? $Get->get['pn'] : 1;

		$d = $this->Model->mainPage($pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('/messages/main');
	}

	/**
	 * Сторінка перегляду повідомлення користувача.
	 */
	public function viewingPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, ['SuperAdmin', 'Admin', 'User', 'Viewer'])) {

			return;
		}

		$Get = new Get([
			'm' => [
				'type' => 'int',
				'isRequired' => true,
				'pattern' => '^\d{1,4}$'
			]
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		$pageNum = isset($Get->get['pn']) ? $Get->get['pn'] : 1;

		$d = $this->Model->viewingPage($pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('/messages/viewing');
	}

	/**
	 * Обробка запита користувача на видалення повідомлень.
	 * @return
	 */
	public function deletePage () {
		$Post = new Post('user_messages', [
			'deleteMessages' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^$'
			],
			'msgsId' => [
				'type' => 'array',
				'pattern' => '^\d{1,5}$',
				'isRequired' => false
			]
		]);

		if ($Post->post['msgsId']) $d = $this->Model->deletePage();

		if ($d['rowCount'] > 0) sess_addSysMessage('Повідомлення видалені');

		hd_sendHeader('Location: '. url('/messages'), __FILE__, __LINE__);
	}
}
