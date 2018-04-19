<?php
namespace Epoque\Chameleon;

/**
 * Router
 * 
 * @author jason favrod <jason@lakonacomputers.com>
 */


interface RouterInterface
{
    /**
     * addRoute
     *
     * Adds a route to the routes array.
     *
     * @param $route assoc_array Key is request, value is what it's
     * routed to.
     * @return boolean True if added to routes array, false otherwise.
     */

    public function addRoute($route=[]);

    
    /**
     * fetchRoute
     * 
     * Grabs the requested route from the routes array
     * using Common::URI method.
     * 
     */

    public function fetchRoute();
}
