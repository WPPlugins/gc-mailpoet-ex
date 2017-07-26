<?php
if(class_exists("Gc_Mailpoet_Ex_Admin_Controller")){
    return;
}
class Gc_Mailpoet_Ex_Admin_Controller 
extends 
    Gc_Mailpoet_Ex_BaseController
implements 
    Gcx_Mailpoet_Ex_Controller_Interface {
    protected $single_params;
    protected $this_plugin = 'gc-mailpoet-ex/main.php';

    public function __construct($namespace){
        parent::__construct($namespace);
        $this->event_manager = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_EVENT_MANAGER);
        $this->exclude_options = array(
            "gc_message_bar" => array(
                "content_align" => true,
                "enable_cloaking" => true,
            ),
            "gc_message_box" => array(
                "content_layout" => true,
                "enable_cloaking" => true,
            )
        );

    }
    public function initialize(){
        $this->single_params = $this->get_options_repository()->get_single_params();
        $this->init_required_plugins();
        $this->event_manager->listen(GC_MAILPOET_EX_NAME.".handle_request",array($this,"on_handle_request"));
        $this->event_manager->listen(GC_MAILPOET_EX_NAME.".handle_request:after",array($this,"on_post_handle_request"));

        $this->init_gc_message_bar_event();        
        $this->init_gc_message_box_event();        
    }

    public function init_gc_message_bar_event(){
        if(!$this->is_gc_message_bar_enable()){
            return;
        }
        $this->event_manager->listen("gc_message_bar.render_section",array($this,"on_render_gc_message_bar_section"));
        $this->event_manager->listen("gc_message_bar.handle_request",array($this,"on_handle_gc_message_bar_request"));
        $this->event_manager->listen("gc_message_bar.change_group_state",array($this,"on_handle_gc_message_bar_change_group_state"));
        $this->event_manager->listen("gc_message_bar.general_settings.render_option",array($this,"on_handle_gc_message_bar_render_option"));
        $this->event_manager->listen("gc_message_bar.style_settings.render_option:after",array($this,"on_handle_gc_message_bar_render_option"));
        $this->event_manager->listen("gc_message_bar.render_style",array($this,"on_handle_gc_message_bar_render_style"));
    }
    public function init_gc_message_box_event(){
        if(!$this->is_gc_message_box_enable()){
            return;
        }
        $this->event_manager->listen("gc_message_box.render_section",array($this,"on_render_gc_message_box_section"));
        $this->event_manager->listen("gc_message_box.handle_request",array($this,"on_handle_gc_message_box_request"));
        $this->event_manager->listen("gc_message_box.change_group_state",array($this,"on_handle_gc_message_box_change_group_state"));
        $this->event_manager->listen("gc_message_box.general_settings.render_option",array($this,"on_handle_gc_message_box_render_option"));
        $this->event_manager->listen("gc_message_box.style_settings.render_option:after",array($this,"on_handle_gc_message_box_render_option"));
        $this->event_manager->listen("gc_message_box.render_style",array($this,"on_handle_gc_message_box_render_style"));


    }
    public function initialize_hooks(){
                
        $this->init_admin_wp_ui();
        $this->init_plugin_handling_hooks();
        $this->init_fonts();
        $this->init_plugin_js_scripts();

        $this->initialize_getconversion_remote();            
        $this->init_stylesheets();
        if(!Gcx_Mailpoet_Ex_Util::is_plugin_page()){
            add_action( 'init', array($this, 'otherscreens_scripts_init') );
        }

    }
    public function  otherscreens_scripts_init() {
        wp_enqueue_script( 'jquery' );
        wp_register_style( 'gc_mailpoet_ex_admin_other',  plugins_url('gc-mailpoet-ex/css/style-gc-mailpoet-ex-admin-other.css') );
        wp_enqueue_style( 'gc_mailpoet_ex_admin_other' );
    }
    protected function is_option_exclude($plugin,$option_name){
        return isset($this->exclude_options[$plugin][$option_name]);
    }
    protected function is_gc_message_bar_option_exclude($option_name){
        return $this->is_option_exclude("gc_message_bar",$option_name);
    }
    protected function is_gc_message_box_option_exclude($option_name){
        return $this->is_option_exclude("gc_message_box",$option_name);
    }
    public function on_handle_gc_message_bar_render_option($event){
        $option_id = $event->get_param("key");
        if($option_id == "bar_shadow"){
            $renderer_name = "Gcx_Mailpoet_Ex_Options_Subgroup_Container_Renderer";
            $parent_namespace = $event->get_param("namespace","gc_message_bar_");
            $multi_params_result = $this->get_multi_params("gc_message_bar");
            $multi_params = $multi_params_result[0];
            $parameters = $multi_params->filter_by_group("style");
            $parameters->set_namespace("gc_message_bar_".$this->namespace);
            $cnt = new $renderer_name(Gcx_Mailpoet_Ex_CF::create_and_init("Option_Group",array(
                "title" => "GC MailPoet EX styles",
                "id"    => "mailpoet_style",
                "option_group" => "compose_gc_message_bar",
                'params' => array(
                    'css_class' => "before-itemgroup after-itemgroup"
                ),

                "extra_param" => array(
                    "parent_namespace" => $parent_namespace,
                    "parent_name" => "gc-message-bar"

                ))
            ),$parameters->get_parameters(),$parent_namespace.$this->namespace);
            $cnt->set_event_manager($this->event_manager);
            $cnt->set_event_prefix('gc_message_bar');
            $cnt->init_event_handler();

            $cnt->render(array());

            //$event->set_handled();
        }
        if($this->is_gc_message_bar_option_exclude($option_id)){
            $event->set_handled();
            return;
        }
    }

    public function on_handle_gc_message_box_render_option($event){
        $option_id = $event->get_param("key");
        if($option_id == "box_shadow"){
            $renderer_name = "Gcx_Mailpoet_Ex_Options_Subgroup_Container_Renderer";
            $parent_namespace = $event->get_param("namespace","gc_message_box_");
            $multi_params_result = $this->get_multi_params("gc_message_box");
            $multi_params = $multi_params_result[0];
            $parameters = $multi_params->filter_by_group("style");
            $parameters->set_namespace("gc_message_box_".$this->namespace);
            $cnt = new $renderer_name(Gcx_Mailpoet_Ex_CF::create_and_init("Option_Group",array(
                "title" => "GC MailPoet EX styles",
                "id"    => "mailpoet_style",
                "option_group" => "compose_gc_message_box",
                'params' => array(
                    'css_class' => "before-itemgroup after-itemgroup"
                ),

                "extra_param" => array(
                    "parent_namespace" => $parent_namespace,
                    "parent_name" => "gc-message-box"

                ))
            ),$parameters->get_parameters(),$parent_namespace.$this->namespace);
            $cnt->set_event_manager($this->event_manager);
            $cnt->set_event_prefix('gc_message_box');
            $cnt->init_event_handler();

            $cnt->render(array());

            //$event->set_handled();
        }
        if($this->is_gc_message_box_option_exclude($option_id)){
            $event->set_handled();
            return;
        }
    }

    public function on_render_gc_message_bar_section($event){
        if(!$this->is_mailpoet_enable()){
            return;
        }
        $container_src = $event->get_params();
        if($container_src['id'] != "compose_message"){
            return;
        }
        $group_state = $this->get_single_param("gc-message-bar-group");

 
        $renderer_name = "Gc_Mailpoet_Ex_Options_Compose_Container_Renderer";
        $multi_params_result = $this->get_multi_params("gc_message_bar");
        $multi_params = $multi_params_result[0];

        $parameters = $multi_params->filter_by_group("compose");
        $parameters->set_namespace($container_src['namespace'].$this->namespace);
        $cnt = new $renderer_name(Gcx_Mailpoet_Ex_CF::create_and_init("Option_Group",array(
            "title" => "MailPoet Settings",
            "id"    => "mailpoet_settings",
            "option_group" => "compose_gc_message_bar",
            "extra_param" => array(
                "parent_namespace" => $container_src['namespace'],
                "parent_name" => "gc-message-bar",
                "group_state" => $group_state))
        ),$parameters->get_parameters(),$container_src['namespace'].$this->namespace);
        $cnt->render(array());
        $event->set_handled();

    }

    public function on_render_gc_message_box_section($event){
        if(!$this->is_mailpoet_enable()){
            return;
        }
        $container_src = $event->get_params();
        if($container_src['id'] != "compose_message"){
            return;
        }
        $group_state = $this->get_single_param("gc-message-box-group");

 
        $renderer_name = "Gc_Mailpoet_Ex_Options_Compose_Container_Renderer";
        $multi_params_result = $this->get_multi_params("gc_message_box");
        $multi_params = $multi_params_result[0];

        $parameters = $multi_params->filter_by_group("compose");
        $parameters->set_namespace($container_src['namespace'].$this->namespace);
        $cnt = new $renderer_name(Gcx_Mailpoet_Ex_CF::create_and_init("Option_Group",array(
            "title" => "MailPoet Settings",
            "id"    => "mailpoet_settings",
            "option_group" => "compose_gc_message_box",
            "extra_param" => array(
                "parent_namespace" => $container_src['namespace'],
                "parent_name" => "gc-message-box",
                "group_state" => $group_state))
        ),$parameters->get_parameters(),$container_src['namespace'].$this->namespace);
        $cnt->render(array());
        $event->set_handled();

    }



    public function on_handle_gc_message_bar_change_group_state($event){
        $this->change_group_state($event,"gc-message-bar-group");

    }
    public function on_handle_gc_message_box_change_group_state($event){
        $this->change_group_state($event,"gc-message-box-group");
    }
    protected function change_group_state($event,$plugin_state_option_name){
        $request = $event->get_param("request");
        $id = $request->get_param('id');
        if($id != "mailpoet_settings"){
            return;
        }
        $group = $request->get_param('group');
        $group_state = $this->single_params->get_parameter($plugin_state_option_name);
        $group_state->set_value($group);
        $this->get_options_repository()->save();

    }
    public function on_handle_gc_message_bar_request($event){
        $this->handle_plugin_request($event,"gc_message_bar","gc_message_bar_");
    }
    public function on_handle_gc_message_box_request($event){
        $this->handle_plugin_request($event,"gc_message_box","gc_message_box_");
    }
    protected function handle_plugin_request($event,$plugin,$namespace){
        $params = $this->get_multi_params($plugin);
        $parameters_compose = $params[0]->filter_by_group("compose");
        $this->save_gc_plugin_settings($event,$parameters_compose,$namespace);
        $parameters_style = $params[0]->filter_by_group("style");
        $this->save_gc_plugin_settings($event,$parameters_style,$namespace);
        $this->get_options_repository()->save();

    }
    protected function save_gc_plugin_settings($event,$parameters,$namespace){
        $namespace = $event->get_param("namespace",$namespace);
        $data = $event->get_param("data",array());
        foreach ($parameters->get_parameters() as $key => $option) {
            if(!$option->is_visible()){
                continue;
            }
            if (isset($data[$namespace.$option->get_unique_name()])) {
                $option->set_value($data[$namespace.$option->get_unique_name()]);
            } elseif($option->is_checkbox()) {
                $option->set_checked(false);
            }else{
                continue;
            }
        }

    }
    public function on_activate_plugin(){
        $remote = $this->single_params->get("enable_remote_configuration");
        $remote->set_value(1);
        $remote->save();


    }

    protected function init_stylesheets(){
        if(!Gcx_Mailpoet_Ex_Util::is_plugin_page()){
            return;
        }
        $this->initialize_less_js();
    }

    protected function init_plugin_js_scripts(){
        if(!Gcx_Mailpoet_Ex_Util::is_plugin_page()){
            return;
        }
        add_action( 'init', array($this, 'js_scripts_init') );

    }

    protected function init_plugin_handling_hooks(){
        register_activation_hook( Gcx_Mailpoet_Ex_Util::get_base_file(), array($this,'on_activate_plugin') );

    }
    protected function init_admin_wp_ui(){
        add_action( 'admin_menu', array($this, 'add_sub_menu_to_wp_admin') );
        add_action( 'wp_ajax_gc-mailpoet-ex-group', array($this,'wp_ajax_group') );
        add_action( 'wp_before_admin_bar_render', array($this, 'adminbar_init') );
        add_action( 'init', array($this, 'adminbar_script_init') );
        add_filter( 'plugin_action_links', array($this, 'add_action_link'), 10, 2 );       
        if(!Gcx_Mailpoet_Ex_Util::is_plugin_page()){
            return;
        }
        
    }
    
    
    protected function initialize_getconversion_remote(){
        add_action( 'wp_ajax'.GC_MAILPOET_EX_TYPE.'_-activate', array($this,'activate') );
        add_action( 'wp_ajax'.GC_MAILPOET_EX_TYPE.'_-deactivate', array($this,'deactivate') );

    }

    public function activate(){
        global $GC_Message_Corner_Config;
        $helper = Gcx_Mailpoet_Ex_CF::create_and_init("Mygetconversion_Helper",array(
            "domain_url" => $this->get_domain_url(),
            "api_url" => $GC_Message_Corner_Config['GCAPI'],
            "request" => Gcx_Mailpoet_Ex_CF::create("Request")
        ));
        $helper->handle_activate();
    }

    public function deactivate(){
        global $GC_Message_Corner_Config;

        $helper = Gcx_Mailpoet_Ex_CF::create_and_init("Mygetconversion_Helper",array(
            "domain_url" => $this->get_domain_url(),
            "api_url" => $GC_Message_Corner_Config['GCAPI'],
            "request" => Gcx_Mailpoet_Ex_CF::create("Request")
        ));
        $helper->handle_deactivate();
    }


    protected function initialize_less_js(){
        $config = $this->get_configuration();

        $less_helper = Gcx_Mailpoet_Ex_CF::create_and_init("Lessjs_Helper",array(
            "less_file" => plugins_url(GC_MAILPOET_EX_TYPE.'/css/style-'.GC_MAILPOET_EX_TYPE.'-admin'),
            "plugin_name" => GC_MAILPOET_EX_TYPE
            ) );
        if($config['GCTYPE'] == "DEV"){
            $less_helper->set_debug_mode();
        }

        $less_helper->initialize();
        

    }

    public function info(){
        die('{"ver":"'.Gcx_Mailpoet_Ex_Util::get_version().'"}');  
    }

    public function remote(){
        $remote_handler = new Gc_Mailpoet_Ex_Remote_Handler($this->namespace);
        $remote_handler->execute(Gcx_Mailpoet_Ex_CF::create("Request"));
        exit();
    }



    public function wp_ajax_group(){
        $request = Gcx_Mailpoet_Ex_CF::create("Request");
        if(!$request->has_param('id')){
            return;
        }
        if(!$request->has_param('group')){
            return;
        }
        $option_name = $request->get_param('id')."-group";
        $option = $this->single_params->get_parameter($option_name);
        if(!$option){
            return;
        }
        $option->set_value($request->get_param('group'));
        $this->get_options_repository()->save();
        return;
    }

    public function add_sub_menu_to_wp_admin() {
        add_submenu_page( 'plugins.php', 'GC MailPoet EX Options', 'GC MailPoet EX','manage_options', GC_MAILPOET_EX_NAME, array($this, 'sub_menu_page'));
    }

    public function sub_menu_page() {
        $this->init_values();
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        $this->render();
    }
    public function render(){

        $renderer = new Gc_Mailpoet_Ex_Admin_Renderer($this->namespace,$this);
        $renderer->render("");
    }
    
    public function add_action_link($links, $file) {
        if ( $file == $this->this_plugin ) {
            $settings_link = '<a href="' . $this->plugin_options_url() . '">' . __( 'Settings' ) . '</a>';
            array_unshift( $links, $settings_link );
        }
        return $links;
    }

    public function init_values() {
        $installedOption = $this->single_params->get("installed");
            
        if ($installedOption->get_value() == "true") {
            return;
        }
        /*
        $options = $this->get_options();
        foreach ($options as $key => $opt) {
            $opt->save();
        }
        $installedOption->set_value("true");
        $installedOption->save();
        */
    }

    public function get_options(){
        return $this->single_params->get_parameters();
    }    

    public function js_scripts_init(){

        wp_enqueue_script( 'jquery' );

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );


        wp_enqueue_script( GC_MAILPOET_EX_NS.'admin', plugins_url(GC_MAILPOET_EX_TYPE.'/js/gc-admin.js') );
        wp_localize_script( GC_MAILPOET_EX_NS.'admin', 'WP', array(
            'base_url' => admin_url("admin-ajax.php"),
            'group_ajax_url' => GC_MAILPOET_EX_TYPE.'-group',
            'disconnect_action' => GC_MAILPOET_EX_TYPE.''

        ) );
        Gc_Mailpoet_Ex_Admin_Bar::script_init();

        $this->init_fonts_selector_scripts();
    }

    protected function init_fonts_selector_scripts(){
        wp_enqueue_script( 'jqueryselectbox',plugins_url(GC_MAILPOET_EX_TYPE.'/js/jquery.selectbox.js' ));
        wp_enqueue_style( 'jqueryselectbox-css', plugins_url(GC_MAILPOET_EX_TYPE.'/css/jquery.selectbox.css') );
    }

    protected function init_fonts(){
        $urlPrefix = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

        wp_register_style( 'gc_font_roboto', $urlPrefix.'fonts.googleapis.com/css?family=Roboto:400,700,300');
        wp_register_style( 'gc_font_roboto_condensed', $urlPrefix.'fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300');
        wp_enqueue_style( 'gc_font_roboto' );
        wp_enqueue_style( 'gc_font_roboto_condensed' );
    }

    public function handle_request(){
        $request = Gcx_Mailpoet_Ex_CF::create("Request");

        if (!$request->has_param($this->namespace.'submit') and !$request->has_param($this->namespace.'engine') or !$request->has_param('post')) {
            return;
        }
        
        if($this->handle_service_request($request)){
            return;
        }

        if(!$request->has_param('post')){
            return;
        }
        $data = $request->get_param('post');

        $event = new Gcx_Mailpoet_Ex_Event(array("data" => $data,"namespace" => $this->namespace));
        $this->event_manager->dispatch(GC_MAILPOET_EX_NAME.".handle_request",$event,true);


    }
    public function on_handle_request($event){
        $data = $event->get_param("data",array());

        $options = $this->get_options();
        
        foreach($options as $option) {
            if(!$option->is_visible()){
                continue;
            }
            if (isset($data[$option->get_unique_name()])) {
                $option->set_value($data[$option->get_unique_name()]);
            } elseif($option->is_checkbox()) {
                $option->set_checked(false);
            }else{
                continue;
            }
            $option->save();
        }
        $this->get_options_repository()->save();
    }
    public function on_post_handle_request($event){
        $cache = new Gcx_Mailpoet_Ex_Wp_Cache($this->namespace,$this);
        $cache->w3_total_cache_flush();
        $cache->wp_super_cache_flush();
        $event->set_handled();

    }

    protected function handle_service_request($request){
        if (!$request->has_param($this->namespace.'engine')) {
            return false;
        }

        if(!$request->has_param('post')){
            return false;
        }

        $options =  $this->single_params->filter_by_group("internal_engine");
        $data = $request->get_param('post');
        foreach($options->get_parameters() as $option) {
            if(!$option->is_visible()){
                continue;
            }
            if (isset($data[$option->get_unique_name()])) {
                $option->set_value($data[$option->get_unique_name()]);
            } elseif($option->is_checkbox()) {
                $option->set_checked(false);
            }else{
                continue;
            }
            $option->save();
        }
        $options =  $this->single_params->filter_by_group("internal_engine");
        $this->get_options_repository()->save();
        return true;
    }

}