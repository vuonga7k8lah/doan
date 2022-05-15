<?php

namespace HSSC\Users\Models;

use HSSC\Users\Database\StatisticFollower;
use wpdb;

class FollowerModel
{
    /**
     * @param array{follower_id: int,user_id: int} $aData
     * @return bool
     */

    public static function isExist($aData): bool
    {
        global $wpdb;
        $result = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM " . StatisticFollower::getTblName() .
            " WHERE follower_id=%d AND user_id=%d", $aData['user_id'], $aData['follower_id'])) ?? [];

        return !empty($result);
    }

    /**
     * @param array{follower_id: int,user_id: int} $aData
     * @return int
     */
    public static function getFollower($aData): int
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare("SELECT count(user_id) FROM " . StatisticFollower::getTblName() .
            " WHERE user_id=%d", $aData['user_id']));
    }

    /**
     * @param array{follower_id: int,user_id: int} $aData
     * @return int
     */
    public static function getFollowing($aData): int
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare("SELECT count(follower_id) FROM " . StatisticFollower::getTblName() .
            " WHERE follower_id=%d", $aData['user_id']));
    }

    /**
     * @param array{follower_id: int,user_id: int} $aData
     * @return bool|int
     */
    public static function insert($aData)
    {
        global $wpdb;
        return $wpdb->insert(
            StatisticFollower::getTblName(),
            [
                'follower_id' => $aData['user_id'],
                'user_id'     => $aData['follower_id'],
            ],
            [
                '%d',
                '%d'
            ]
        );
    }

    /**
     * @param array{follower_id: int,user_id: int} $aData
     * @return bool|int
     */
    public static function delete($aData)
    {
        global $wpdb;
        return $wpdb->delete(
            StatisticFollower::getTblName(),
            [
                'follower_id' => $aData['user_id'],
                'user_id'     => $aData['follower_id']
            ],
            [
                '%d',
                '%d'
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param integer $myID
     * @param integer $userID
     * @return bool
     */
    public static function checkIsFollowingUser(int $myID, int $userID): bool
    {
        global $wpdb;
        $followers = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM " . StatisticFollower::getTblName() . " WHERE user_id = %d AND follower_id = %d",
            $userID,
            $myID
        ));
        return !!$followers && !empty($followers);
    }


    /**
     * Undocumented function
     *
     * @param integer $userID
     * @return array[data,totalItems]
     */
    public static function getAUserFollowers(int $userID, array $aArgs = []): array
    {
        global $wpdb;
        $aFollowers = $wpdb->get_results($wpdb->prepare(
            "SELECT follower_id FROM " . StatisticFollower::getTblName() . " WHERE user_id = %d",
            $userID
        ));
        $aFollowers = is_array($aFollowers) ? $aFollowers : [];

        if (empty($aFollowers)) {
            return [
                'data'          => [],
                'totalItems'    => 0,
            ];
        }
        $aUserIDs = [];
        foreach ($aFollowers as  $oUser) {
            $aUserIDs[] = $oUser->follower_id;
        }
        $aArgs['include'] = $aUserIDs;
        $oQuery = new \WP_User_Query($aArgs);

        return [
            'data'          => $oQuery->get_results(),
            'totalItems'    => $oQuery->get_total(),
        ];
    }

    /**
     * Undocumented function
     *
     * @param integer $userID
     * @return array[data,totalItems]
     */
    public static function getAUserMeFollowing(int $userID, array $aArgs = []): array
    {
        global $wpdb;
        $aFollowings = $wpdb->get_results($wpdb->prepare(
            "SELECT user_id FROM " . StatisticFollower::getTblName() . " WHERE follower_id = %d",
            $userID
        ));
        $aFollowings = is_array($aFollowings) ? $aFollowings : [];
        if (empty($aFollowings)) {
            return [
                'data'          => [],
                'totalItems'    => 0,
            ];
        }

        $aUserIDs = [];
        foreach ($aFollowings as  $oUser) {
            $aUserIDs[] = $oUser->user_id;
        }
        $aArgs['include'] = $aUserIDs;
        $oQuery = new \WP_User_Query($aArgs);
        return [
            'data'          => $oQuery->get_results(),
            'totalItems'    => $oQuery->get_total()
        ];
    }
}
