<?php
if(class_exists("Gcx_Mailpoet_Ex_Fonttype_Select_Renderer")){
    return;
}

class Gcx_Mailpoet_Ex_Fonttype_Select_Renderer extends Gcx_Mailpoet_Ex_Abstract_Renderer{
    public function __construct(){

    }

    public function render($description) {
        ?>
        <div class="item selectbox <?php /* echo $this->get_descriptor_param("css_class"); */ ?>" id="<?php echo $description->get_unique_name(); ?>_cnt" <?php if(!$description->is_visible()){ echo 'style="display:none"';}?>>
            <div class="label">
                <label><?php echo $description->get_text(); ?></label>
            </div>
            <div class="edit chkbx">                
                <select id="<?php echo $description->get_unique_name(); ?>_input" name="post[<?php echo $description->get_unique_name(); ?>]" class="def">
                    <?php foreach($description->get_options() as $value => $text) : ?>
                    <option <?php if($description->get_value() == $value) echo "selected=\"selected\""; ?> value="<?php echo $value;?>" data-text='<span style="font-family: <?php echo $value;?>"><?php echo $text;?></span>'><?php echo __($text) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($description->get_description()) { ?>
            <div class="desc">
                <label><?php echo $description->get_description(); ?></label>
            </div>
            <?php } ?>
            <div class="clear"></div>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery("#<?php echo $description->get_unique_name();?>_input").selectBoxIt();
                })
            </script>
        </div>
        <?php
    }

}
