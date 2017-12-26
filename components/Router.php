<?php
/**
 * Created by PhpStorm.
 * User: jart
 * Date: 14.12.17
 * Time: 0:16
 */

namespace components;


class Router
{
    private $routes;

    public function __construct()
    {
        $rout = ROOT . '/config/routes.php';
        $this->routes = include($rout);
    }


    //         Получаем строку запроса

    /**
     * @return string
     */

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {

            return $uri = trim($_SERVER['REQUEST_URI'], '/');

        }

    }


    public function run()
    {

        $uri = $this->getUri();
//        echo $uri;

        // Разбираем строку запроса,  и проверяем на наличие его в routes.php

        foreach ($this->routes as $request => $path) {

            if (preg_match("~$request~", $uri)) {
                $routesPath = explode('/',$path);

                $controllerName = array_shift($routesPath) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($routesPath));

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)){
                    include ($controllerFile);
//                    debug($controllerFile);die;

                }


                $controllers = new $controllerName;
                $controllers->$actionName();
            }

        }


    }

}