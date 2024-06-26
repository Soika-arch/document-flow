<?php

namespace core\models;

use \core\db_record\user_messages;
use \core\models\MainModel;
use \core\RecordSliceRetriever;
use \libs\Paginator;

/**
 * Модель cron-завдань.
 */
class MessagesModel extends MainModel {

	/**
	 * @return array
	 */
	public function mainPage (int $pageNum=1) {
		$Us = rg_Rg()->get('Us');
		$d['title'] = 'Повідомлення';
		$tName = DbPrefix .'user_messages';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('usm_trash_bin = :trashBin')
			->where('usm_id_user = :idUser')
			->orderBy('usm_id', 'desc')
			->setParameter('trashBin', 'n')
			->setParameter('idUser', $Us->_id);

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 10;
		$d['messages'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/messages?pn=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function viewingPage () {
		$Us = rg_Rg()->get('Us');
		$get = rg_Rg()->get('Get')->get;

		$d['title'] = 'Повідомлення';
		$d['Message'] = new user_messages($get['m']);

		// Якщо поточний користувач є отримувачем і повідомлення має статус непрочитаного -
		// змінити статус на прочитане.
		if (($Us->_id === $d['Message']->_id_user) && ($d['Message']->_read === 'n')) {
			$d['Message']->update(['usm_read' => 'y']);
		}

		return $d;
	}

	/**
	 * @return array
	 */
	public function deletePage () {
		$Us = rg_Rg()->get('Us');
		$post = rg_Rg()->get('Post')->post;
		$sqlInList = array_map('intval', $post['msgsId']);

		$SQL = db_getDelete()
			->from(DbPrefix .'user_messages')
			->where('usm_id_user', '=', $Us->_id)
			->where('usm_id', 'in', array_map('intval', $sqlInList));

		return db_delete($SQL);
	}
}
