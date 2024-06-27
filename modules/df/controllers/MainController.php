<?php

namespace modules\df\controllers;

use \core\controllers\MainController as MC;
use \core\Get;
use \modules\df\models\MainModel;

/**
 * Контроллер типів документів.
 */
class MainController extends MC {

	private MainModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Viewer', 'User', 'Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'del_doc' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'pg' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'clear' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^y$'
			],
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		$pageNum = isset($Get->get['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->mainPage('pageNum:'. $pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('main');
	}

	/**
	 * @return
	 */
	public function documentDownloadPage () {
		$Get = new Get([
			'n' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^(inc|out|int)_\d{8}$'
			]
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		// Унікальний номер документа з таблиці реєстру документів.
		$docNumber = $Get->get['n'];

		// Масив ідентифікації таблиць реєстру документів по отриманому GET-параметру.
		$docTypes = [
			'inc' => 'incoming_documents_registry',
			'out' => 'outgoing_documents_registry',
			'int' => 'internal_documents_registry'
		];

		// Отримання префікса ключа до назви відповідної таблиці реєстру документів.
		/** @var string */
		$px = substr($docNumber, 0, 3);

		// Отримання префіксу стовпців відповідної таблиці реєстру документів.
		/** @var string */
		$tableColPx = db_Db()->getColPxByTableName(DbPrefix . $docTypes[$px]);

		// Отримання запису з таблиці реєстру документів для файла з номером $docNumber.
		/** @var array */
		$dbRow = $this->Model->selectRowByCol(
			DbPrefix . $docTypes[$px], $tableColPx . 'number', substr($docNumber, 4)
		);

		$docClass = '\core\db_record\\'. $docTypes[$px];
		/** @var incoming_documents_registry|outgoing_documents_registry|internal_documents_registry */
		$Doc = new $docClass($dbRow[$tableColPx .'id'], $dbRow);
		/** @var string */
		$filePath = $Doc->filePath;

		// Перевірка існування файлу.
		if (!file_exists($filePath)) {
			http_response_code(404);
			die('File not found');
		}

		// Отримання інформації про файл.
		$fileName = basename($filePath);
		$fileSize = filesize($filePath);
		$fileType = mime_content_type($filePath);

		// Відправка користувачу заголовків, які надають інформацію про файл, який буде завантажуватись.

		hd_Hd()->addHeader('Content-Description: File Transfer', __FILE__, __LINE__);
		hd_Hd()->addHeader('Content-Type: ' . $fileType, __FILE__, __LINE__);

		hd_Hd()->addHeader('Content-Disposition: attachment; filename="' . $fileName . '"',
			__FILE__, __LINE__);

		hd_Hd()->addHeader('Content-Length: ' . $fileSize, __FILE__, __LINE__);

		// Зчитування файлу та надсилання його вмісту користувачу.
		readfile($filePath);
		hd_Hd()->send();

		exit;
	}

	/**
	 * Друк картки документа.
	 */
	public function printCardPage () {
		$Get = new Get([
			'n' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^(inc|out|int)_\d{8}$'
			]
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		$d = $this->Model->printCardPage();

		require $this->getViewFile('print_card');
	}

	/**
	 * Сторінка коментарів до картки
	 */
	public function comments () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'd_id' => [
				'type' => 'int',
				'isRequired' => true,
				'pattern' => '^\d{1,6}$'
			],
			'pg' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'clear' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^y$'
			],
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		$pageNum = isset($Get->get['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->mainPage('pageNum:'. $pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('card_comments');
	}

	/**
	 * Додавання коментаря до картки документа.
	 */
	public function cardAddCommentPage () {
		$rawData = file_get_contents('php://input');
		$data = json_decode($rawData, true);

		if ($data) {
			// Отримано дані коментаря.

			if ($data['dComment'] === '') {
				$resp['errors'][] = 'Відсутній текст повідомлення';
			}
			else {
				if ($this->Model->addCardComment($data)) {
					$resp['result'] = true;
				}
				else {
					$resp['errors'][] = 'Помилка! Коментар не додано';
				}
			}
		}
		else {
			$resp = ['errors' => ['Помилка отримання даних']];
		}

		// Відправка відповіді у форматі JSON
		$this->sendJsonData($resp);
	}

	/**
	 *
	 */
	public function getCardCommentsPage () {
		$rawData = file_get_contents('php://input');
		$data = json_decode($rawData, true);

		if ($data) {
			// Отримано дані коментаря.

			$cardComments = $this->Model->getCardCommentsPage(
				$data['docDirection'], $data['docNumber'], $data['pageNumber']
			);

			if ($cardComments) {
				$resp['commentsData'] = $cardComments;
				// $resp['result'] = true;
			}
			else {
				$resp['errors'][] = 'Помилка! Коментар не додано';
			}
		}
		else {
			$resp = ['errors' => ['Помилка отримання даних']];
		}

		// Відправка відповіді у форматі JSON
		$this->sendJsonData($resp);
	}

	/**
	 *
	 */
	public function sendJsonData ($data) {
		// hd_Hd()->addHeader('Content-Type: application/json', __FILE__, __LINE__)->send();
		echo json_encode($data);
		exit;
	}
}
