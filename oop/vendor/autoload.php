<?php

class ClassLoader {

    public static $classMap;
    public static $addMap = array();

    public static function autoload($className){

        //подключаем и сохраняем карту классов. Добавляем пользовательские классы.
        self::$classMap = array_merge(require(__DIR__ . '/classes.php'), self::$addMap);

        //Ищем в карте классов
        if (isset(self::$classMap[$className])) {
            $filename = self::$classMap[$className];
            include_once $_SERVER['DOCUMENT_ROOT'] . $filename;
        }

        //Проверка был ли объявлен класс
        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new Exception('Невозможно найти класс '.$className);
        }
    }


}