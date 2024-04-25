<?php

// Головний header сайта.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

e('<!DOCTYPE html>');
e('<html lang="ua">');
	e('<head>');
		e('<meta http-equiv="Content-Type" content="text/html" charset="utf-8" >');
		e('<meta name="viewport" content="width=device-width, initial-scale=1">');
		e('<link rel="stylesheet" type="text/css" href="'. url('/') .'css/'. MainCssName .'.css">');
		e("<title>". SiteName ." - {$d['title']}</title>");
	e('</head>');
	e('<body>');
		e('<h1>'. SiteName .'</h1>');
		e('<h2>'. $d['title'] .'</h2>');
