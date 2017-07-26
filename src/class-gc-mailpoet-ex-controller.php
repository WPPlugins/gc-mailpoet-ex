<?php
if(class_exists("Gc_Mailpoet_Ex_Controller")){
    return;
}
class Gc_Mailpoet_Ex_Controller extends 
    Gc_Mailpoet_Ex_BaseController
implements 
    Gcx_Mailpoet_Ex_Controller_Interface {

    protected $renderer = null;
    protected $metrix_code = null;
    protected $metrix_enable = false;
        
    public function __construct($namespace){
        parent::__construct($namespace);
        $this->event_manager = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_EVENT_MANAGER);
        $this->single_params = $this->get_options_repository()->get_single_params();

    }

    public function initialize(){
        $this->init_required_plugins();
        $this->event_manager->listen(GC_MAILPOET_EX_NAME.".handle_request",array($this,"on_handle_request"));
        $this->init_gc_message_bar_event();
        $this->init_gc_message_box_event();

    }

    protected function init_gc_message_bar_event(){
        if(!$this->is_gc_message_bar_enable()){
            return;
        }
        $this->event_manager->listen("gc_message_bar.render_bar_inner_content",array($this,"on_render_gc_message_bar_inner_content"));
        $this->event_manager->listen("gc_message_bar.render_style",array($this,"on_handle_gc_message_bar_render_style"));
        $this->event_manager->listen("gc_message_bar.render_bar_metrix_tracker_event",array($this,"on_render_bar_metrix_tracker_event"));
        $this->event_manager->listen(GC_MAILPOET_EX_NAME.".gc_message_bar.handle_request",array($this,"on_handle_gc_message_bar_request"));
    }

    protected function init_gc_message_box_event(){
        if(!$this->is_gc_message_box_enable()){
            return;
        }
        $this->event_manager->listen("gc_message_box.render_box_inner_content",array($this,"on_render_gc_message_box_inner_content"));
        $this->event_manager->listen("gc_message_box.render_style",array($this,"on_handle_gc_message_box_render_style"));
        $this->event_manager->listen(GC_MAILPOET_EX_NAME.".gc_message_box.handle_request",array($this,"on_handle_gc_message_box_request"));
        $this->event_manager->listen("gc_message_box.render_box_metrix_tracker_event",array($this,"on_render_box_metrix_tracker_event"));
    }

    public function initialize_hooks(){
        add_action( 'init', array($this, 'eventhandler_init') );
        add_action( 'wp_before_admin_bar_render', array($this, 'adminbar_init') );
        add_action( 'init', array($this, 'adminbar_script_init') );

    }

    public function handle_request(){
        $request = Gcx_Mailpoet_Ex_CF::create("Request");
        if (!$request->has_param($this->namespace.'submit') and !$request->has_param(GC_MAILPOET_EX_NAME)) {
            return;
        }
        $this->event_manager->dispatch(GC_MAILPOET_EX_NAME.".handle_request",$event);
    }

    public function eventhandler_init(){
        if(!$this->is_mailpoet_enable()){
            return;
        }
        $request = Gcx_Mailpoet_Ex_CF::create("Request");
        $this->dispatch_message_bar_request($request);
        $this->dispatch_message_box_request($request);
    }

    protected function dispatch_message_bar_request($request){
        
        if(!$this->is_gc_message_bar_enable()){
            return;
        }
        if(!$request->has_param(GC_MAILPOET_EX_NS.'email')){
            return;
        }
        $type = 'gc_message_bar';
        if($request->get_param(GC_MAILPOET_EX_NS.'type') != $type){
            return;
        }
        $data = $request->get_param(GC_MAILPOET_EX_NS.'email');
        $event = new Gcx_Mailpoet_Ex_Event(array("data" => $data,"namespace" => $this->namespace));
        $this->event_manager->dispatch(GC_MAILPOET_EX_NAME.".gc_message_bar.handle_request",$event);               
    }
    protected function dispatch_message_box_request($request){
        
        if(!$this->is_gc_message_box_enable()){
            return;
        }
        if(!$request->has_param(GC_MAILPOET_EX_NS.'email')){
            return;
        }
        $type = 'gc_message_box';
        if($request->get_param(GC_MAILPOET_EX_NS.'type') != $type){
            return;
        }

        $data = $request->get_param(GC_MAILPOET_EX_NS.'email');
        $event = new Gcx_Mailpoet_Ex_Event(array("data" => $data,"namespace" => $this->namespace));
        $this->event_manager->dispatch(GC_MAILPOET_EX_NAME.".gc_message_box.handle_request",$event);               
    }

    /*
    EVENT HANDLERS
     */
    public function on_render_bar_metrix_tracker_event($event){
        $event->set_handled();
    }
    public function on_render_box_metrix_tracker_event($event){
        $event->set_handled();
    }

    protected function subscribe_handler($event,$plugin){
        if(!$this->is_mailpoet_enable()){
            echo json_encode(array(
                "type" => "error",
                "msg" => "No MailPoet Plugin"
            ));
            die;
        }

        $data = $event->get_param("data",array());
        //in this array firstname and lastname are optional
        $user_data = array(
            'email' => $data
        );
 

        $multi_params_result = $this->get_multi_params($plugin);
        $multi_params = $multi_params_result[0];

        $parameters = $multi_params->filter_by_group("compose");

        $data_subscriber = array(
          'user' => $user_data,
          'user_list' => array('list_ids' => array($parameters->get_parameter("lists")->get_value()))
        );
        global $wysija_msg;
        $helper_user = WYSIJA::get('user','helper');
        @header('Content-type: application/json');
        if($helper_user->addSubscriber($data_subscriber)){
            if(isset($wysija_msg['updated'])){
                echo json_encode(array(
                    "type" => "error",
                    "msg" => $wysija_msg['updated'][0]
                ));
                die;                   
            }
            echo json_encode(array(
                "type" => "success",
                "msg" => "ok"
            ));
            die;
        }
        echo json_encode(array(
            "type" => "error",
            "msg" => $wysija_msg['error'][0]
        ));
        die;

    }
    public function on_handle_gc_message_bar_request($event){
        $this->subscribe_handler($event,"gc_message_bar");
    }


    public function on_handle_gc_message_box_request($event){
        $this->subscribe_handler($event,"gc_message_box");
    }


    public function on_render_gc_message_bar_inner_content($event) {
        if(!$this->is_mailpoet_enable()){
            return;
        }
        $options = $event->get_param("options");
        $renderer = new Gc_Mailpoet_Ex_Gc_Message_Bar_Renderer($options);
        $event->set_result($renderer->render());
        $event->set_handled();
     }

    public function on_render_gc_message_box_inner_content($event) {
        if(!$this->is_mailpoet_enable()){
            return;
        }
        $options = $event->get_param("options");
        $gci = $event->get_param("gci");
        $renderer = new Gc_Mailpoet_Ex_Gc_Message_Box_Renderer($options,$gci);
        $event->set_result($renderer->render());
        $event->set_handled();
     }

}