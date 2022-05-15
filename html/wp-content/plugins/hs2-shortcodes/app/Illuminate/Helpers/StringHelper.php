<?php


namespace HSSC\Illuminate\Helpers;


class StringHelper
{
	public static function replaceUpperCaseWithUnderscore($string): string
	{
		return preg_replace_callback('/\B([A-Z])/', function ($aMatches) {
			return '_' . strtolower($aMatches[1]);
		}, $string);
	}

	public static function replaceUnderscoreWithUpperCase($string): string
	{
		return preg_replace_callback('/_([a-zA-Z0-9])/', function ($aMatches) {
			return ucfirst($aMatches[1]);
		}, $string);
	}
	public static function ksesHTML($content, $isReturn = false)
	{
		$allowed_html = [
			'a'      => [
				'href'   => [],
				'style'  => [
					'color' => []
				],
				'title'  => [],
				'target' => [],
				'class'  => []
			],
			'div'    => ['class' => []],
			'h1'     => ['class' => []],
			'h2'     => ['class' => []],
			'h3'     => ['class' => []],
			'h4'     => ['class' => []],
			'h5'     => ['class' => []],
			'h6'     => ['class' => []],
			'br'     => ['class' => []],
			'p'      => ['class' => [], 'style' => []],
			'em'     => ['class' => []],
			'strong' => ['class' => []],
			'span'   => ['data-typer-targets' => [], 'class' => []],
			'i'      => ['class' => []],
			'ul'     => ['class' => []],
			'ol'     => ['class' => []],
			'li'     => ['class' => []],
			'code'   => ['class' => []],
			'b'   	 => ['class' => []],
			'pre'    => ['class' => []],
			'iframe' => ['src' => [], 'width' => [], 'height' => [], 'class' => ['embed-responsive-item']],
			'img'    => ['src' => [], 'width' => [], 'height' => [], 'class' => [], 'alt' => []],
			'embed'  => ['src' => [], 'width' => [], 'height' => [], 'class' => []],
		];

		if (!$isReturn) {
			echo wp_kses(wp_unslash($content), $allowed_html);
		} else {
			return wp_kses(wp_unslash($content), $allowed_html);
		}
	}
}
