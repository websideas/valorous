<?php
/**
 * Handles taxonomies in admin
 *
 * @class       WC_Admin_Taxonomies
 * @version     1.0
 * @package     London
 * @category    Class
 * @author      WooThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * WC_Admin_Taxonomies class.
 */
class KT_WC_Admin_Taxonomies {

    /**
     * Constructor
     */
    public function __construct() {

        // Category/term ordering
        add_action( 'create_term', array( $this, 'create_term' ), 5, 3 );
        add_action( 'delete_term', array( $this, 'delete_term' ), 5 );

        // Add form
        add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ) );
        add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 10 );
        add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
        add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );

        // Add columns
        add_filter( 'manage_edit-product_cat_columns', array( $this, 'product_cat_columns' ) );
        add_filter( 'manage_product_cat_custom_column', array( $this, 'product_cat_column' ), 12, 3 );



        // Maintain hierarchy of terms
        add_filter( 'wp_terms_checklist_args', array( $this, 'disable_checked_ontop' ) );
    }

    /**
     * Order term when created (put in position 0).
     *
     * @param mixed $term_id
     * @param mixed $tt_id
     * @param mixed $taxonomy
     */
    public function create_term( $term_id, $tt_id = '', $taxonomy = '' ) {

        if ( $taxonomy != 'product_cat' && ! taxonomy_is_product_attribute( $taxonomy ) ) {
            return;
        }

        $meta_name = taxonomy_is_product_attribute( $taxonomy ) ? 'order_' . esc_attr( $taxonomy ) : 'order';

        update_woocommerce_term_meta( $term_id, $meta_name, 0 );
    }

    /**
     * When a term is deleted, delete its meta.
     *
     * @param mixed $term_id
     */
    public function delete_term( $term_id ) {

        $term_id = (int) $term_id;

        if ( ! $term_id ) {
            return;
        }

        global $wpdb;
        $wpdb->query( "DELETE FROM {$wpdb->woocommerce_termmeta} WHERE `woocommerce_term_id` = " . $term_id );
    }

    /**
     * Category thumbnail fields.
     */
    public function add_category_fields() {
        ?>

        <div class="form-field">
            <label><?php _e( 'Icon', 'woocommerce' ); ?></label>
            <div id="product_cat_icon" style="float:left;margin-right:10px;"><img src="<?php echo wc_placeholder_img_src(); ?>" width="60px" height="60px" /></div>
            <div style="line-height:60px;">
                <input type="hidden" id="product_cat_icon_id" name="product_cat_icon_id" />
                <button type="button" class="icon_upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
                <button type="button" class="icon_remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
            </div>
            <script type="text/javascript">

                jQuery( document).ready( function(){

                    // Only show the "remove image" button when needed
                    if ( ! jQuery('#product_cat_icon_id').val() ) {
                        jQuery('.icon_remove_image_button').hide();
                    }

                    // Uploading files
                    var file_frame;

                    jQuery( document ).on( 'click', '.icon_upload_image_button', function( event ) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if ( file_frame ) {
                            file_frame.open();
                            return;
                        }

                        // Create the media frame.
                        file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php _e( 'Choose an image', 'woocommerce' ); ?>',
                            button: {
                                text: '<?php _e( 'Use image', 'woocommerce' ); ?>',
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        file_frame.on( 'select', function() {
                            attachment = file_frame.state().get('selection').first().toJSON();

                            jQuery('#product_cat_icon_id').val( attachment.id );
                            var image_url  =  attachment.sizes.full.url;
                            jQuery('#product_cat_icon img').attr('src', image_url );
                            jQuery('.icon_remove_image_button').show();
                        });

                        // Finally, open the modal.
                        file_frame.open();
                    });

                    jQuery( document ).on( 'click', '.icon_remove_image_button', function( event ) {
                        jQuery('#product_cat_icon img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
                        jQuery('#product_cat_icon_id').val('');
                        jQuery('.icon_remove_image_button').hide();
                        return false;
                    });


                } );



            </script>
            <div class="clear"></div>
        </div>
    <?php
    }

    /**
     * Edit category thumbnail field.
     *
     * @param mixed $term Term (category) being edited
     */
    public function edit_category_fields( $term ) {

        $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );
        $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'icon_id', true ) );

        if ( $thumbnail_id ) {
            $image = wp_get_attachment_thumb_url( $thumbnail_id );
        } else {
            $image = wc_placeholder_img_src();
        }
        ?>

        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label><?php _e( 'Icon', 'woocommerce' ); ?></label></th>
            <td>
                <div id="product_cat_icon" style="float:left;margin-right:10px;"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
                <div style="line-height:60px;">
                    <input type="hidden" id="product_cat_icon_id" name="product_cat_icon_id" value="<?php echo esc_attr($thumbnail_id); ?>" />
                    <button type="submit" class="icon_upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
                    <button type="submit" class="icon_remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
                </div>
                <script type="text/javascript">

                    jQuery( document).ready( function(){
                        // Uploading files
                        var file_frame;

                        jQuery( document ).on( 'click', '.icon_upload_image_button', function( event ) {

                            event.preventDefault();

                            // If the media frame already exists, reopen it.
                            if ( file_frame ) {
                                file_frame.open();
                                return;
                            }

                            // Create the media frame.
                            file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: '<?php _e( 'Choose an image', 'woocommerce' ); ?>',
                                button: {
                                    text: '<?php _e( 'Use image', 'woocommerce' ); ?>',
                                },
                                multiple: false
                            });

                            // When an image is selected, run a callback.
                            file_frame.on( 'select', function() {
                                attachment = file_frame.state().get('selection').first().toJSON();

                                jQuery('#product_cat_icon_id').val( attachment.id );
                                var image_url  =  attachment.sizes.full.url;

                                jQuery('#product_cat_icon img').attr('src', image_url);
                                jQuery('.icon_remove_image_button').show();
                            });

                            // Finally, open the modal.
                            file_frame.open();
                        });

                        jQuery( document ).on( 'click', '.icon_remove_image_button', function( event ) {
                            jQuery('#product_cat_icon img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
                            jQuery('#product_cat_icon_id').val('');
                            jQuery('.icon_remove_image_button').hide();
                            return false;
                        });

                    });

                </script>
                <div class="clear"></div>
            </td>
        </tr>
    <?php
    }

    /**
     * save_category_fields function.
     *
     * @param mixed $term_id Term ID being saved
     */
    public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

        if ( isset( $_POST['product_cat_icon_id'] ) && 'product_cat' === $taxonomy ) {
            update_woocommerce_term_meta( $term_id, 'icon_id', absint( $_POST['product_cat_icon_id'] ) );
        }
    }


    /**
     * Thumbnail column added to category admin.
     *
     * @param mixed $columns
     * @return array
     */
    public function product_cat_columns( $columns ) {
        $new_columns          = array();
        $new_columns['cb']    = $columns['cb'];
        $new_columns['icon'] = __( 'icon', 'woocommerce' );

        unset( $columns['cb'] );

        return array_merge( $new_columns, $columns );
    }

    /**
     * Thumbnail column value added to category admin.
     *
     * @param mixed $columns
     * @param mixed $column
     * @param mixed $id
     * @return array
     */
    public function product_cat_column( $columns, $column, $id ) {

        if ( 'icon' == $column ) {

            $thumbnail_id = get_woocommerce_term_meta( $id, 'icon_id', true );

            if ( $thumbnail_id ) {
                $image = wp_get_attachment_thumb_url( $thumbnail_id );
            } else {
                $image = wc_placeholder_img_src();
            }

            // Prevent esc_url from breaking spaces in urls for image embeds
            // Ref: http://core.trac.wordpress.org/ticket/23605
            $image = str_replace( ' ', '%20', $image );

            $columns .= '<img src="' . esc_url( $image ) . '" alt="' . __( 'Icon', 'woocommerce' ) . '" class="wp-post-image" height="35" width="35" />';

        }

        return $columns;
    }

    /**
     * Maintain term hierarchy when editing a product.
     *
     * @param  array $args
     * @return array
     */
    public function disable_checked_ontop( $args ) {

        if ( 'product_cat' == $args['taxonomy'] ) {
            $args['checked_ontop'] = false;
        }

        return $args;
    }
}

new KT_WC_Admin_Taxonomies();
