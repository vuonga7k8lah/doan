<?php

namespace ZIMAC\Comment\Controllers;

use HSSC\Users\Models\CommentEmotionModel;

/**
 *
 */
class CommentController
{
    static $commentIndex = 0;
    static $commentCount = 0;
    static $numberMore = 4;

    public function __construct(int $commentCount = 0)
    {
        self::$commentCount = $commentCount;
        $this->doActionDeleteComment();
        $this->doActionEditComment();
    }


    public function doActionEditComment()
    {
        if (!defined('HSBLOG2_SC_PREFIX')) {
            return;
        }
        if (isset($_POST['edit-comment-id']) && isset($_POST['edit-comment-content'])) {
            if (current_user_can('edit_comment', $_POST['edit-comment-id'])) {
                $editArgs = [
                    'comment_ID' => $_POST['edit-comment-id'],
                    'comment_content' => $_POST['edit-comment-content']
                ];
                wp_update_comment($editArgs, true);
            }
        }
    }


    public function doActionDeleteComment()
    {
        if (!defined('HSBLOG2_SC_PREFIX')) {
            return;
        }
        if (isset($_POST['delete-comment-id'])) {
            if (current_user_can('edit_comment', $_POST['delete-comment-id'])) {
                wp_delete_comment($_POST['delete-comment-id']);
            }
        }
    }
    /**
     * render comment area on theme
     *
     * @param [type] $comment
     * @param [type] $args
     * @param [type] $depth
     * @return void
     */
    public static function renderThemeComment($comment, $args, $depth)
    {
        self::$commentIndex = 1 + self::$commentIndex;
        //
        if ('div' === $args['style']) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }

        $classses = self::$commentIndex > self::$numberMore ? 'hidden comment-body-hidden' : '';
?>
        <<?php echo esc_html($tag); ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
            <!-- === -->
            <?php if ('div' !== $args['style']) : ?>
                <div id="div-comment-<?php comment_ID(); ?>" class="comment-body relative <?php echo esc_attr($classses); ?>">
                <?php endif; ?>

                <?php
                $hasAvatar = !!$comment->comment_author_email && $args['avatar_size'] !== 0 && !strpos(get_avatar_url($comment), 'gravatar.com');
                $avatarSize =   $depth < 2 ? 'w-12 h-12' : 'w-10 h-10';
                ?>
                <div class="flex items-center space-x-4 pr-8 font-medium mb-10px">
                    <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-medium bg-gray-200 rounded-1.5xl <?php echo esc_attr($avatarSize); ?> ring-2 ring-white <?php echo esc_attr($hasAvatar ? "" : "wil-avatar-no-img"); ?> ">
                        <?php if ($hasAvatar) : ?>
                            <img src="<?php echo esc_url(get_avatar_url($comment)); ?>" class="absolute inset-0 w-full h-full object-cover" alt="<?php echo esc_attr(get_comment_author($comment)); ?>">
                        <?php endif; ?>
                        <span class="wil-avatar__name">
                            <?php echo esc_html(substr(get_comment_author($comment), 0, 1)); ?>
                        </span>
                    </div>
                    <div>
                        <span class="block text-gray-900 dark:text-gray-100 leading-tight <?php echo esc_attr($depth < 2 ? 'text-body' : 'text-base'); ?>">
                            <?php echo get_comment_author_link(); ?>
                        </span>
                        <span class="block text-gray-600 dark:text-gray-400 text-base leading-tight">
                            <?php echo get_comment_date(); ?>
                        </span>
                    </div>
                </div>

                <!-- === -->
                <?php if ($comment->comment_approved === '0') : ?>
                    <em class="comment-awaiting-moderation text-sm font-normal">
                        <?php echo esc_html__('Your comment is awaiting moderation.', 'zimac'); ?>
                    </em>
                    <br />
                <?php endif; ?>

                <div class="prose prose-sm mb-10px text-gray-700 dark:text-gray-300">
                    <?php comment_text(); ?>
                </div>

                <div class="text-xs font-medium text-gray-700 dark:text-gray-300 flex items-center leading-none comment-reply">
                    <!--  COMMENT STATUS IF ACTIVE HSSC -->
                    <?php if (defined('HSBLOG2_ACTION_PREFIX')) : ?>
                        <?php
                        $aData = [
                            'comment_id'    => get_comment_ID(),
                            'user_id'       => get_current_user_id()
                        ];
                        $status = CommentEmotionModel::getStatus($aData);
                        $countLikes = CommentEmotionModel::countLike($aData);
                        $countDisLikes = CommentEmotionModel::countDislike($aData);

                        // OPEN MODAL SIGIN IF NOT LOGGED YET
                        $btnLikeAttrs = 'data-open-modal=wil-modal-form-sign-in';
                        $btnDisLikeAttrs = 'data-open-modal=wil-modal-form-sign-in';

                        // WHEN LOGGED
                        if (is_user_logged_in()) {
                            $btnLikeAttrs = 'data-comment-emotion-type=like data-comment-status=' . ($status === 'like' ? "like" : 'none') . ' data-comment-user-ID=' . get_current_user_id() . ' data-comment-ID=' . get_comment_ID();
                            $btnDisLikeAttrs = 'data-comment-emotion-type=dislike data-comment-status=' . ($status === 'dislike' ? 'dislike' : 'none') . ' data-comment-user-ID=' . get_current_user_id() . ' data-comment-ID=' . get_comment_ID();
                        }
                        ?>

                        <button <?php echo esc_attr($btnLikeAttrs); ?> class="flex items-center pr-1 mr-1 <?php echo esc_attr($status === 'like' ? "text-blue-500" : ""); ?>">
                            <i class="las la-thumbs-up leading-none inline-block text-body"></i>
                            <span class="leading-none inline-block">
                                <?php echo esc_html($countLikes); ?>
                            </span>
                        </button>
                        <button <?php echo esc_attr($btnDisLikeAttrs); ?> class="flex items-center px-1 mr-3 <?php echo esc_attr($status === 'dislike' ? "text-blue-500" : ""); ?>">
                            <i class="las la-thumbs-down leading-none inline-block text-body"></i>
                            <span class="leading-none inline-block">
                                <?php echo esc_html($countDisLikes); ?>
                            </span>
                        </button>
                    <?php endif; ?>
                    <!-- END IF ACTIVE HSSC -->

                    <?php comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => $add_below,
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth']
                            )
                        )
                    ); ?>
                </div>
                <?php
                // if (current_user_can('edit_comment', $comment->comment_ID)) :
                if (is_user_logged_in()) : ?>
                    <div class="absolute right-0 top-0">
                        <div class="wil-dropdown relative inline-block text-left">
                            <button class="wil-dropdown__btn flex focus:outline-none text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary rounded-full" type="button">
                                <i class="text-2xl las la-ellipsis-h leading-none"></i>
                            </button>
                            <div class="wil-dropdown__panel origin-top-right absolute right-0 mt-2 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 w-[150px] overflow-hidden hidden rounded-2.5xl">
                                <div class="text-base text-gray-700 py-2 leading-tight" aria-labelledby="options-menu" aria-orientation="vertical" role="menu">
                                    <!-- EDIT -->
                                    <?php if (current_user_can('edit_comment', $comment->comment_ID)) : ?>
                                        <a href="<?php echo esc_url(get_edit_comment_link()); ?>" class="block px-5 py-2 hover:bg-gray-300"  data-open-modal="<?php echo esc_attr('wil-modal-form-edit-comment--' . $comment->comment_ID); ?>">
                                            <i class="text-body leading-none mr-2 las la-edit"></i>
                                            <?php echo esc_html__('Edit', 'zimac'); ?>
                                        </a>

                                        <?php zimac_render_modal_form_edit_comment([
                                            'id'        => $comment->comment_ID,
                                        ]); ?>
                                    <?php endif; ?>
                                    <!-- REPLY -->
                                    <?php comment_reply_link(array_merge(
                                        $args,
                                        array(
                                            'reply_text' => '<i class="text-body leading-none mr-2 las la-reply"></i>' . esc_html__('Reply ', 'zimac'),
                                            'depth'      => $depth,
                                            'max_depth'  => $args['max_depth'],
                                            'before'    => '<div id="comment-reply-in-dropdown"  wil-close-dropdown>',
                                            'after'     => '</div>'
                                        )
                                    )); ?>
                                    <!-- REPORT -->
                                    <a href="#" class="block px-5 py-2 hover:bg-gray-300"  data-open-modal="<?php echo esc_attr('wil-modal-form-report-comment--' . $comment->comment_ID); ?>">
                                        <i class="text-body leading-none mr-2 las la-flag"></i>
                                        <?php echo esc_html__('Report', 'zimac'); ?>
                                    </a>
                                    <?php if (is_user_logged_in()) : ?>
                                        <?php zimac_render_modal_form_report_comment(['id' => $comment->comment_ID]); ?>
                                    <?php endif; ?>
                                    <!-- DELETE -->
                                    <?php if (current_user_can('edit_comment', $comment->comment_ID)) : ?>
                                        <a href="#" class="block px-5 py-2 hover:bg-gray-300"  data-open-modal="<?php echo esc_attr('wil-modal-form-delete-comment--' . $comment->comment_ID); ?>">
                                            <i class="text-body leading-none mr-2 las la-trash-alt"></i>
                                            <?php echo esc_html__('Delete', 'zimac'); ?>
                                        </a>
                                        <?php zimac_render_modal_form_delete_comment(['id' => $comment->comment_ID]); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                if (self::$commentIndex === self::$numberMore) {
                    $more = self::$commentCount - self::$commentIndex;
                    if ($more > 0) {
                        echo '<div class="comment__overlay bg-gradient-to-t from-white dark:from-gray-800 absolute inset-0 z-1"></div>';
                        echo '<div class="comment__overlay bg-gradient-to-t from-white dark:from-gray-800 absolute inset-0 z-1"></div>';
                        echo '<div class="comment__overlay-loadmore absolute bottom-0 left-0 z-2">';
                        printf('<a href="#" id="comment-overlay-loadmore-btn" class="block text-gray-800 dark:text-gray-100 font-semibold text-body">' . esc_html__('Load more replies (%d)', 'zimac') . '</a>', $more);
                        echo '</div>';
                    }
                }
                ?>
                <!-- === -->
                <?php if ('div' !== $args['style']) : ?>
                    <!-- === -->
                </div>
    <?php endif;
            }
        }
