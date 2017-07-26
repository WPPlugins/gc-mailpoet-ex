<?php
if(class_exists("Gc_Mailpoet_Ex_Options_Compose_Container_Renderer")){
	return;
}
class Gc_Mailpoet_Ex_Options_Compose_Container_Renderer extends Gcx_Mailpoet_Ex_Options_Group_Container_Renderer{
    public function __construct($group_descriptor,$items,$namespace){
	   parent::__construct($group_descriptor,$items,$namespace);
    }

    public function render($gci) {
        $this->on_before_render();
        $this->custom_render($this->items);
        $this->on_after_render();
    }

	public function group_header_render(){ 
        global $GC_MailPoet_Ex_Config;
        $group_id = $this->group_descriptor->get_id();
        $extra_params = $this->group_descriptor->get_extra_param();
        if(!isset($extra_params["group_state"])){
            $state_option = $this->state_option;
        }else{
            $state_option = $extra_params["group_state"];
        }
        if(!isset($extra_params["parent_name"])){
            $parent_name = "";
        }else{
            $parent_name = "/".$extra_params["parent_name"];
        }

        ?>
        <a name="<?php echo $group_id; ?>"></a>
        <section class="adminblock INT_GC_MAILPOET_EX" id="<?php echo $group_id;?>">
            <section class="blockheader">
                <a href="#" onClick="return Gc.Option_Group_On_Click(this,'<?php echo $group_id;?>');" class="opener <?php echo $state_option->get_value();?>" id="<?php echo $group_id.'_a';?>">
                    <span></span><h2><?php echo $this->group_descriptor->get_title();?></h2>
                    <b><?php echo _('Show / hide panel');?></b>
                    <div class="clear"></div>
                </a>
                <div class="ad">
                    <div class="mailpoetblock">
                        <div class="extensionblock">
                            <div class="extension_logo"></div>
                        </div>
                        <a href="<?php echo $GC_MailPoet_Ex_Config['GCSERVICES'].$parent_name; ?>/mailpoet" target="_blank">
                            <i>Compatible with</i>
                            <b></b>
                            <div class="clear"></div>
                        </a>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </section>
            <section class="blockcnt" id="<?php echo $group_id."_body";?>" <?php if($state_option->get_value() == "close"){ echo 'style="display:none;"';}?>>
        <?php
	}

   	public function custom_render($items){
       $this->init_mailpoet_lists($items);
        ?>
        <div class="composemessage leadgen">
            <div class="label">
                <label><?php echo $items['message_text']->get_text(); ?> <i>/ <?php echo $items['message_text']->get_description(); ?></i></label>
            </div>
            <div class="edit">
                <div class="msgtxt"><input type="text" id="<?php echo $items['message_text']->get_unique_name(); ?>" name="post[<?php echo $items['message_text']->get_unique_name(); ?>]" value="<?php echo $items['message_text']->get_value(); ?>" /></div>
                <div class="msgtxt_counter" id="<?php echo $items['message_text']->get_unique_name(); ?>_counter">0</div>
                <div class="clear"></div>
            </div>
            <div class="leftcol">
                <div class="label">
                    <label><?php echo $items['place_holder_text']->get_text(); ?> <i>/ <?php echo $items['place_holder_text']->get_description(); ?></i></label>
                </div>
                <div class="edit">
                    <div class="phtxt"><input type="text" id="<?php echo $items['place_holder_text']->get_unique_name(); ?>" name="post[<?php echo $items['place_holder_text']->get_unique_name(); ?>]" value="<?php echo $items['place_holder_text']->get_value(); ?>" /></div>
                    <div class="phtxt_counter" id="<?php echo $items['place_holder_text']->get_unique_name(); ?>_counter">0</div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="rightcol">
                <div class="label">
                    <label><?php echo $items['action_button_text']->get_text(); ?> <i>/ <?php echo $items['action_button_text']->get_description(); ?></i></label>
                </div>
                <div class="edit">
                    <div class="btntxt"><input type="text" id="<?php echo $items['action_button_text']->get_unique_name(); ?>" name="post[<?php echo $items['action_button_text']->get_unique_name(); ?>]" value="<?php echo $items['action_button_text']->get_value(); ?>" /></div>
                    <div class="btntxt_counter" id="<?php echo $items['action_button_text']->get_unique_name(); ?>_counter">0</div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="ex_item" id="<?php echo $items['lists']->get_unique_name(); ?>_cnt" <?php if(!$items['lists']->is_visible()){ echo 'style="display:none"';}?>>
                <div class="label">
                    <label><?php echo $items['lists']->get_text(); ?> <i>/ <?php echo $items['lists']->get_description(); ?></i></label>
                </div>
                <div class="edit select">
                <?php if(count($items['lists']->get_options())): ?>
                    <select id="<?php echo $items['lists']->get_unique_name(); ?>_input" name="post[<?php echo $items['lists']->get_unique_name(); ?>]" class="def">
                        
                        <?php foreach($items['lists']->get_options() as $value => $text) : ?>
                        <option <?php if($items['lists']->get_value() == $value) echo "selected=\"selected\""; ?> value="<?php echo $value;?>"><?php echo __($text) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <div class="nolist">No list is available. Add a list with MailPoet plugin to use this function</div>
                <?php endif; ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="alldesc"><?php echo _('You may use these HTML tags: &lt;b&gt;<b>bold</b>&lt;/b&gt;, &lt;i&gt;<i>italic</i>&lt;/i&gt;, &lt;u&gt;<u>underline</u>&lt;/u&gt;, &lt;s&gt;<s>strike</s>&lt;/s&gt;'); ?></div>

            <?php /*  <br/>In case the Message Text or Action Button Text field is empty, the Message or the Action Button will not appear */ ?>
        </div>
        <?php /*
        <div class="itemgroup before-itemgroup">
            <h3>Notifications and error messages</h3>
            <div class="ex_item">
                <div class="label">
                    <label><?php echo $items['notice_success']->get_text(); ?> <i>/ <?php echo $items['notice_success']->get_description(); ?></i></label>
                </div>
                <div class="edit">
                    <div class="txt"><input type="text" id="<?php echo $items['notice_success']->get_unique_name(); ?>" name="post[<?php echo $items['notice_success']->get_unique_name(); ?>]" value="<?php echo $items['notice_success']->get_value(); ?>" /></div>
                </div>
            </div>
            <div class="ex_item">
                <div class="label">
                    <label><?php echo $items['notice_already_exists']->get_text(); ?> <i>/ <?php echo $items['notice_already_exists']->get_description(); ?></i></label>
                </div>
                <div class="edit">
                    <div class="txt"><input type="text" id="<?php echo $items['notice_already_exists']->get_unique_name(); ?>" name="post[<?php echo $items['notice_already_exists']->get_unique_name(); ?>]" value="<?php echo $items['notice_already_exists']->get_value(); ?>" /></div>
                </div>
            </div>
            <div class="ex_item">
                <div class="label">
                    <label><?php echo $items['notice_empty_data']->get_text(); ?> <i>/ <?php echo $items['notice_empty_data']->get_description(); ?></i></label>
                </div>
                <div class="edit">
                    <div class="txt"><input type="text" id="<?php echo $items['notice_empty_data']->get_unique_name(); ?>" name="post[<?php echo $items['notice_empty_data']->get_unique_name(); ?>]" value="<?php echo $items['notice_empty_data']->get_value(); ?>" /></div>
                </div>
            </div>
            <div class="ex_item">
                <div class="label">
                    <label><?php echo $items['notice_not_valid']->get_text(); ?> <i>/ <?php echo $items['notice_not_valid']->get_description(); ?></i></label>
                </div>
                <div class="edit">
                    <div class="txt"><input type="text" id="<?php echo $items['notice_not_valid']->get_unique_name(); ?>" name="post[<?php echo $items['notice_not_valid']->get_unique_name(); ?>]" value="<?php echo $items['notice_not_valid']->get_value(); ?>" /></div>
                </div>
            </div>
        </div>
        */ ?>
        <script type="text/javascript">
           jQuery(document).ready(function(){
                Gc.Input_Type_Text_Character_Counter('<?php echo $items['message_text']->get_unique_name(); ?>','<?php echo $items['message_text']->get_unique_name(); ?>_counter');
                Gc.Input_Type_Text_Character_Counter('<?php echo $items['place_holder_text']->get_unique_name(); ?>','<?php echo $items['place_holder_text']->get_unique_name(); ?>_counter');
                Gc.Input_Type_Text_Character_Counter('<?php echo $items['action_button_text']->get_unique_name(); ?>','<?php echo $items['action_button_text']->get_unique_name(); ?>_counter');
                jQuery("#<?php echo $items['message_text']->get_unique_name(); ?>").trigger("keyup");
                jQuery("#<?php echo $items['place_holder_text']->get_unique_name(); ?>").trigger("keyup");
                jQuery("#<?php echo $items['action_button_text']->get_unique_name(); ?>").trigger("keyup");
            });
        </script>
        <?php
   	}
    public function init_mailpoet_lists($items){
        $modelLIST=WYSIJA::get('list','model');
        $results=$modelLIST->getLists();
        $list_option = $items['lists'];
        $options = array();
        foreach ($results as $value) {
            $options[$value["list_id"]] = $value['name'];
        }
        $list_option->set_options($options);
    }
    public function group_footer_render(){ 
        $group_id = $this->group_descriptor->get_id();
        $extra_params = $this->group_descriptor->get_extra_param();
        if(!isset($extra_params["group_state"])){
            $state_option = $this->state_option;
        }else{
            $state_option = $extra_params["group_state"];
        }
        ?>
            </section>
            <section class="blockfooter" id="<?php echo $group_id."_footer";?>" <?php if($state_option->get_value() == "close"){ echo 'style="display:none;"';}?>>
                <input type="submit" value="<?php echo _('Save');?>" onClick="return Gc.Save_Button_On_Click('<?php echo $group_id;?>');" class="savebutton" name="<?php echo (isset($extra_params['parent_namespace']) ? $extra_params['parent_namespace'] : $this->namespace);?>submit"/>
            </section>
            </footer>
        </section>
        <?php
    }

    public function render_item($key,$description,$counter) { }

}

