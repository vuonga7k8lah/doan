<?php


namespace HSSC\Users\Models;


use HSSC\Users\Database\StatisticCommentEmotion;

class CommentEmotionModel
{
    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return bool
     */
    public static function isExist($aData): bool
    {
        global $wpdb;
        $result = $wpdb->get_var($wpdb->prepare("SELECT status FROM " . StatisticCommentEmotion::getTblName() .
            " WHERE comment_id=%d AND user_id=%d", $aData['comment_id'], $aData['user_id']));
        return !empty($result);
    }

    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return string
     */
    public static function getStatus($aData): string
    {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT status FROM " . StatisticCommentEmotion::getTblName() .
            " WHERE comment_id=%d AND user_id=%d ", $aData['comment_id'], $aData['user_id'])) ?? 'none';
    }

    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return int
     */
    public static function countLike($aData): int
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM " . StatisticCommentEmotion::getTblName() .
            " WHERE comment_id=%d AND user_id=%d AND status='like'", $aData['comment_id'], $aData['user_id'])) ?? 0;
    }

    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return int
     */
    public static function countDislike($aData): int
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM " . StatisticCommentEmotion::getTblName() .
            " WHERE comment_id=%d AND user_id=%d AND status='dislike'", $aData['comment_id'], $aData['user_id'])) ?? 0;
    }

    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return bool|int
     */
    public static function insert($aData)
    {
        global $wpdb;
        return $wpdb->insert(
            StatisticCommentEmotion::getTblName(),
            [
                'comment_id' => $aData['comment_id'],
                'user_id'    => $aData['user_id'],
                'status'     => $aData['status']
            ],
            [
                '%d',
                '%d',
                '%s'
            ]
        );
    }

    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return bool|int
     */
    public static function update($aData)
    {
        global $wpdb;
        return $wpdb->update(
            StatisticCommentEmotion::getTblName(),
            [
                'status' => $aData['status']
            ],
            [
                'comment_id' => $aData['comment_id'],
                'user_id'    => $aData['user_id']
            ],
            [
                '%s'
            ],
            [
                '%d',
                '%d'
            ]
        );
    }

    /**
     * @param array{comment_id: int,user_id: int,status: 'like'|'dislike'} $aData
     * @return bool|int
     */
    public static function delete($aData)
    {
        global $wpdb;
        return $wpdb->delete(
            StatisticCommentEmotion::getTblName(),
            [
                'comment_id' => $aData['comment_id'],
                'user_id'    => $aData['user_id']
            ],
            [
                '%d',
                '%d'
            ]
        );
    }
}
