<?php

namespace Library;

/**
 * Cette classe représente une route dans une application. Une route associe une URL à un module et une action spécifique.
 * Elle peut également contenir des variables dynamiques dans l'URL.
 */
class Route
{
	/**
	 * @var string L'action associée à la route.
	 */
	protected $action;

	/**
	 * @var string Le module associé à la route.
	 */
	protected $module;

	/**
	 * @var string Le motif de l'URL pour cette route (expression régulière).
	 */
	protected $url;

	/**
	 * @var string[] Un tableau contenant les noms des variables dynamiques dans l'URL.
	 */
	protected $varsNames;

	/**
	 * @var array Un tableau contenant les valeurs des variables dynamiques extraites de l'URL (vide par défaut).
	 */
	protected $vars = [];

	/**
	 * Route constructor.
	 *
	 * @param string $url Le motif de l'URL pour la route (expression régulière).
	 * @param string $module Le module associé à la route.
	 * @param string $action L'action associée à la route.
	 * @param string[] $varsNames Un tableau contenant les noms des variables dynamiques dans l'URL (facultatif).
	 * @throws \InvalidArgumentException Si l'URL, le module ou l'action n'est pas une chaîne de caractères.
	 */
	public function __construct($url, $module, $action, array $varsNames = [])
	{
		$this->setUrl($url);
		$this->setModule($module);
		$this->setAction($action);
		$this->setVarsNames($varsNames);
	}

	/**
	 * Vérifie si la route contient des variables dynamiques.
	 *
	 * @return bool True si la route contient des variables dynamiques, False sinon.
	 */
	public function hasVars()
	{
		return !empty($this->varsNames);
	}

	/**
	 * Essaie d'associer l'URL fournie à la route.
	 *
	 * @param string $url L'URL à associer.
	 * @return array|false Un tableau contenant les correspondances des variables dynamiques si l'URL correspond à la route, False sinon.
	 */
	public function match($url)
	{
		if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
			return $matches;
		} else {
			return false;
		}
	}

	/**
	 * Setter de la route.
	 *
	 * @param string $action L'action associée à la route.
	 * @throws \InvalidArgumentException Si l'action n'est pas une chaîne de caractères.
	 */
	public function setAction($action)
	{
		if (is_string($action)) {
			$this->action = $action;
		} else {
			throw new \InvalidArgumentException('L\'action doit être une chaîne de caractères');
		}
	}

	/**
	 * Setter du module associé à la route.
	 *
	 * @param string $module Le module associé à la route.
	 * @throws \InvalidArgumentException Si le module n'est pas une chaîne de caractères.
	 */
	public function setModule($module)
	{
		if (is_string($module)) {
			$this->module = $module;
		} else {
			throw new \InvalidArgumentException('Le module doit être une chaîne de caractères');
		}
	}

	/**
	 * Setter de l'URL
	 *
	 * @param string $url Le motif de l'URL pour la route (expression régulière).
	 * @throws \InvalidArgumentException Si l'URL n'est pas une chaîne de caractères.
	 */
	public function setUrl($url)
	{
		if (is_string($url)) {
			$this->url = $url;
		} else {
			throw new \InvalidArgumentException('L\'URL doit être une chaîne de caractères');
		}
	}


	/**
	 * Setter des variables dynamiques dans l'URL.
	 *
	 * @param string[] $varsNames Un tableau contenant les noms des variables.
	 * @throws \InvalidArgumentException Si les noms des variables ne sont pas des chaînes de caractères.
	 */
	public function setVarsNames(array $varsNames)
	{
		$this->varsNames = $varsNames;
	}

	/**
	 * Setters des variables dynamiques extraites de l'URL.
	 *
	 * @param array $vars Un tableau contenant les valeurs des variables.
	 */
	public function setVars(array $vars)
	{
		$this->vars = $vars;
	}

	/**
	 * Getters Renvoie l'action associée à la route.
	 *
	 * @return string L'action associée à la route.
	 */
	public function action()
	{
		return $this->action;
	}

	/**
	 * Getters Renvoie le module associé à la route.
	 *
	 * @return string Le module associé à la route.
	 */
	public function module()
	{
		return $this->module;
	}

	/**
	 * Getters Renvoie les valeurs des variables dynamiques extraites de l'URL.
	 *
	 * @return array Un tableau contenant les valeurs des variables dynamiques.
	 */
	public function vars()
	{
		return $this->vars;
	}

	/**
	 * Getters Renvoie les noms des variables dynamiques présentes dans l'URL.
	 *
	 * @return string[] Un tableau contenant les noms des variables dynamiques.
	 */
	public function varsNames()
	{
		return $this->varsNames;
	}
}
