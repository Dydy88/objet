<?php

namespace Library;

/**
 * Cette classe abstraite représente une entité d'un modèle de données.
 * Elle fournit des fonctionnalités communes à toutes les entités de l'application, 
 * telles que l'hydratation, l'accès aux attributs et la gestion des erreurs.
 *
 * Elle implémente l'interface `\ArrayAccess` pour permettre l'accès aux attributs comme à un tableau.
 */
//abstract class Entity implements \ArrayAccess

abstract class Entity
{
	/**
	 * @var array $erreurs Un tableau contenant les erreurs de validation de l'entité.
	 */
	protected $erreurs = [];

	/**
	 * @var mixed $id L'identifiant unique de l'entité.
	 */
	protected $id;

	/**
	 * Constructeur de l'entité.
	 *
	 * @param array $donnees Un tableau associatif contenant les données à hydrater.
	 */
	public function __construct(array $donnees = [])
	{
		if (!empty($donnees)) {
			$this->hydrate($donnees);
		}
	}

	/**
	 * Hydrate l'entité à partir d'un tableau de données.
	 *
	 * Cette méthode parcourt le tableau de données et tente d'appeler un setter correspondant à chaque clé du tableau.
	 * Le setter est appelé avec la valeur associée à la clé. Par exemple, si le tableau contient une clé "nom", la méthode
	 * attend une méthode `setNom` qui sera appelée avec la valeur de la clé "nom".
	 *
	 * @param array $donnees Un tableau associatif contenant les données à hydrater.
	 */
	public function hydrate(array $donnees)
	{
		foreach ($donnees as $attribut => $valeur) {
			$methode = 'set' . ucfirst($attribut);

			if (is_callable(array($this, $methode))) {
				$this->$methode($valeur);
			}
		}
	}

	/**
	 * Indique si l'entité est nouvelle (ne possède pas encore d'identifiant).
	 *
	 * @return bool Vrai si l'entité n'a pas d'identifiant, Faux sinon.
	 */
	public function isNew(): bool
	{
		return empty($this->id);
	}

	/**
	 * Renvoie le tableau des erreurs de validation de l'entité.
	 *
	 * @return array Un tableau contenant les messages d'erreur.
	 */
	public function erreurs(): array
	{
		return $this->erreurs;
	}

	/**
	 * Getters Renvoie l'identifiant unique de l'entité.
	 *
	 * @return int L'identifiant de l'entité.
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * Setters Définit l'identifiant de l'entité.
	 *
	 * @param int $id L'identifiant de l'entité.
	 */
	public function setId(int $id)
	{
		$this->id = (int) $id;
	}

	/**
	 * Permet d'accéder aux attributs de l'entité comme à un élément de tableau.
	 *
	 * @param string $var Le nom de l'attribut à récupérer.
	 * @return mixed La valeur de l'attribut, ou null si l'attribut n'existe pas ou si le getter correspondant n'est pas défini.
	 * @throws \Exception Si la tentative de modification d'un attribut échoue.
	 */
	public function offsetGet($var)
	{
		if (isset($this->$var) && is_callable(array($this, $var))) {
			return $this->$var();
		}

		return null;
	}

	/**	
	 * Tentative de définition d'un attribut de l'entité via un offset.
	 * Cette méthode ne permet pas réellement la modification des attributs, 
	 * elle essaye d'appeler le setter correspondant à l'attribut si celui-ci existe.
	 *
	 * @param string $var Le nom de l'attribut à définir.
	 * @param mixed $value La valeur à attribuer.
	 * @throws \Exception Si la tentative de modification d'un attribut échoue.
	 */
	public function offsetSet($var, $value)
	{
		$method = 'set' . ucfirst($var);

		if (isset($this->$var) && is_callable(array($this, $method))) {
			$this->$method($value);
		} else {
			throw new \Exception('Impossible de définir une valeur pour l\'attribut "' . $var . '"');
		}
	}

	/**	
	 * Vérifie si un attribut de l'entité existe et si un getter correspondant est défini.
	 *
	 * @param string $var Le nom de l'attribut à tester.
	 * @return bool Vrai si l'attribut existe et qu'un getter correspondant est défini, Faux sinon.
	 */
	public function offsetExists($var)
	{
		return isset($this->$var) && is_callable(array($this, $var));
	}

	/**
	 * Lève une exception car la modification d'attributs via cette méthode n'est pas autorisée.
	 *
	 * @param string $var Le nom de l'attribut à supprimer.
	 * @throws \Exception L'exception est toujours levée car la suppression d'attribut n'est pas supportée.
	 */
	public function offsetUnset($var)
	{
		throw new \Exception('Impossible de supprimer une quelconque valeur');
	}
}
