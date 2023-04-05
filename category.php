<?php get_header(); ?>

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
			<h2 class="heading-underline mb-4 text-secondary"><?php single_cat_title(); ?> Posts</h2>
			<?php if ( have_posts() ): ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="<?php echo $post->post_status; ?> ucf-news-item-content media-body mb-4 position-relative">
						<!-- Title -->
						<h3>
							<a class="ucf-workday-item-title d-block text-decoration-none h5 mb-2 pb-1 stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<!-- Excerpt -->
						<div class="ucf-workday-item-excerpt font-size-sm mb-2">
							<?php the_excerpt(); ?>
						</div>
						<!-- Post categories -->
						<div class="d-block mb-1">
							<?php
							$categories = get_the_category();
							if ($categories) {
								foreach ($categories as $category) {
									$category_link = get_category_link($category->term_id);
									echo '<span class="ucf-workday-section-category badge badge-primary"><a class="text-decoration-none text-secondary" href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></span> ';
								}
							}
							?>
						</div>
						<!-- Date -->
						<div class="meta">
							<span class="date text-muted text-uppercase letter-spacing-3 font-size-sm"><?php the_time( 'F j, Y' ); ?></span>
						</div>
					</article>
				<?php endwhile; ?>

				<?php ucfwp_the_posts_pagination(); ?>
			<?php else: ?>
				<p>No results found.</p>
			<?php endif; ?>
		</div>
	</div>


</div>

<?php get_footer(); ?>
