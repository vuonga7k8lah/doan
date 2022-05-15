<?php


namespace HSSC\Users\Database;


class StatisticFollower
{
	public static $tblName = HSBLOG2_SC_PREFIX . 'statistic_follower';
	public        $version = '1.0';

	public function __construct()
	{
		add_action('plugins_loaded', [$this, 'createTable']);
	}

	public static function getTblName(): string
	{
		global $wpdb;
		return $wpdb->prefix . self::$tblName;
	}

	public function createTable()
	{
		global $wpdb;
		$tblName = $wpdb->prefix . self::$tblName;
		$userTbl = $wpdb->users;
		$charsetCollect = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $tblName(
    			ID bigint(20) NOT NULL AUTO_INCREMENT PRiMARY KEY,
    			user_id bigint(20) UNSIGNED NOT NULL,
    			follower_id bigint(20) UNSIGNED NOT NULL,
    			date TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
				Foreign key (user_id) References $userTbl(ID) ON DELETE CASCADE,
				Foreign key (follower_id) References $userTbl(ID) ON DELETE CASCADE
			) $charsetCollect";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta($sql);
		update_option(self::$tblName, $this->version);
	}
}
