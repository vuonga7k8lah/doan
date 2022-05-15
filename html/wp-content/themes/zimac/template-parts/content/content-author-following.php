<?php

use HSSC\Helpers\App;
use HSSC\Users\Models\FollowerModel;
use HSSC\Users\Models\UserModel;

$userID = get_queried_object()->ID;

// PAGINATION
$number   = 12;
$paged    = $_GET['myPaged'] ?? 1;
$offset   = ($paged - 1) * $number;
$aQuery = FollowerModel::getAUserMeFollowing($userID, [
    'number'    => $number,
    'offset'    => $offset,
    'paged'     => $paged
]);
$aUserFollowings = $aQuery['data'];
$totalItems =  $aQuery['totalItems'];
$totalPages = ceil($totalItems / $number);

?>
<?php if (empty($aUserFollowings)) : ?>
    <div class="py-10 text-gray-800 dark:text-gray-200">
        <?php echo esc_html__('You doesn‘t have any followers yet.', 'zimac'); ?>
    </div>
<?php endif; ?>
<?php if (!empty($aUserFollowings)) : ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
        <?php foreach ($aUserFollowings as $oUser) : ?>
            <?php echo App::get('AuthorCardItemSc')->renderSc([
                'id'           => $oUser->ID,
                'name'         => $oUser->data->display_name,
                'number_posts' => count_user_posts($oUser->ID, 'post', true),
                'avatar'       => UserModel::getUrlAvatarAuthor($oUser->ID),
                'url'          => get_author_posts_url($oUser->ID),
                'type'         => FollowerModel::checkIsFollowingUser(get_current_user_id(), $oUser->ID) ? "following" : "follow",
            ]); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($totalItems > count($aUserFollowings)) : ?>
    <div id="pagination" class="clearfix">
        <?php echo paginate_links(array(
            'format'        => '?myPaged=%#%',
            'current'       => $paged,
            'total'         => $totalPages,
            'prev_text'     => '<span class="w-10 h-10 bg-white dark:bg-black flex items-center justify-center rounded-full text-2xl"><span class="sr-only">Next</span><i class="las la-angle-left"></i></span>',
            'next_text'     => '<span class="w-10 h-10 bg-white dark:bg-black flex items-center justify-center rounded-full text-2xl"><span class="sr-only">Next</span><i class="las la-angle-right"></i></span>',
        ));  ?>
    </div>
<?php endif; ?>
