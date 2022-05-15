<?php

namespace DoAn\TSMasters\Model;

use DoAn\TSMasters\Database\TsMastersTable;

class TSMasterModel
{
    /**
     * @param array{postID: int} $aData
     */
    public static function insert($aData): int
    {
        global $wpdb;
        $query = $wpdb->insert(
            TsMastersTable::getTblName(),
            [
                'postID' => $aData['postID'],
                'userID' => $aData['userID'],
                'info'  => $aData['userID']
            ],
            [
                '%d',
                '%d',
                '%s'
            ]
        );
        return !empty($query) ? $wpdb->insert_id : 0;
    }

    /**
     * @param array{postID: int,total: int} $aData
     * @return bool|int
     */
    public static function update($aData)
    {
        global $wpdb;

        return $wpdb->update(
            TsMastersTable::getTblName(),
            [
                'total' => $aData['total']
            ],
            [
                'info' => $aData['ID']
            ]
        );
    }

    /**
     * @param @param array{postID: int,total: int} $aData
     * @return bool|int
     */
    public static function delete($postID)
    {
        global $wpdb;
        return $wpdb->delete(
            TsMastersTable::getTblName(),
            [
                'ID' => $postID,
            ],
            [
                '%d',
            ]
        );
    }
}
