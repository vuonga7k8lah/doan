<?php

use HSSC\Helpers\FunctionHelper;
use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\BookmarkModel;
use HSSC\Users\Models\UserModel;

/**
 * Undocumented function
 *
 * @param WP_Post $oPost
 * @param string $featured_image_size
 * @return array
 */
function getDataValueOfPost(WP_Post $oPost, string $featured_image_size): array
{
    $aCategories = FunctionHelper::getPostTermInfoWithNumberDetermined($oPost->ID);
    // GET COUNTVIEWS
    $countViews = UserModel::getCountViewByPostID($oPost->ID);
    return [
        'id'                => $oPost->ID,
        'is_saved'          => BookmarkModel::get([
            'post_id' => $oPost->ID,
            'user_id' => get_current_user_id()
        ]),
        'name'              => $oPost->post_title,
        'featured_image'    => FunctionHelper::getPostFeaturedImage($oPost->ID, $featured_image_size),
        'url'               => get_permalink($oPost->ID),
        'number_views'      => $countViews,
        'number_comments'   => $oPost->comment_count,
        'category_name'     => $aCategories[0]['name'],
        'author_avatar'     => UserModel::getUrlAvatarAuthor($oPost->post_author),
        'author_name'       => get_the_author_meta('display_name', $oPost->post_author),
        'created_day'       => FunctionHelper::getDateFormat($oPost->post_date, 'd'),
        'created_month'     => FunctionHelper::getDateFormat($oPost->post_date, 'M'),
    ];
}
