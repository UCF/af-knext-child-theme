<?php
/**
 * Template Name: Workday Top Priority
 * Template Post Type: page, post
 */
?>
<?php get_header(); the_post(); ?>

	<article class="<?php echo $post->post_status; ?> post-list-item">
		<div class="container mt-5 mb-5 pb-sm-4">
			<div class="row">

				<!-- Left menu -->
				<div class="col-12 col-md-3 flex-last">
					<h3 class="h5 mb-3">Categories</h3>
					<?php wp_nav_menu(array(
						'theme_location' => 'priority-menus',
						'container' => 'nav',
						'container_class' => 'flex-column nav-pills pl-0',
						'menu_id' => 'priority-menu',
						'menu_class' => 'pl-0'
					)); ?>
				</div>

				<!-- Right side: List of posts -->
				<div class="d-block">
					<?php
					if ( have_rows('priority_repeater') ) :
						while ( have_rows('priority_repeater') ) : the_row();

							// Get the text field value
							$text_field_value = get_sub_field('priority_text');
							$link_field_value = get_sub_field('priority_link')
						?>
						<div class="mt-2 mt-md-4 col-md-6">
							<a class="media-background-container d-block w-100 h-100 hover-parent text-secondary hover-text-inverse text-decoration-none p-3 py-lg-4 px-lg-5 card card-outline-default" href="<?php echo $link_field_value; ?>" target="_blank" rel="noopener">
								<div class="media-background object-fit-cover bg-inverse-t-3 hover-child hover-child-show fade" data-object-fit="cover"></div>
								<h3 class="h5 my-3 heading-underline text-transform-none"><?php echo $text_field_value; ?></h3>
							</a>
						</div>
					<?php
						endwhile;
					else :
						// No rows found
						echo '<p>No repeater rows found.</p>';
					endif;
					?>
				</div>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</article>

<?php get_footer(); ?>
<?php
