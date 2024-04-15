<?php

// Головні функції проєкту.

// Автопідключення класів.

use core\Debug;

function classesAutoload () {
	spl_autoload_register(
		function($className) {
			$fname = str_replace('\\', '/', DirRoot .'/'. $className . '.php');

			if (is_file($fname)) {
				require_once $fname;
			}
			else {
				// dd([$fname, is_file($fname)], __FILE__, __LINE__,1);
			}
		}
	);

	define('PetamicrClassesAutoloader', true);
}

function dd (mixed $var, string $fname, string $line, bool $stop=false, bool $saveToFile=false) {
	$html = ob_get_clean();
	$trace = debug_backtrace();
	$f = file($trace[0]["file"]);
	$l = $trace[0]["line"] - 1;
	preg_match( "#^.*?dd\((.*?), __#", $f[$l], $match);

	$htmlLoc = "<div style=\"margin:0px 0px 10px 0px;padding:10px 0px 10px 0px;background:#e6dbb6;".
		"color:#1a0f68;font-size:17px;\">\n";

	$htmlLoc .= "<div style=\"display:inline-block;margin:5px 5px 0px 10px;padding:2px 10px 2px 10px;'.
		' background:#e4dfdf;\"><i>file: {$fname}, line: {$line}</i></div>\n";

	if (isset($match[1])) {
		$htmlLoc .= "<div style=\"margin:10px 0px 0px 10px;\">&gt;&gt; <span style=\"color:#410ce0;\">".
			$match[1] ."</span></div></div>\n";
	}

	// if ($saveToFile) file_put_contents(PlugPath .'/debug.json', json_encode($var));

	require_once DirRoot .'/core/Debug.php';

	echo $htmlLoc . Debug::var_dump($var);
	echo $html;

	if ($stop) exit;
}
