<?php
if(interface_exists('Gcx_Mailpoet_Ex_Configurable_Interface')) {
    return;
}

interface Gcx_Mailpoet_Ex_Configurable_Interface{
    function configure(array $options);

}


