<?php
if(class_exists("Gcx_Mailpoet_Ex_Button_Darklight_Renderer")){
    return;
}

class Gcx_Mailpoet_Ex_Button_Darkligth_Renderer extends Gcx_Mailpoet_Ex_Button_Twostate_Renderer{
    public function __construct(){
      $this->type ="darklight";
      $this->states = array(1 => "light",2 => "dark");
      $this->text = array(1=> '<span>Light</span><b></b><div class="clear"></div>',2=>'<b></b><span>Dark</span><div class="clear"></div>');
      $this->onclik_handler = "Gc.Darklight_Button_On_Click";
    }
}

