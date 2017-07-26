<?php
if(class_exists("Gc_Mailpoet_Ex_Options_Plugin_Container_Renderer")){
	return;
}
class Gc_Mailpoet_Ex_Options_Plugin_Container_Renderer extends Gcx_Mailpoet_Ex_Options_Group_Container_Renderer{
    protected  $required = array();
    public function __construct($group_descriptor,$items,$namespace){
	   parent::__construct($group_descriptor,$items,$namespace);
        $this->repository = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_OPTION_REPOSITORY);
        $this->options = $this->repository->get_single_params();
        $this->state_option = $this->options->get_parameter("general-group");
        $this->required = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_REQUIRED);
    }

    public function render($gci) {
        $this->on_before_render();
        $this->custom_render(array());
        $this->on_after_render();
    }


   	public function custom_render($items){
        $required = $this->required;
        ?>
                <div class="blocklabel">
                    <?php if(isset($required["wysija-newsletters/index.php"]) and $required["wysija-newsletters/index.php"]["Available"] and is_plugin_active("wysija-newsletters/index.php")): ?>                   
                    <h2>This is an extension plugin. Setting panels are added / replaced on your GetConversion plugins</h2>
                    <?php else: ?>
                    <h2 class="alert">MailPoet plugin is required</h2>
                    <?php endif; ?>
                </div>
                <?php foreach($required as $key => $plugin) : 
                ?>
                <div class="blockitem">
                    <div class="onoff">
                    <?php if($plugin['Available'] and is_plugin_active($key)): ?>

                        <?php if ($plugin["onoff"] and $option = $this->options->get_parameter(str_replace(".","_",str_replace("/","_",$key)))) : 
                        //var_dump($option);
                        ?>
                        <div class="edit">

                            <a href="#" class="<?php if($option->get_value() == "1"){ echo "on";}else{ echo "off";}?>" onclick="return Gc.Onoff_Button_On_Click(this,'<?php echo $option->get_unique_name();?>')" id="<?php echo $option->get_unique_name();?>_a"><?php if($option->get_value() == "1"){ echo "<span>ON</span><b></b>";}else{ echo "<b></b><span>OFF</span>";}?><div class="clear"></div></a>
                            <input type="hidden" name="post[<?php echo $option->get_unique_name();?>]" value="<?php echo $option->get_value();?>" id="<?php echo $option->get_unique_name().'_input';?>"/>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    </div>
                    <div class="label">
                        <b><?php echo $plugin["Name"];?></b>
                    <?php if($plugin['Available']): ?>
                        <i><?php echo $plugin["Desc"];?></i>
                    <?php else: ?>
                        <i>Plugin is not installed</i>
                    <?php endif; ?>
                    </div>

                    
                    <?php if(($plugin['Available'])): ?>
                        <?php if($plugin["InstalledVersion"] < $plugin["Version"] ) : ?>
                        <div class="required_label">
                            <i>Required</i>
                            <b><?php echo $plugin["Version"]; ?></b>
                        </div>
                        <div class="installed_label">
                            <i>Installed</i>
                            <b><?php echo $plugin["InstalledVersion"];?></b>
                        </div>
                        <div class="indicator">
                            <div class="inactive"><a target="_blank" href="<?php echo  get_admin_url()."plugins.php";?>">Update</a></div>
                            <div class="inactive_desc">Higher version required</div>
                        </div>
                        <?php else: ?>
                        <?php if(isset($plugin["InstalledVersion"])) : ?>
                        <div class="required_label">
                            <i>Required</i>
                            <b><?php echo $plugin["Version"]; ?></b>
                        </div>
                        <div class="installed_label">
                            <i>Installed</i>
                            <b><?php echo $required[$key]["InstalledVersion"];?></b>
                        </div>
                        <?php endif; ?>
                        <?php if(is_plugin_active($key)): ?>
                        <div class="indicator">
                            <div class="active_label">Active</div>
                        </div>
                        <?php else: ?>
                        <div class="indicator">
                            <div class="inactive"><a target="_blank" href="<?php echo  get_admin_url()."plugins.php";?>">Activate</a></div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                    <div class="required_label">
                            <i>Required</i>
                            <b><?php echo $plugin["Version"]; ?></b>
                        </div>
                        <div class="installed_label">
                            <i>Installed</i>
                            <b>-</b>
                        </div>
                        <div class="indicator">
                            <?php /* echo $plugin["Download"]; */ ?>
                            <div class="inactive"><a target="_blank" href="<?php echo get_admin_url()."plugin-install.php?".$plugin["Search"];?>">Install</a></div>
                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
                <?php endforeach; ?>
        <?php
   	}

    public function render_item($key,$description,$counter) { }

}

