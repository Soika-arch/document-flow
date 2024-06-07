<?php

// https://github.com/jasongrimes/php-paginator/blob/master/src/JasonGrimes/Paginator.php

namespace libs;

/**
 * Цей клас є простим інструментом для роботи з пагінацією в веб-додатках. Він дозволяє керувати
 * розбиттям великих наборів даних на сторінки, надаючи інформацію про поточну сторінку, загальну
 * кількість елементів, кількість елементів на сторінці та шаблон URL для кожної сторінки. Клас також
 * автоматично обчислює загальну кількість сторінок на основі даних.
 */
class Paginator
{
    /**
  	 * Заповнювач, який використовується в шаблоні URL для номерів сторінок.
  	 */
		const NUM_PLACEHOLDER = '(:num)';

	  /**
  	 * Загальна кількість предметів.
  	 * @var int
  	 */
		protected $totalItems;

		/**
		 * Загальна кількість сторінок.
		 * @var int
		 */
		protected $numPages;

		/**
  	 * Кількість елементів на сторінці.
  	 * @var int
  	 */
		protected $itemsPerPage;

		/**
  	 * Номер поточної сторінки.
  	 * @var int
  	 */
		protected $currentPage;

		/**
  	 * Шаблон URL-адреси для навігації по сторінках.
  	 * @var string
  	 */
		protected $urlPattern;

		/**
  	 * Максимальна кількість сторінок для показу в навігації по сторінках.
  	 * @var int
  	 */
		protected $maxPagesToShow = 10;

		/**
  	 * Текст для «попереднього» елемента керування розбивкою на сторінки.
  	 * @var string
  	 */
		protected $previousText = '&#8656;';

		/**
  	 * Текст для «наступного» елемента керування розбивкою на сторінки.
  	 * @var string
  	 */
		protected $nextText = '&#8658;';

    /**
     * @param int $totalItems загальна кількість елементів, які будуть розбиті на сторінки.
     * @param int $itemsPerPage кількість елементів на одній сторінці.
     * @param int $currentPage номер поточної сторінки.
     * @param string $urlPattern шаблон URL для кожної сторінки, де (:num) є заповнювачем для номера
		 * сторінки. Наприклад, '/foo/page/(:num)'.
     */
    public function __construct($totalItems, $itemsPerPage, $currentPage, $urlPattern = '')
    {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->urlPattern = $urlPattern;

        $this->updateNumPages();
    }

		/**
		 * Оновлює загальну кількість сторінок на основі загальної кількості елементів і елементів
		 * на сторінці.
		 * @return void
		 */
    protected function updateNumPages()
    {
        $this->numPages = ($this->itemsPerPage == 0 ? 0 : (int) ceil($this->totalItems/$this->itemsPerPage));
    }

    /**
		 * Встановлює максимальну кількість сторінок для показу в навігаційній панелі.
		 * @param int $maxPagesToShow Максимальна кількість сторінок для відображення.
		 * @throws \InvalidArgumentException, якщо $maxPagesToShow менше 3.
		 * @return void
		 */
    public function setMaxPagesToShow($maxPagesToShow)
    {
        if ($maxPagesToShow < 3) {
            throw new \InvalidArgumentException('maxPagesToShow cannot be less than 3.');
        }
        $this->maxPagesToShow = $maxPagesToShow;
    }

    /**
		 * Retrieves максимальна кількість сторінок для показу в навігаційній частині.
		 * @return int Максимальна кількість сторінок для відображення.
		 */
    public function getMaxPagesToShow()
    {
        return $this->maxPagesToShow;
    }

    /**
		 * Встановлює номер поточної сторінки.
		 * @param int $currentPage Номер поточної сторінки.
		 * @return void
		 */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
  	 * Встановлює кількість елементів на сторінці та оновлює загальну кількість сторінок.
  	 * @param int $itemsPerPage Кількість елементів на сторінці.
  	 * @return void
  	 */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        $this->updateNumPages();
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
  	 * Встановлює загальну кількість елементів і оновлює загальну кількість сторінок.
  	 * @param int $totalItems Загальна кількість елементів.
  	 * @return void
  	 */
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
        $this->updateNumPages();
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @return int
     */
    public function getNumPages()
    {
        return $this->numPages;
    }

    /**
  	 * Встановлює шаблон URL-адреси для навігації по сторінках.
  	 * @param string $urlPattern Шаблон URL-адреси з (:num) як заповнювач для номера сторінки.
  	 * @return void
  	 */
    public function setUrlPattern($urlPattern)
    {
        $this->urlPattern = $urlPattern;
    }

    /**
     * @return string
     */
    public function getUrlPattern()
    {
        return $this->urlPattern;
    }

    /**
  	 * Створює URL-адресу для певного номера сторінки за допомогою шаблону URL-адреси.
  	 * @param int $pageNum Номер сторінки, для якої потрібно створити URL-адресу.
  	 * @return string URL-адреса для вказаного номера сторінки.
  	 */
    public function getPageUrl($pageNum)
    {
        return str_replace(self::NUM_PLACEHOLDER, $pageNum, $this->urlPattern);
    }

		/**
  	 * Отримує номер наступної сторінки, якщо доступний.
  	 * @return int|null Номер сторінки наступної сторінки або null, якщо поточна сторінка є останньою.
  	 */
    public function getNextPage()
    {
        if ($this->currentPage < $this->numPages) {
            return $this->currentPage + 1;
        }

        return null;
    }

    public function getPrevPage()
    {
        if ($this->currentPage > 1) {
            return $this->currentPage - 1;
        }

        return null;
    }

    public function getNextUrl()
    {
        if (!$this->getNextPage()) {
            return null;
        }

        return $this->getPageUrl($this->getNextPage());
    }

    /**
     * @return string|null
     */
    public function getPrevUrl()
    {
        if (!$this->getPrevPage()) {
            return null;
        }

        return $this->getPageUrl($this->getPrevPage());
    }

    /**
  	 * Отримує масив даних сторінок із розбивкою на сторінки.
  	 * 	Приклад:
  	 * array(
  	 * 		array('num' => 1, 'url' => '/example/page/1', 'isCurrent' => false),
	   * 		array('num' => '...', 'url' => NULL, 'isCurrent' => false),
  	 * 		array('num' => 3, 'url' => '/example/page/3', 'isCurrent' => false),
	   * 		array('num' => 4, 'url' => '/example/page/4', 'isCurrent' => true ),
  	 * 		array('num' => 5, 'url' => '/example/page/5', 'isCurrent' => false),
  	 * 		array('num' => '...', 'url' => NULL, 'isCurrent' => false),
	   * 		array('num' => 10, 'url' => '/example/page/10', 'isCurrent' => false),
  	 * )
  	 * @return array, що містить інформацію про кожну розбиту на сторінки сторінку.
  	 */
    public function getPages()
    {
        $pages = array();

        if ($this->numPages <= 1) {
            return array();
        }

        if ($this->numPages <= $this->maxPagesToShow) {
            for ($i = 1; $i <= $this->numPages; $i++) {
                $pages[] = $this->createPage($i, $i == $this->currentPage);
            }
        } else {

            // Determine the sliding range, centered around the current page.
            $numAdjacents = (int) floor(($this->maxPagesToShow - 3) / 2);

            if ($this->currentPage + $numAdjacents > $this->numPages) {
                $slidingStart = $this->numPages - $this->maxPagesToShow + 2;
            } else {
                $slidingStart = $this->currentPage - $numAdjacents;
            }
            if ($slidingStart < 2) $slidingStart = 2;

            $slidingEnd = $slidingStart + $this->maxPagesToShow - 3;
            if ($slidingEnd >= $this->numPages) $slidingEnd = $this->numPages - 1;

            // Build the list of pages.
            $pages[] = $this->createPage(1, $this->currentPage == 1);
            if ($slidingStart > 2) {
                $pages[] = $this->createPageEllipsis();
            }
            for ($i = $slidingStart; $i <= $slidingEnd; $i++) {
                $pages[] = $this->createPage($i, $i == $this->currentPage);
            }
            if ($slidingEnd < $this->numPages - 1) {
                $pages[] = $this->createPageEllipsis();
            }
            $pages[] = $this->createPage($this->numPages, $this->currentPage == $this->numPages);
        }


        return $pages;
    }


    /**
  	 * Створює структуру даних сторінки.
  	 * @param int $pageNum Номер сторінки.
  	 * @param bool $isCurrent Вказує, чи сторінка є поточною.
  	 * @return array Масив, що містить інформацію про сторінку.
  	 */
    protected function createPage($pageNum, $isCurrent = false)
    {
        return array(
            'num' => $pageNum,
            'url' => $this->getPageUrl($pageNum),
            'isCurrent' => $isCurrent,
        );
    }

    /**
  	 * Створює структуру даних сторінки, що представляє три крапки.
  	 * @return array Масив, що містить інформацію про сторінку з крапками.
		 */
    protected function createPageEllipsis()
    {
        return array(
            'num' => '...',
            'url' => null,
            'isCurrent' => false,
        );
    }

    /**
  	 * Відображає елемент керування розбивкою на сторінки HTML.
  	 * @return string HTML-представлення елемента керування розбивкою на сторінки.
  	 */
    public function toHtml(string $sccClass='menu-pagin', string $id="pagin")
    {
        if ($this->numPages <= 1) {
            return '';
        }

        $html = '<div id="'. $id .'" class="'. $sccClass .'">';
        if ($this->getPrevUrl()) {
            $html .= '<span><a href="' . htmlspecialchars($this->getPrevUrl()) . '">'.$this->previousText .'</a></span>';
        }

        foreach ($this->getPages() as $page) {
            if ($page['url']) {
                $html .= '<span' . ($page['isCurrent'] ? ' class="active"' : '') . '><a href="' . htmlspecialchars($page['url']) . '">' . htmlspecialchars($page['num']) .
								'</a></span>';
            } else {
                $html .= '<span class="disabled"><span>' . htmlspecialchars($page['num']) . '</span></span>';
            }
        }

        if ($this->getNextUrl()) {
            $html .= '<span><a href="' . htmlspecialchars($this->getNextUrl()) . '">'. $this->nextText .'</a></span>';
        }
        $html .= '</div>';

        return $html;
    }

    public function __toString()
    {
        return $this->toHtml();
    }

		/**
  	 * Отримує індекс першого елемента на поточній сторінці.
  	 * @return int|null Індекс першого елемента на поточній сторінці або null, якщо на сторінці
		 * немає елементів.
  	 */
    public function getCurrentPageFirstItem()
    {
        $first = ($this->currentPage - 1) * $this->itemsPerPage + 1;

        if ($first > $this->totalItems) {
            return null;
        }

        return $first;
    }

		/**
  	 * Отримує індекс останнього елемента на поточній сторінці.
	   * @return int|null Індекс останнього елемента на поточній сторінці або null, якщо на сторінці
		 * немає елементів.
  	 */
    public function getCurrentPageLastItem()
    {
        $first = $this->getCurrentPageFirstItem();
        if ($first === null) {
            return null;
        }

        $last = $first + $this->itemsPerPage - 1;
        if ($last > $this->totalItems) {
            return $this->totalItems;
        }

        return $last;
    }

		/**
  	 * Встановлює текст для «попереднього» елемента керування розбивкою на сторінки.
  	 * @param string $text Текст для відображення для «попереднього» елемента керування.
  	 * @return $this
  	 */
    public function setPreviousText($text)
    {
        $this->previousText = $text;
        return $this;
    }

		/**
  	 * Встановлює текст для «наступного» елемента керування розбивкою на сторінки.
  	 * @param string $text Текст для відображення для «наступного» елемента керування.
  	 * @return $this
  	 */
    public function setNextText($text)
    {
        $this->nextText = $text;
        return $this;
    }
}
