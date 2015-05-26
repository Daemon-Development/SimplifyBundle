<?php

namespace Daemon\SimplifyBundle\Component;

class RouterContext {

    public static $INDEX;
    public static $CREATE;
    public static $SHOW;
    public static $UPDATE;
    public static $DELETE;


    public static function setContext(array $viewContext) {
        foreach ($viewContext as $key => $value) {
            switch($key) {
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
     * The name of the route will be matched against the defined ViewTypes
     *
     * @param string $route
     * @return string
     */
    public static function getViewTypeByRoute($route) {
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
}