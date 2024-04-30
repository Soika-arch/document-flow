<?php

// Вид сторінки page-not-found.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (isset($d['errors'])) require $this->getViewFile('/inc/errors');

require $this->getViewFile('/inc/footer');
