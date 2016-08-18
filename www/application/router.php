<?php

class Router
{

    public static function route(Request $request)
    {
//        echo "<pre>\n";
        $controller = $request->getController() . 'Controller';
//        echo "\ncontroller: " . $controller;
        $method = $request->getMethod();
//        echo "\nmethod: " . $method;
        $args = $request->getArgs();
//        echo "\n";
//        var_dump($args);

        $controllerFile = SITE_PATH . 'controllers' . DS . $controller . '.php';
//        echo "\ncontrollerFile: " . $controllerFile;
//        echo "</pre>";

        if (is_readable($controllerFile)) {
            require_once $controllerFile;

            $controller = new $controller;
            $method = (is_callable(array($controller, $method))) ? $method : 'index';

            if (!empty($args)) {
                call_user_func_array(array($controller, $method), array(json_encode($args)));
            } else {
                call_user_func(array($controller, $method));
            }
            return;
        }

        throw new Exception('404 - ' . $request->getController() . ' not found');
    }
}
