<?php

namespace Library;

/**
 * Cette classe représente un routeur pour une application. Elle est responsable 
 * d'associer des URLs à des routes et de fournir l'objet de route correspondant.
 */

class Router
{
    /**
     * @var Route[] Un tableau des routes enregistrées.
     */
    protected $routes = [];

    /**
     * Constante pour le code d'exception "aucune route trouvée".
     */
    const NO_ROUTE = 1;


    /**
     * Ajoute une route au routeur.
     *
     * @param Route $route La route à ajouter.
     * @throws \InvalidArgumentException Si la route est déjà enregistrée.
     */
    public function addRoute(Route $route)
    {
        if (in_array($route, $this->routes)) {
            throw new \InvalidArgumentException('Route déjà enregistrée');
        }

        $this->routes[] = $route;
    }

    /**
     * Récupère la route pour une URL donnée.
     *
     * @param string $url L'URL à associer.
     * @return Route|null L'objet de route qui correspond à l'URL, ou null si aucune route ne correspond.
     * @throws \RuntimeException Si aucune route ne correspond à l'URL.
     */
    public function getRoute($url)
    {
        foreach ($this->routes as $route) {
            // Si la route correspond à l'URL.
            if (($varsValues = $route->match($url)) !== false) {
                // Si elle a des variables.
                if ($route->hasVars()) {
                    $varsNames = $route->varsNames();
                    $listVars = [];

                    // Crée un nouveau tableau clé/valeur.
                    foreach ($varsValues as $key => $match) {
                        // La première valeur contient entièrement la chaîne capturée
                        if ($key !== 0) {
                            $listVars[$varsNames[$key - 1]] = $match;
                        }
                    }

                    // Assigne ce tableau de variables à la route.
                    $route->setVars($listVars);
                }

                return $route;
            }
        }

        throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }
}
