<?php

declare(strict_types=1);

namespace codevink\avenum\utils;

trait StaticTrait {
	private const EXCEPTION_MESSAGE = 'Object have been already initialized';

	private static bool $initialized = false;

	private function __construct() {
	}

	private static function setInitialized(bool $initialized = true): void {
		self::$initialized = $initialized;
	}

	private static function isInitialized(): bool {
		return self::$initialized;
	}
}
