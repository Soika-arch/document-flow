<?php

namespace core\traits;

use core\exceptions\ClassException;
use core\exceptions\SingletonException;

/**
 * Трейт, який реалізує базові магічні методи __set і __get для Singleton класа	.
 */
trait Singleton_SetGet {

	use Singleton;

  /**
   * Метод, який викликається автоматично, коли є звертання до недоступної властивості класу.
	 * @param string $name назва властивості, до якої відбулося звернення.
   */
  public function __get ($name) {
		if (isset(self::$_instance)) {
			if ($name == "_instance") {
				// Окремий випадок для властивості _instance.

				return $this::$_instance;
			}
			else {
				// Якщо властивість вже ініціалізована - вона повертається одразу.
				if (isset(self::$_instance->$name)) return self::$_instance->$name;

				if (property_exists(self::$_instance, $name)) {
					// Цей блок виконується якщо поточний клас має вказану властивість
					// і вона ще не ініціалізована.

					// Формування імені метода, який повинен повернути вказану властивість.
					$method = "get_". $name;

					if (method_exists(self::$_instance, $method)) {
						// Метод існує, викликається і повертається результат його обчислень.

						return $this::$_instance->$method();
					}

					throw new SingletonException(3999, ['calledClass' => get_called_class(), 'value' => $name]);
				}

				throw new ClassException(6001, ['calledClass' => get_called_class(), 'value' => $name]);

			}
		}
		else {
			dd('', __FILE__, __LINE__,1);
			// throw new ClassException(9, ["class" => get_called_class(), "name" => $name]);
		}
  }

  /**
   *
   */
  public function __set (string $name, $value) {
		dd([$name, $value], __FILE__, __LINE__,1);
		if (isset(self::$_instance)) {
			if (property_exists(self::$_instance, $name)) {
				$method = "set_". $name;

				if (method_exists(self::$_instance, $method)) {
					self::$_instance->$method($value);
				}
				else {
					dd('', __FILE__, __LINE__,1);
					// err("classes", 2, __FILE__, __LINE__, debug_backtrace(),
					// 	["name" => $name, "method" => $method]);
				}
			}
			else {
				dd('', __FILE__, __LINE__,1);
				// err("classes", 1, __FILE__, __LINE__, debug_backtrace(),
				// 	["name" => $name, "class" => get_class(self::$_instance)]);
			}
		}
		else {
			throw new ClassException(9, ["class" => get_called_class(), "name" => $name]);
		}
  }
}
