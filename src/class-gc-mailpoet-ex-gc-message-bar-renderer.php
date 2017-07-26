<?php
if(class_exists("Gc_Mailpoet_Ex_Gc_Message_Bar_Renderer")){
	return;
}
class Gc_Mailpoet_Ex_Gc_Message_Bar_Renderer{
	protected $bar_options = null;
	protected $ex_options = null;
    protected $options_repository = null;
    protected $namspace = "gc_message_bar_";
    const ON = "1";
    const OFF = "2";
	public function __construct($bar_options){
		$this->bar_options = $bar_options;
        $params = $this->get_multi_params("gc_message_bar");
        $parameters = $params[0]->filter_by_group("compose");
        $this->namespace = $this->bar_options->get_namespace();
		$this->ex_options = $params[0]->filter_by_group("compose");
	}
	public function render(){
		$content = "";
        $content = 
            '<div id="'.$this->namespace.'content" class="content">'.
                $this->_render_open_close_button("close","pre") .
                '<div id="gc_mailpoet_ex" class="embed">
                    <div class="default" id="'.GC_MAILPOET_EX_NS.'default">'.
            
                $this->_render_message().
                $this->_render_input().
                $this->_render_button().
                    '</div>'.
                $this->_render_response().
                '</div>'.
                $this->_render_open_close_button("close","last").
            '</div>'.
            $this->_render_javascript();
         return $content;
         /*
            <div class="content">
                ? <a class="closebutton"></a>
                <div class="embed">
                    <div class="default" >
                        <div class="message"></div>
                        <div class="subscription-wrapper">
                            <div class="not-filled" style="display:none;"></div>
                            <div class="not-valid-email" style="display:none;"></div>
                            <div class="the-input"></div>
                        </div>
                        <div class="button"></div>
                    </div>
                    <div class="success" style="display:none;">
                    </div>
                    <div class="already-exists" style="display:none;">
                    </div>
                </div>
                ? <a class="closebutton"></a>
            </div>
         */
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

    protected function _render_message(){
        $content = '';
        $content .= '<div class="message">'.$this->_get_message().'</div>';
        return $content;
    }
    protected function _get_message(){
        $message = $this->ex_options->get("message_text")->get_value();
        $message = $this->icl_t_message($message);

        return (!empty($message) 
                    ? (($this->ex_options->get('message_text')->is_formatting_enabled()) ? $this->add_html_formatting($message) : $message) 
                    : '' 
                );
    }
    protected function _render_response(){
        $content = '';
        $success_str = $this->icl_t_message("Check your inbox now to confirm your subscription.","Check your inbox now to confirm your subscription. (for Gc Message Bar)");
        $error_str = $this->icl_t_message("Oops! You're already subscribed.","Oops! You're already subscribed. (for Gc Message Bar)");
        $content .= '<div id="'.GC_MAILPOET_EX_NS.'success" class="success" style="display:none;">'.$success_str.'
                    </div>
                    <div id="'.GC_MAILPOET_EX_NS.'error" class="already-exists" style="display:none;">'.$error_str.'
                    </div>';
        return $content;

    }
    protected function _render_open_close_button($button, $place, $state=null) {
        if ($this->get_bar_option_value('enable_close_button') != self::ON) {
            return '';
        }
        $content = '';
        $request = (array)Gcx_Mailpoet_Ex_CF::create("Request");
        $query = parse_url($this->get_current_url(), PHP_URL_QUERY);
        if (($button == 'open' || $place == 'pre') && $this->get_bar_option_value('button_align') == self::ON) {
            $content .= '<a id="'.$this->namespace.$button.'" class="';
            $content .= 'left ';
            $content = $this->_get_button_classes($content, $state);
            if (!isset($request["data"][$button])) {
                if( $query ) {
                    $url = $this->get_current_url() . '&' . $button;
                }
                else {
                    $url = $this->get_current_url() . '?' . $button;
                }
            } else {
                $url = $this->get_current_url();
            }
            $url = str_replace("open&close", "close", $url);
            $url = str_replace("close&open", "open", $url);
            $content .= '" '.(($this->get_bar_option_value('enable_animation') == self::OFF) ? 'href="'.$url.'"' : '').'><span class="icon"></span></a>';
        }  
        if (($button == 'open' || $place == 'last') && $this->get_bar_option_value('button_align') == self::OFF) {
            $content = '<a id="'.$this->namespace.$button.'" class="';
            $content .= 'right ';
            $content = $this->_get_button_classes($content, $state);
            if (!isset($request["data"][$button])) {
                if( $query ) {
                    $url = $this->get_current_url() . '&' . $button;
                }
                else {
                    $url = $this->get_current_url() . '?' . $button;
                }   
            } else {
                $url = $this->get_current_url();
            }
            $url = str_replace("open&close", "close", $url);
            $url = str_replace("close&open", "open", $url);
            $content .= '" '.(($this->get_bar_option_value('enable_animation') == self::OFF) ? 'href="'.$url.'"' : '').'><span class="icon"></span></a>';
        }
        return $content;
    }
    
    protected function _get_button_classes($content, $state=null) {
        if ($this->get_bar_option_value('close_icon_color') == "1") {
            $content .= 'light ';
        } else {
            $content .= 'dark ';
        }
        if (is_admin_bar_showing()) {
            $content .= 'adminbar ';
        }
        if ($this->get_bar_option_value('location') == "1") {
            $content .= 'top ';
            if ($state == 'closed' && ($this->get_bar_option_value('enable_animation') == self::OFF)) {
                $content .= 'showopentop ';
            }
        } else {
            $content .= 'bottom ';
            if ($state == 'closed' && ($this->get_bar_option_value('enable_animation') == self::OFF)) {
                $content .= 'showopenbottom ';
            }
        }
        return $content;
    }
	protected function _render_input() {
		$content = '';
		$placeholder = $this->ex_options->get('place_holder_text')->get_value('');
		$placeholder = $this->icl_t_message($placeholder,"Placeholder text for Gc Message Bar");
        $error_email_required_str = $this->icl_t_message("Email address is required","Email address is required for Gc Message Bar");
        $error_email_invalid_str = $this->icl_t_message("Invalid email address","Invalid email address for Gc Message Bar");
        $content .='
                        <div class="subscription-wrapper">
                            <div id="'.GC_MAILPOET_EX_NS.'not_filled" class="not-filled" style="display:none;">'.$error_email_required_str.'</div>
                            <div id="'.GC_MAILPOET_EX_NS.'not_valid_email" class="not-valid-email" style="display:none;">'.$error_email_invalid_str.'</div>
                            <div class="the-input"><input type="text" id="'.GC_MAILPOET_EX_NS.'email" name="'.GC_MAILPOET_EX_NAME.'[email]" value="" placeholder="'.$placeholder.'"/></div>
                        </div>';
        return $content;
	}
	protected function _render_button() {
		$content = '';
		$message = $this->ex_options->get('action_button_text')->get_value();
		$message = $this->icl_t_message($message,"Button text for Gc Message Bar");
		if (empty($message)) {
			return '';
		}
		$content .= '<a id="gc_message_bar_button_a" class="button" onclick="return '.$this->namespace.'subscribe_click();">';
		$content .=     '<span id="'.$this->namespace.'button">'.
							'<span id="'.$this->namespace.'buttontext">'.(($this->ex_options->get('action_button_text')->is_formatting_enabled()) ? $this->add_html_formatting($message) : $message).'</span>'.
						'</span>'.
				'</a>';
		return $content;
	}
    protected function _render_javascript(){
        $content ='';
        $metrix_code = $this->get_bar_option_value("metrix_code");
        $metrix_enable =  ($metrix_code!= "");        
        $content .= '<script type="text/javascript">
        function '.$this->namespace.'subscribe_click(e){
            var params = { '.GC_MAILPOET_EX_NS.'type:"gc_message_bar" };
            var error_not_filled = jQuery("#'.GC_MAILPOET_EX_NS.'not_filled");
            var error_not_valid_email = jQuery("#'.GC_MAILPOET_EX_NS.'not_valid_email");
            error_not_filled.hide();
            error_not_valid_email.hide();
            var email = jQuery("#'.GC_MAILPOET_EX_NS.'email").val();
            var validation_error = false;
            if(email == ""){
                error_not_filled.show();
                validation_error = true;
                return false;
            }
            var regex= /^((([a-z]|\\d|[!#\\$%&\'\\*\\+\\-\\/=\\?\\^_`{\\|}~]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])+(\\.([a-z]|\\d|[!#\\$%&\'\\*\\+\\-\\/=\\?\\^_`{\\|}~]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])+)*)|((\\x22)((((\\x20|\\x09)*(\\x0d\\x0a))?(\\x20|\\x09)+)?(([\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x7f]|\\x21|[\\x23-\\x5b]|[\\x5d-\\x7e]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])|(\\\\([\\x01-\\x09\\x0b\\x0c\\x0d-\\x7f]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF]))))*(((\\x20|\\x09)*(\\x0d\\x0a))?(\\x20|\\x09)+)?(\\x22)))@((([a-z]|\\d|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])|(([a-z]|\\d|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])([a-z]|\\d|-|\\.|_|~|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])*([a-z]|\\d|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])))\\.)+(([a-z]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])|(([a-z]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])([a-z]|\\d|-|\\.|_|~|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])*([a-z]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])))\\.?$/i;
            if(!email.match(regex)){
                error_not_valid_email.show();
                validation_error = true;
            } else{
                params.'.GC_MAILPOET_EX_NS.'email = email;
            }
            if(validation_error){
                return false;
            }
            jQuery.get("'.$this->get_current_url().'",params,function(e){
                if(e.type == undefined){
                    return;
                }
                var message = jQuery("#'.GC_MAILPOET_EX_NS.'default");
                message.hide();
                if(e.type == "success"){
                    var response = jQuery("#'.GC_MAILPOET_EX_NS.'success");
                    response.show();
                    ';
        if($metrix_enable){

            $content .= '
                    if(MXTracker == undefined){
                        return
                    }
                    MXTracker.trackClick("'.$metrix_code.'");
            ';

        }
        $content .= '                    
                    return;
                }
                if(e.type == "error"){
                    var response = jQuery("#'.GC_MAILPOET_EX_NS.'error");
                    response.show();
                    return;
                }
            });
        }
        </script>';
        return $content;
    }
    protected function get_options_repository(){
    	if(is_null($this->options_repository )){
    		$this->options_repository = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_OPTION_REPOSITORY);
    	}
    	return $this->options_repository;
    }
    protected function get_bar_option($name) {
    	return $this->bar_options->get($name);
    }
    protected function get_bar_option_value($name) {
    	return $this->get_bar_option($name)->get_value();
    }
    protected function add_html_formatting($text) {
        $text = preg_replace('/&lt;b&gt;(.*?)&lt;\/b&gt;/i', '<b>${1}</b>', $text);
        $text = preg_replace('/&lt;s&gt;(.*?)&lt;\/s&gt;/i', '<s>${1}</s>', $text);
        $text = preg_replace('/&lt;i&gt;(.*?)&lt;\/i&gt;/i', '<i>${1}</i>', $text);
        $text = preg_replace('/&lt;u&gt;(.*?)&lt;\/u&gt;/i', '<u>${1}</u>', $text);
        return $text;
    }
    protected function icl_t_message($message,$key = 'Message Text for GC Message Bar'){
        if (!function_exists("icl_register_string")) {
        	return $message;
        }
        icl_register_string('plugin gc-mailpoet-ex', $key, $message);
        return icl_t('plugin gc-mailpoet-ex', $key, $message);

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
}
