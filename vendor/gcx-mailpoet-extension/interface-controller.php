<?php
if(interface_exists("Gcx_Mailpoet_Ex_Controller_Interface")){
    return;
}

interface Gcx_Mailpoet_Ex_Controller_Interface{
    function initialize();
    function initialize_hooks();
    function handle_request();
    function render();
}
