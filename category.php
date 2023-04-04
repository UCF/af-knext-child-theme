<?php get_header(); ?>

<div class="container mt-4 mb-5 pb-sm-4">
	<div class="row">

		<!-- Left menu -->
		<div class="col-3">
			<?php wp_nav_menu(array(
				'theme_location' => 'category-menus',
				'container' => 'nav',
				'container_class' => 'flex-column nav-pills',
				'menu_id' => 'wpt-menu'
			)); ?>
		</div>

		<!-- Right side: List of posts -->
		<div class="col-9">
			<?php if ( have_posts() ): ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="<?php echo $post->post_status; ?> ucf-news-item-content media-body mb-4 position-relative">
						<!-- Title -->
						<h3>
							<a class="ucf-workday-item-title d-block text-decoration-none h5 mb-2 pb-1 stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<!-- Post categories -->
						<?php
						$categories = get_the_category();
						if ($categories) {
							foreach ($categories as $category) {
								$category_link = get_category_link($category->term_id);
								echo '<span class="ucf-workday-section-category badge badge-primary"><a class="text-decoration-none text-secondary" href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></span> ';
							}
						}
						?>
						<!-- Excerpt -->
						<div class="ucf-workday-item-excerpt font-size-sm">
							<?php the_excerpt(); ?>
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
