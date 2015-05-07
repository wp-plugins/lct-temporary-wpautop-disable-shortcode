<?php /*
Plugin Name: LCT Temporary wpautop Disable Shortcode
Plugin URI: http://lookclassy.com/wordpress-plugins/temporary-wpautop-disable/
Version: 4.2.2
Text Domain: lct-temporary-wpautop-disable
Author: Look Classy Technologies
Author URI: http://lookclassy.com/
License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
Description: Use a simple shortcode to bypass the sometimes damaging effect of the wpautop function.
Also Available in lct-useful-shortcodes-functions
Copyright 2014 Look Classy Technologies  (email : info@lookclassy.com)
*/

/*
Copyright (C) 2014 Look Classy Technologies

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


//PLUGIN PREFIX: ltwd


if( ! class_exists( 'g_ltwd' ) ) {
	class g_ltwd {
		public $editzz						= 'editzz';
		public $pre							= 'ltwd_';
		public $lct_dash					= 'lct-temporary-wpautop-disable';
		public $lct_us						= 'lct_temporary_wpautop_disable';

		public function __construct() {
			$this->plugin_file				= __FILE__;
			$this->plugin_dir_url			= plugin_dir_url( __FILE__ );
			$this->plugin_dir_path			= plugin_dir_path( __FILE__ );
		}
	}
}


if( ! function_exists( 'is_plugin_active' ) ) { include_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
if( ! is_plugin_active( 'lct-useful-shortcodes-functions/lct-useful-shortcodes-functions.php' ) ) {
	//Globals
	$g_ltwd = new g_ltwd;


	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
	add_filter( 'the_content', 'lct_temporary_wpautop_disable', 99 );
	function lct_temporary_wpautop_disable( $content ) {
		$new_content = '';
		$pattern_full = '{(\[raw\].*?\[/raw\])}is';
		$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
		$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

		foreach( $pieces as $piece ) {
			if( preg_match( $pattern_contents, $piece, $matches ) ) {
				$new_content .= $matches[1];
			} else {
				$new_content .= wptexturize( wpautop( $piece ) );
			}
		}

		$new_content = str_replace( array( "[raw]", "[/raw]" ), "", $new_content );

		return $new_content;
	}
}
