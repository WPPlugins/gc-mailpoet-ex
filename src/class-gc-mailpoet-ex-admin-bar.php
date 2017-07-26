<?php
if(class_exists("Gc_Mailpoet_Ex_Admin_Bar")){
	return;
}
class Gc_Mailpoet_Ex_Admin_Bar {
	public function initialize($plugin_options_url){

        $config =Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_CONFIG);
        $wp_admin_bar = $this->get_wp_admin_bar();

        $wp_admin_bar->add_menu( array(
            'parent' => false, // use 'false' for a root menu, or pass the ID of the parent menu
            'id' => 'adminbar_gc_menu', // link ID, defaults to a sanitized title value
            'title' => '<span class="gc-logo-icon"></span> '.__('GetConversion'), // link title
            'href' => "#", // name of file
            'meta' => array( 'html' => '', 'class' => 'gc_adminbar_icon', 'onclick' => '', 'target' => '', 'title' => 'GetConversion' ),
        ));
        $wp_admin_bar->add_menu( array(
            'parent' => 'adminbar_gc_menu', // use 'false' for a root menu, or pass the ID of the parent menu
            'id' => 'adminbar_mygetconversion', // link ID, defaults to a sanitized title value
            'title' => __('MY.GetConversion'), // link title
            'href' => $config['MYGC'], // name of file
            'meta' => array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '_blank', 'title' => 'MY.GetConversion' ),
        ));
        $wp_admin_bar->add_menu( array(
            'parent' => 'adminbar_gc_menu', // use 'false' for a root menu, or pass the ID of the parent menu
            'id' => 'adminbar_'.GC_MAILPOET_EX_NAME, // link ID, defaults to a sanitized title value
            'title' => __('GC MailPoet EX'), // link title
            'href' => Gcx_Mailpoet_Ex_Util::plugin_options_url(), // name of file
            'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
        ));

	}
    public function get_wp_admin_bar(){
        global $wp_admin_bar;
        return $wp_admin_bar;
    }
	public static function script_init(){
			if(!is_admin_bar_showing()){
				return;
			}
            
            wp_register_style( 'gc_admin_bar_css', plugins_url(GC_MAILPOET_EX_TYPE.'/css/adminbar.css'));
            wp_enqueue_style( 'gc_admin_bar_css' );
	}
}