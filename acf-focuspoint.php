<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('acffp_acf_plugin_focuspoint') ) :

class acffp_acf_plugin_focuspoint {
	
	// vars
	var $settings;
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	void
	*/
	
	function __construct() {
		
		// settings
		// - these will be passed into the field class.
		$this->settings = array(
			'version'	=> '1.2.0',
			'url'		=> \get_template_directory_uri() . '/vendor/burovoordeboeg/acf-focus-point/',
			'path'		=> \get_template_directory() . '/vendor/burovoordeboeg/acf-focus-point/'
		);
		
		// include field
		add_action('acf/include_field_types', array($this, 'include_field')); // v5
	}
	
	
	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/
	
	function include_field( $version = false ) {
		
		// include
		include_once('fields/class-acffp-acf-field-focuspoint-v' . $version . '.php');
	}
	
}


// initialize
new acffp_acf_plugin_focuspoint();


// class_exists check
endif;
	
?>
