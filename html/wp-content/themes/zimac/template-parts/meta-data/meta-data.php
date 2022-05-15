<?php
if (defined('HSBLOG2_ACTION_PREFIX')) :
	$aArgs = wp_parse_args($args, [
		'user_id'        => '',
		'post_id'        => '',
		'number_comment' => '',
		'post_url'       => '#',
		'gridClassName'  => 'grid-cols-1'
	]);
?>

	<div class="grid gap-2 md:gap-3 text-sm lg:text-base font-medium text-primary pb-8 <?php echo esc_attr($aArgs['gridClassName']); ?>">
		<?php
		echo do_shortcode(sprintf(
			'[hs_number_views post_id="%1$d" user_id="%2$d"]',
			$aArgs['post_id'],
			$aArgs['user_id']
		));
		echo do_shortcode(sprintf('[hs_number_comments number_comments="%1$d"]', $aArgs['number_comment']));
		echo do_shortcode(sprintf(
			'[hs_bookmark post_id="%1$d" user_id="%2$d"]',
			$aArgs['post_id'],
			$aArgs['user_id']
		));
		echo do_shortcode(sprintf('[hs_share_to_social post_url="%1$s"]', $aArgs['post_url']));
		?>
	</div>
<?php endif; ?>