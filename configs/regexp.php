<?php

// Стандартні регулярні вирази.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

return [
	'date' => '\d{4}-\d\d-\d\d',
	'dateTime' => '\d{4}-\d\d-\d\d \d\d:\d\d:\d\d',
	'freeTextClass' => '[ \',.;:!@#$%&()\[\]{}=№a-zA-Zа-яА-ЯїЇіІєЄґҐеЕсСШшьЬтТрРуУщЩюЮхХ\d-]',
	'standartURI' => '^[a-zA-Z0-9\-._~!$&\'()*+,;=:@\/]+(?:\?[a-zA-Z0-9\-._~!$&\'()*+,;=:@\/?=]*)?$'
];
