<?php
if(interface_exists('Gcx_Mailpoet_Ex_HTTP_CLient_Interface')) {
    return;
}
interface Gcx_Mailpoet_Ex_HTTP_CLient_Interface{
    function set_endpoint($url);
    function set_action($cmd);
    function set_parameters($parametes);
    function get_response();
}

