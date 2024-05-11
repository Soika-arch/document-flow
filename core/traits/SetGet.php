<?php

namespace core\traits;

use core\exceptions\ClassException;

/**
 * Трейт, який реалізує базові магічні методи __set і __get.
 */
trait SetGet {

  /**
   * Метод, який викликається автоматично, коли є звертання до недоступної властивості класу.
	 * @param string $name назва властивості, до якої відбулося звернення.
   */
  public function __get (string $name) {
		// Якщо властивість вже ініціалізована - вона портається одразу.
		if (isset($this->$name)) return $this->$name;

		if (property_exists($this, $name)) {
			// Цей блок виконується якщо поточний клас має вказану властивість і вона ще не ініціалізована.

			// Формування імені метода, який повинен повернути вказану властивість.
			$method = "get_". $name;

			if (method_exists($this, $method)) {
				// Метод існує, викликається і повертається результат його обчислень.

				return $this->$method();
			}

			throw new ClassException(2000, ["name" => $name, "method" => $method]);
		}

		throw new ClassException(2001, ["name" => $name]);
  }

	/**
   * Метод, який викликається автоматично при спробі перезаписати значення недоступної властивості.
	 * @param string $name назва властивості, до якої відбулося звернення.
	 * @param mixed $value назва властивості, до якої відбулося звернення з метою її перезапису.
   */
  public function __set (string $name, mixed $value) {
		if (property_exists($this, $name)) {
			// Цей блок виконується тільки якщо поточний клас має вказану властивість.

			// Формування імені метода, який повинен виконати зміну значення вказаної властивості.
			$method = "set_". $name;

			if (method_exists($this, $method)) {
				// Метод існує і викликається.

				$this->$method($value);
			}
			else {
				throw new ClassException(6002, ['value' => $value, 'method' => $method]);
			}
		}
		else {
			throw new ClassException(2001, ["name" => $name]);
		}
  }
}
