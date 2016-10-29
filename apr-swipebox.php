<?php
/*
  Plugin Name: APR Swipebox
  Plugin URI: http://alexrusin.com
  Description: A simple plugin that integrates JQuery Swipebox plugin into WordPress.
  Version: 0.1
  Author: Alex Rusin
  Author URI: http://alexrusin.com
  License: GPL2
  Text Domain: apr-swipebox
 */

/*  @2016  Alex Rusin (email : alex@alexrusin.com)

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

    //Exit if accessed directly
if(!defined('ABSPATH')){
    exit;
}

function apr_load_textdomain() {
   load_plugin_textdomain( 'apr-swipebox', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
   
}
add_action( 'init', 'apr_load_textdomain' );






function apr_swipe_enqueue_scripts(){
	wp_enqueue_style( 'apr-swipebox-css', plugins_url( 'src/css/swipebox.min.css', __FILE__ ) );
	wp_enqueue_script( 'apr-swipebox', plugin_dir_url( __FILE__ ) . 'src/js/jquery.swipebox.min.js', array('jquery'), '10262016', true );
	wp_enqueue_script( 'apr-swipebox-controls', plugin_dir_url( __FILE__ ) . 'src/js/swipebox-controls.js', array('apr-swipebox'), '10262016', true );

    $swipebox_options = get_option('apr_swipebox');
    if (gettype($swipebox_options)!='array'){
        $swipebox_options=array();
    }

        if(isset($swipebox_options) && !empty($swipebox_options)){
            $swipebox_options['delay_time'] = (int)$swipebox_options['delay_time'];
            $swipebox_options['video_max_width'] = (int)$swipebox_options['video_max_width'];
            $swipebox_options['hide_close'] = ($swipebox_options['hide_close'] ==='true') ? true : false;
            $swipebox_options['top_bar'] = ($swipebox_options['top_bar'] ==='true') ? true : false;
        } else {
            $swipebox_options = array(
                'delay_time' => 3000,
                'video_max_width' => 1140,
                'hide_close' => false,
                'top_bar'  => true
             );
        }
    wp_localize_script('apr-swipebox-controls', 'SWIPE_CONTROLS', $swipebox_options);
}

add_action('wp_enqueue_scripts','apr_swipe_enqueue_scripts' );


require_once 'settings-page.php';

function apr_swipebox_add_settings_link( $links ) {
$url = get_admin_url() . 'options-general.php?page=apr_swipebox';
    $settings_link = '<a href="' . $url . '">' . __('Settings', 'apr-swipebox') . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}

 add_filter( 'plugin_action_links_'. plugin_basename( __FILE__ ), 'apr_swipebox_add_settings_link' );
