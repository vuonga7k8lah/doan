<?php

use HSSC\Users\Models\BookmarkModel;

$userID = get_queried_object()->ID;

// CHECK PERMISSION
if (get_current_user_id() !== $userID) {
    echo  '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">';
    echo  'Sorry! You can not access this page.';
    echo  '</div>';
    return;
}

$aBookmarks = BookmarkModel::getAllPostSavedByUserId($userID);

$aPostIds = [];
foreach ($aBookmarks as $oBookmark) {
    $aPostIds[] = $oBookmark->post_id;
}
$aPosts = [];
if (!empty($aPostIds)) {
    $aPosts = get_posts([
        'include' => $aPostIds
    ]);
}

?>

<?php if (!empty($aPosts)) { ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
        <?php
        foreach ($aPosts as $oPost) {
            zimac_render_post_card(['post' => $oPost]);
        }
        wp_reset_postdata();
        ?>
    </div>
<?php
    zimac_render_post_pagination();
} else {
    zimac_render_content_none();
}
?>
