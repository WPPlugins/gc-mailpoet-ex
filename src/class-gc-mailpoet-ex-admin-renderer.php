<?php
if(class_exists("Gc_Mailpoet_Ex_Admin_Renderer")){
    return;
}
class Gc_Mailpoet_Ex_Admin_Renderer extends Gcx_Mailpoet_Ex_Abstract_Renderer{
    protected $options;
    protected $multi_options;
    protected $repository = null;
    protected $themes_repo;
    protected $event_manager = null;


    public function __construct($namespace, $controller){
        parent::__construct($namespace,$controller);
        $this->repository = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_OPTION_REPOSITORY);
        $this->options = $this->repository->get_single_params();
        $this->event_manager = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_EVENT_MANAGER);
        $this->initialize();        
	}
    public function initialize(){
        $this->event_manager->listen(GC_MAILPOET_EX_NAME.".render_section",array($this,"on_render_section"));
    }

	public function render($gci) {

        $config = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_CONFIG);
?>
<div class="clear"></div>
<section class="GCPLUGIN">
    <div class="wrapper820">
        <div class="adminpanel">
            <header>
                <div class="headertop">
                    <div class="logo"></div>
                </div>
                <nav>
                    <ul class="menu1">
                        <li class="first"><a href="<?php echo $config['GCFORUM']; ?>" target="_blank"><b>Forum</b></a></li>
                        <li><a href="<?php echo $config['GCIDEA']; ?>" target="_blank">Suggest an <b>Idea</b></a></li>
                        <li><a href="<?php echo $config['GCBUG']; ?>" target="_blank">Report a <b>Bug</b></a></li>
                        <div class="clear"></div>
                    </ul>
                    <ul class="menu2">
                        <li class="first"><a href="<?php echo $config['WPORGURL']; ?>" target="_blank">Support us by giving &#9733;&#9733;&#9733;&#9733;&#9733; rating on wordpress.org</a></li>
                        <div class="clear"></div>
                    </ul>
                    <div class="clear"></div>
                </nav>
            </header>
            <section class="newprodmsg">
                <iframe src="<?php echo $config['GCSERVICES']; ?>/gc-mailpoet-ex/buy" width="818" height="280"></iframe>
            </section>
            <form method="post" id="updateSettings">
                <?php 
                $admin_layout = Gcx_Mailpoet_Ex_Service_Locator::get(GC_MAILPOET_EX_SL_LAYOUT_CONFIG);
                foreach($admin_layout as $container){
                    $this->event_manager->dispatch(GC_MAILPOET_EX_NAME.".render_section",new Gcx_Mailpoet_Ex_Event($container));
                }
                ?>
            </form>
            
            <footer>
                <nav>
                    <ul class="menu1">
                        <li class="first"><a href="<?php echo $config['GCFORUM']; ?>" target="_blank">Ask on <b>Forum</b></a></li>
                        <li><a href="<?php echo $config['GCROADMAP']; ?>" target="_blank">Vote for <b>Roadmap</b></a></li>
                        <li><a href="<?php echo $config['GCIDEA']; ?>" target="_blank">Suggest an <b>Idea</b></a></li>
                        <li><a href="<?php echo $config['GCBUG']; ?>" target="_blank">Report a <b>Bug</b></a></li>
                        <div class="clear"></div>
                    </ul>
                    <ul class="menu2">
                        <li class="first"><a href="<?php echo $config['WPORGURL']; ?>" target="_blank">Support us by giving &#9733;&#9733;&#9733;&#9733;&#9733; rating on wordpress.org</a></li>
                        <div class="clear"></div>
                    </ul>
                    <div class="clear"></div>
                </nav>
                <div class="metainfo">
                    <div class="metablock">
                        <div class="gcpversion">Version: <?php echo Gcx_Mailpoet_Ex_Util::get_version() ?> <?php if($config['GCTYPE'] == 'DEV'): ?>DEVELOPMENT<?php endif; ?></div>
                        <?php /*
                        <div class="gcpengine">
                            <a href="#" id="engine_switcher">Show/Hide Engine Settings</a>                            
                        </div>
                        */ ?>
                    </div>
                    <div class="copyblock">
                        <div class="copytxt"><a href="<?php echo $config['GCPLUGINHOME']; ?>" target="_blank">GC MailPoet EX</a> by</div>
                        <div class="copylogo"><a href="<?php echo $config['GCHOME']; ?>" target="_blank" class="gclogo">GetConversion</a></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </footer>
        </div>
        <form method="post">
            <?php
                $renderer_name = "Gc_Mailpoet_Ex_Options_Engine_Group_Container_Renderer";
                $container =  array(
                    "title" => "Engine",
                    "id"    => "engine-settings",
                    "option_group" => "internal_engine",
                );
                $cnt = new $renderer_name(Gcx_Mailpoet_Ex_CF::create_and_init("Option_Group",$container),$this->options->filter_by_group($container["option_group"]),$this->namespace);
                $cnt->render(array());
            ?>
        <input type="hidden" name="<?php echo $this->namespace.'engine';?>" value="true"/>
        </form>

    </div>
</section>
<div style="clear:both;"></div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#engine_switcher").click(function() {
            enginepanel_close();
            return false;
        });
        
        jQuery("#engine_settings_a").click(function() {
            enginepanel_close();
            return false;
        });
    }); 

    function enginepanel_close() {
        jQuery('.enginepanel').toggle();
        Gc.Option_Group_On_Click(this,'engine-settings');
    }
</script>

    <?php
	}
    public function on_render_section($event){
        $container = $event->get_params();
        if(isset($container["renderer"])){
            $renderer_name = $container["renderer"];
        }else{
            $renderer_name = "Gcx_Mailpoet_Ex_Options_Group_Container_Renderer";
        }
        $cnt = new $renderer_name(Gcx_Mailpoet_Ex_CF::create_and_init("Option_Group",$container),$this->options->filter_by_group($container["option_group"]),$this->namespace);
        $cnt->render(array());
    }


}