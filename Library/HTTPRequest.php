<?php

namespace Library;

/**
 * Gère la Request transmis par le Client
 */

class HTTPRequest
{
	/**
	 * Récupère la valeur d'un Cookies
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function cookieData($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
	}

	/**
	 * Vérifie l'existance d'un Cookies
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function cookieExists($key)
	{
		return isset($_COOKIE[$key]);
	}

	/**
	 * Récupèrer un paramètre de $_GET
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function getData($key)
	{
		return isset($_GET[$key]) ? $_GET[$key] : null;
	}

	/**
	 * Vérifie si un paramètre existe dans $_GET
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function getExists($key)
	{
		return isset($_GET[$key]);
	}

	/**
	 * Retourne la méthode HTTP utilisé
	 *
	 * @return void
	 */
	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Récupèrer un paramètre de $_POST
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function postData($key)
	{
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}

	/**
	 * Vérifie si un paramètre existe dans $_POST
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function postExists($key)
	{
		return isset($_POST[$key]);
	}

	/**
	 * Recupèrer l'URL envoyer par le Client (Navigateur)
	 *
	 * @return void
	 */
	public function requestURI()
	{
		return $_SERVER['REQUEST_URI'];
	}
}
