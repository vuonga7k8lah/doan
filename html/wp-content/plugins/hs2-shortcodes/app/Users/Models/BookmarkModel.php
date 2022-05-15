<?php


namespace HSSC\Users\Models;


use HSSC\Users\Database\StatisticBookmark;

class BookmarkModel
{
    /**
     * @param array{post_id: int,user_id: int,status: 'yes'|'no'} $aData
     * @return bool
     */
    public static function isExist($aData): bool
    {
        global $wpdb;
        $result = $wpdb->get_var($wpdb->prepare("SELECT status FROM " . StatisticBookmark::getTblName() .
            " WHERE post_id=%d AND user_id=%d", $aData['post_id'], $aData['user_id']));
        return !empty($result);
    }

    /**
     * @param array{post_id: int,user_id: int,status: 'yes'|'no'} $aData
     * @return string
     */
    public static function get($aData): string
    {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT status FROM " . StatisticBookmark::getTblName() .
            " WHERE post_id=%d AND user_id=%d", $aData['post_id'], $aData['user_id'])) ?? 'no';
    }


    /**
     * 
     */
    public static function getAllPostSavedByUserId(int $userId): array
    {
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare("SELECT * FROM " . StatisticBookmark::getTblName() .
            " WHERE user_id=%d AND status='yes'", $userId)) ??  [];
    }

    /**
     * @param array{post_id: int,user_id: int,status: 'yes'|'no'} $aData
     * @return bool|int
     */
    public static function insert($aData)
    {
        global $wpdb;
        return $wpdb->insert(
            StatisticBookmark::getTblName(),
            [
                'post_id' => $aData['post_id'],
                'user_id' => $aData['user_id'],
                'status'  => 'yes'
            ],
            [
                '%d',
                '%d',
                '%s'
            ]
        );
    }

    /**
     * @param array{post_id: int,user_id: int,status: 'yes'|'no'} $aData
     * @return bool|int
     */
    public static function update($aData)
    {
        global $wpdb;
        return $wpdb->update(
            StatisticBookmark::getTblName(),
            [
                'status' => $aData['status']
            ],
            [
                'post_id' => $aData['post_id'],
                'user_id' => $aData['user_id']
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
     * @param array{post_id: int,user_id: int,status: 'yes'|'no'} $aData
     * @return bool|int
     */
    public static function delete($aData)
    {
        global $wpdb;
        return $wpdb->delete(
            StatisticBookmark::getTblName(),
            [
                'post_id' => $aData['post_id'],
                'user_id' => $aData['user_id']
            ],
            [
                '%d',
                '%d'
            ]
        );
    }
}
