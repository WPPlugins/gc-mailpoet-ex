<?php
if(interface_exists('Gcx_Mailpoet_Ex_Option_Meta_Data_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Option_Meta_Data_Interface{
    function is_visible();
    function set_visible($visible);
    function is_remote_edit_enable();
    function set_remote_edit_enable($enable);
    function set_instance($id);
    function get_instance();

}
