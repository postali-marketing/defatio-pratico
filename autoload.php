<?php

	function normalizeDirSeparator ($file)
	{
		return preg_replace("/\\/|\\\\/", DIRECTORY_SEPARATOR, $file);
	}

	define('MAIN_FOLDER', __DIR__);

	//Função de carregamento automático das classes
	function _autoload($class)
	{
		
		$file = MAIN_FOLDER . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . normalizeDirSeparator($class) . '.php';

		if(file_exists($file))
			return require_once($file);
		else
			return false;
	}

	//Auto registrar classes
	spl_autoload_register('_autoload');

	//Definir zona do tempo padrão
	date_default_timezone_set('America/Sao_Paulo');