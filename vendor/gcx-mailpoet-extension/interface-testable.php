<?php
if(interface_exists('Gcx_Mailpoet_Ex_Testable_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Testable_Interface{
    function set_variant($variant);
    function get_variant();
    function count_actual_variant();
    function is_under_testing();
    function get_control_value();
    function get_variant_value($variant);
}


