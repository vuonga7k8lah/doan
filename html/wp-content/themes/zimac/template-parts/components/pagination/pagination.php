<?php

$post_type = get_post_type_object(get_post_type());
$post_type_name = '';
if (
	is_object($post_type) &&
	property_exists($post_type, 'labels') &&
	is_object($post_type->labels) &&
	property_exists($post_type->labels, 'name')
) {
	$post_type_name = $post_type->labels->name;
}

the_posts_pagination(
	[
		'prev_text' => '<span class="w-10 h-10 bg-white dark:bg-black flex items-center justify-center rounded-full text-2xl"><span class="sr-only">' .
			esc_html__('Prev', 'zimac') . '</span><i class="las la-angle-left"></i></span>',
		'next_text' => '<span class="w-10 h-10 bg-white dark:bg-black flex items-center justify-center rounded-full text-2xl"><span class="sr-only">' .
			esc_html__('Next', 'zimac') . '</span><i class="las la-angle-right"></i></span>',
	]
);
