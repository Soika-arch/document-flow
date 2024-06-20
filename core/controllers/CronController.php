<?php

namespace core\controllers;

use \core\controllers\MainController;
use \core\db_record\cron_tasks;
use \Cron\CronExpression;

/**
 * Контроллер cron-завдань.
 */
class CronController extends MainController {

	/**
   * Конструктор для CronController.
   *
   * Ініціалізує контролер, завантажує cron задачі та модулі, перевіряє наявність
   * необхідних файлів і методів, та запускає задачі.
   */
	public function __construct () {
		parent::__construct();
		// Підключення файлу cron функцій.
		require_once DirFunc . '/cron.php';
	}

	/**
	 * @return
	 */
	public function findControllerByMethod (string $taskMethod) {
		// Отримання списку модулів.
		$dirModules = scandir(DirModules);

		if (method_exists($this, $taskMethod)) return $this;

		// Проходження по кожній директорії модуля для пошуку метода $taskMethod.
		foreach ($dirModules as $dirName) {
			// Пропуск директорій '.' та '..'.
			if ($this->isDotDirectory($dirName)) continue;

			// Формування шляху до файлу конфігурації модуля.
			$moduleFile = DirModules . '/' . $dirName . '/config.php';

			// Перевірка, чи існує файл конфігурації.
			if (! is_file($moduleFile)) continue;

			// Завантаження конфігурації модуля.
			$config = require $moduleFile;

			// Перевірка наявності налаштувань cron в конфігурації.
			if (! isset($config['cron'])) continue;

			$moduleDir = DirModules .'/'. $dirName;
			$cronFile = $moduleDir .'/controllers/CronController.php';

			if (! is_file($cronFile)) continue;

			// Формування повного імені класу контролера cron задач.
			$relativePath = str_replace(DirRoot . '/', '', $cronFile);
			$cronContrClass = str_replace(['/', '.php'], ['\\', ''], $relativePath);

			if (method_exists($cronContrClass, $taskMethod)) return new $cronContrClass();
		}

		return false;
	}

	/**
	 *
	 */
	public function run () {
		// Отримання списку модулів.
		$dirModules = scandir(DirModules);

		// Отримання даних усіх cron задач з таблиці БД `cron_tasks`.
		$cronTasks = cron_getTasks();

		// Проходження по кожній директорії модуля.
		foreach ($dirModules as $dirName) {
			// Пропуск директорій '.' та '..'.
			if ($this->isDotDirectory($dirName)) continue;

			// Формування шляху до файлу конфігурації модуля.
			$moduleFile = DirModules . '/' . $dirName . '/config.php';

			// Перевірка, чи існує файл конфігурації.
			if (! is_file($moduleFile)) continue;

			// Завантаження конфігурації модуля.
			$config = require $moduleFile;

			// Перевірка наявності налаштувань cron в конфігурації.
			if (! isset($config['cron'])) continue;

			// Підключення модуля та запуск cron задач.
			$this->includeModule($dirName, $cronTasks);
		}
	}

	/**
	 * @return
	 */
	public function runTask (string $taskMethod) {
		if (method_exists($this, $taskMethod)) {
			$this->loadModule();
			$this->$taskMethod();

			return true;
		}
		else {
			$CronContr = $this->findControllerByMethod($taskMethod);
			$CronContr->loadModule();
			$CronContr->$taskMethod();
		}

		return false;
	}

	public function loadModule () {
		$str = str_replace('\controllers\CronController', '', get_class($this));
		$loadFile = DirModules .'/'. substr($str, (strpos($str, '\\') + 1)) .'/load.php';

		if (is_file($loadFile)) require_once $loadFile;
	}

	/**
	 * Перевіряє, чи є директорія "." або "..".
	 *
	 * @param string $dirName Назва директорії.
	 * @return bool
	 */
	private function isDotDirectory (string $dirName) {
		return $dirName === '.' || $dirName === '..';
	}

	/**
	 * Підключає модуль та запускає cron задачі, якщо конфіг містить cron.
	 *
	 * @param string $dirName Назва директорії модуля.
	 * @param array &$cronTasks Список cron задач.
	 * @return void
	 */
	private function includeModule (string $dirName, array &$cronTasks) {
		// Формування шляху до директорії модуля.
		$moduleDir = DirModules . '/' . $dirName;

		// Підключення файлу завантаження модуля.
		require_once $moduleDir . '/load.php';

		// Формування шляху до контролера cron задач модуля.
		$cronFile = $moduleDir . '/controllers/CronController.php';

		// Перевірка наявності файлу контролера cron задач.
		if (!is_file($cronFile)) {
			// Відправка повідомлення про виключення, якщо файл не знайдено.
			tg_sendExeption(__FILE__, __LINE__, ['cronFile' => $cronFile]);

			// Завершення виконання методу.
			return;
		}

		// Формування повного імені класу контролера cron задач.
		$relativePath = str_replace(DirRoot . '/', '', $cronFile);
		$cronContrClass = str_replace(['/', '.php'], ['\\', ''], $relativePath);

		// Створення екземпляра класу контролера cron задач.
		$CronController = new $cronContrClass();

		// Запуск cron задач для даного контролера.
		$this->runCronTasks($CronController, $cronTasks);
	}

	/**
	 * Запускає cron задачі для даного контролера.
	 *
	 * @param object $CronController Об'єкт контролера cron.
	 * @param array $cronTasks Список cron задач таблиці `cron_tasks`.
	 * @return void
	 */
	private function runCronTasks (object $CronController, array &$cronTasks) {
		foreach ($cronTasks as $key => $taskData) {
			$taskMethod = $taskData['crt_task_name'];

			if (! method_exists($CronController, $taskMethod)) {
				tg_sendExeption(__FILE__, __LINE__, ['taskMethod' => $taskMethod]);

				continue;
			}

			if ($this->taskExec($CronController, $taskData)) unset($cronTasks[$key]);
		}
	}

	/**
	 * Виконує вказану cron задачу, якщо настав час її запуску.
	 *
	 * @param object $CronController Об'єкт контролера cron.
	 * @param array $task Дані задачі cron.
	 * @return bool Повертає true, якщо задача була виконана, інакше false.
	 */
	protected function taskExec (object $CronController, array $task) {
		// Створення об'єкта виразу cron для розрахунку часу запуску.
		$CronExpr = CronExpression::factory($task['crt_schedule']);
		// Отримання дати останнього запуску задачі.
		$LastRunDate = new \DateTime($task['crt_last_run']);
		// Поточна дата і час.
		$CurrentDate = new \DateTime();

		// Перевірка, чи настав час виконання задачі.
		if (!$task['crt_last_run'] || ($CronExpr->getNextRunDate($LastRunDate) <= $CurrentDate)) {
			// Час виконання крон задачі.

			// Отримання методу задачі з даних задачі.
			$taskMethod = $task['crt_task_name'];
			// Виконання відповідної cron задачі.
			$CronController->$taskMethod();
			// Створення об'єкта для роботи з записом задачі в базі даних.
			$CronRow = new cron_tasks($task['crt_id'], $task);

			// Оновлення часу останнього і часу наступного виконання cron задачі.
			$CronRow->update([
				'crt_last_run' => $CurrentDate->format('Y-m-d H:i:s'),
				'crt_next_run' => $CronExpr->getNextRunDate()->format('Y-m-d H:i:s')
			]);

			// Повертає true, якщо задача була виконана.
			return true;
		}

		// Повертає false, якщо задача не була виконана.
		return false;
	}
}
