<?php
if(class_exists("Gcx_Mailpoet_Ex_Service_Locator")){
    return;
}

class Gcx_Mailpoet_Ex_Service_Locator{
    protected static $services = array();
    public static function set($name,$service){
        self::$services[$name] = $service;
    }
    public static function get($name){
        if(!isset(self::$services[$name])){
            return null;
        }
        return self::$services[$name];
    }

    public static function has($name){
        return isset(self::$services[$name]);
    }
    public static function dump(){
        var_dump(self::$services);
    }

}