<?php

namespace DoAn\Shared;

class AutoPrefix {
	public static function namePrefix( $name ) {
		return str_starts_with($name, MYSHOOKITPSS_PREFIX_1) ? $name : MYSHOOKITPSS_PREFIX_1 . $name;
	}

	public static function removePrefix( string $name ): string {
		if (str_starts_with($name, MYSHOOKITPSS_PREFIX_1)) {
			$name = str_replace( MYSHOOKITPSS_PREFIX_1, '', $name );
		}

		return $name;
	}
}
