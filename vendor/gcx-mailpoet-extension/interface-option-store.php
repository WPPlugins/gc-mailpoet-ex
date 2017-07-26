<?php
if(interface_exists('Gcx_Mailpoet_Ex_Option_Store_Interface')) {
    return;
}
interface Gcx_Mailpoet_Ex_Option_Store_Interface{
    function save_option($option_name, $newValue,$deprecated=' ', $autoload='no');
    function add_option($option_name,$optionValue, $deprecated=' ', $autoload='no');
    function update_option($option_name,$optionValue);
    function get_option($option_name,$default = null);
    function commit();

}