<?php

// === COMPONENTS ===


/**
 *
 * @return void
 */
function zimac_render_modal_form_edit_comment(array $args = [])
{
	get_template_part('template-parts/components/modal-form-report/modal-form-edit-comment', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_modal_form_delete_comment(array $args = [])
{
	get_template_part('template-parts/components/modal-form-report/modal-form-delete-comment', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_modal_form_report_comment_result(array $args = [])
{
	get_template_part('template-parts/components/modal-form-report/modal-form-report-result', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_modal_form_report_comment(array $args = [])
{
	get_template_part('template-parts/components/modal-form-report/modal-form-report', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_single_related_posts(array $args = [])
{
	get_template_part('template-parts/components/single-related-posts/single-related-posts', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_archive_page_has_hssc_plugin()
{
	get_template_part('template-parts/content/content-archive-has-plugin');
}

/**
 *
 * @return void
 */
function zimac_render_archive_page_default()
{
	get_template_part('template-parts/content/content-archive-default');
}

/**
 *
 * @return void
 */
function zimac_render_modal_categories(array $args = [])
{
	get_template_part('template-parts/components/modal-categories/modal-categories', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_category_card(array $args = [])
{
	get_template_part('template-parts/components/category-card/category-card', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_search_page_content_authors()
{
	get_template_part('template-parts/content/content-search-authors');
}

/**
 *
 * @return void
 */
function zimac_render_search_page_content_tags()
{
	get_template_part('template-parts/content/content-search-tags');
}

/**
 *
 * @return void
 */
function zimac_render_search_page_content_categories()
{
	get_template_part('template-parts/content/content-search-categories');
}

/**
 *
 * @return void
 */
function zimac_render_search_page_content_articles()
{
	get_template_part('template-parts/content/content-search-articles');
}

/**
 *
 * @return void
 */
function zimac_render_search_page_tabs()
{
	get_template_part('template-parts/components/search-page-tab/search-page-tab');
}

/**
 *
 * @return void
 */
function zimac_render_search_header()
{
	get_template_part('template-parts/components/search-header/search-header');
}

/**
 *
 * @return void
 */
function zimac_render_author_content_edit_profile()
{
	get_template_part('template-parts/content/content-author-edit-profile');
}

/**
 *
 * @return void
 */
function zimac_render_author_content_following()
{
	get_template_part('template-parts/content/content-author-following');
}

/**
 *
 * @return void
 */
function zimac_render_author_content_followers()
{
	get_template_part('template-parts/content/content-author-followers');
}

/**
 *
 * @return void
 */
function zimac_render_author_content_saved()
{
	get_template_part('template-parts/content/content-author-saved');
}

/**
 *
 * @return void
 */
function zimac_render_author_content_about()
{
	get_template_part('template-parts/content/content-author-about');
}

/**
 *
 * @return void
 */
function zimac_render_author_content_articles()
{
	get_template_part('template-parts/content/content-author-articles');
}

/**
 *
 * @return void
 */
function zimac_render_author_page_tab()
{
	get_template_part('template-parts/components/author-page-tab/author-page-tab');
}

/**
 *
 * @return void
 */
function zimac_render_post_card_author(array $args)
{
	get_template_part('template-parts/components/post-card/post-card-author', null, $args);
}

/**
 *
 * @return void
 */
function zimac_render_post_card(array $args)
{
	get_template_part('template-parts/components/post-card/post-card', null, $args);
}

/**
 * Undocumented function
 *
 * @return void
 */
function zimac_render_post_pagination()
{
	get_template_part('template-parts/components/pagination/pagination');
}

/**
 * Undocumented function
 *
 * @return void
 */
function zimac_render_author_header()
{
	get_template_part('template-parts/components/author-header/author-header');
}


/**
 * Undocumented function
 * @param  ['user_id'=>'','post_id'=> '','number_comment'=>'','post_url'=> '#']
 * @return void
 */
function zimac_render_single_meta_data(array $args)
{
	get_template_part('template-parts/meta-data/meta-data', null, $args);
}

/**
 * Undocumented function
 *
 * @return void
 */
function zimac_render_single_author()
{
	get_template_part('template-parts/components/single-author/single-author');
}

/**
 * Single header
 *
 * @return void
 */
function zimac_render_single_header()
{
	get_template_part('template-parts/components/single-header/single-header');
}

//
/**
 * Undocumented function
 *
 * @return void
 */
function zimac_render_single_header2()
{
	get_template_part('template-parts/components/single-header/single-header2');
}

/**
 * Undocumented function
 *
 * @return void
 */
function zimac_render_single_header3()
{
	get_template_part('template-parts/components/single-header/single-header3');
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_single_header_common_meta(array $args = [])
{
	get_template_part('template-parts/components/single-header/common-meta', null, $args);
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_single_list_tags(array $args = [])
{
	get_template_part('template-parts/components/single-list-tags/single-list-tags', null, $args);
}

// ===  CONTENT ===
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_content_submitted_posts(array $args = [])
{
	get_template_part('template-parts/content/content-submitted-post', null, $args);
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_content_home(array $args = [])
{
	get_template_part('template-parts/content/content-home', null, $args);
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_content_none(array $args = [])
{
	get_template_part('template-parts/content/content-none', null, $args);
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_content_page(array $args = [])
{
	get_template_part('template-parts/content/content-page', null, $args);
}

//
/**
 * Undocumented function
 *
 * @return void
 */
function zimac_render_content_single()
{
	get_template_part('template-parts/content/content-single');
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_socials_login()
{
	get_template_part('template-parts/components/socials-login/socials-login');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_widget4()
{
	get_template_part('template-parts/footer/footer-widget-4');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_widget3()
{
	get_template_part('template-parts/footer/footer-widget-3');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_widget2()
{
	get_template_part('template-parts/footer/footer-widget-2');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_widget1()
{
	get_template_part('template-parts/footer/footer-widget-1');
}

/**
 * @return bool
 */
function zimac_is_footer_active()
{
	$aFooters = [
		ZIMAC_THEME_PREFIX . 'first-footer',
		ZIMAC_THEME_PREFIX . 'second-footer',
		ZIMAC_THEME_PREFIX . 'third-footer',
		ZIMAC_THEME_PREFIX . 'four-footer',
	];

	foreach ($aFooters as $key) {
		if (is_active_sidebar($key)) {
			return true;
		}
	}

	return false;
}

/**
 * @return bool
 */
function zimac_is_mobile_menu_activating(): bool
{
	return has_nav_menu(ZIMAC_THEME_PREFIX . '_sidebar_menu');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_widget_recent_posts()
{
	get_template_part('template-parts/footer/footer-widget-recent-posts');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_modal_forgot_password()
{
	get_template_part('template-parts/footer/footer-modal-form-forgot-password');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_modal_sign_in_form()
{
	get_template_part('template-parts/footer/footer-modal-form-sign-in');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_modal_sign_up_form()
{
	get_template_part('template-parts/footer/footer-modal-form-sign-up');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer_modal_nav_mobile()
{
	get_template_part('template-parts/footer/footer-modal-navigation-mobile');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_footer()
{
	get_template_part('template-parts/footer/footer');
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header_user()
{
	get_template_part('template-parts/header/site-header-user');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_switch_night_mode()
{
	get_template_part('template-parts/components/switch-night-mode/switch-night-mode');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header_socials()
{
	get_template_part('template-parts/header/site-header-socials');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header_input_search()
{
	get_template_part('template-parts/header/site-header-input-search');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header_logo(array $args = [])
{
	get_template_part('template-parts/header/site-header-logo', null, $args);
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header_nav()
{
	get_template_part('template-parts/header/site-header-nav');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header_brand()
{
	get_template_part('template-parts/header/site-header-brand');
}

/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_site_header()
{
	get_template_part('template-parts/header/site-header');
}

//
/**
 * Undocumented function
 *
 * @param [type] $args
 * @return void
 */
function zimac_render_single_sidebar(array $args = [])
{
	get_template_part('template-parts/sidebar/single-sidebar', null, $args);
}
