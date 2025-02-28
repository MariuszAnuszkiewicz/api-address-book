<?php

declare(strict_types=1);

class App {

    const CONTROLLER_SUFFIX = 'Controller';
    protected static $router;
    public static $db;

    public static function getRouter()
    {
        return self::$router;
    }

    public static function run(string $uri)
    {
        self::$router = new Router($uri);
        self::$router->initRoute();
        Config::initEnv();
        self::$db = new DB(getenv('DATABASE_HOST'), getenv('DATABASE_NAME'));

        try {
            if ('' !== self::$router->getController()) {
                $controllerClass = ucfirst(self::$router->getController()) . self::CONTROLLER_SUFFIX;
                $controllerMethod = lcfirst(self::$router->getAction());
                if (class_exists($controllerClass)) {
                    $controllerObject = new $controllerClass();
                    if (is_object($controllerObject)) {
                        $controllerObject?->$controllerMethod();
                    }
                }
            } else {
                throw new Exception('Controller not exist. Address url is too short, should be have controller name. ');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
