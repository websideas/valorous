<?php

/**
 * Register type for metabox
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if ( ! class_exists( 'RWMB_Sidebars_Field' )){
	class RWMB_Sidebars_Field extends RWMB_Select_Field{

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$field['options'] = self::get_options( $field );
			return RWMB_Select_Field::html( $meta, $field );
		}
        /**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = parent::normalize_field( $field );

            if(!isset($field['default'])){
                $field['default'] = false;
            } 
            
			return $field;
		}
        
        /**
		 * Get options
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function get_options( $field )
		{
			$options = array();
            if($field['default']){
                $options['default'] = __('Default area', THEME_LANG);  
            }
            
            foreach($GLOBALS['wp_registered_sidebars'] as $sidebar){
                $options[$sidebar['id']] = ucwords( $sidebar['name'] );
            }

			return $options;
		}
        
	}
} // end RWMB_Sidebars_Field



if ( ! class_exists( 'RWMB_RevSlider_Field' )){
	class RWMB_RevSlider_Field extends RWMB_Select_Field{

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$field['options'] = self::get_options( $field );
			return RWMB_Select_Field::html( $meta, $field );
		}
        
        /**
		 * Get options
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function get_options( $field )
		{
			$options = array();
            $options[''] = __('Select Option', THEME_LANG);
            
            if ( class_exists( 'RevSlider' ) ) {
                $revSlider = new RevSlider();
                $arrSliders = $revSlider->getArrSliders();
                
                if(!empty($arrSliders)){
					foreach($arrSliders as $slider){
					   $options[$slider->getParam("alias")] = $slider->getParam("title");
					}
                }
            }

			return $options;
		}
        
	}
} // end RWMB_RevSlider_Field



if ( ! class_exists( 'RWMB_Layerslider_Field' )){
	class RWMB_Layerslider_Field extends RWMB_Select_Field{

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$field['options'] = self::get_options( $field );
			return RWMB_Select_Field::html( $meta, $field );
		}
        
        /**
		 * Get options
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function get_options( $field )
		{
			$options = array();
            $options[''] = __('Select Option', THEME_LANG);
            
            if ( is_plugin_active( 'LayerSlider/layerslider.php' ) ) {
            global $wpdb;
                $table_name = $wpdb->prefix . "layerslider";
                $sliders = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY date_c ASC LIMIT 100" );
                if ( $sliders != null && !empty( $sliders ) ) {
                    foreach ( $sliders as $item ) :
                        $options[$item->id] = $item->name;
                    endforeach;
                }
            }

			return $options;
		}
        
	}
} // end RWMB_Layerslider_Field






