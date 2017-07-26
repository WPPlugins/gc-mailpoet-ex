<?php
if(interface_exists('Gcx_Mailpoet_Ex_Remote_Action_Output_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Remote_Action_Output_Interface{
    function format($data);
}