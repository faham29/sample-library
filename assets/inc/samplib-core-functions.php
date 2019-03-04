<?php 
/*
*
*	***** Sample Library *****
*
*	Core Functions
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
/*
*
* Custom Front End Ajax Scripts / Loads In WP Footer
*
*/
function samplib_frontend_ajax_form_scripts(){
?>
<script type="text/javascript">
jQuery(document).ready(function($){
    "use strict";
    // add basic front-end ajax page scripts here
    $('#samplib_custom_plugin_form #samplib-submit').on('click', function(event){
    	console.log('clicked');
        event.preventDefault();
        var data = $('#samplib_custom_plugin_form').serialize();
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
        $.post(ajaxurl, data, function(response) {
                if(response.Status == true)
                {
                    console.log(response.message);
                    $('#samplib_custom_plugin_form_wrap').html(response);

                }
                else
                {
                    console.log(response.message);
                    $('#samplib_custom_plugin_form_wrap').html(response);
                }
        });
    });
    $('#samplib_custom_plugin_form #samplib-submit').trigger('click');
}(jQuery));    
</script>
<?php }
add_action('wp_footer','samplib_frontend_ajax_form_scripts');
/**
 * Registers a new post type
 * @uses $wp_post_types Inserts new post type object into the list
 *
 * @param string  Post type key, must not exceed 20 characters
 * @param array|string  See optional args description above.
 * @return object|WP_Error the registered post type object, or an error object
 */
function samplib_register_post_type() {
	$labels = array(
		'name'               => __( 'Books', 'samplib' ),
		'singular_name'      => __( 'Book', 'samplib' ),
		'add_new'            => _x( 'Add New Book', 'samplib', 'samplib' ),
		'add_new_item'       => __( 'Add New Book', 'samplib' ),
		'edit_item'          => __( 'Edit Book', 'samplib' ),
		'new_item'           => __( 'New Book', 'samplib' ),
		'view_item'          => __( 'View Book', 'samplib' ),
		'search_items'       => __( 'Search Books', 'samplib' ),
		'not_found'          => __( 'No Books found', 'samplib' ),
		'not_found_in_trash' => __( 'No Books found in Trash', 'samplib' ),
		'parent_item_colon'  => __( 'Parent Book:', 'samplib' ),
		'menu_name'          => __( 'Books', 'samplib' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'revisions',
		),
	);

	register_post_type('samplib-books', $args);
}
add_action('init', 'samplib_register_post_type');
function samplib_books_meta_fields_cb() {
	global $post;
	$samplib_meta_fields = array(
		'author'	=>	array(
			'type'		=>	'text',
			'default'	=>	'Faham',
			'value'		=>	''
			),
		'publisher'	=>	array(
			'type'		=>	'text',
			'default'	=>	'Faham',
			'value'		=>	''
			),
		'rating'	=>	array(
			'type'		=>	'select',
			'default'	=>	'1',
			'value'		=>	array(1,2,3,4,5)
			),
		'price'			=>	array(
			'type'		=>	'number',
			'default'	=>	'100',
			'value'		=>	''
			),
	);
	foreach ($samplib_meta_fields as $samplib_meta_key => $samplib_meta_field) {
		if ($samplib_meta_field['type'] == 'text') {
			if (get_post_meta($post->ID, "samplib_{$samplib_meta_key}_field", $single = true )) {
				$value = get_post_meta($post->ID, "samplib_{$samplib_meta_key}_field", $single = true );
			} elseif (!empty($samplib_meta_field['value'])) {
				$value = $samplib_meta_field['value'];
			} else {
				$value = $samplib_meta_field['default'];
			}
			?>
			<div class="samplib samplib-<?php echo $samplib_meta_key?>">
				<label for="" id="samplib-<?php echo $samplib_meta_key?>-label">
					<?php _e(strtoupper($samplib_meta_key), 'samplib');?>
				</label>
				<?php
					$samplib_placeholder = ucwords('Add '.$samplib_meta_key);
				?>
				<input type="text" name="samplib[samplib_<?php echo $samplib_meta_key?>_field]" id="samplib_<?php echo $samplib_meta_key?>_field" value="<?php echo $value;?>" placeholder="<?php _e($samplib_placeholder,'samplib')?>">
			</div>
			<?php
		} elseif ($samplib_meta_field['type'] == 'number') {
			if (get_post_meta($post->ID, "samplib_{$samplib_meta_key}_field", $single = true )) {
				$value = get_post_meta($post->ID, "samplib_{$samplib_meta_key}_field", $single = true );
			} elseif (!empty($samplib_meta_field['value'])) {
				$value = $samplib_meta_field['value'];
			} else {
				$value = $samplib_meta_field['default'];
			}
			?>
			<div class="samplib samplib-<?php echo $samplib_meta_key?>">
				<label for="" id="samplib-<?php echo $samplib_meta_key?>-label">
					<?php _e(strtoupper($samplib_meta_key), 'samplib');?>
				</label>
				<?php
					$samplib_placeholder = ucwords('Add '.$samplib_meta_key);
				?>
				<input type="number" name="samplib[samplib_<?php echo $samplib_meta_key?>_field]" id="samplib_<?php echo $samplib_meta_key?>_field" value="<?php echo $value;?>" placeholder="<?php _e($samplib_placeholder,'samplib')?>">
			</div>
			<?php
		} elseif($samplib_meta_field['type'] == 'select') {
			if (get_post_meta($post->ID, "samplib_{$samplib_meta_key}_field", $single = true )) {
				$value = get_post_meta($post->ID, "samplib_{$samplib_meta_key}_field", $single = true );
			} elseif (!empty($samplib_meta_field['value'])) {
				$value = $samplib_meta_field['value'];
			} else {
				$value = $samplib_meta_field['default'];
			}
			?>
			<div class="samplib samplib-<?php echo $samplib_meta_key?>">
				<label for="" id="samplib-<?php echo $samplib_meta_key?>-label">
					<?php _e(strtoupper($samplib_meta_key), 'samplib');?>
				</label>
				<select name="samplib[samplib_<?php echo $samplib_meta_key?>_field]" id="samplib_<?php echo $samplib_meta_key?>_field">
					<?php
						if (is_array($value)) {
							foreach ($value as $v) {
								echo $v;
								?>
								<option value="<?php echo $v?>"><?php echo $v?></option>
								<?php
							}
						} else {
							$checked = (int) $value == 1 ? 'selected="selected"' : ''?>
							<option value="1" <?php echo $checked?>>1</option>
							<?php $checked = (int) $value == 2 ? 'selected="selected"' : ''?>
							<option value="2" <?php echo $checked?>>2</option>
							<?php $checked = (int) $value == 3 ? 'selected="selected"' : ''?>
							<option value="3" <?php echo $checked?>>3</option>
							<?php $checked = (int) $value == 4 ? 'selected="selected"' : ''?>
							<option value="4" <?php echo $checked?>>4</option>
							<?php $checked = (int) $value == 5 ? 'selected="selected"' : ''?>
							<option value="5" <?php echo $checked?>>5</option>
							<?php
						}
					?>
				</select>
			</div>
			<?php
		}
	}
}
add_action('add_meta_boxes', 'samplib_meta_boxes');
function samplib_meta_boxes() {
	add_meta_box('samplib_meta_fields', __('Book Info', 'samplib'), 'samplib_books_meta_fields_cb', 'samplib-books', $context = 'side', $priority = 'default');
}
add_action('save_post', 'samplib_save_books', 10, 2);
function samplib_save_books($id, $data) {
	if (!current_user_can("edit_post", $id)) {
		return $data;
	}
	if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
		return $data;
	}
	if ($data->post_type != 'samplib-books')
		return $data;
	$samplib = $_POST['samplib'];
	if (!empty($samplib)) {
		foreach ($samplib as $samplib_key => $samplib_value) {
			update_post_meta($id, sanitize_text_field($samplib_key), sanitize_text_field($samplib_value));
		}
	}
}