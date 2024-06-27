<?php

// Головний header сайта.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

e('<!DOCTYPE html>');
e('<html lang="uk">');
	e('<head>');
		e('<script src="'. url('/') .'/js/functions.js"></script>');
		e('<meta charset="UTF-8">');
		e('<meta name="viewport" content="width=device-width, initial-scale=1">');
		e('<link rel="stylesheet" type="text/css" href="'. url('/css') .'/bootstrap.css">');
		e('<link rel="stylesheet" type="text/css" href="'. url('/css') .'/'. MainCssName .'.css">');

		if (URIModule) {
			// Підключення css поточного модуля.
			e('<link rel="stylesheet" type="text/css" href="'. url('/css') .'/'. URIModule .'.css">');
		}

		e("<title>". SiteName ." - {$d['title']}</title>");
	e('</head>');
	e('<body>');
		e('<div id="notification" class="notification"></div>');
		e('<h1>'. SiteName .'</h1>');
		e('<h2>'. $d['title'] .'</h2>');
