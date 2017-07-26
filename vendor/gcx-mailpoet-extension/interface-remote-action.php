<?php
if(interface_exists('Gcx_Mailpoet_Ex_Remote_Action_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Remote_Action_Interface{
    function execute($request);
}