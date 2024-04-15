<?php

namespace core\traits;

/**
 *
 */
trait Singleton_SetGet {

  /**
   * Возвращает значение protected или private свойства текущего объекта.
   * Доступ к любому свойству вне класса через $obj::instance()->$name.
   * @param string $name имя свойства класса
   * @return mixed $this->$name значение свойства текущего объекта
   * @return bool false если запрошенного свойства не существует
   */
  public function __get ($name) {
		dd($name, __FILE__, __LINE__,1);
		if (isset(self::$_instance)) {
			if ($name == "_instance") {
				/** Частный случай для свойства _instance. */

				return $this::$_instance;
			}
			else {
				if (property_exists(self::$_instance, $name)) {
					$method = "get_". $name;

					if (method_exists(self::$_instance, $method)) {
						return $this::$_instance->$method();
					}

					dd('', __FILE__, __LINE__,1);
					// err("classes", 3, __FILE__, __LINE__, debug_backtrace(),
					// 	["class" => get_called_class(), "name" => $name, "method" => $method]);
				}
				else {
					dd('', __FILE__, __LINE__,1);
					// err("classes", 1, __FILE__, __LINE__, debug_backtrace(),
					// 	['class' => get_called_class(), 'name' => $name]);
				}
			}
		}
		else {
			throw new ClassException(9, ["class" => get_called_class(), "name" => $name]);
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
