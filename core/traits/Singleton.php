<?php

namespace core\traits;

/**
 * Синглтон шаблон.
 * Гарантирует наличие только одного объекта данного класса во время выполнения приложения.
 */
trait Singleton {

  // Текущий объект. Не обращаться к данному свойству вне класса. Только через self::instance().
  static private $_instance;

  private function __construct () {}
  private function __clone() {}

  /**
   * Метод для доступа к текущему объекту.
   * @return $this
   */
  static public function getInstance () {
    if (! isset(self::$_instance)) {
			self::$_instance = new self();
			self::$_instance->_init();
		}

    return self::$_instance;
  }
}
