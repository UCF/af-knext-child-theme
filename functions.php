<?php
//namespace knext\Theme;

define( 'KNEXT_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );


// Theme foundation
include_once KNEXT_THEME_DIR . 'includes/config.php';
include_once KNEXT_THEME_DIR . 'includes/meta.php';

// Add other includes to this file as needed.

/**
 * Register category-menus menu location
 *
 * @since 0.2.1
 * @author Mike Setzer
 **/

function af_knext_theme_register_menus() {
    register_nav_menus(array(
        'category-menus' => __('Category Menus', 'af-knext-child-theme')
    ));
}
add_action('after_setup_theme', 'af_knext_theme_register_menus');



/**
 * Add CSS classes to category-menu li items
 *
 * @since 0.2.1
 * @author Mike Setzer
 **/

function my_custom_menu_item_classes($classes, $item, $args, $depth) {
    if ('category-menus' === $args->theme_location) {
        $classes[] = 'nav-item my-1 d-block'; // Add your custom class
    }

    //Array for special nav items
    $special_items = array('General', 'Finance', 'Human Resources', 'All Posts', 'Top Priority');

    //Add custom class to non-special nav items
    if ('category-menus' === $args->theme_location && !in_array($item->title, $special_items)) {
    	$classes[] = ' pl-3 '; // Add custom class
    }

    //Add custom class to special nav items
    if ('category-menus' === $args->theme_location && in_array($item->title, $special_items)) {
        $classes[] = 'bg-inverse'; // Add 'bg-inverse' class
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'my_custom_menu_item_classes', 10, 4);



/**
 * Add CSS classes to category-menu anchor items
 *
 * @since 0.2.1
 * @author Mike Setzer
 **/

function my_custom_menu_link_attributes($atts, $item, $args, $depth) {
    if ('category-menus' === $args->theme_location) {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' nav-link' : 'nav-link'; // Add your custom class
    }

    //Check if nav item is General, Finance, or HR, and modify styles
    $special_items = array('General', 'Finance', 'Human Resources', 'All Posts', 'Top Priority');

    if ('category-menus' === $args->theme_location && in_array($item->title, $special_items)) {
        $existing_classes = isset($atts['class']) ? $atts['class'] : '';
        $atts['class'] = $existing_classes . ' text-inverse'; // Add 'text-inverse' class
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'my_custom_menu_link_attributes', 10, 4);



/**
 * Enable excerpt field for Advanced Post Creation
 *
 * @since 0.2.1
 * @author Mike Setzer
 **/

add_filter( 'gform_advancedpostcreation_excerpt', 'enable_excerpt', 10, 1 );
function enable_excerpt( $enable_excerpt ){
	return true;
}



/**
 * Sort Gravity Forms category checkboxes hierarchically
 *
 * @since 0.2.2
 * @author Mike Setzer
 **/

add_filter( 'gform_pre_render', 'sort_categories_hierarchically' );
add_filter( 'gform_pre_validation', 'sort_categories_hierarchically' );
add_filter( 'gform_pre_submission_filter', 'sort_categories_hierarchically' );
add_filter( 'gform_admin_pre_render', 'sort_categories_hierarchically' );

function sort_categories_hierarchically( $form ) {
    foreach ( $form['fields'] as &$field ) {
        if ( $field->type == 'post_category' && $field->inputType == 'checkbox' ) {
            $categories = get_categories( array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hierarchical' => true,
                'parent' => 0,
            ) );

            $choices = array();
            foreach ( $categories as $category ) {
                $choices[] = array( 'text' => $category->name, 'value' => $category->term_id );
                $subcategories = get_categories( array(
                    'taxonomy'   => 'category',
                    'hide_empty' => false,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hierarchical' => true,
                    'parent' => $category->term_id,
                ) );

                foreach ( $subcategories as $subcategory ) {
                    $choices[] = array( 'text' => '— ' . $subcategory->name, 'value' => $subcategory->term_id );
                }
            }

            $field->choices = $choices;
        }
    }

    return $form;
}



/**
 * Add custom "Workday" list layout for UCF Post List shortcode
 *
 * @since 0.2.1
 * @author Mike Setzer
 **/

if ( ! function_exists( 'ucfwp_post_list_display_workday_before' ) ) {
	function ucfwp_post_list_display_workday_before( $content, $posts, $atts ) {
		ob_start();
	?>
	<div class="ucf-post-list ucfwp-post-list-workday" id="post-list-<?php echo $atts['list_id']; ?>">
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_post_list_display_workday_before', 'ucfwp_post_list_display_workday_before', 10, 3 );


if ( ! function_exists( 'ucfwp_post_list_display_workday' ) ) {
	function ucfwp_post_list_display_workday( $content, $posts, $atts ) {
		if ( $posts && ! is_array( $posts ) ) { $posts = array( $posts ); }

		$item_col = 'col-lg';
		if ( $atts['posts_per_row'] > 0 && ( 12 % $atts['posts_per_row'] ) === 0 ) {
			// Use specific column size class if posts_per_row equates
			// to a valid grid size
			$item_col .= '-' . 12 / $atts['posts_per_row'];
		}

		ob_start();
	?>

	<?php if ( $posts ): ?>

		<div class="row">

		<?php
		foreach ( $posts as $index => $item ):
			$item_title   = apply_filters( 'ucfwp_post_list_workday_title', wptexturize( $item->post_title ), $item, $posts, $atts );
			$item_excerpt = $item_subhead = null;
			if ( filter_var( $atts['show_excerpt'], FILTER_VALIDATE_BOOLEAN ) ) {
				setup_postdata( $item );
				$excerpt_length = apply_filters( 'ucfwp_post_list_workday_excerpt_length', 25 );
				$item_excerpt = apply_filters( 'ucfwp_post_list_workday_excerpt', ucfwp_get_excerpt( $item, $excerpt_length ), $item, $posts, $atts );
			}
			if ( filter_var( $atts['show_subhead'], FILTER_VALIDATE_BOOLEAN ) ) {
				if ( $item->post_type === 'ucf_resource_link' ) {
					$resource_sources = wp_get_post_terms( $item->ID, 'sources', array( 'fields' => 'names' ) );
					if ( ! empty( $resource_sources ) && is_array( $resource_sources ) )  {
						$item_subhead = wptexturize( $resource_sources[0] );
					}
				}
				else {
					$item_subhead = date( 'M d', strtotime( $item->post_date ) );
				}
				$item_subhead = apply_filters( 'ucfwp_post_list_workday_subhead', $item_subhead, $item, $posts, $atts );
			}

			$item_link = '';
			if ( $item->post_type === 'ucf_resource_link' ) {
				$item_link = get_post_meta( $item->ID, 'ucf_resource_link_url', true );
			}
			else {
				$item_link = get_permalink( $item );
			}
			$item_link = apply_filters( 'ucfwp_post_list_workday_link', $item_link, $item, $posts, $atts );

			$item_img = $item_img_srcset = null;
			if ( $atts['show_image'] ) {
				$item_img        = UCF_Post_List_Common::get_image_or_fallback( $item, 'thumbnail' );
				$item_img_srcset = UCF_Post_List_Common::get_image_srcset( $item, 'thumbnail' );
			}

			if ( $atts['posts_per_row'] > 0 && $index !== 0 && ( $index % $atts['posts_per_row'] ) === 0 ) {
				echo '</div><div class="row">';
			}
		?>

			<div class="<?php echo $item_col; ?> mb-4 ucf-post-list-item">
				<article>
					<?php if ( $item_link ) : ?>
					<a class="d-block text-secondary workdayitem-link" href="<?php echo $item_link; ?>">
					<?php else: ?>
					<div class="text-default">
					<?php endif; ?>

						<div class="row">
							<?php if ( $item_img ) : ?>
							<div class="col-3 col-md-2 pr-0">
								<img src="<?php echo $item_img; ?>" srcset="<?php echo $item_img_srcset; ?>" class="ucf-post-list-thumbnail-image img-fluid" alt="">
							</div>
							<?php endif; ?>

							<div class="col">
								<h3 class="workday-item-heading"><?php echo $item_title; ?></h3>

								<?php if ( $item_excerpt ): ?>
								<div class="workday-item-excerpt"><?php echo $item_excerpt; ?></div>
								<?php endif; ?>

								<?php if ( $item_subhead ): ?>
								<div class="small text-default mt-2 workday-item-subhead"><?php echo $item_subhead; ?></div>
								<?php endif; ?>
							</div>
						</div>

					<?php if ( $item_link ): ?>
					</a>
					<?php else: ?>
					</div>
					<?php endif; ?>
				</article>
			</div>

		<?php endforeach; ?>

		</div>

	<?php else: ?>
		<div class="ucf-post-list-error">No results found.</div>
	<?php
		endif;

		return ob_get_clean();
	}
}

add_filter( 'ucf_post_list_display_workday', 'ucfwp_post_list_display_workday', 10, 3 );
