<?php

namespace Library;

/**
 * Cette classe abstraite représente un contrôleur principal (back-controller) dans une application.
 * Elle sert de base pour les contrôleurs de modules spécifiques et définit un comportement commun.
 */
abstract class BackController extends ApplicationComponent
{
	/**
	 * @var string L'action associée au contrôleur.
	 */
	protected $action = '';

	/**
	 * @var string Le module associé au contrôleur.
	 */
	protected $module = '';

	/**
	 * @var Page Un objet de type Page représentant la page courante.
	 */
	protected $page = null;

	/**
	 * @var string La vue associée à l'action du contrôleur.
	 */
	protected $view = '';

	/**
	 * @var Managers Un objet de type Managers.
	 */
	protected $managers = null;


	/**
	 * Constructeur du contrôleur principal.
	 *
	 * @param Application $app L'instance de l'application.
	 * @param string $module Le module associé au contrôleur.
	 * @param string $action L'action associée au contrôleur.
	 * @throws \InvalidArgumentException Si le module ou l'action n'est pas une chaîne de caractères valide.
	 */
	public function __construct(Application $app, $module, $action)
	{
		parent::__construct($app);

		$this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
		$this->page = new Page($app);

		$this->setModule($module);
		$this->setAction($action);
		$this->setView($action);
	}

	/**
	 * Exécute l'action associée au contrôleur.
	 *
	 * La méthode attend une méthode nommée `execute` suivie du premier caractère de l'action en majuscule 
	 * (par exemple, `executeIndex` pour l'action `index`). Si la méthode n'existe pas, une exception est levée.
	 *
	 * @param HTTPRequest $request La requête HTTP associée à la page.
	 * @throws \RuntimeException Si l'action n'est pas définie sur le module.
	 */
	public function execute(HTTPRequest $request)
	{
		$method = 'execute' . ucfirst($this->action);

		if (!is_callable(array($this, $method))) {
			throw new \RuntimeException('L\'action "' . $this->action . '" n\'est pas définie sur ce module');
		}

		$this->$method($request);
	}

	/**
	 * Renvoie l'objet Page associé au contrôleur.
	 *
	 * @return Page L'objet Page représentant la page courante.
	 */
	public function page()
	{
		return $this->page;
	}

	/**
	 * Définit le module associé au contrôleur.
	 *
	 * @param string $module Le nom du module.
	 * @throws \InvalidArgumentException Si le module n'est pas une chaîne de caractères valide.
	 */
	public function setModule($module)
	{
		if (!is_string($module) || empty($module)) {
			throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
		}

		$this->module = $module;
	}

	/**
	 * Définit l'action associée au contrôleur.
	 *
	 * @param string $action Le nom de l'action.
	 * @throws \InvalidArgumentException Si l'action n'est pas une chaîne de caractères valide.
	 */
	public function setAction($action)
	{
		if (!is_string($action) || empty($action)) {
			throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
		}

		$this->action = $action;
	}

	/**
	 * Définit la vue associée à l'action du contrôleur.
	 *
	 * @param string $view Le nom de la vue.
	 * @throws \InvalidArgumentException Si la vue n'est pas une chaîne de caractères valide.
	 */
	public function setView($view)
	{
		if (!is_string($view) || empty($view)) {
			throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
		}

		$this->view = $view;
		
		$this->page->setContentFile(__DIR__ . '/../Applications/' . $this->app->name() . '/Modules/' . $this->module . '/Views/' . $this->view . '.php');
	}
}
