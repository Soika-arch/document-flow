<?php

namespace modules\df\models;

use \core\db_record\user_messages;
use \core\models\MainModel as MM;
use \core\RecordSliceRetriever;
use \core\User;
use \libs\Paginator;
use \libs\query_builder\SelectQuery;

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
	 * @return array|false
	 */
	public function mainPage () {
		$args = funcGetArgs(func_get_args());
		$pageNum = isset($args['pageNum']) ? $args['pageNum'] : 1;
		$d['title'] = 'ЕД';

		$SQLDocs = db_getSelect()
			->from(DbPrefix . 'incoming_documents_registry')
			->columns([DbPrefix .'incoming_documents_registry.*'])
			->orderBy('idr_add_date');

		if (isset($_SESSION['getParameters'])) {
			if (! ($SQLDocs = $this->documentsSearchSQLHendler($SQLDocs))) return false;
			// dd($SQLDocs->prepare(), __FILE__, __LINE__,1);
		}

		$SQLDocs = new RecordSliceRetriever($SQLDocs);

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

	/**
	 * @return SelectQuery|false $SQL
	 */
	protected function documentsSearchSQLHendler (SelectQuery $SQL) {
		if (isset(rg_Rg()->get('Get')->get['clear'])) {
			sess_delGetParameters();

			return false;
		}

		$params = $_SESSION['getParameters'];
		$orJoin = [];

		if (isset($params['d_number'])) {
			$SQL->where('idr_number', 'like', '%'. $params['d_number'] .'%');
		}

		if (isset($params['d_age']) || isset($params['d_month']) || isset($params['d_day'])) {
			if (isset($params['d_age'])) {
				$SQL->whereRaw($SQL->raw('year(idr_document_date)') .' = "'.
					$params['d_age'] .'"');
			}

			if (isset($params['d_month'])) {
				$SQL->whereRaw($SQL->raw('month(idr_document_date)') .' = "'.
					$params['d_month'] .'"');
			}

			if (isset($params['d_day'])) {
				$SQL->whereRaw($SQL->raw('day(idr_document_date)') .' = "'.
					$params['d_day'] .'"');
			}
		}
		else if (isset($params['d_date_from']) || isset($params['d_date_until'])) {
			if (isset($params['d_date_from']) && isset($params['d_date_until'])) {
				$SQL->whereRaw('idr_document_date >= "'. $params['d_date_from'] .'"'.
					' and idr_document_date <= "'. $params['d_date_until'] .'"');
			}
			else if (isset($params['d_date_from'])) {
				$SQL->whereRaw('idr_document_date >= "'. $params['d_date_from'] .'"');
			}
			else if (isset($params['d_date_until'])) {
				$SQL->whereRaw('idr_document_date <= "'. $params['d_date_until'] .'"');
			}
		}

		if (isset($params['d_location'])) {
			$SQL
				->join(DbPrefix .'departments', 'dp_id', '=', 'idr_id_document_location')
				->where('idr_id_document_location', '=', $params['d_location']);
		}

		if (isset($params['d_sender_external'])) {
			$SQL
				->join(DbPrefix .'document_senders', 'dss_id', '=', 'idr_id_sender')
				->where('idr_id_sender', '=', $params['d_sender_external']);
		}

		if (isset($params['d_recipient_user'])) {
			$orJoin['users'][] = 'us_id = idr_id_recipient';
			$SQL->where('idr_id_recipient', '=', $params['d_recipient_user']);
		}

		if (isset($params['d_registrar_user'])) {
			$orJoin['users'][] = 'us_id = idr_id_user';
			$SQL->where('idr_id_user', '=', $params['d_registrar_user']);
		}

		if ($orJoin) {
			foreach ($orJoin as $table => $joinData) {
				$strJoin = '';

				foreach ($joinData as $condition) {
					$strJoin .= ' or '. $condition;
				}

				if (strpos($strJoin, ' or ') === 0) $strJoin = substr($strJoin, 4);

				$SQL->joinRaw(DbPrefix . $table, $strJoin);
			}
		}

		return $SQL;
	}

	/**
	 * Отримання користувачів, які приймають участь в документообігу (мають доступи не тільки до
	 * перегляду).
	 * @return
	 */
	public function getDocumentFlowParticipants () {
		$SQL = db_getSelect();

		$SQL
			->columns([DbPrefix .'users.*'])
			->from(DbPrefix .'users')
			->join(DbPrefix .'users_rel_statuses', 'usr_id_user', '=', 'us_id')
			->join(DbPrefix .'user_statuses', 'uss_id', '=', 'usr_id_status')
			->where('uss_access_level', '<', '4');

		return db_select($SQL);
	}

	/**
	 * Перевірка та обробка події відкриття картки документа призначеним виконавцем.
	 * Повертає ture, якщо поточний користувач є виконавцем документа.
	 * @return bool
	 */
	protected function checkCardOpenedByExecutor (object $Obj) {
		$Us = rg_Rg()->get('Us');

		if ($idExecutor = $Obj->_id_assigned_user) {
			if (($idExecutor === $Us->_id) && (! $Obj->_date_of_receipt_by_executor)) {

				return $Obj->update([
					$Obj->px .'date_of_receipt_by_executor' => tm_getDatetime()->format('Y-m-d H:i:s')
				]);
			}
		}

		return false;
	}

	/**
	 * Вираховує чи має поточний користувач права реєстратора на картку документа.
	 * @return bool
	 */
	protected function isRegistrarRights (User $Us, object $Doc) {
		$isRegistrar = ($Us->_id === $Doc->_id_user);

		$isExecutor = $Doc->ExecutorUser ?
			$Doc->ExecutorUser->_id === $Us->_id : false;

		return ($isRegistrar || $isExecutor);
	}

	/**
	 * Вираховує чи має поточний користувач права адміна на картку документа.
	 * @return bool
	 */
	protected function isAdminRights (User $Us) {

		return ($Us->Status->_access_level < 3);
	}

	/**
	 * Відправляє повідомлення користувачу про призначення виконавцем документа.
	 * @return
	 */
	protected function informAboutAppointmentAsExecutor (int $idUser, object $Doc) {
		$Msg = new user_messages(null);
		$dt = tm_getDatetime()->format('Y-m-d H:i:s');

		$docLink = '<a href="'. $Doc->cardURL .'">'. $Doc->DocumentTitle->_title .'</a>';

		return $Msg->set([
			'usm_id_user' => $idUser,
			'usm_id_sender' => 1,
			'usm_header' => 'Призначено новий документ на виконання',
			'usm_msg' => 'Вам призначено новий документ на виконання: '. $docLink,
			'usm_read' => 'n',
			'usm_trash_bin' => 'n',
			'usm_add_date' => $dt,
			'usm_change_date' => $dt,
		]);
	}

	/**
	 * @return array
	 */
	public function printCardPage () {
		$get = rg_Rg()->get('Get')->get;

		$documentDirections = [
			'inc' => 'incoming_documents_registry',
			'int' => 'internal_documents_registry',
			'out' => 'outgoing_documents_registry'
		];

		$d['cardData'] = explode('_', $get['n']);
		$table = 'core\db_record\\'. $documentDirections[$d['cardData'][0]];
		$d['Doc'] = new $table($d['cardData'][1]);

		return $d;
	}
}
