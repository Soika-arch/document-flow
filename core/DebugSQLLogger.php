<?php

namespace core;

use Doctrine\DBAL\Logging\SQLLogger;

class DebugSQLLogger implements SQLLogger {

	public function startQuery($sql, ?array $params=null, ?array $types=null) {
		file_put_contents(DirRoot .'/service/sql_log.log', $sql ."\n\nParameters: ". var_export($params, true) ."\n\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\n", FILE_APPEND);
	}

	public function stopQuery() {
		// You can implement this method if needed
	}
}
