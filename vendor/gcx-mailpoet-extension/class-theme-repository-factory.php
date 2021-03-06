<?php
if(class_exists('Gcx_Mailpoet_Ex_Theme_Repository_Factory')) {
    return;
}

class Gcx_Mailpoet_Ex_Theme_Repository_Factory{
    private static $repository = null;

    public function get_instance()
    {
        if(null === self::$repository) {
            self::$repository = Gcx_Mailpoet_Ex_CF::create("Theme_Repository");
        }
        return self::$repository;
    }

    public function set_instance($repository)
    {
        self::$repository = $repository;
    }        
}