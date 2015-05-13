<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Make sure "select" field is loaded
require_once RWMB_FIELDS_DIR . 'select-advanced.php';

if ( ! class_exists( 'RWMB_Post_Field' ) )
{
	class RWMB_Post_Field extends RWMB_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			RWMB_Select_Advanced_Field::admin_enqueue_scripts();
		}

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
			switch ( $field['field_type'] )
			{
				case 'select':
					return RWMB_Select_Field::html( $meta, $field );
				case 'select_advanced':
				default:
					return RWMB_Select_Advanced_Field::html( $meta, $field );
			}
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

			$field = wp_parse_args( $field, array(
				'js_options' => array(),
			) );
            
            
            if ( $field['multiple'] )
                $field['field_name'] .= '[]';
            

			$field['js_options'] = wp_parse_args( $field['js_options'], array(
				'allowClear'  => true,
				'width'       => 'resolve',
				'placeholder' => $field['placeholder'],
			) );
            
            
			return $field;
		}
        

		/**
		 * Get posts
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function get_options( $field )
		{
			$options = array();
			$query   = new WP_Query( $field['query_args'] );
			if ( $query->have_posts() )
			{
				while ( $query->have_posts() )
				{
					$post               = $query->next_post();
					$options[$post->ID] = '#'.$post->ID.' - '.$post->post_title;
                    if(  $field['post_type']  == 'collection'){
                        $des_id = get_post_meta( $post->ID, '_kt_designer', true );
                        $options[$post->ID] .= ' '.sprintf( __('by %s', THEME_LANG ), get_the_title( $des_id ) ) ;
                    }
				}
			}

			return $options;
		}
	}
}
