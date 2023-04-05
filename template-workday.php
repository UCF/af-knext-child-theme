<?php
/**
 * Template Name: Workday Progress Tracker
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
						'theme_location' => 'category-menus',
						'container' => 'nav',
						'container_class' => 'flex-column nav-pills pl-0',
						'menu_id' => 'wpt-menu',
						'menu_class' => 'pl-0'
					)); ?>
				</div>

				<!-- Right side: List of posts -->
				<div class="col-12 col-md-9">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</article>

<?php get_footer(); ?>
<?php
