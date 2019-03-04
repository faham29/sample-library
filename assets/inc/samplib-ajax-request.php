<?php 
/*
*
*	***** Sample Library *****
*
*	Ajax Request
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
/*
Ajax Requests
*/
add_action( 'wp_ajax_samplib_custom_plugin_frontend_ajax', 'samplib_custom_plugin_frontend_ajax' );
add_action( 'wp_ajax_nopriv_samplib_custom_plugin_frontend_ajax', 'samplib_custom_plugin_frontend_ajax' );
function samplib_custom_plugin_frontend_ajax(){	
    // ob_start();
    $samplib_formdata = $_POST;
    if (wp_verify_nonce(sanitize_text_field($samplib_formdata['_wpnonce']), 'samplib-nonce')) {
        $posts_per_page = 10;
        if (!empty($samplib_formdata['_posts_per_page'])) {
            $posts_per_page = sanitize_text_field($samplib_formdata['_posts_per_page']);
        }
        $paged = sanitize_text_field($samplib_formdata['_paged']);
        $args = array(
            'post_type'   => 'samplib-books',
            'post_status' => 'publish',
            'order'               => 'DESC',
            'orderby'             => 'date',
            'posts_per_page'      => $posts_per_page,
            'paged'               => $paged,
        );
        if (!empty($samplib_formdata['samplib']['title'])) {
            $args['s']  = sanitize_text_field($samplib_formdata['samplib']['title']);
        }
        if (!empty($samplib_formdata['samplib']['author']) || !empty($samplib_formdata['samplib']['publisher']) || !empty($samplib_formdata['samplib']['ratings']) || !empty($samplib_formdata['samplib']['price'])) {
            $count = 0;
            if (!empty($samplib_formdata['samplib']['author'])) {
                $temp_arr = array(
                    'key'     => 'samplib_author_field',
                    'value'   => sanitize_text_field($samplib_formdata['samplib']['author']),
                    'compare' => '=',
                );
                $count++;
                array_push($args['meta_query'], $temp_arr);
            }
            if (!empty($samplib_formdata['samplib']['publisher'])) {
                $temp_arr = array(
                    'key'     => 'samplib_publisher_field',
                    'value'   => sanitize_text_field($samplib_formdata['samplib']['publisher']),
                    'compare' => '=',
                );
                $count++;
                array_push($args['meta_query'], $temp_arr);
            }
            if (!empty($samplib_formdata['samplib']['ratings'])) {
                $temp_arr = array(
                    'key'     => 'samplib_rating_field',
                    'value'   => sanitize_text_field($samplib_formdata['samplib']['rating']),
                    'compare' => '=',
                );
                $count++;
                array_push($args['meta_query'], $temp_arr);
            }
            if (!empty($samplib_formdata['samplib']['price'])) {
                $temp_arr = array(
                    'key'     => 'samplib_price_field',
                    'value'   => sanitize_text_field($samplib_formdata['samplib']['price']),
                    'compare' => '<=',
                );
                $count++;
                array_push($args['meta_query'], $temp_arr);
            }
            if ($count > 1) {
                $args['meta_query']['relation'] = 'AND';
            }
        }
        $samplib_query = new WP_Query($args);
        if ( $samplib_query->have_posts() ) {
            $counter = ((int)$paged - 1)*(int)$posts_per_page + 1;
            while ( $samplib_query->have_posts() ) { 
                $samplib_query->the_post();
                ?>
                    <div class="samplib-responsive-table">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php _e('No.', 'samplib');?></th>
                                    <th><?php _e('Book Name', 'samplib');?></th>
                                    <th><?php _e('Price', 'samplib');?></th>
                                    <th><?php _e('Author.', 'samplib');?></th>
                                    <th><?php _e('Publisher', 'samplib');?></th>
                                    <th><?php _e('Rating', 'samplib');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php _e($counter,'samplib');?></td>
                                    <td><?php _e('<a href="'.get_the_permalink().'">'.get_the_title().'</a>', 'samplib');?></td>
                                    <td><?php _e(get_post_meta(get_the_ID(), 'samplib_price_field', true), 'samplib');?></td>
                                    <td><?php _e(get_post_meta(get_the_ID(), 'samplib_author_field', true), 'samplib');?></td>
                                    <td><?php _e(get_post_meta(get_the_ID(), 'samplib_publisher_field', true), 'samplib');?></td>
                                    <td><?php _e(get_post_meta(get_the_ID(), 'samplib_price_field', true), 'samplib');?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php
                $counter++;
            }
            ?>
            <div class="samplib-clearfix"></div>
            <div class="samplib-pagination">
                <?php
                $big = 999999999; // need an unlikely integer
                global $wp;
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', home_url(sanitize_text_field($samplib_formdata['_wp_http_referer']).'?paged='.$big)),
                    'format' => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'total' => $samplib_query->max_num_pages
                ) );
                wp_reset_postdata();
                ?>
            </div>
            <?php
        } else {
            echo 'No books found matching your search criteria';
            ?>
            <?php 
        }
    }
	wp_die();
}