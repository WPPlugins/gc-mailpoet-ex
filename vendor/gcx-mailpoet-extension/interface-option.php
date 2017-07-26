<?php
if(interface_exists('Gcx_Mailpoet_Ex_Option_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Option_Interface{
    function get_value();
    function set_value($value);
    function get_group();
    function get_type();
    function get_text();
    function get_id();
    function get_description();
    function get_options();

}


