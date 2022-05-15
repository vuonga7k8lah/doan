<?php

namespace HSSC\Widgets\Controllers;

class WidgetController
{
	public function __construct()
	{
		add_action("widgets_init", [$this, "registerMyCustomWidgets"]);
	}


	public function registerMyCustomWidgets()
	{
		// 
		register_widget("HSSC\Widgets\Controllers\MyWidgetSlideListPosts");
		register_widget("HSSC\Widgets\Controllers\MyWidgetPostTabs");
		register_widget("HSSC\Widgets\Controllers\MyWidgetRecentPosts");
		register_widget("HSSC\Widgets\Controllers\MyWidgetCategories");
		register_widget('HSSC\Widgets\Controllers\SocialNetworkWidget');
	}
}
