<?php

namespace Library;

/**
 * Permet de stocker pendant la construction de l'objet, 
 * l'instance de l'application exécutée.
 */
abstract class ApplicationComponent
{
	/**
	 * @var Application L'instance de l'application associée à ce composant.
	 */
	protected $app;


	/**
	 * Constructeur de ApplicationComponent.
	 * Prend une instance d'Application` en argument et l'attribue à la propriété `$app`.
	 *
	 * @param Application $app L'instance de l'application associée à ce composant.
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}


	/**
	 * Getters pour l'instance de l'application.
	 *
	 * @return Application L'instance de l'application associée à ce composant.
	 */
	public function app()
	{
		return $this->app;
	}
}
