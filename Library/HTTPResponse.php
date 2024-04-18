<?php

namespace Library;

/**
 * Gère la réponse HTTP du Serveur
 */

class HTTPResponse extends ApplicationComponent
{
	/**
	 * La page à renvoyer au client
	 *
	 * @var Page $page
	 */
	protected $page;

	/**
	 * Ajoute un Header à la réponse HTTP
	 *
	 * @param string $header
	 * @return void
	 */
	public function addHeader($header)
	{
		header($header);
	}

	/**
	 * EFfectuer une redirection HTTP
	 *
	 * @param [type] $location
	 * @return void
	 */
	public function redirect($location)
	{
		header('Location: ' . $location);
		exit;
	}

	/**
	 * EFfectuer une redirection 404
	 *
	 * @return void
	 */
	public function redirect404()
	{
		$this->page = new Page($this->app);
		$this->page->setContentFile(__DIR__.'/../Errors/404.html');
		
		$this->addHeader('HTTP/1.0 404 Not Found');
		
		$this->send();
	}

	/**
	 * Envoie la page au Client
	 *
	 * @return void
	 */
	public function send()
	{
		// Actuellement, cette ligne a peu de sens dans votre esprit.
		// Promis,  vous saurez vraiment ce qu'elle fait d'ici la fin du chapitre
		// (bien que je suis sûr que les noms choisis sont assez explicites !).
		exit($this->page->getGeneratedPage());
	}

	/**
	 * Setters de l'objet Page
	 *
	 * @param Page $page Objet
	 */
	public function setPage(Page $page)
	{
		$this->page = $page;
	}


	/**
	 * Créer un Cookies 
	 *
	 * @param [type] $name
	 * @param string $value
	 * @param integer $expire
	 * @param [type] $path
	 * @param [type] $domain
	 * @param boolean $secure
	 * @param boolean $httpOnly
	 * @return void
	 */
	public function setCookie(
		$name, 
		$value = '', 
		$expire = 0, 
		$path = null, 
		$domain = null, 
		$secure = false, 
		$httpOnly = true
		)
	{
		setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
	}
}
