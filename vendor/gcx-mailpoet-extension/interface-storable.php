<?php
if(interface_exists('Gcx_Mailpoet_Ex_Storable_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Storable_Interface{
    function save();
    function load();
    function set_store_engine($engine);
    function get_store_engine();
    function get_store_engine_instance();

}


