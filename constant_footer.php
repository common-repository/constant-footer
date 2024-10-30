<?php
/*

Plugin Name: Constant Footer
Plugin URI: http://www.pingable.org/constant-footer
Description: Creates a jQuery powered sticky footer bar that is always visible regardless of how the user scrolls.
Version: 1.5
Author: Cyrus Patten
Author URI: http://www.cyruspatten.com
License: Creative Commons Attribution-ShareAlike (GPLv2) //License
//Other terms and conditions
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

*/

/* use WP_PLUGIN_URL if version of WP >= 2.6.0. If earlier, use wp_url */
if($wp_version >= '2.6.0') {
	$stimuli_constant_footer_plugin_prefix = WP_PLUGIN_URL."/constant-footer/"; /* plugins dir can be anywhere after WP2.6 */
} else {
	$stimuli_constant_footer_plugin_prefix = get_bloginfo('wpurl')."/wp-content/plugins/constant-footer/";
}

/* options page (required for saving prefs)*/
$footer_options_page = get_option('siteurl') . '/wp-admin/admin.php?page=constant-footer/options.php';
/* Adds our admin options under "Options" */
function constant_footer_options_page() {
	add_options_page('Constant Footer Options', 'Constant Footer', 10, 'constant-footer/options.php');
}

function constant_footer_styles() {
	/* What version of WP is running? */
	global $wp_version;
	global $stimuli_constant_footer_plugin_prefix;
    /* The next line figures out where the javascripts and images and CSS are installed, relative to your wordpress server's root: */
    $footer_style_prefix = ($stimuli_constant_footer_plugin_prefix."css/");

    /* The xhtml header code needed for footer to work: */
	$footerstyles = "
	<!-- begin constant footer scripts -->
	<script type=\"text/javascript\">
    //<![CDATA[
    document.write('<link rel=\"stylesheet\" href=\"".$footer_style_prefix."footer_style.css\" type=\"text/css\" media=\"screen\" />');
    //]]>
    </script>
	<!-- end constant footer scripts -->\n";
	/* Output $footerscript as text for our web pages: */
	echo($footerstyles);
}

function constant_footer_scripts(){
	/* What version of WP is running? */
	global $wp_version;
	global $stimuli_constant_footer_plugin_prefix;
	
    /* The next line figures out where the javascripts and images and CSS are installed, relative to your wordpress server's root: */
    $footer_jscripts_prefix = ($stimuli_constant_footer_plugin_prefix."js/");
	
	if (!is_admin()) { // if we are *not* viewing an admin page, like writing a post or making a page:
		/* The code needed for footer to work: */
		$constant_footer_height = get_option("constant_footer_height");
		$constant_footer_bgcolor = get_option("constant_footer_bgcolor");
		$constant_footer_opacity = get_option("constant_footer_opacity");
		$constant_footer_fhtml = stripslashes(get_option("constant_footer_fhtml"));
		
		/* storing default values if CSS properties are NULL */
		if(trim($constant_footer_height) == "")		$constant_footer_height = "50";
		if(trim($constant_footer_bgcolor) == "")	$constant_footer_bgcolor = "000000";
		if(trim($constant_footer_opacity) == "")	$constant_footer_opacity = "0.9";
		if(trim($constant_footer_fhtml) == "")		$constant_footer_fhtml = "HTML Content Goes Here...";
		
		$footerscripts = "
		<!-- begin constant footer scripts -->
			<script type=\"text/javascript\" src=\"".$footer_jscripts_prefix."jquery-1.4.2.min.js\" > </script>
			<script type=\"text/javascript\" src=\"".$footer_jscripts_prefix."jquery.constantfooter.js\" > </script>
			<script language=\"javascript\" > 
				$(\"#footer\").constantfooter({\"opacity\": \"$constant_footer_opacity\"});
				$(\"#footer\").css(\"backgroundColor\", \"#$constant_footer_bgcolor\");
				$(\"#footer\").height($constant_footer_height);
				$(\"#footer\").html(\"<div id='cftext' style='position: relative;'>$constant_footer_fhtml</p>\");
				var textCenterAttr = ($constant_footer_height - $(\"#cftext\").height()) / 2;
				textCenterAttr = textCenterAttr + 5;
				$(\"#cftext\").css(\"top\", textCenterAttr + \"%\");
			</script>
		<!-- end constant footer scripts -->\n";
		/* Output $footerscript as text for our web pages: */
		echo($footerscripts);
	}
}

/* START CODE installing the plugin and adding the plugin options */
function constant_footer_install()
{ 
	add_option('constant_footer_height', '50');
	add_option('constant_footer_bgcolor', '000000');
	add_option('constant_footer_opacity', '0.8');
	add_option('constant_footer_fhtml', "Custom Footer goes here...");
}
add_action('activate_constant-footer/constant_footer.php', 'constant_footer_install');
/* END CODE installing the plugin and adding the plugin options */

/* START CODE uninstalling the plugin and deleting the plugin options */
function constant_footer_uninstall()
{ 
	delete_option('constant_footer_height');
	delete_option('constant_footer_bgcolor');
	delete_option('constant_footer_opacity');
	delete_option('constant_footer_fhtml');
}
add_action('deactivate_constant-footer/constant_footer.php', 'constant_footer_uninstall');
/* END CODE uninstalling the plugin and deleting the plugin options */

/* START CODE load script for color box in admin panel */
function load_colorbox_script() {
	global $stimuli_constant_footer_plugin_prefix;
	echo "<script type=\"text/javascript\" src=\"".$stimuli_constant_footer_plugin_prefix."js/"."jscolor.js\" > </script>";
}
/* END CODE load script for color box in admin panel */

/* we want to add the above xhtml to the header of our pages: */
add_action('wp_head', 'constant_footer_styles');
add_action('admin_menu', 'constant_footer_options_page');
add_action('wp_footer', 'constant_footer_scripts');
add_action('admin_head', 'load_colorbox_script');

/* Add Dashboard Widget */
function dashboard_widget_function() {
	wp_widget_rss_output('http://feeds.feedburner.com/pingableorg', array('items' => 5, 'show_author' => 1, 'show_date' => 1, 'show_summary' => 0));
} 
 
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'Latest Wordpress Resources', 'dashboard_widget_function');	
} 

add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
?>