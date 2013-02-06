<?php

// Pending deals
if ( gb_account_merchant_id() && function_exists( 'gb_deal_preview_available' ) ) {
	$deals= null;
	$args=array(
		'post_type' => gb_get_deal_post_type(),
		'post__in' => gb_get_merchants_deal_ids( gb_account_merchant_id() ),
		'post_status' => array( 'pending', 'draft', 'future', 'private' ),
		'posts_per_page' => -1, // return this many

	);
	$deals = new WP_Query( $args );
	if ( $deals->have_posts() ) {
?>
			<div class="dashboard-container">
				<table class="report_table merchant_dashboard"><!-- Begin .purchase-table -->

					<thead>
						<tr>
							<th class="purchase_history_status"><?php gb_e( 'Status' ); ?></th>
							<th class="purchase_history_title"><?php gb_e( 'Pending Deals' ); ?></th>
							<th><?php gb_e( 'Previews' ); ?></th>
						</tr>
					</thead>

					<tbody>
					<?php
		while ( $deals->have_posts() ) : $deals->the_post();
		if ( gb_get_status() !== 'closed' ) {
?>
							<tr>
								<td class="purchase_history_status"><?php echo get_post_status( get_the_ID() ) ?></td>
								<td class="purchase_history_title">
									<?php the_title() ?>
								</td>
								<td class="td_deal_preview va-middle">
									<?php if ( gb_deal_preview_available() ): ?>
										<a href="<?php gb_deal_preview_link() ?>" class="report_button" target="_blank"><?php gb_e( 'Deal Preview' ) ?></a>
										<br/>
									<?php endif ?>
									<?php if ( gb_voucher_preview_available() ): ?>
										<a href="<?php gb_voucher_preview_link() ?>" class="report_button" target="_blank"><?php gb_e( 'Voucher Preview' ) ?></a>
									<?php endif ?>
								</td>
							</tr>
						<?php
		}
		endwhile;
?>
					</tbody>
				</table><!-- End .purchase-table -->
			</div><!-- End .dashboard-container -->
			<?php
	}
}
?>

<div class="dashboard-container">

	<?php
if ( gb_account_merchant_id() ) {
	$deals= null;
	$args=array(
		'post_type' => gb_get_deal_post_type(),
		'post__in' => gb_get_merchants_deal_ids( gb_account_merchant_id() ),
		'post_status' => 'publish',
		'posts_per_page' => -1, // return this many

	);
	$deals = new WP_Query( $args );
	if ( $deals->have_posts() ) {
?>

				<span class="full_history_report clearfix"><a href="<?php gb_merchant_purchases_report_url( $postID ) ?>" class="report_button"><?php gb_e( 'Purchase History' ) ?></a></span>
				<table class="report_table"><!-- Begin .purchase-table -->

					<thead>
						<tr>
							<th class="purchase_history_status"><?php gb_e( 'Status' ); ?></th>
							<th class="purchase_history_title"><?php gb_e( 'Deal' ); ?></th>
							<th><?php gb_e( 'Total Sold' ); ?></th>
							<th><?php gb_e( 'Published' ); ?></th>
							<th><?php gb_e( 'Reports' ); ?></th>
						</tr>
					</thead>

					<tbody>
					<?php
		while ( $deals->have_posts() ) : $deals->the_post();
?>
						<tr>
							<td class="purchase_history_status"><?php echo gb_get_status() ?></td>
							<td class="purchase_history_title">
								<?php the_title() ?>
								<br/>
								<a href="<?php the_permalink() ?>"><?php gb_e( 'View Deal' ) ?></a>
							</td>
							<td><?php gb_number_of_purchases() ?></td>
							<td><?php the_time() ?> <?php the_time() ?></td>
							<td>
								<?php gb_merchant_purchase_report_link() ?>
								<?php gb_merchant_voucher_report_link() ?>
							</td>
						</tr>
					<?php
		endwhile;
?>
					</tbody>
				</table><!-- End .purchase-table -->
				<?php
	} else {
		echo '<p>'.gb__( 'No sales info.' ).'</p>';
	}
} else {
	echo '<p>'.gb__( 'Restricted to Businesses.' ).'</p>';
}
?>

</div><!-- End .dashboard-container -->