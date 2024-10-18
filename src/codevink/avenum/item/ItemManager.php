<?php

declare(strict_types=1);

namespace codevink\avenum\item;

use codevink\avenum\item\hub\HubItems;
use codevink\avenum\Loader;
use codevink\avenum\utils\HubException;
use codevink\avenum\utils\StaticTrait;

final class ItemManager {
	use StaticTrait;

	public static function initialize(Loader $plugin): void {
		if (self::isInitialized()) {
			throw new HubException(self::EXCEPTION_MESSAGE);
		}

		new HubItems();

		self::setInitialized();
	}
}
