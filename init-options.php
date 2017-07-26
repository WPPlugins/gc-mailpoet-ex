<?php
require_once( plugin_dir_path( __FILE__ ) . 'options-gc-mailpoet-ex.php');

$repository = Gcx_Mailpoet_Ex_CF::create_and_init(
	"Setting_Repository",
	array(
		'namespace'            => GC_MAILPOET_EX_NS,
		'single_params_config' => $gc_mailpoet_ex_options_singleton,
		'multi_params_config' => $gc_mailpoet_ex_options
	)
);
$repository->load();
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_OPTION_REPOSITORY,$repository);
Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_REQUIRED,$gc_mailpoet_ex_required);