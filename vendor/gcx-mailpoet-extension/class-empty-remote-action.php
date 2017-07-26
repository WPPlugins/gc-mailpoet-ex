<?php
if(class_exists("Gcx_Mailpoet_Ex_Remote_Action_Empty")){
    return;
}

class Gcx_Mailpoet_Ex_Remote_Action_Empty implements Gcx_Mailpoet_Ex_Remote_Action_Interface {
    public function execute($request){
        return array("error" => true,"msg" => "cmd not found", "code" => 101);
    }
}