<?php
require_once(GC_MAILPOET_EX_ABS_LIB_PATH."init.php");
Gcx_Mailpoet_Ex_CF::set_prefix("Gcx_Mailpoet_Ex");
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_OPTION_STORE,Gcx_Mailpoet_Ex_CF::create("Option_Store"));
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_SETTING_STORE,Gcx_Mailpoet_Ex_CF::create("Setting_Store"));
global $GC_MailPoet_Ex_Config;
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_CONFIG, $GC_MailPoet_Ex_Config);


$event_manager = Gcx_Mailpoet_Ex_CF::create_and_init("Event_Manager",array("global" => true, "namespace"=> "get_conversion"));
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_EVENT_MANAGER,$event_manager);
