<?php
global $gc_mailpoet_ex_options_singleton;
$gc_mailpoet_ex_options_singleton = array(
            'installed' => array(
                'id' => 'installed',
                'default' => "false",
                'text' => 'Plugin installed',
                'type' => 'text',
                'group' => 'general',
                'visible' => false
            ),
            'general-group' => array(
                'id' => 'general-group',
                'default' => "open",
                'text' => 'Extension Settings Panel State',
                'type' => 'text',
                'group' => 'group_state',
                'visible' => false
            ),
            'engine-settings-group' => array(
                'id' => 'engine-settings-group',
                'default' => "close",
                'text' => 'Engine Settings Panel State',
                'type' => 'text',
                'group' => 'group_state',
                'visible' => false
            ),
            'gc-message-bar-group' => array(
                'id' => 'gc-message-bar-group',
                'default' => "open",
                'text' => 'Gc Message Bar Panel State',
                'type' => 'text',
                'group' => 'group_state',
                'visible' => false
            ),
            'gc-message-box-group' => array(
                'id' => 'gc-message-box-group',
                'default' => "open",
                'text' => 'Gc Message Box Panel State',
                'type' => 'text',
                'group' => 'group_state',
                'visible' => false
            ),
            'enable_remote_configuration' => array(
                'id' => 'enable_remote_configuration',
                'default' =>2,
                'text' => 'Enable remote configuration:',
                'type' => 'onoff',
                'group' => 'general',
                'visible' => true,
                'description' => 'Enable connect to MY.GetConversion'
            ),
            'gc-mailpoet-ex_main_php' => array(
                'id' => 'gc-mailpoet-ex_main_php',
                'default' => 1,
                'text' => 'GC Mailpoet EX (extension)',                
                'description' => 'Turn ON to activate extension',
                'type' => 'onoff',
                'group' => 'general',
                'visible' => true
            ),
            'gc-message-bar_main_php' => array(
                'id' => 'gc-message-bar_main_php',
                'default' => 1,
                'text' => 'GC Message Bar',
                'description' => 'Turn ON to activate for GC Message Bar',
                'type' => 'onoff',
                'group' => 'general',
                'visible' => true
            ),
            'gc-message-box_main_php' => array(
                'id' => 'gc-message-box_main_php',
                'default' => 1,
                'text' => 'GC Message Box',
                'description' => 'Turn ON to activate for GC Message Box',
                'type' => 'onoff',
                'group' => 'general',
                'visible' => true
            ),

        );
global $gc_mailpoet_ex_options;
$gc_mailpoet_ex_options = array(
            /*
             * COMPOSE
             */
            'action_button_text' => array(
                'id' => 'action_button_text',
                'default' =>'Subscribe',
                'text' => 'Action Button Text',
                'formatting' => true,
                'type' => 'text',
                'group' => 'compose',
                'visible' => true,
                'description' => 'Recommended max length: 24 characters'
                ),
            'message_text' => array(
                'id' => 'message_text',
                'default' =>'Subscribe to my first newsletter',
                'text' => 'Message Text',
                'type' => 'textarea',
                'formatting' => true,
                'group' => 'compose',
                'visible' => true,
                'description' => 'Recommended max length: 78 characters'
            ),
            'place_holder_text' => array(
                'id' => 'place_holder_text',
                'default' =>'Email address',
                'text' => 'Placeholder Text',
                'type' => 'textarea',
                'formatting' => true,
                'group' => 'compose',
                'visible' => true,
                'description' => 'Recommended max length: 24 characters'
            ),
            'lists' => array(
                'id' => 'lists',
                'default' =>'2',
                'text' => 'MailPoet list',
                'type' => 'select',
                'visible' => true,
                'options' => array(
                ),
                'group' => 'compose',
                'description' => 'Select the target list'
            ),
            'input_background_color' => array(
                'id' => 'input_background_color',
                'default' =>'#ffffff',
                'text' => 'Input Background Color:',
                'type' => 'color',
                'visible' => true,
                'group' => 'style'
            ),
            'input_border_color' => array(
                'id' => 'input_border_color',
                'default' =>'#00709f',
                'text' => 'Input Border Color:',
                'type' => 'color',
                'visible' => true,
                'group' => 'style'
            ),
            'input_text_color' => array(
                'id' => 'input_text_color',
                'default' =>'#555555',
                'text' => 'Input Text Color:',
                'type' => 'color',
                'visible' => true,
                'group' => 'style'
            ),
            'input_placeholder_color' => array(
                'id' => 'input_placeholder_color',
                'default' =>'#cccccc',
                'text' => 'Input Placeholder Color:',
                'type' => 'color',
                'visible' => true,
                'group' => 'style'
            ),


        );
global $gc_mailpoet_ex_required;
$gc_mailpoet_ex_required = array(            
            "gc-mailpoet-ex/main.php" => array(
                "onoff" => true, 
                "Name" => "GC Mailpoet EX (extension)", 
                "Desc" => "Turn ON to activate this extension", 
                "Download" => "",
                "Version" => "",
                "Available" => false
            ),
            "wysija-newsletters/index.php"  => array(
                "onoff" => false, 
                "Name" => "MailPoet", 
                "Desc" => "MailPoet plugin is required", 
                "Version" => "2.5.9.3",
                "Search"  => 'tab=search&s='.urlencode('"wysija-newsletters"').'&plugin-search-input=Search Plugins',
                "Download" => "http://downloads.wordpress.org/plugin/wysija-newsletters.zip",
                "Available" => false
            ),
            "gc-message-bar/main.php" => array(
                "onoff" => true, 
                "Name" => "GC Message Bar", 
                "Desc" => "Turn ON to activate on GC Message Bar", 
                "Version" => "2.3.0",
                "Search" => 'tab=search&s='.urlencode('"GC Message Bar"').'&plugin-search-input=Search Plugins',
                "Download" => "http://downloads.wordpress.org/plugin/gc-message-bar.zip",
                "Available" => false
            ),
            "gc-message-box/main.php" => array(
                "onoff" => true, 
                "Name" => "GC Message Box", 
                "Desc" => "Turn ON to activate on GC Message Box", 
                "Version" => "2.3.0",
                "Search" => 'tab=search&s='.urlencode('"GC Message Box"').'&plugin-search-input=Search Plugins',
                "Download" => "http://downloads.wordpress.org/plugin/gc-message-box.zip",
                "Available" => false
            ),
        );