<?php

// Загрузка классов "на лету"
function __autoload($className)
{
    // определяем класс и находим для него путь
    preg_match_all('/((?:^|[A-Z])[a-z]+)/', $className, $matches);
    $expArr = $matches[0];
    $expArr[0] = strtolower($expArr[0]);
    $filename = implode($expArr) . '.php';

    $folder = 'application';
    if (!empty($expArr[0] && $expArr[0] == 'base')) {
    } else if (!empty($expArr[1])) {
        switch (strtolower($expArr[1])) {
            case 'controller':
                $folder = 'controllers';
                break;

            case 'model':
                $folder = 'models';
                break;

            default:
                $folder = 'application';
                break;
        }
    }
    // путь до класса
    $file = SITE_PATH . $folder . DS . $filename;
    // проверяем наличие файла
    if (file_exists($file) == false) {
        return false;
    }
    // подключаем файл с классом
    include($file);
}

try {
    Router::route(new Request);
} catch (Exception $e) {
    $controller = new errorController;
    $controller->error($e->getMessage());
}
