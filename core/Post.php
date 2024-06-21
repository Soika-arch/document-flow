<?php

namespace core;

/**
 * Клас надає методи роботи з даними, відправленими методом POST.
 */
class Post {

	use \core\traits\SetGet;

	// Містить масив $_POST
	private array $post;
	// Значення атрибуту name форми, яку обробляє поточний об'єкт.
	private string $formName;
	private array $formTypes;

	// Дозволені типи даних
	private array $allowedTypes = [
		'int', 'float', 'varchar', 'text', 'email', 'dateTime', 'date', 'array'
	];

	private array $errors = [];

	/**
	 *
	 */
	public function __construct (string $formName, array $types) {
		$this->formName = $formName;
		$this->get_post();
		$this->validateAndProcessPostData($types);
		rg_Rg()->add('Post', $this);

		if (isset($this->errors) && $this->errors) sess_addErrMessage($this->printErrors());
	}

	/**
	 * Ініціалізує та повертає властивість $this->post.
	 */
	private function get_post (): array {
		if (! isset($this->post)) $this->post = $_POST;

		return $this->post;
	}

	/**
   * Перевіряє та обробляє параметри, передані через масив $_POST, ґрунтуючись на описаних типах
	 * даних та їх правилах валідації.
   * @param array $types Масив, що містить інформацію про типи даних та їх правила перевірки.
   * @return void
   */
	private function validateAndProcessPostData (array $types) {
		// Отримуємо поточні параметри з масиву $_POST.
		$post = $this->get_post();

		// Проходимо по всіх зазначених типах даних для перевірки та обробки.
		foreach ($types as $name => $typeData) {
			// Перевіряємо, чи існує параметр у масиві $_POST.
			$issetParam = isset($post[$name]);

			// Перевіряємо, чи належить тип даних до дозволених типів.
			if (in_array($typeData['type'], $this->allowedTypes)) {
				// Перевіряємо, чи є параметр обов'язковим
				if (isset($typeData['isRequired']) && $typeData['isRequired']) {
					// Якщо параметр обов'язковий, але відсутній, додаємо повідомлення про помилку.
					if (! $issetParam) {
						$this->errors[$name] = 'Відсутній обов\'язковий параметр $_POST["'. $name .'"]';

						continue;
					}
				}

				// Формуємо ім'я методу перевірки типу даних.
				$checkMethod = 'check'. ucfirst($typeData['type']);

				// Перевіряємо параметр за допомогою відповідного методу, якщо він існує.
				if ($issetParam && (! $this->$checkMethod($name, $typeData))) {
					$this->errors[$name] = 'Параметр '. $name .' не пройшов перевірку типу даних метода '.
						$checkMethod;
				}
			}
			else {
				// Якщо тип даних не є дозволеним, додаємо повідомлення про помилку.
				$this->errors[$name] = 'Отримано недозволений тип даних: '. $typeData['type'];
			}

			// Видаляємо оброблений параметр із масиву $_POST.
			unset($post[$name]);
		}

		// Перевіряємо, чи є непередбачені параметри в масиві $_POST.
		foreach ($post as $name => $value) {
			$this->errors[$name] = 'Отримано непередбачене значення параметру: $_POST["'. $name .'"] - '.
				var_export($value, true);
		}
	}

	/**
	 * Повертає очищене значення масиву $_POST, якщо воно існує.
	 * @return string
	 */
	public function sanitizeValue (string $name) {
		if (isset($this->post[$name])) {

			return htmlspecialchars(trim($this->post[$name]));
		}

		return null;
	}

	/**
	 * @return bool
	 */
	private function checkInt (string $name, array $typeData) {
		if (isset($typeData['pattern'])) {
			if (! ($res = preg_match('/'. $typeData['pattern'] .'/', intval($this->post[$name])))) {
				$this->errors[$name] = 'Параметр: $_POST["'. $name .'"] - не відповідає шаблону [ '.
					$typeData['pattern'] .' ]';
			}
		}
		else {
			$res = preg_match('/\d{0,11}/', $this->post[$name]);
		}

		return $res;
	}

	/**
	 * @return bool
	 */
	private function checkFloat (float $v) {

		return is_float($v);
	}

	/**
	 * Перевіряє чи є $v текстом, а також чи відповідиє довжина тексту величині $l.
	 * @return bool
	 */
	private function checkText (string $v, array $typeData) {
		$f = isset($typeData['length']) ? (strlen($v) <= $typeData['length']) : true;

		return ($f && is_string($v));
	}

	/**
	 * @return bool
	 */
	private function checkVarchar (string $name, array $typeData) {
		if (preg_match('/'. $typeData['pattern'] .'/', $this->post[$name])) {

			return $this->checkText($this->post[$name], $typeData);
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private function checkDateTime (string $name, array $typeData) {
		if (preg_match('/'. $typeData['pattern'] .'/', $this->post[$name])) {

			return $this->checkText($this->post[$name], $typeData);
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private function checkDate (string $name, array $typeData) {
		if (preg_match('/\d{4}-\d\d-\d\d/', $this->post[$name])) {

			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private function checkArray (string $name, array $typeData) {
		foreach ($this->post[$name] as $k => $v) {
			if (isset($typeData['pattern'])) {
				if (! preg_match('/'. $typeData['pattern'] .'/', $v)) return false;
			}
		}

		return true;
	}

	/**
	 * @return string
	 */
	public function printErrors () {
		$str = '';

		if (isset($this->errors) && $this->errors) {
			$str = '<div class="post-errors">';

			foreach ($this->errors as $msg) $str .= '<div>'. $msg .'</div>';

			$str .= '</div>';
		}

		return $str;
	}
}
