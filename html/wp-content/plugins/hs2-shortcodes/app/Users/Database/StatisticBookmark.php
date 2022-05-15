<?php


namespace HSSC\Users\Database;


class StatisticBookmark
{
	public static $tblName = HSBLOG2_SC_PREFIX . 'statistic_bookmark';
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
		$postTbl = $wpdb->posts;
		$userTbl = $wpdb->users;
		$charsetCollect = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $tblName(
    			ID bigint(20) NOT NULL AUTO_INCREMENT PRiMARY KEY,
    			post_id bigint(20) UNSIGNED NOT NULL,
    			user_id bigint(20) UNSIGNED NOT NULL,
    			status varchar (20) NOT NULL,
    			date TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
				Foreign key (post_id) References $postTbl(ID) ON DELETE CASCADE,
				Foreign key (user_id) References $userTbl(ID) ON DELETE CASCADE
			) $charsetCollect";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta($sql);
		update_option(self::$tblName, $this->version);
	}
}
