<?php
if(class_exists("Gc_Mailpoet_Ex_Gc_Message_Box_Style_Renderer")){
	return;
}
class Gc_Mailpoet_Ex_Gc_Message_Box_Style_Renderer{
	protected $box_options = null;
	protected $ex_options = null;
    protected $options_repository = null;
    protected $namspace = "gc_message_box_";
    const ON = "1";
    const OFF = "2";
    protected $echo = true;

	public function __construct($box_options){
		$this->box_options = $box_options;
        $params = $this->get_multi_params("gc_message_box");
        $parameters = $params[0]->filter_by_group("compose");
        $this->namespace = $this->box_options->get_namespace();
		$this->ex_options = $params[0]->filter_by_group("compose");
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

    public function configure(array $options){
        $this->configure_field($options,"echo");
        $this->configure_field($options,"minify");
        $this->configure_field($options,"dev_mode");
    }

    protected function configure_field(array $options,$field_name){
        if(isset($options[$field_name])){
            $this->$field_name = $options[$field_name];
        }
    }


    protected function get_options_repository(){
    	if(is_null($this->options_repository )){
    		$this->options_repository = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_OPTION_REPOSITORY);
    	}
    	return $this->options_repository;
    }
    protected function get_box_option($name) {
    	return $this->box_options->get($name);
    }
    protected function get_box_option_value($name) {
    	return $this->get_box_option($name)->get_value();
    }
    protected function get_mailpoet_option_value($name){
        $params = $this->get_multi_params("gc_message_box");
        return $params[0]->get_parameter($name)->get_value();
    }
    protected function generate_shadow($dark_light_option_name) {
        if($this->get_box_option_value("text_shadow") == "1"){
            $dark_light_option = $this->get_box_option_value($dark_light_option_name);
            switch($dark_light_option) {
                case "1":
                    return "text-shadow: 1px 1px 1px rgba(255,255,255,.3);";                
                case "2":
                    return "text-shadow: 1px 1px 1px rgba(0,0,0,.3);";
            }

        }
        return "";
    }
    public function render(){
$css_content = "";
$css_content .= 
"
/* GC MAILPOET EX */
.gc_mailpoet_ex_gc_message_box.embed {
    margin: 0;
    vertical-align: top;
    text-align: center;
}
.gc_mailpoet_ex_gc_message_box.embed div {
    margin: 0;
}
.gc_mailpoet_ex_gc_message_box.embed .default {
    font-weight: normal;
    vertical-align: top;
}
.gc_mailpoet_ex_gc_message_box.embed .default .message{
    display: inline-table;
    position: relative;
    overflow: hidden;
    vertical-align: top;
    line-height: 30px;
    margin: 6px 0;
    color: ".$this->get_box_option_value("message_color").";
".$this->generate_shadow('message_shadow').
 "
    font-family: ".$this->get_box_option_value('message_font')." !important;
    font-size: ".$this->get_box_option_value('message_font_size').";
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper {
    display: inline-table;
    position: relative;
    vertical-align: top;
    height: 30px;
    line-height: 30px;
    margin: 0 10px;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .not-valid-email,
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .not-filled {
    display: inline-block;
    position: absolute;
    top: -28px;
    border-radius: 3px;
    padding: 0 10px;
    background: #aa0000;
    color: white;
    height: 30px;
    line-height: 30px;
    white-space: nowrap;
    z-index: 4;
    font-family: ".$this->get_box_option_value('message_font')." !important;
    font-size: ".$this->get_box_option_value('message_font_size').";
    border: 1px solid #ffffff;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .not-valid-email:before,
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .not-filled:before { 
    content: \" \"; 
    display: block; 
    width: 0; 
    height: 0;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-top: 6px solid #aa0000;
    position: absolute;
    top: 30px;
    left: 10px;
    z-index: 5;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .not-valid-email:after,
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .not-filled:after { 
    content: \" \"; 
    display: block; 
    width: 0; 
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 7px solid #ffffff;
    position: absolute;
    top: 30px;
    left: 9px;
    z-index: 2;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .the-input {
    display: inline-block;
    margin: 6px 0;
    height: 30px;
    line-height: 30px;
    vertical-align: baseline;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .the-input input{
    margin: 0;
    height: 30px;
    line-height: 30px;
    border: 1px solid ".$this->get_mailpoet_option_value("input_border_color").";
    color: ".$this->get_mailpoet_option_value("input_text_color").";
    background-color: ".$this->get_mailpoet_option_value("input_background_color").";
    border-radius: 3px;
    font-family: inherit;
    position: relative;
    overflow: hidden;
    display: inline-block;
    vertical-align: baseline;
    padding: 0 8px;
    width: 140px;
    font-family: ".$this->get_box_option_value('message_font')." !important;
    font-size: ".$this->get_box_option_value('message_font_size').";
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-appearance: textfield;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .the-input input::-webkit-input-placeholder {   
    color: ".$this->get_mailpoet_option_value("input_placeholder_color").";
    vertical-align: baseline;
    line-height: 30px;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .the-input input:-moz-placeholder {
    color: ".$this->get_mailpoet_option_value("input_placeholder_color").";
    vertical-align: baseline;
    line-height: 30px;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .the-input input::-moz-placeholder {
    color: ".$this->get_mailpoet_option_value("input_placeholder_color").";
    vertical-align: baseline;
    line-height: 30px;
}
.gc_mailpoet_ex_gc_message_box.embed .default .subscription-wrapper .the-input input:-ms-input-placeholder {  
    color: ".$this->get_mailpoet_option_value("input_placeholder_color").";
    vertical-align: baseline;
    line-height: 30px;
}
.gc_mailpoet_ex_gc_message_box.embed .default .button {
    display: inline-table;
    position: relative;
    overflow: hidden;
    vertical-align: top;
    margin: 6px 0;
    background: none !important;
}
.gc_mailpoet_ex_gc_message_box.embed .default .button span {
    overflow: hidden;
    vertical-align: top;
}
.gc_mailpoet_ex_gc_message_box.embed .success {
    display: inline-block;
    position: relative;
    overflow: hidden;
    line-height: 30px;
    margin: 6px 0;
    color: ".$this->get_box_option_value("message_color").";
".$this->generate_shadow('message_shadow').
"
    font-family: ".$this->get_box_option_value('message_font')." !important;
    font-size: ".$this->get_box_option_value('message_font_size').";
}
.gc_mailpoet_ex_gc_message_box.embed .already-exists {
    display: inline-block;
    position: relative;
    overflow: hidden;
    line-height: 30px;
    margin: 6px 0;
    color: ".$this->get_box_option_value("message_color").";
".$this->generate_shadow('message_shadow').
"
    font-family: ".$this->get_box_option_value('message_font')." !important;
    font-size: ".$this->get_box_option_value('message_font_size').";
}
";
        if($this->echo){
            echo $css_content;
        } else {
            return $css_content;
        }

    }

}
