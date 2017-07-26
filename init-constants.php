<?php
if(!defined('GC_MAILPOET_EX_LIB_PATH')){
	define('GC_MAILPOET_EX_LIB_PATH','vendor'.DIRECTORY_SEPARATOR.'gcx-mailpoet-extension'.DIRECTORY_SEPARATOR);	
	define('GC_MAILPOET_EX_ABS_LIB_PATH',plugin_dir_path( __FILE__ ) . GC_MAILPOET_EX_LIB_PATH);
}
if(!defined('GC_MAILPOET_EX_NAME')){
	define('GC_MAILPOET_EX_NAME','gc_mailpoet_ex');
	define('GC_MAILPOET_EX_TYPE','gc-mailpoet-ex');
	define('GC_MAILPOET_EX_NS', 'gc_mailpoet_ex_');	

	define('GC_MAILPOET_EX_SL_CONFIG', 'config');
	define('GC_MAILPOET_EX_SL_LAYOUT_CONFIG', 'layout_config');
	define('GC_MAILPOET_EX_SL_OPTION_REPOSITORY', 'option_repository');
	define('GC_MAILPOET_EX_SL_OPTION_STORE', 'option_store');
	define('GC_MAILPOET_EX_SL_SETTING_STORE', 'setting_store');
	define('GC_MAILPOET_EX_SL_EVENT_MANAGER', 'event_manager');
	define('GC_MAILPOET_EX_SL_REQUIRED','required_plugins');
}


