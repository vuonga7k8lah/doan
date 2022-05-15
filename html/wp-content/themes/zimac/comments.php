<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

use ZIMAC\Comment\Controllers\CommentController;
use HSSC\Reports\Controllers\ReportsController;

if (post_password_required()) {
	return;
}

if (is_user_logged_in() && isset($_POST['report-comment-id']) && isset($_POST['report-message'])) {
	if (defined('HSBLOG2_SC_PREFIX')) {
		$addPostArgs = [
			'post_author' 	=> get_current_user_id(),
			'post_content' 	=> $_POST['report-message'],
			'post_title' 	=> 'comment id: ' . $_POST['report-comment-id'],
			'post_type' 	=> 'report',
			'post_status' 	=> 'pending',
		];
		ReportsController::doActionReportComment($addPostArgs);
	}
}
?>

<div id="comments" class="comments-area">
	<?php

	// You can start editing here -- including this comment!
	if (have_comments()) :
	?>
		<h5 class="mb-5 text-gray-800 dark:text-gray-200">
			<?php
			printf(
				esc_html__('Response (%d)', 'zimac'),
				get_comments_number()
			);
			?>
		</h5><!-- .comments-title -->
		<?php the_comments_navigation(); ?>

		<ol class="comment-list comments space-y-8">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback' => [new CommentController(get_comments_number()), 'renderThemeComment'],
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if (!comments_open()) :
		?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'zimac'); ?></p>
	<?php
		endif;
		// echo '<hr class="w-full border-t-2 border-gray-200 dark:border-gray-700 my-8" />';

	endif; // Check for have_comments().


	//Array
	$comments_args = [
		'comment_notes_before' 	=> '<span class="col-span-2 col-end-3 mb-5">' . esc_html__('Your email address will not be published. Required fields are marked *', 'zimac') . '</span>',
		'class_form' 			=> 'mb-8 grid grid-cols-2 gap-x-4 gap-y-5',
		//Define Fields
		'fields' 				=> [
			//Author field
			'author' 	=> '<div class="inline-block"><div class="wil-input relative"><input name="author" id="author" aria-required="true" required type="text" aria-label="' . esc_attr__('Name*', 'zimac') . '" placeholder="' . esc_attr__('Name*', 'zimac') . '" class=" px-5 h-14 w-full border-2 border-gray-300 dark:border-gray-600 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base focus:border-primary focus:ring-0 font-medium"></div></div>',
			//Email Field
			'email' 	=> '<div class="inline-block"><div class="wil-input relative"><input name="email" id="email" aria-required="true" required type="email" aria-label="' . esc_attr__('Email*', 'zimac') . '" placeholder="' . esc_attr__('Email*', 'zimac') . '" class=" px-5 h-14 w-full border-2 border-gray-300 dark:border-gray-600 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base focus:border-primary focus:ring-0 font-medium"></div></div>',
			// Url
			'url' 		=> '',
			//Cookies
			'cookies' 	=> '',
		],
		// Change the title of send button
		'submit_button' 			=> '<button  name="%1$s" type="submit" id="%2$s" class="wil-button rounded-full h-14 w-full text-gray-900 dark:text-gray-200 bg-gray-200 dark:bg-gray-900 text-xs lg:text-sm xl:text-body inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">' . esc_html__('Post Comments', 'zimac') . '</button>',
		'title_reply_before' 	=> '<h5>',
		'title_reply_after' 	=> '</h5>',
		// Change the title of the reply section
		'title_reply' 			=> esc_html__('Leave a comment', 'zimac'),
		// Change the title of the reply section
		'title_reply_to' 		=> esc_html__('Reply', 'zimac'),
		//Cancel Reply Text
		'cancel_reply_link' 	=> esc_html__('Cancel reply', 'zimac'),
		// Redefine your own textarea (the comment body).
		'comment_field' 		=> '<span class="flex col-span-2 col-end-3"><textarea id="comment" name="comment"  aria-required="true" required class="h-40 py-3 px-5 border-2 border-gray-300 dark:border-gray-600 w-full rounded-[30px] placeholder-gray-600 bg-transparent text-xs md:text-base focus:border-primary focus:ring-0 font-medium" placeholder="' . esc_html__('What are your thought?', 'zimac') . '"></textarea></span>',

	];

	comment_form($comments_args);
	?>

</div><!-- #comments -->
