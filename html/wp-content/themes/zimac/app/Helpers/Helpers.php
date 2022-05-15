<?php

namespace ZIMAC\Helpers;

class Helpers
{

    /**
     *
     * @param string $name
     * @param string $href
     * @return array[icon,href]
     */
    public  static function getASocialFontClass(string $name, string $href): array
    {
        switch ($name) {
            case 'facebook':
                return [
                    'href'  => $href,
                    'icon'  => 'lab la-facebook-f'
                ];
//            case 'twitter':
//                return [
//                    'href'  => $href,
//                    'icon'  => 'lab la-twitter'
//                ];
//            case 'linkedin':
//                return  [
//                    'href'  => $href,
//                    'icon'  => 'lab la-linkedin-in'
//                ];
            case 'youtube':
                return  [
                    'href'  => $href,
                    'icon'  => 'lab la-youtube'
                ];

            case 'whatsapp':
                return   [
                    'href'  => $href,
                    'icon'  => 'lab la-whatsapp'
                ];
            case 'email':
                return   [
                    'href'  => $href,
                    'icon'  => 'las la-at'
                ];
            case 'instagram':
                return   [
                    'href'  => $href,
                    'icon'  => 'lab la-instagram'
                ];

            default:
                return [];
        }
    }

    /**
     * Get array categoies IDs or array tags ID by post ID
     *
     * @param boolean $isCategory
     * @param integer $postID
     * @return array
     */
    public static function getArrayTermIDByPostID(bool $isCategory, int $postID): array
    {
        if ($isCategory) {
            $aCategories = get_the_category($postID) ?? [];
            if (is_wp_error($aCategories)) {
                return [];
            }
            $aCatIDs = [];
            foreach ($aCategories as $oCat) {
                $aCatIDs[] = $oCat->term_id;
            }
            return $aCatIDs;
        } else {
            $aTags = get_the_tags($postID) ?? [];
            if (is_wp_error($aTags)) {
                return [];
            }
            $aTagIDs = [];
            foreach ($aTags as $oTag) {
                $aTagIDs[] = $oTag->term_id;
            }
            return $aTagIDs;
        }
    }


    /**
     *
     * @return boolean
     */
    public static function canShowPostThumbnail()
    {
        return apply_filters(
            'twenty_twenty_one_can_show_post_thumbnail',
            !post_password_required() && !is_attachment() && has_post_thumbnail()
        );
    }

    /**
     * Get avatar Url from userID
     *
     * @param integer $userID
     * @return string
     */
    public static function getUserAvatarUrl(int $userID): string
    {
        return strpos(get_avatar_url($userID), 'gravatar.com') ? '' : get_avatar_url($userID);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function registerUserMetabox()
    {
        /**
         * Metabox for the user profile screen
         */
        $cmb_user = new_cmb2_box(array(
            'id'               => HSBLOG2_SC_PREFIX . 'user_edit',
            'title'            => esc_html__('User Profile Metabox', 'zimac'),
            'object_types'     => array('user'), // Tells CMB2 to use user_meta vs post_meta
            'show_names'       => true,
            'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
        ));

        // ------------------------------------------------------------------------------------------------------------
        $cmb_user->add_field(array(
            'name'     => esc_html__('Other Info', 'zimac'),
            'id'       => HSBLOG2_SC_PREFIX . 'user_other_info',
            'type'     => 'title',
            'on_front' => false,
        ));
        $cmb_user->add_field(array(
            'name'      => esc_html__('Author Page Background', 'zimac'),
            'desc'      => esc_html__('Add or Upload header image on author page', 'zimac'),
            'id'        => HSBLOG2_SC_PREFIX . 'user_page_background',
            'default'   => "",
            'type'      => 'file',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Your Job', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_job_name',
            'type' => 'text',
        ));

        // ------------------------------------------------------------------------------------------------------------
        $cmb_user->add_field(array(
            'name'     => esc_html__('Socials Info', 'zimac'),
            'id'       => HSBLOG2_SC_PREFIX . 'user_socials_info',
            'type'     => 'title',
            'on_front' => false,
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Facebook URL', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_facebook_url',
            'type' => 'text_url',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Twitter URL', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_twitter_url',
            'type' => 'text_url',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Instagram Url', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_user_instagram_url',
            'type' => 'text_url',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Linkedin URL', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_linkedin_url',
            'type' => 'text_url',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Youtube URL', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_youtube_url',
            'type' => 'text_url',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Email URL', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_email_url',
            'type' => 'text_url',
        ));
        $cmb_user->add_field(array(
            'name' => esc_html__('Whatsapp URL', 'zimac'),
            'id'   => HSBLOG2_SC_PREFIX . 'user_whatsapp_url',
            'type' => 'text_url',
        ));

        // ------------------------------------------------------------------------------------------------------------
    }
}
