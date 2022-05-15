<?php


namespace HSSC\Users\Models;

use HSSC\Users\Database\StatisticViewInDay;

class UserModel
{
    /**
     * @param $authorId
     * @return false|string
     */
    public static function getUrlAvatarAuthor($authorId)
    {
        return (strpos(get_avatar_url($authorId), 'gravatar.com') !== false) ? '' : get_avatar_url($authorId);
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return bool
     */
    public static function isViewedToday($aData): bool
    {
        return !empty(self::getIdViewed($aData));
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return int
     */
    public static function getIdViewed($aData): int
    {
        global $wpdb;
        $id = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM " . StatisticViewInDay::getTblName() .
                " WHERE DATE(viewed_date) = CURDATE() AND ((ip_address=%s AND user_id=0) OR (user_id=%d AND user_id !=0)) AND post_id=%d",
            $aData['ip_address'],
            $aData['user_id'],
            $aData['post_id']
        ));
        return empty($id) ? 0 : (int)$id;
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return int
     */
    public static function getCountViewByPostID(int $postID): int
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare(
            "SELECT SUM(count) FROM " . StatisticViewInDay::getTblName() .
                " WHERE post_id=%d",
            $postID
        ));
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return int
     */
    public static function getCountView($aData): int
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare(
            "SELECT count FROM " . StatisticViewInDay::getTblName() .
                " WHERE DATE(viewed_date) = CURDATE() AND ((ip_address=%s AND user_id=0) OR (user_id=%d AND user_id !=0)) AND post_id=%d",
            $aData['ip_address'],
            $aData['user_id'],
            $aData['post_id']
        ));
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return bool|int
     */

    public static function updateCountView($aData)
    {
        global $wpdb;
        return
            $wpdb->query($wpdb->prepare(
                "UPDATE " . StatisticViewInDay::getTblName() .
                    " SET count=%d,ip_address=%s,country=%s  WHERE (post_id= %s AND user_id=%d AND user_id !=0 ) OR (post_id=%d AND ID=%s)",
                $aData['count'],
                $aData['ip_address'],
                $aData['country'],
                $aData['post_id'],
                $aData['user_id'],
                $aData['post_id'],
                $aData['ID']
            ));
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return bool|int
     */
    public static function insertCountView(array $aData)
    {
        global $wpdb;
        return $wpdb->insert(
            StatisticViewInDay::getTblName(),
            [
                'post_id'    => $aData['post_id'],
                'user_id'    => $aData['user_id'],
                'count'      => 1,
                'ip_address' => $aData['ip_address'],
                'country'    => $aData['country'],
            ],
            [
                '%d',
                '%d',
                '%d',
                '%s',
                '%s'
            ]
        );
    }

    /**
     * @param array $aData
     * @return bool|int
     */
    public static function deleteCountView(array $aData)
    {
        global $wpdb;
        return
            $wpdb->query($wpdb->prepare(
                "DELETE FROM " . StatisticViewInDay::getTblName() .
                    " WHERE (post_id= %s AND user_id=%d AND user_id !=0 ) OR (post_id=%d AND ID=%s)",
                $aData['post_id'],
                $aData['user_id'],
                $aData['post_id'],
                $aData['ID']
            ));
    }
}
