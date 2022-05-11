<?php

$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_name === 'finance-hr-accordions' ) :

	if( have_rows('finance_repeater') ): ?>

	<div id="finance-accordion" class="repeater-container my-5">

		<?php
		$count = 0;
		while( have_rows('finance_repeater') ): the_row();

			$financeheader = get_sub_field('finance_business_center_title');
			$financecontent = get_sub_field('finance_business_center_info');

			?>

			<div class="card">

				<div class="card-header" role="tab" id="finance-heading-<?php echo $count; ?>">
					<h4 class="finance-header mb-0" href="finance-collapse-<?php echo $count; ?>" aria-expanded="false"
						aria-controls="collapse-<?php echo $count;?>">
						<a data-toggle="collapse" href="#finance-collapse-<?php echo $count; ?>" aria-expanded="false"
						   aria-controls="collapse-<?php echo $count; ?>">
							<?php echo $financeheader; ?>
						</a>
					</h4>
				</div>
				<div id="finance-collapse-<?php echo $count; ?>" class="collapse" role="tabpanel"
					 aria-labelledby="finance-heading-<?php echo $count; ?>" data-parent="#finance-accordion">
					<div class="finance-content"><?php echo $financecontent; ?></div>
				</div>

			</div>

		<?php
		$count++;
		endwhile; ?>

		<div class="clear"></div>

	</div>

<?php
	endif;

	if( have_rows('hr_repeater') ): ?>

		<div id="finance-accordion" class="repeater-container my-5">

			<?php
			$count = 0;
			while( have_rows('finance_repeater') ): the_row();

				$hrheader = get_sub_field('hr_business_center_title');
				$hrcontent = get_sub_field('hr_business_center_info');

				?>

				<div class="card">

					<div class="card-header" role="tab" id="hr-heading-<?php echo $count; ?>">
						<h4 class="hr-header mb-0" href="hr-collapse-<?php echo $count; ?>" aria-expanded="false"
							aria-controls="collapse-<?php echo $count;?>">
							<a data-toggle="collapse" href="#hr-collapse-<?php echo $count; ?>" aria-expanded="false"
							   aria-controls="collapse-<?php echo $count; ?>">
								<?php echo $hrheader; ?>
							</a>
						</h4>
					</div>
					<div id="hr-collapse-<?php echo $count; ?>" class="collapse" role="tabpanel"
						 aria-labelledby="hr-heading-<?php echo $count; ?>" data-parent="#hr-accordion">
						<div class="hr-content"><?php echo $hrcontent; ?></div>
					</div>

				</div>

				<?php
				$count++;
			endwhile; ?>

			<div class="clear"></div>

		</div>

	<?php
	endif;
endif;

