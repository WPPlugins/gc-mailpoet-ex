<?php
if(!class_exists("Gc_Mailpoet_Ex_BaseController")){
    class Gc_Mailpoet_Ex_BaseController{
        protected $namespace;
        protected $options_repository = null;
        protected $configuration = null;
        public function __construct($namespace){
            $this->namespace = $namespace;

        }
        public function get_options_repository(){
        	if(is_null($this->options_repository )){
        		$this->options_repository = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_OPTION_REPOSITORY);
        	}
        	return $this->options_repository;
        }
        public function get_single_param($name){
        	return $this->get_options_repository()->get_single_params()->get($name);
        }
        public function get_configuration(){
        	if(is_null($this->configuration )){
        		$this->configuration = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_CONFIG);
        	}
        	return $this->configuration;

        }
        public function get_multi_params($name){
            $res = $this->get_options_repository()->get_multi_params($name);
            if(!empty($res)){
                return $res;
            }
            $res = $this->get_options_repository()->get_new_multi_params();
            $this->get_options_repository()->add_multi_params($res,$name);
            return array($res);

        }

        public function init_required_plugins(){
            $plugins = get_plugins();
            $required = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_REQUIRED);
            foreach($required as $key => $plugin){
                if(isset($plugins[$key])){
                    $required[$key]['Available'] = true;
                    $required[$key]['InstalledVersion'] = $plugins[$key]["Version"];
                }

            }
            Gcx_Mailpoet_Ex_Service_Locator::set(GC_MAILPOET_EX_SL_REQUIRED,$required);
        }

    
        public function plugin_options_url() {
            return Gcx_Mailpoet_Ex_Util::plugin_options_url();
        }

        protected function get_current_url() {
            $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            if ($_SERVER["SERVER_PORT"] != "80")
            {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } 
            else 
            {
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
            return $pageURL;
        }
    
        protected function get_domain_url(){
            return $this->get_current_url();
        }

        public function adminbar_script_init(){
            Gc_Mailpoet_Ex_Admin_Bar::script_init();
        }
        public function adminbar_init() {
            $bar = new Gc_Mailpoet_Ex_Admin_Bar();
            $bar->initialize($this->plugin_options_url());

        }


        public function render()        {
            
        }

        protected function is_mailpoet_enable(){
             return class_exists('WYSIJA');
        }

        protected function is_gc_message_bar_enable(){
            $enable_plugin = $this->single_params->get_parameter("gc-mailpoet-ex_main_php");
            if($enable_plugin->get_value() == "2"){
                return false;
            }
            $enable_gc_message_bar = $this->single_params->get_parameter("gc-message-bar_main_php");
            if($enable_gc_message_bar->get_value() == "2"){
                return false;
            }
            $required = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_REQUIRED);
            if($required['wysija-newsletters/index.php']['Available'] == false){
                return false;
            }
            return true;
        }
        protected function is_gc_message_box_enable(){
            $enable_plugin = $this->single_params->get_parameter("gc-mailpoet-ex_main_php");
            if($enable_plugin->get_value() == "2"){
                return false;
            }
            $enable_gc_message_bar = $this->single_params->get_parameter("gc-message-box_main_php");
            if($enable_gc_message_bar->get_value() == "2"){
                return false;
            }
            $required = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_REQUIRED);
            if($required['wysija-newsletters/index.php']['Available'] == false){
                return false;
            }
            return true;
        }

        public function on_handle_gc_message_bar_render_style($event){
            $options = $event->get_param("options");
            $renderer = new Gc_Mailpoet_Ex_Gc_Message_Bar_Style_Renderer($options);
            $params = $event->get_param("params");
            if(false == isset($params["echo"])){
                $echo = true;
            } else{
                $echo = $params["echo"];
            }

            $renderer->configure(
                array(
                    "echo" => $echo,
                    "minify" => false,
                ));
            if($echo){
                $renderer->render();
            }else{
                $event->set_result($renderer->render());
            }
        }

        public function on_handle_gc_message_box_render_style($event){
            $options = $event->get_param("options");
            $renderer = new Gc_Mailpoet_Ex_Gc_Message_Box_Style_Renderer($options);
            $params = $event->get_param("params");
            if(false == isset($params["echo"])){
                $echo = true;
            } else{
                $echo = $params["echo"];
            }

            $renderer->configure(
                array(
                    "echo" => $echo,
                    "minify" => false,
                ));
            if($echo){
                $renderer->render();
            }else{
                $event->set_result($renderer->render());
            }
        }


    }
}