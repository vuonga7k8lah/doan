<?php

use ZIMAC\Author\Controllers\AuthorController;

$userID = get_queried_object()->ID;

//  ------ Update user from page edit-profile ------
if (defined('HSBLOG2_SC_PREFIX') && isset($_POST['submitUpdateUser']) && current_user_can('edit_user', $userID)) {
	$oAuthor = new AuthorController($userID);
	//  ------ Update displayName   ------
	$oAuthor->updateUserDisplayName($_POST['display_name']);
	//  ------ Update userMeta  ------
	unset($_POST['submitUpdateUser']);
	unset($_POST['display_name']);
	$oAuthor->updateUserMeta($_POST);
}

get_header();
?>

<div class="wil-author-page bg-gray-100 dark:bg-gray-800 ">
	<?php
	zimac_render_author_header();
	$currentPageType = $_GET['pageType'] ?? '';
	?>

    <div class="<?php echo esc_attr(($currentPageType === 'about' && defined('HSBLOG2_SC_PREFIX')) ?
		"max-w-screen-lg mx-auto px-10px lg:px-4 pt-13 pb-20 text-base md:text-body text-gray-700" :
		'wil-container container py-13'); ?>">
		<?php
		if ($currentPageType !== 'edit-profile' && defined('HSBLOG2_SC_PREFIX')) {
			zimac_render_author_page_tab();
        }
		?>
		<?php
		if (defined('HSBLOG2_SC_PREFIX')) {
			switch ($currentPageType) {
				case 'about':
					zimac_render_author_content_about();
					break;
				case 'saved':
					zimac_render_author_content_saved();
					break;
				case 'followers':
					zimac_render_author_content_followers();
					break;
				case 'following':
					zimac_render_author_content_following();
					break;
				case 'edit-profile':
					zimac_render_author_content_edit_profile();
					break;
				default:
					zimac_render_author_content_articles();
					break;
			}
		} else {
			zimac_render_author_content_articles();
		}
		?>
    </div>
</div>

<?php
get_footer();
?>
