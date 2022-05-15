<?php

namespace HSSC\Shared\Elementor;

/**
 * Undocumented class
 */
class CommonRegistration
{

    private static $aTerms = [];
    private static $aPosts = [];

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getElGetPostByControl(): array
    {
        return [
            'label'   => esc_html__('Get Post By', 'hsblog2-shortcodes'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'categories'      => 'Categories',
                'specified_posts' => 'Specified Posts',
            ],
            'default' => 'categories',
        ];
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getElItemsPerRowControl(int $default = 4, string $label = null): array
    {
        return [
            'label'   => $label ?? esc_html__('Items per row', 'hsblog2-shortcodes'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 8,
            'step'    => 1,
            'default' => $default,
        ];
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getElGapControl(int $default = 8, string $label = null): array
    {
        return [
            'label'   => $label ?? esc_html__('Gap', 'hsblog2-shortcodes'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 12,
            'step'    => 1,
            'default' => $default
        ];
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getElMaxRowsControl(int $default = 1): array
    {
        return [
            'label'     => esc_html__('Max Rows', 'hsblog2-shortcodes'),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 10,
            'step'      => 1,
            'default'   => $default,
        ];
    }
    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getElOrderByControl(): array
    {
        return [
            'label'     => esc_html__('Order By', 'hsblog2-shortcodes'),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => array_keys(self::getOrderByOptions())[0],
            'options'   => self::getOrderByOptions()
        ];
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getOrderByOptions(): array
    {
        return [
            'ID'                => esc_html__('ID', 'hsblog2-shortcodes'),
            'author'            => esc_html__('Author', 'hsblog2-shortcodes'),
            'title'             => esc_html__('Title', 'hsblog2-shortcodes'),
            'date'              => esc_html__('Date', 'hsblog2-shortcodes'),
            'menu_order'        => esc_html__('Menu Order', 'hsblog2-shortcodes'),
            'rand'              => esc_html__('Random', 'hsblog2-shortcodes'),
            'comment_count'     => esc_html__('Comment Count', 'hsblog2-shortcodes'),
        ];
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getOrderOptions(): array
    {
        return  [
            'DESC'              => esc_html__('DESC', 'hsblog2-shortcodes'),
            'ASC'               => esc_html__('ASC', 'hsblog2-shortcodes'),
        ];
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function getElOrderControl(): array
    {
        return [
            'label'     => esc_html__('Order', 'hsblog2-shortcodes'),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => array_keys(self::getOrderOptions())[0],
            'options'   => self::getOrderOptions()
        ];
    }

    /**
     * Undocumented function
     *
     * @param [category|post_tag|$other] $taxonomyName
     * @return <id: name>[]
     */
    public static function getTermsOptions(string $taxonomyName = 'category'): array
    {
        if (isset(self::$aTerms[$taxonomyName])) {
            return self::$aTerms[$taxonomyName];
        }
        self::$aTerms[$taxonomyName] = [];
        foreach (get_terms($taxonomyName) as $oTerm) {
            if (!is_object($oTerm)) {
                break;
            }
            self::$aTerms[$taxonomyName][$oTerm->term_id] = $oTerm->name;
        }
        return  self::$aTerms[$taxonomyName];
    }

    /**
     * Undocumented function
     *
     * @return <id: post_title>[]
     */
    public static function getPostOptions(): array
    {
        if (!empty(self::$aPosts)) {
            return self::$aPosts;
        }
        foreach (get_posts(['numberposts' => -1]) as $oPost) {
            if (!is_object($oPost)) {
                break;
            }
            self::$aPosts[$oPost->ID] = $oPost->post_title;
        }
        return self::$aPosts;
    }
}
