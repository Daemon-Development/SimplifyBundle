<?php

namespace Daemon\SimplifyBundle\Component;

use Daemon\SimplifyBundle\Component\Enum\HTTP;

class RouterContext
{

    public static $INDEX;
    public static $CREATE;
    public static $SHOW;
    public static $UPDATE;
    public static $DELETE;


    /**
     * Sets the view context with the default values or the one configured inside the config.yml
     *
     * @param array $viewContext
     */
    public static function setContext(array $viewContext)
    {
        foreach ($viewContext as $key => $value) {
            switch ($key) {
                case "INDEX": {
                    self::$INDEX = $value;
                    break;
                }
                case "CREATE": {
                    self::$CREATE = $value;
                    break;
                }
                case "SHOW": {
                    self::$UPDATE = $value;
                    break;
                }
                case "DELETE": {
                    self::$DELETE = $value;
                    break;
                }
            }
        }
    }


    /**
     * Guesses the view context by the name of the route
     *
     * @param string $route
     * @return string
     */
    public static function guessViewContextByRoute($route)
    {
        switch ($route) {
            case (strpos($route, self::$INDEX) !== false): {
                return self::$INDEX;
            }
            case (strpos($route, self::$CREATE) !== false): {
                return self::$CREATE;
            }
            case (strpos($route, self::$SHOW) !== false): {
                return self::$SHOW;
            }
            case (strpos($route, self::$UPDATE) !== false): {
                return self::$UPDATE;
            }
            case (strpos($route, self::$DELETE) !== false): {
                return self::$DELETE;
            }
        }
        return false;
    }

    /**
     * Guesses the HTTP request method by the name of the route
     *
     * @param $route
     * @return bool|string
     */
    public static function guessMethodByRoute($route)
    {
        switch ($route) {
            case (strpos($route, self::$INDEX) !== false): {
                return HTTP::GET;
            }
            case (strpos($route, self::$CREATE) !== false): {
                return HTTP::POST;
            }
            case (strpos($route, self::$SHOW) !== false): {
                return HTTP::GET;
            }
            case (strpos($route, self::$UPDATE) !== false): {
                return HTTP::PUT;
            }
            case (strpos($route, self::$DELETE) !== false): {
                return HTTP::DELETE;
            }
        }
        return false;
    }
}