<?php

class ClassLoader {

    public static $classMap;
    public static $addMap = array();

    public static function autoload($className){

        // include and save cart map
        self::$classMap = array_merge(require(__DIR__ . '/classes.php'), self::$addMap);

        // search in cart map
        if (isset(self::$classMap[$className])) {
            $filename = self::$classMap[$className];
            include_once $_SERVER['DOCUMENT_ROOT'] . $filename;
        }

        // check is classes, traits, interfaces exist
        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new Exception('Невозможно найти класс '.$className);
        }
    }


}