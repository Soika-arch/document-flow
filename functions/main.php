<?php

// Головні функції проєкту.

// Автопідключення класів.
function classesAutoload () {
	spl_autoload_register(
		function($className) {
			$fname = str_replace('\\', '/', DirClasses .'/'. $className . '.php');

			if (is_file($fname)) {
				require_once $fname;
			}
			else {
				dd($fname, __FILE__, __LINE__);
			}
		}
	);

	define('PetamicrClassesAutoloader', true);
}
