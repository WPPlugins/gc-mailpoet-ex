<?php
if(class_exists("Gcx_Mailpoet_Ex_Remote_Handler")){
    return;
}

class Gcx_Mailpoet_Ex_Remote_Handler{
    protected $_handlers = array();
    protected $_default_handler;
    protected $_output_formatter;
    protected $_cmd_name = "cmd";
    public function __construct(){
        $this->_default_handler =  Gcx_Mailpoet_Ex_CF::create("Remote_Action_Empty");
        $this->_output_formatter = Gcx_Mailpoet_Ex_CF::create("Remote_Action_Output_Json");
    }

    public function add_handler($name,Gcx_Mailpoet_Ex_Remote_Action_Interface $handler){
        $this->_handlers[$name] = $handler;
    }

    public function execute($request){

        if(!$request->has_param($this->_cmd_name)){
            $handler = $this->_default_handler;
        }else{
            $handler = $this->get_handler($request->get_param($this->_cmd_name));
        }
        $response = $handler->execute($request);
        echo $this->_output_formatter->format($response);

    }

    protected function has_handler($name){
        return isset($this->_handlers[$name]);
    }

    public function get_handler($name){
        if($this->has_handler($name)){
            return $this->_handlers[$name];
        }
        return $this->_default_handler;
    }
}

