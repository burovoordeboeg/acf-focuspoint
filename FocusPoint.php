<?php

    namespace BvdB\ACF;

	class FocusPoint {
		
		// vars
		public static array $settings;
		
		
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
			SELF::$settings = array(
				'version'	=> '1.2.1',
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
			include_once('fields/field.php');
			new FocusPointField();
		}

		/**
		 * Return settings
		 *
		 * @return array
		 */
		public static function get_settings():array
		{
			return SELF::$settings;
		}
		
	}

?>