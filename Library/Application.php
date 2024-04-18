<?php

namespace Library;

use Library\Router;
use Library\Route;

/**
 * Ceci est une classe abstraite qui définit la structure de base d'une application.
 * Les sous-classes doivent étendre cette classe et implémenter la méthode `run()`.
 */

abstract class Application
{

	/**
	 * @var HTTPRequest L'objet de requête HTTP utilisé par l'application.
	 */
	protected $httpRequest;

	/**
	 * @var HTTPResponse L'objet de réponse HTTP utilisé par l'application.
	 */
	protected $httpResponse;

	/**
	 * @var string $name Le nom de l'application.
	 */
	protected $name;

	/**
	 * Constructeur de l'application.
	 *
	 * Initialise l'application avec des objets de requête et de réponse HTTP,
	 * et définit le nom sur une chaîne vide.
	 */
	public function __construct()
	{
		$this->httpRequest = new HTTPRequest();
		$this->httpResponse = new HTTPResponse($this);
		$this->name = '';
	}

	/**
	 * Méthode chargée de récupèrer le Controlleur associé à l'URL
	 *
	 * @return void
	 */
	public function getController()
	{
		$router = new Router;
		$xml = new \DOMDocument;
		$xml->load(__DIR__ . '/../Applications/' . $this->name . '/Config/routes.xml');
		$routes = $xml->getElementsByTagName('route');

		// On parcourt les routes du fichier XML.
		foreach ($routes as $route) {
			$vars = [];

			// On regarde si des variables sont présentes dans l'URL.
			if ($route->hasAttribute('vars')) {
				$vars = explode(',', $route->getAttribute('vars'));
			}

			// On ajoute la route au routeur.
			$router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
		}

		try {
			// On récupère la route correspondante à l'URL.
			$matchedRoute = $router->getRoute($this->httpRequest->requestURI());
		} catch (\RuntimeException $e) {
			if ($e->getCode() == Router::NO_ROUTE) {
				// Si aucune route ne correspond, c'est que la page demandée n'existe pas.
				$this->httpResponse->redirect404();
			}
		}

		// On ajoute les variables de l'URL au tableau $_GET.
		$_GET = array_merge($_GET, $matchedRoute->vars());

		// On instancie le contrôleur.
		$controllerClass = 'Applications\\' . $this->name . '\\Modules\\' . $matchedRoute->module() . '\\' . $matchedRoute->module() . 'Controller';
		return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
	}


	/**
	 * Méthode abstraite qui définit la logique principale de l'application.
	 *
	 * Les sous-classes doivent implémenter cette méthode pour définir le comportement spécifique de l'application.
	 *
	 * @return void
	 */
	abstract public function run();


	/**
	 * Retourne l'objet de requête HTTP.
	 *
	 * @return HTTPRequest L'objet de requête HTTP utilisé par l'application.
	 */
	public function httpRequest()
	{
		return $this->httpRequest;
	}

	/**
	 * Retourne l'objet de réponse HTTP.
	 *
	 * @return HTTPResponse L'objet de réponse HTTP utilisé par l'application.
	 */
	public function httpResponse()
	{
		return $this->httpResponse;
	}

	/**
	 *  Retourne le nom de l'application.
	 *
	 * @return string Le nom de l'application.
	 */
	public function name()
	{
		return $this->name;
	}
}
