<?php
/*
Plugin Name: GC MailPoet EX
Version: 1.0.9
Plugin URI: http://wordpress.org/plugins/gc-mailpoet-ex
Description: GC MailPoet EX is an easy to use extension that allows you to convert your visitors to email subscribers with 1-click
Author: GetConversion
Author URI: http://getconversion.com
License: GPL2
*/

/*  Copyright 2014  eRise Hungary Ltd.  (email : info@getconversion.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


require_once( plugin_dir_path( __FILE__ ) . 'default.php');
require_once( plugin_dir_path( __FILE__ ) . 'init-constants.php');
require_once( plugin_dir_path( __FILE__ ) . 'init-gc.php');
require_once( plugin_dir_path( __FILE__ ) . 'init-options.php');
require_once( plugin_dir_path( __FILE__ ) . 'admin-layout-gc-mailpoet-ex.php');
require_once( plugin_dir_path( __FILE__ ) . 'init-mailpoet-ex.php');

Gcx_Mailpoet_Ex_Util::initialize(__FILE__,GC_MAILPOET_EX_NAME,GC_MAILPOET_EX_TYPE);

$p = new Gcx_Mailpoet_Ex_Plugin();
$p->add_admin_controller(new Gc_Mailpoet_Ex_Admin_Controller(GC_MAILPOET_EX_NS))
       ->add_controller(new Gc_Mailpoet_Ex_Controller(GC_MAILPOET_EX_NS))
       ->run();
