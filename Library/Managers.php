<?php

namespace Library;

class Managers
{
	/**
	 * @var mixed L'instance d'API utilisée par les managers.
	 */
	protected $api;

	/**
	 * @var DB L'instance de DB utilisée par les managers.
	 */
	protected $db;

	/**
	 * @var Manager[] Un tableau contenant les instances de managers déjà chargées, indexées par le nom du module.
	 */
	protected $managers = [];

	/**
	 * Constructeur de la classe Managers.
	 *
	 * @param mixed $api L'instance d'API (DSN) utilisée par les managers.
	 * @param DB $dbL'instance de DB utilisée par les managers.
	 * @throws \InvalidArgumentException Si l'API ou le DB n'est pas défini.
	 */
	public function __construct($api, $db)
	{
		if (is_null($api) || is_null($db)) {
			throw new \InvalidArgumentException('L\'API et la DB doivent être définis');
		}

		$this->api = $api;
		$this->$db = $db;
	}

	/**
	 * Récupère le manager associé à un module spécifique.
	 *
	 * Cette méthode charge dynamiquement le manager si il n'existe pas déjà. Le nom de la classe du manager est construit
	 * en concaténant `\Library\Models\\` suivi du nom du module, `Manager_`, et le type d'API utilisé.
	 *
	 * @param string $module Le nom du module pour lequel récupérer le manager.
	 * @return Manager L'instance du manager associé au module.
	 * @throws \InvalidArgumentException Si le nom du module est invalide.
	 */
	public function getManagerOf($module)
	{
		if (!is_string($module) || empty($module)) {
			throw new \InvalidArgumentException('Le module spécifié est invalide');
		}

		if (!isset($this->managers[$module])) {
			$managerClass = '\\Library\\Models\\' . $module . 'Manager_' . $this->api;
			$this->managers[$module] = new $managerClass($this->db);
		}

		return $this->managers[$module];
	}
}
