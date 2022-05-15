<?php

use Elementor\Plugin;
use HSSC\Controllers\Elementor\AmazingPostsShowcaseElement\AmazingPostsShowcaseElement;
use HSSC\Controllers\Elementor\AuthorsListElement\AuthorsListElement;
use HSSC\Controllers\Elementor\CategoriesBoxElement\CategoriesBoxElement;
use HSSC\Controllers\Elementor\ColorfulPostsFilterElement\ColorfulPostsFilterElement;
use HSSC\Controllers\Elementor\CreativePostsFilterElement\CreativePostsFilterElement;
use HSSC\Controllers\Elementor\LookCoolPostsElement\LookCoolPostsElement;
use HSSC\Controllers\Elementor\PostsGridElement\PostsGridElement;
use HSSC\Controllers\Elementor\PostsSlideshowElement\PostsSlideshowElement;
use HSSC\Controllers\Elementor\PostsTabElement\PostsTabElement;
use HSSC\Controllers\Elementor\RectanglePostGridElementor\RectanglePostGridElementor;
use HSSC\Controllers\Elementor\SimplePostsListElement\SimplePostsListElement;

Plugin::instance()->widgets_manager->register_widget_type(new AmazingPostsShowcaseElement());
Plugin::instance()->widgets_manager->register_widget_type(new AuthorsListElement());
Plugin::instance()->widgets_manager->register_widget_type(new CategoriesBoxElement());

Plugin::instance()->widgets_manager->register_widget_type(new CreativePostsFilterElement());
Plugin::instance()->widgets_manager->register_widget_type(new LookCoolPostsElement());
Plugin::instance()->widgets_manager->register_widget_type(new PostsGridElement());
Plugin::instance()->widgets_manager->register_widget_type(new PostsSlideshowElement());
Plugin::instance()->widgets_manager->register_widget_type(new RectanglePostGridElementor());
Plugin::instance()->widgets_manager->register_widget_type(new PostsTabElement());
Plugin::instance()->widgets_manager->register_widget_type(new SimplePostsListElement());
Plugin::instance()->widgets_manager->register_widget_type(new ColorfulPostsFilterElement());
