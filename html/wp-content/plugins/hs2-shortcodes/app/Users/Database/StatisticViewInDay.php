<?php


namespace HSSC\Users\Database;


class StatisticViewInDay
{
	public static $tblName = HSBLOG2_SC_PREFIX . 'statistic_views_in_day';
	public        $version = '1.0';

	public function __construct()
	{
		add_action('plugins_loaded', [$this, 'createTable']);
	}

	public function createTable()
	{
		global $wpdb;
		$tblName = $wpdb->prefix . self::$tblName;
		$postTbl = $wpdb->posts;
		$charsetCollect = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $tblName(
    			ID bigint(20) NOT NULL AUTO_INCREMENT PRiMARY KEY,
    			post_id bigint(20) UNSIGNED NOT NULL,
    			user_id bigint(20) UNSIGNED NOT NULL,
    			count bigint(20) NOT NULL,
    			ip_address varchar(100) NOT NULL,
    			country varchar(100) NOT NULL,
    			viewed_date TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
				Foreign key (post_id) References $postTbl(ID) ON DELETE CASCADE
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
