<?php
global $gc_mailpoet_ex_admin_layout;
$gc_mailpoet_ex_admin_layout = array(
	"general" => array(
        "title" => "Extension Settings",
        "id"    => "general",
        "option_group" => "general",
        "renderer" => "Gc_Mailpoet_Ex_Options_Plugin_Container_Renderer"
        ),
);
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_LAYOUT_CONFIG, $gc_mailpoet_ex_admin_layout);
