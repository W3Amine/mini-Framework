<?php


namespace src\config;

class config {


public static $configResult;
    public static function get($configFile){
if(file_exists(__DIR__ . '/../../config/' . $configFile . '.php')){
    $configData = require __DIR__ . '/../../config/' . $configFile . '.php' ;
// self::$configResult = $configData[$key];
        return $configData;

  
} else {

    die(' this config file ' . $configFile. ' is not exists in the config folder ');

}
        

    }


}