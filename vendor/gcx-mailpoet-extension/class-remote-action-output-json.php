<?php
if(class_exists("Gcx_Mailpoet_Ex_Remote_Action_Output_Json")){
    return;
}

class Gcx_Mailpoet_Ex_Remote_Action_Output_Json implements Gcx_Mailpoet_Ex_Remote_Action_Output_Interface{
    public function format($data){
        return json_encode($data);
    }
}