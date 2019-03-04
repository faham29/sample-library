<?php 
/*
*
*	***** Sample Library *****
*
*	Shortcodes
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
/*
*
*  Build The Custom Plugin Form
*
*  Display Anywhere Using Shortcode: [samplib_custom_plugin_form]
*
*/
function samplib_custom_plugin_book_display($atts, $content = NULL){
		$atts = shortcode_atts(array(
      	'posts_per_page' => 10,
		),$atts, 'samplib-book-display');
    global $wp;
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $current_slug = add_query_arg( array(), $wp->request );
      $out ='<h2>'.__('Search Book','samplib').'</h2>';
      $out .= '<div id="samplib_custom_plugin_book_wrap" class="samplib-form-wrap">';
        $out .= '<form id="samplib_custom_plugin_form">';
          $out .= '<input type="hidden" name="_wpnonce" value="'.wp_create_nonce('samplib-nonce').'" id="_wpnonce">';
          $out .= '<input type="hidden" name="_wp_http_referer" value="/'.$current_slug.'">';
          $out .= '<input type="hidden" name="_posts_per_page" value="'.$atts['posts_per_page'].'">';
          $out .= '<input type="hidden" name="_paged" value="'.$paged.'">';
          $out .= '<input type="hidden" name="action" value="samplib_custom_plugin_frontend_ajax">';
          $out .= '<div class="samplib-two-cols">';
            $out .= '<div class="samplib-one-half-left">';
              $out .= '<label>Book Name</label>';
              $out .= '<input type="text" class="samplib-input" name="samplib[title]">';
            $out .= '</div>';
            $out .= '<div class="samplib-one-half-right">';
              $out .= '<label>Author</label>';
              $out .= '<input type="text" class="samplib-input" name="samplib[author]">';
            $out .= '</div>';
            $out .= '<div class="samplib-clearfix"></div>';
          $out .= '</div>';
          $out .= '<div class="samplib-two-cols">';
            $out .= '<div class="samplib-one-half-left">';
              $out .= '<label>Publisher</label>';
              $out .= '<input type="text" class="samplib-input" name="samplib[publisher]">';
            $out .= '</div>';
            $out .= '<div class="samplib-one-half-right">';
              $out .= '<label>Rating</label>';
              $out .= '<select name="samplib[ratings]" class="samplib-input">';
                $out .= '<option value="">Select</option>';
                $out .= '<option value="1">One Star</option>';
                $out .= '<option value="2">Two Star</option>';
                $out .= '<option value="3">Three Star</option>';
                $out .= '<option value="4">Four Star</option>';
                $out .= '<option value="5">Five Star</option>';
              $out .= '</select>';
            $out .= '</div>';
            $out .= '<div class="samplib-clearfix"></div>';
          $out .= '</div>';
          $out .= '<div class="samplib-two-cols">';
            $out .= '<div class="samplib-one-half-left">';
              $out .= '<label>Price</label>';
              $out .= '<p class="samplib-input"> ';
                $out .= '<label id="samplib-price-label">$200</label>';
                $out .= '<div id="samplib-price-slider" class="samplib-one-col"></div>';
                $out .= '<input type="hidden" name="samplib[price]" value="">';
              $out .= '</p>';
            $out .= '</div>';
            $out .= '<div class="samplib-clearfix"></div>';
          $out .= '</div>';
          $out .= '<div class="samplib-one-col">';
            $out .= '<div class="samplib-one-center">';
              $out .= '<a href="javascript:void" id="samplib-submit">'.__('Search', 'samplib').'</a>';
            $out .= '</div>';
            $out .= '<div class="samplib-clearfix"></div>';
          $out .= '</div>';
        $out .= '</form>';
      $out .= '</div><!-- samplib_custom_plugin_book_wrap -->';    
      $out .= '<div id="samplib_custom_plugin_form_wrap"></div>';
      return $out;
}
/*
Register All Shorcodes At Once
*/
add_action( 'init', 'samplib_register_shortcodes');
function samplib_register_shortcodes(){
	// Registered Shortcodes
	add_shortcode ('samplib-book-display', 'samplib_custom_plugin_book_display' );
};