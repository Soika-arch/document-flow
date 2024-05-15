<?php

namespace modules\df\models;

use \core\db_record\document_types;
use \core\models\MainModel;
use \core\Post;
use \core\RecordSliceRetriever;
use \libs\Paginator;

/**
 * Модель типів документів.
 */
class DocumentTypesModel extends MainModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function add () {
		$d = [];

		return $d;
	}

	/**
	 * Обробка спроби додавання нового користувача в БД.
	 * @return bool
	 */
	public function addDocumentType () {
		$Post = new Post('fm_userAdd', [
			'dtName' => [
				'type' => 'varchar',
				'pattern' => '^[ \'№a-zA-Zа-яА-ЯїЇіІєЄґҐеЕсСШшьЬтТрРуУщЩюЮхХ\d-]{1,255}$'
			],
			'dtDescription' => [
				'type' => 'text',
				'length' => 1000,
				'pattern' => '[ \',.;:!@#$%&()\[\]{}=№a-zA-Zа-яА-ЯїЇіІєЄґҐеЕсСШшьЬтТрРуУщЩюЮхХ\d-]{1,1000}'
			],
			'bt_addDt' => [
				'type' => 'varchar',
				'pattern' => '^$'
			]
		]);

		if ($Post->errors) dd($Post, __FILE__, __LINE__,1);

		$dtName = $Post->sanitizeValue('dtName');
		$nowDt = date('Y-m-d H:i:s');

		$DocTypeNew = (new document_types(null))->set([
			'dt_id_user' => rg_Rg()->get('Us')->_id,
			'dt_name' => $dtName,
			'dt_description' => $Post->sanitizeValue('dtDescription'),
			'dt_add_date' => $nowDt,
			'dt_change_date' => $nowDt
		]);

		if ($DocTypeNew->_id) {
			sess_addSysMessage('Створено новий тип документа <b>"'. $dtName .'"</b>.');
		}

		return true;
	}

	/**
	 * @param int $pageNum
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$SQLDt = (new RecordSliceRetriever())
			->from(DbPrefix .'document_types')
			->columns(['dt_id', 'dt_name'])
			->orderBy('dt_id');

		$itemsPerPage = 2;

		$d['dt'] = $SQLDt->select($itemsPerPage, $pageNum);

		$url = url('/df/document-types/list?pg=(:num)');

		$Pagin = new Paginator($SQLDt->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}
}
