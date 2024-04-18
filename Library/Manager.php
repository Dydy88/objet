<?php

namespace Library;

/**
 * Interface pour les Managers
 */
abstract class Manager
{
	protected $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
}
