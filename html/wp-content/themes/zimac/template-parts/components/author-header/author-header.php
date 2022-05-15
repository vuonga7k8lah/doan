<?php

use HSSC\Helpers\App;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;
use HSSC\Users\Models\FollowerModel;

$userID = get_queried_object()->ID;
$name = get_the_author_meta('display_name', $userID);
$currentPageType = $_GET['pageType'] ?? '';
$authorLink = get_author_posts_url($userID);

// USE FOR DEFAULT THEME
$bgImage = 'https://images.pexels.com/photos/1450082/pexels-photo-1450082.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=750&amp;w=1260';

if (defined('HSBLOG2_SC_PREFIX')) {
    $bgImage = get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_page_background', true);
    if (!$bgImage) {
        $bgImage = ThemeOptionSkeleton::getField('author_page_header_section_default_bg')['url'];
    }
    $countFollowers = FollowerModel::getFollower(['user_id' => $userID]);
    $countFollowings = FollowerModel::getFollowing(['user_id' => $userID]);
}
?>
<header class="h-64 relative">
    <?php if ($bgImage) : ?>
        <img class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($bgImage); ?>" alt="<?php echo esc_attr($name); ?>">
    <?php endif; ?>
    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 flex items-end py-4">
        <div class="w-full">
            <div class="wil-container container">
                <div class="flex flex-col md:flex-row md:items-end justify-between md:space-x-4 space-y-4 md:space-y-0">
                    <div class="flex-grow flex items-end justify-between space-x-4 overflow-hidden">
                        <div class="rounded-1.5xl text-white flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0 flex-grow overflow-hidden p-1">
                            <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-1.5xl w-14 md:w-16 h-14 md:h-16 ring-2 ring-white wil-avatar-no-img">
                                <span class="wil-avatar__name">
                                    <?php echo esc_html(substr($name, 0, 1)); ?>
                                </span>
                            </div>
                            <div>
                                <span class="block text-body font-bold truncate">
                                    <?php echo esc_html($name); ?>
                                </span>

                                <?php if (defined('HSBLOG2_SC_PREFIX')) : ?>
                                    <span class="block text-sm font-medium text-gray-400 truncate">
                                        <?php echo esc_html(get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_job_name', true)); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- CAN WAIT PLUGIN DONE -->
                        <div class="flex-shrink-0 block md:hidden p-1">
                            <button class="wil-button rounded-full h-11 text-gray-900 dark:text-gray-200 bg-primary text-xs lg:text-sm xl:text-body inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">
                                <?php echo esc_html__('Following', 'zimac'); ?>
                            </button>
                        </div>
                    </div>
                    <?php if (defined('HSBLOG2_SC_PREFIX')) : ?>
                        <div class="flex-shrink-0 flex flex-wrap items-center text-gray-300 text-xs lg:text-sm xl:text-base">
                            <a href="<?php echo esc_url($authorLink . '?pageType=followers'); ?>" class="block py-2 px-4 leading-tight <?php echo esc_html($currentPageType === 'followers' ? 'border-2 border-white border-opacity-30 rounded-md text-primary mr-4' : 'text-white'); ?>">
                                <?php
                                printf(
                                    App::get('FunctionHelper')::translatePluralText(
                                        esc_html__('%s Follower', 'zimac'),
                                        esc_html__('%s Followers', 'zimac'),
                                        intval($countFollowers)
                                    ),
                                    $countFollowers
                                );
                                ?>
                            </a>
                            <a href="<?php echo esc_url($authorLink . '?pageType=following'); ?>" class="block py-2 px-4 leading-tight <?php echo esc_html($currentPageType === 'following' ? 'border-2 border-white border-opacity-30 rounded-md text-primary' : 'text-white'); ?> mr-2">
                                <?php
                                printf(
                                    App::get('FunctionHelper')::translatePluralText(
                                        esc_html__('%s Following', 'zimac'),
                                        esc_html__('%s Following', 'zimac'),
                                        intval($countFollowings)
                                    ),
                                    $countFollowings
                                );
                                ?>
                            </a>

                            <!-- CHECK USER CURRENT IS MYSELF THEN HIDDEN BUTTON -->
                            <?php if (get_current_user_id() !== $userID) : ?>
                                <?php
                                $isFollowing =  FollowerModel::checkIsFollowingUser(get_current_user_id(), $userID);
                                $isLogged = is_user_logged_in();
                                ?>
                                <div class="hidden md:block ml-1">
                                    <button class="btn-follow-user <?php echo esc_attr($isFollowing ? 'bg-primary text-gray-900' : ' bg-transparent border-2 border-opacity-30 border-gray-100 text-gray-100') ?>  wil-button rounded-full h-11 text-sm xl:text-base inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none " <?php echo esc_attr($isLogged ? null : 'data-open-modal=wil-modal-form-sign-in'); ?> <?php echo esc_attr(!$isLogged ? null : 'data-is-following=' . ($isFollowing ? "yes" : "no") . ''); ?> <?php echo esc_attr(!$isLogged ? null : 'data-user-id=' . $userID . ''); ?>>
                                        <?php
                                        if ($isFollowing) {
                                            echo esc_html__("Following", 'zimac');
                                        } else {
                                            echo esc_html__("Follow", 'zimac');
                                        }
                                        ?>
                                    </button>
                                </div>
                            <?php else : ?>
                                <?php $writePageLink = ThemeOptionSkeleton::getField('header_admin_user_wrire_artile_page_link'); ?>
                                <div class="hidden md:block ml-1">
                                    <a href="<?php echo esc_url($writePageLink); ?>" class="bg-primary text-gray-900 wil-button rounded-full h-11 text-sm xl:text-base inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">
                                        <?php echo (esc_html__("Write an article", 'zimac')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
