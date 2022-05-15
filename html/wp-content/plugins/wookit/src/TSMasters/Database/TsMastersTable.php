<?php
namespace DoAn\TSMasters\Database;
class TsMastersTable
{
    public static string  $tblName          = 'Master_statistic';
    protected string      $version          = '1.0';

    public function __construct()
    {
        add_action('admin_init', [$this, 'createTable']);
    }

    public function createTable()
    {
        global $wpdb;
        $tblName = self::getTblName();
        $postTbl = $wpdb->posts;
        $userTbl = $wpdb->users;
        $charsetCollect = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $tblName(
	  		ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	  		userID bigint(20) UNSIGNED NOT NULL,
	  		postID bigint(20) UNSIGNED NOT NULL,
			info longtext  NOT NULL,
			createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			FOREIGN KEY (postID) REFERENCES $postTbl(ID) ON DELETE CASCADE,
			FOREIGN KEY (userID) REFERENCES $userTbl(ID) ON DELETE CASCADE,
			PRIMARY KEY (ID)
		) $charsetCollect";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option(self::$tblName, $this->version);
    }

    public static function getTblName(): string
    {
        global $wpdb;
        return $wpdb->prefix . self::$tblName;
    }
}
