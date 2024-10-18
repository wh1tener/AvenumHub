<?php

declare(strict_types=1);

namespace codevink\avenum\item\hub;

use pocketmine\item\Item;
use pocketmine\utils\CloningRegistryTrait;

/**
 * @method static ServerSelection SERVER_SELECTION()
 */
final class HubItems {
	use CloningRegistryTrait;

	public function __construct() {
	}

	protected static function setup(): void {
		self::register('server_selection', new ServerSelection());
	}

	/**
	 * @return array<string, Item>
	 */
	public static function getAll(): array {
		return self::_registryGetAll();
	}

	protected static function register(string $name, Item $item): void {
		self::_registryRegister($name, $item);
	}
}
