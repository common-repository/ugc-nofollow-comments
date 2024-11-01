<?php
/*
  Plugin Name: UGC NoFollow Comments
  Description: This plugin is used to add "ugc" and "nofollow" in "rel" attribute in external links in comments section.
  Author: Aftab Muni
  Version: 1.0
  Author URI: https://aftabmuni.com/
 */

/*
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
 */

define('AMM_UGCNFC_VERSION', '1.0');
define('AMM_UGCNFC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AMM_UGCNFC_DONATE_LINK', 'https://www.paypal.me/aftabmuni');

function amm_ugcnfc_activate_plugin(){}
register_activation_hook(__FILE__, 'amm_ugcnfc_activate_plugin');

function amm_ugcnfc_deactivate_plugin(){}
register_deactivation_hook(__FILE__, 'amm_ugcnfc_deactivate_plugin');

//Keep comments as it is for admin panel whereas change links for frontend side.
if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( wp_unslash( $_SERVER['REQUEST_URI'] ), 'wp-admin' ) === false ) {
      add_filter('comment_text', 'amm_ugcnfc_add_ugc_nofollow_links');
      add_filter('get_comment_author_link', 'amm_ugcnfc_add_ugc_nofollow_links');
}

if( !function_exists("amm_ugcnfc_add_ugc_nofollow_links")){
	function amm_ugcnfc_add_ugc_nofollow_links($comment){
		$comment = str_ireplace( 'nofollow', 'nofollow ugc', $comment );
		if ( ! preg_match( '/rel=/', $comment ) ) {
			$comment = str_ireplace( 'href=', 'rel="nofollow ugc" href=', $comment );
		}	
		return $comment;
	}
}

add_filter('plugin_row_meta', 'amm_ugcnfc_plugin_row_meta', 10, 2);
function amm_ugcnfc_plugin_row_meta($meta, $file) {
	if ( strpos( $file, basename(__FILE__) ) !== false ) {
		$meta[] = '<a href="'.AMM_UGCNFC_DONATE_LINK.'" target="_blank">' . esc_html__('Donate', 'amm_ugcnfc') . '</a>';
	}
	return $meta;
}
?>