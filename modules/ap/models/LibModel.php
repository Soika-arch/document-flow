<?php

namespace modules\ap\models;

use \core\db_record\document_descriptions;
use \core\db_record\document_titles;
use \modules\df\models\MainModel;

/**
 * Модель звітів документів.
 */
class LibModel extends MainModel {

	/**
	 * @return array
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @return array
	 */
	public function mainPage () {
		$d['title'] = 'Бібліотека';

		return $d;
	}

	/**
	 * @return array
	 */
	public function documentTitlesAddPage () {
		$d['title'] = 'Бібліотека - додавання назви (заголовка) документа';

		return $d;
	}

	/**
	 * @return document_titles|false
	 */
	public function documentTitleAdd () {
		$Us = rg_Rg()->get('Us');
		/** @var \core\Post */
		$Post = rg_Rg()->get('Post');
		$DocTitle = new document_titles(null);
		$newTitle = $Post->sanitizeValue('docTitle');
		$idTitle = $this->selectCellByCol($DocTitle->tName, 'dts_title', $newTitle, 'dts_id');

		if ($idTitle) return false;

		$dt = date('Y-m-d H:i:s');

		$DocTitle->set([
			'dts_id_user' => $Us->_id,
			'dts_title' => $newTitle,
			'dts_add_date' => $dt,
			'dts_change_date' => $dt
		]);

		return $DocTitle ? $DocTitle : false;
	}

	/**
	 * @return array
	 */
	public function documentDescriptionsAddPage () {
		$d['title'] = 'Бібліотека - додавання опису документа';

		return $d;
	}

	/**
	 * @return document_descriptions|false
	 */
	public function documentDescriptionAdd () {
		$Us = rg_Rg()->get('Us');
		/** @var \core\Post */
		$Post = rg_Rg()->get('Post');
		$DocDescription = new document_descriptions(null);
		$newDescription = $Post->post['docDescription'];

		$idDescription = $this->selectCellByCol(
			$DocDescription->tName, 'dds_description', $newDescription, 'dds_id'
		);

		if ($idDescription) return false;

		$dt = date('Y-m-d H:i:s');

		$DocDescription->set([
			'dds_id_user' => $Us->_id,
			'dds_description' => $newDescription,
			'dds_add_date' => $dt,
			'dds_change_date' => $dt
		]);

		return $DocDescription ? $DocDescription : false;
	}
}
