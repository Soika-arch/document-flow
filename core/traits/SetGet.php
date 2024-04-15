<?php

/**
 * Трейт получения и изменения свойств объекта, данные которого НЕ содержатся в БД.
 */

namespace core\traits;

use core\exceptions\ClassException;

/**
 *
 */
trait SetGet {

  /**
   * Возвращает значение protected или private свойства текущего объекта.
   * @param string $name имя свойства класса
   * @return mixed $this->$name значение свойства текущего объекта
   * @return bool false если запрошенного свойства не существует
   */
  public function __get ($name) {
		try {
			if (property_exists($this, $name)) {
				$method = "get_". $name;

				if (method_exists($this, $method)) {

					return $this->$method();
				}

				throw new ClassException(2000, ["name" => $name, "method" => $method]);
			}
			else {
				throw new ClassException(2001, ["name" => $name]);
			}
		} catch (ClassException $th) {
			$th->printMsg();
		}
  }

	/**
   *
   */
  public function __set (string $name, $value) {
		try {
			if (property_exists($this, $name)) {
				$method = "set_". $name;

				if (method_exists($this, $method)) {
					$this->$method($value);
				}
				else {
					err("classes", 2, __FILE__, __LINE__, debug_backtrace(),
						['class' => get_called_class(), 'name' => $name, 'method' => $method]);
				}
			}
			else {
				throw new ClassException(2001, ["name" => $name]);
			}
		} catch (ClassException $th) {
			$th->printMsg();
		}
  }
}
