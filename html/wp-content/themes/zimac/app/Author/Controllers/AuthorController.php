<?php

namespace ZIMAC\Author\Controllers;

/**
 * Class AuthorController
 * @package ZM\Author\Controllers
 */
class AuthorController
{
    /**
     *
     * @var [type]
     */
    public static $userID;

    /**
     *
     * @param integer $userID
     */
    function __construct(int $userID)
    {
        $this::$userID = $userID;
    }

    /**
     * Undocumented function
     *
     * @param string $newDisplayName
     * @return void
     */
    public function updateUserDisplayName(string $newDisplayName)
    {
        if (!$newDisplayName || get_userdata($this::$userID)->display_name === $newDisplayName) {
            return;
        }
        $updateUser = wp_update_user(['ID' => $this::$userID, 'display_name' => $newDisplayName]);
        if (is_wp_error($updateUser)) {
            wp_die(esc_html__('An error occurred', 'zimac'));
        }
    }

    /**
     * Undocumented function
     *
     * @param array $aUserMeta
     * @return void
     */
    public function updateUserMeta(array $aUserMeta)
    {
        foreach ($aUserMeta as $key => $value) {
            if (get_user_meta($this::$userID, $key, true) === $value) {
                continue;
            }

            $updated = update_user_meta($this::$userID, $key, $value);
            // Will return false if the previous value is the same as $new_value.
            if ($updated) {
                return;
            }
            // So check and make sure the stored value matches $new_value.
            if ($value !== get_user_meta($this::$userID, $key, true)) {
                wp_die(esc_html__('An error occurred', 'zimac'));
            }
        }
    }
}
