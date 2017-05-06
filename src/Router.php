<?php
namespace Epoque\Chameleon;

/**
 * Router
 *
 * @author jason favrod <jason@epoquecorporation.com>
 */

abstract class Router extends Common
{
    protected static $routes = [];


    /**
     * isRoute
     *
     * Checks if a given route (assoc_array) is in the routes array.
     *
     * @param assoc_array $route A route to check.
     * @return boolean True if in array, false otherwise.
     */

    public static function isRoute($route=[])
    {
        $r = FALSE;
        $request  = trim(key($route), '/');
        $resource = current($route);

        foreach (self::$routes as $req => $res) {
            if ($request === $req && $resource === $res) {
                $r = TRUE;
            }
        }

        return $r;
    }


    /**
     * addRoute
     *
     * Adds a route to the routes array.
     *
     * @param $route assoc_array Key is request, value is what
     * the resource routed to.
     * @return boolean True if route added to routes array.
     */

    public static function addRoute($route=[])
    {
        $result = FALSE;

        if (is_array($route) && !empty($route)) {
            if (is_string(key($route)) && is_string(current($route))) {
                $request  = trim(key($route), '/');
                $resource = current($route);

                if (!self::isRoute($route)) {
                    self::$routes[$request] = $resource;
                    $result = TRUE;
                }
                else {
                    self::logError(__METHOD__ . ": route [$request => $resource] already exists.");
                }
            }
            else {
                self::logError(__METHOD__ . ': route argument is malformed.');
            }
        }
        else {
            self::logError(__METHOD__ . ': route argument is not an array, or is empty.');
        }

        return $result;
    }


    /**
     * fetchRequested
     *
     * Include file if URI is a key in routes array.
     *
     * @return mixed True if route included, null if fetchView is
     * called.
     */

    public static function fetchRequested()
    {
        $request = parent::URI();

        if (array_key_exists($request, self::$routes)) {
            return self::$routes[$request];
        }
    }
}
