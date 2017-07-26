<?php
if(interface_exists('Gcx_Mailpoet_Ex_Serializable_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Serializable_Interface{
    function load_from_array($parameters);
    function export_to_array();
    function export_data_to_array();

}


