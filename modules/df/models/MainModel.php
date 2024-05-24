<?php

namespace modules\df\models;

use \core\models\MainModel as MM;
use \core\RecordSliceRetriever;
use \libs\Paginator;

/**
 * Модель типів документів.
 */
class MainModel extends MM {

	/** @var string повний шлях до каталога зберігання завантажених документів. */
	protected string $storagePath;

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Ініціалізує та повертає властивість $this->storagePath.
	 * @return string
	 */
	protected function get_storagePath () {
		if (! isset($this->storagePath)) $this->storagePath = DirModules .'/'. URIModule .'/storage';

		return $this->storagePath;
	}

	/**
	 *
	 */
	public function mainPage () {
		$args = funcGetArgs(func_get_args());
		$pageNum = isset($args['pageNum']) ? $args['pageNum'] : 1;
		$d['title'] = 'ЕД';

		$get = rg_Rg()->get('Get')->get;

		$SQLDocs = (new RecordSliceRetriever())
			->from(DbPrefix . 'incoming_documents_registry')
			->columns([DbPrefix .'incoming_documents_registry.*'])
			->orderBy('idr_add_date');

		if (isset($get['d_age'])) {
			$SQLDocs->SQL->whereRaw($SQLDocs->SQL->raw('year(idr_document_date)') .' = "'.
				$get['d_age'] .'"');
		}
		// dd($SQLDocs->SQL->prepare(), __FILE__, __LINE__,1);
		$itemsPerPage = 5;

		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-incoming/list?pg=(:num)');

		$d['Pagin'] = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);

		return $d;
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

		$itemsPerPage = 5;

		$d['dt'] = $SQLDt->select($itemsPerPage, $pageNum);

		$d['Pagin'] = new Paginator($SQLDt->getRowsCount(), $itemsPerPage, $pageNum);

		return $d;
	}
}
