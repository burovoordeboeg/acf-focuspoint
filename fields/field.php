<?php

    namespace BvdB\ACF;


	class FocusPointField extends \acf_field {
		
		private $settings;
		public $name;
		public $label;
		public $category;
		public $l10n;
		public $defaults;

		/*
		*  __construct
		*
		*  This function will setup the field type data
		*
		*  @type	function
		*  @date	5/03/2014
		*  @since	5.0.0
		*
		*  @param	n/a
		*  @return	n/a
		*/
		
		function __construct() {
			
			/*
			*  name (string) Single word, no spaces. Underscores allowed
			*/
			
			$this->name = 'focuspoint';
			
			
			/*
			*  label (string) Multiple words, can include spaces, visible when selecting a field type
			*/
			
			$this->label = __('FocusPoint', 'acffp');
			
			
			/*
			*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			*/
			
			$this->category = 'jquery';
			
			
			/*
			*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
			*/
			
			$this->defaults = array(
				'preview_size'	=>	'large',
				'library'		=> 'all',
				'mime_types'	=> '',
			);
			
			
			/*
			*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
			*  var message = acf._e('focuspoint', 'error');
			*/
			
			$this->l10n = array();
			
			
			/*
			*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
			*/
			
			$this->settings = \BvdB\ACF\FocusPoint::get_settings();
			

			// do not delete!
			parent::__construct();

			// Register the field type
			acf_register_field_type($this);

		}
		
		
		/*
		*  render_field_settings()
		*
		*  Create extra settings for your field. These are visible when editing a field
		*
		*  @type	action
		*  @since	3.6
		*  @date	23/01/13
		*
		*  @param	$field (array) the $field being edited
		*  @return	n/a
		*/
		
		function render_field_settings( $field ) {
			
			/*
			*  acf_render_field_setting
			*
			*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
			*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
			*
			*  More than one setting can be added by copy/paste the above code.
			*  Please note that you must also have a matching $defaults value for the field name (font_size)
			*/
			
			// clear numeric settings
			
			// clear numeric settings
			$clear = array(
				'min_width',
				'min_height',
				'min_size',
				'max_width',
				'max_height',
				'max_size'
			);
			
			foreach( $clear as $k ) {
				if( empty($field[$k]) ) {
					$field[$k] = '';
				}
			}
			
			// Preview size select
			acf_render_field_setting( $field, array(
				'label'			=> __('Preview Size','acf-focuspoint'),
				'instructions'	=> __('Image used to create a FocusPoint. Should be around the same image ratio as Image Size','acf-focuspoint'),
				'type'			=> 'select',
				'name'			=> 'preview_size',
				'choices'		=>	acf_get_image_sizes()
			));
			
			
			// library
			acf_render_field_setting( $field, array(
				'label'			=> __('Library','acf'),
				'instructions'	=> __('Limit the media library choice','acf'),
				'type'			=> 'radio',
				'name'			=> 'library',
				'layout'		=> 'horizontal',
				'choices' 		=> array(
					'all'			=> __('All', 'acf'),
					'uploadedTo'	=> __('Uploaded to post', 'acf')
				)
			));
			
			
			// Min sizes
			acf_render_field_setting( $field, array(
				'label'			=> __('Minimum', 'acf-focuspoint'),
				'instructions'	=> __('', 'acf-focuspoint'),
				'type'			=> 'text',
				'name'			=> 'min_width',
				'prepend'		=> __('Width', 'acf-focuspoint'),
				'append'		=> 'px',
			));
			
			acf_render_field_setting( $field, array(
				'label'			=> '',
				'type'			=> 'text',
				'name'			=> 'min_height',
				'prepend'		=> __('Height', 'acf-focuspoint'),
				'append'		=> 'px',
				'_append' 		=> 'min_width'
			));
			
			acf_render_field_setting( $field, array(
				'label'			=> '',
				'type'			=> 'text',
				'name'			=> 'min_size',
				'prepend'		=> __('File size', 'acf-focuspoint'),
				'append'		=> 'MB',
				'_append' 		=> 'min_width'
			));	
			
			
			// Max sizes
			acf_render_field_setting( $field, array(
				'label'			=> __('Maximum', 'acf-focuspoint'),
				'instructions'	=> __('', 'acf-focuspoint'),
				'type'			=> 'text',
				'name'			=> 'max_width',
				'prepend'		=> __('Width', 'acf-focuspoint'),
				'append'		=> 'px',
			));
			
			acf_render_field_setting( $field, array(
				'label'			=> '',
				'type'			=> 'text',
				'name'			=> 'max_height',
				'prepend'		=> __('Height', 'acf-focuspoint'),
				'append'		=> 'px',
				'_append' 		=> 'max_width'
			));
			
			acf_render_field_setting( $field, array(
				'label'			=> '',
				'type'			=> 'text',
				'name'			=> 'max_size',
				'prepend'		=> __('File size', 'acf-focuspoint'),
				'append'		=> 'MB',
				'_append' 		=> 'max_width'
			));	
			
			
			// allowed type
			acf_render_field_setting( $field, array(
				'label'			=> __('Allowed file types','acf'),
				'instructions'	=> __('Comma separated list. Leave blank for all types','acf'),
				'type'			=> 'text',
				'name'			=> 'mime_types',
			));

		}
		
		
		
		/*
		*  render_field()
		*
		*  Create the HTML interface for your field
		*
		*  @param	$field (array) the $field being rendered
		*
		*  @type	action
		*  @since	3.6
		*  @date	23/01/13
		*
		*  @param	$field (array) the $field being edited
		*  @return	n/a
		*/
		
		function render_field( $field ) {

			// Merge defaults
			$field = array_merge($this->defaults, $field);
			
			// Get set image id
			$id = (isset($field['value']['id'])) ? $field['value']['id'] : '';

			// data vars
			$data = array(
				'top'		=>	isset($field['value']['top']) ? $field['value']['top'] : '',
				'left'		=>	isset($field['value']['left']) ? $field['value']['left'] : '',
			);
			
			// If we already have an image set...
			if ($id) {
				
				// Get image by ID, in size set via options
				$img = wp_get_attachment_image_src($id, $field['preview_size']);
							
			}
				
			// If image found...
			// Set to hide add image button / show canvas
			$is_active 	= ($id) ? 'active' : '';

			// And set src
			$url = ($id) ? $img[0] : '';
			
			// create Field HTML
			?>

			<div class="acf-focuspoint acf-image-uploader <?php echo $is_active; ?>" data-preview_size="<?php echo $field['preview_size']; ?>" data-library="<?php echo $field['library']; ?>" data-mime_types="<?php echo $field['mime_types']; ?>">

				<input data-name="acf-focuspoint-img-id" type="hidden" name="<?php echo $field['name']; ?>[id]" value="<?php echo $id; ?>" />

				<?php foreach ($data as $k => $d): ?>
					<input data-name="acf-focuspoint-<?php echo $k ?>" type="hidden" name="<?php echo $field['name']; ?>[<?php echo $k ?>]" value="<?php echo $d ?>" />
				<?php endforeach ?>

				<div class="focuspoint-image <?php echo $id && wp_attachment_is_image( $id ) ? 'has-image' : 'no-image' ?>">
					<img data-name="acf-focuspoint-img" src="<?php echo $url; ?>">
					<img class="focal-point-picker" src="<?php echo $this->settings['url']; ?>assets/images/focal-point-picker.svg" style="top: <?php echo $data['top']; ?>%; left: <?php echo $data['left']; ?>%;">
					<div class="focuspoint-selection-layer"></div>
					<a class="acf-button-delete acf-icon -cancel acf-icon-cancel dark" data-name="remove"></a>
				</div>
				
				<div class="view hide-if-value">
					<p><?php _e('No image selected','acf'); ?> <a data-name="add" class="acf-button button" href="#"><?php _e('Add Image','acf'); ?></a></p>
				</div>

			</div>

			<?php

		}
		
			
		/*
		*  input_admin_enqueue_scripts()
		*
		*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
		*  Use this action to add CSS + JavaScript to assist your render_field() action.
		*
		*  @type	action (admin_enqueue_scripts)
		*  @since	3.6
		*  @date	23/01/13
		*
		*  @param	n/a
		*  @return	n/a
		*/
		function input_admin_enqueue_scripts() {
			
			// vars
			$url = $this->settings['url'];
			$version = $this->settings['version'];
			
			
			// register & include JS
			wp_register_script('acffp', "{$url}assets/js/input.min.js", array('jquery', 'acf-input'), $version );
			wp_enqueue_script('acffp');
				wp_enqueue_media();
			
			
			// register & include CSS
			wp_register_style('acffp', "{$url}assets/css/input.min.css", array('acf-input'), $version );
			wp_enqueue_style('acffp');
			
		}
		
		function update_value( $value, $post_id, $field ) {
			
			if( empty( $value['id'] ) ){
				return false;
			}
			if( empty( $value['left'] ) && empty( $value['top'] ) ){
				$value['left'] = 50;
				$value['top'] = 50;
			}

			return $value;
			
		}
		
		
		function validate_value( $valid, $value, $field, $input ){

			// vd( $valid );
			// vdd( empty($value['id']) );

			// Bail early if field not required and value not set
			if( $field['required'] === 0 && !$value['id'] ) return true;
			
			// bail early if field required and id empty		
			if( $field['required'] !== 0 && empty($value['id']) ) return false;
			
			// bail ealry if id not numeric
			if( !is_numeric($value['id']) ) return false;

			$image = wp_get_attachment_image_src( $value['id'], 'full' );
			$image_size_kb = filesize( get_attached_file( $value['id'] ) );
			
			if( !empty($field['min_width']) && $image[1] < $field['min_width'] ) {
				$valid = sprintf( __('Image width must be at least %dpx.', 'acf-focuspoint'), $field['min_width'], $image[1], $image[2] );
			}
			elseif( !empty($field['min_height']) && $image[2] < $field['min_height'] ) {
				$valid = sprintf( __('Image height must be at least %dpx.', 'acf-focuspoint'), $field['min_height'], $image[1], $image[2] );
			}
			elseif( !empty($field['min_size']) && $image_size_kb < $field['min_size'] * (1024 * 1024) ) {
				$valid = sprintf( __('File size must be at least %d&nbsp;KB.', 'acf-focuspoint'), size_format( $field['min_size'] * (1024 * 1024), 2), size_format( $image_size_kb, 2 ) );
			}
			elseif( !empty($field['max_width']) && $image[1] > $field['max_width'] ) {
				$valid = sprintf( __('Image width must not exceed %dpx.', 'acf-focuspoint'), $field['max_width'], $image[1], $image[2] );
			}
			elseif( !empty($field['max_height']) && $image[2] > $field['max_height'] ) {
				$valid = sprintf( __('Image height must not exceed %dpx.', 'acf-focuspoint'), $field['max_height'], $image[1], $image[2] );
			}
			elseif( !empty($field['max_size']) && $image_size_kb > $field['max_size'] * (1024 * 1024) ) {
				$valid = sprintf( __('File size must not exceed %d&nbsp;KB.', 'acf-focuspoint'), size_format( $field['max_size'] * (1024 * 1024), 2), size_format( $image_size_kb, 2 ) );
			}
			else{
				$valid = true;
			}
			
			// return
			return $valid;

		}
		
	}

?>
