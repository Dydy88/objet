<?php

namespace Library;

/**
 * Cette classe représente une page de l'application.
 * Elle permet de gérer le contenu de la page et son affichage.
 */
class Page extends ApplicationComponent
{
	/**
	 * @var string Le chemin vers le fichier de contenu de la page.
	 */
	protected $contentFile;

	/**
	 * @var array Un tableau associatif contenant les variables à transmettre à la vue.
	 */
	protected $vars = array();

	/**
	 * Ajoute une variable à transmettre à la vue.
	 *
	 * @param string $var Le nom de la variable.
	 * @param mixed $value La valeur de la variable.
	 * @throws \InvalidArgumentException Si le nom de la variable n'est pas une chaîne de caractères non nulle.
	 */
	public function addVar($var, $value)
	{
		if (!is_string($var) || is_numeric($var) || empty($var)) {
			throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractère non nulle');
		}

		$this->vars[$var] = $value;
	}

	/**
	 * Génère le contenu complet de la page.
	 *
	 * Cette méthode charge d'abord le fichier de contenu de la page spécifié par `$this->contentFile`.
	 * Ensuite, elle utilise la fonction `extract` pour rendre les variables de `$this->vars` accessibles localement
	 * dans le fichier de contenu. Le contenu de la page est stocké dans une variable temporaire.
	 *
	 * Finalement, la méthode charge le gabarit principal (`layout.php`) situé dans le répertoire `Templates` de l'application
	 * et y injecte le contenu de la page. Le contenu final est retourné.
	 *
	 * @return string Le contenu HTML complet de la page.
	 * @throws \RuntimeException Si le fichier de contenu de la page n'existe pas.
	 */
	public function getGeneratedPage()
	{
		if (!file_exists($this->contentFile)) {
			throw new \RuntimeException('La vue spécifiée n\'existe pas');
		}

		extract($this->vars);

		ob_start();
		require $this->contentFile;
		$content = ob_get_clean();

		ob_start();
		require __DIR__ . '/../Applications/' . $this->app->name() . '/Templates/layout.php';
		return ob_get_clean();
	}

	/**
	 * Définit le chemin vers le fichier de contenu de la page.
	 *
	 * @param string $contentFile Le chemin vers le fichier de contenu.
	 * @throws \InvalidArgumentException Si le chemin vers le fichier de contenu est invalide.
	 */
	public function setContentFile($contentFile)
	{
		if (!is_string($contentFile) || empty($contentFile)) {
			throw new \InvalidArgumentException('La vue spécifiée est invalide');
		}

		$this->contentFile = $contentFile;
	}
}
