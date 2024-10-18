<?php

declare(strict_types=1);

namespace codevink\avenum\world\sound;

use pocketmine\utils\CloningRegistryTrait;
use pocketmine\world\sound\NoteInstrument;
use pocketmine\world\sound\NoteSound;
use pocketmine\world\sound\Sound;

/**
 * @method static NoteSound JOIN()
 */
final class HubSound {
	use CloningRegistryTrait;

	private function __construct() {
	}

	protected static function setup(): void {
		self::register('join', new NoteSound(NoteInstrument::PIANO(), 14));
	}

	/**
	 * @return array<string, Sound>
	 */
	public static function getAll(): array {
		return self::_registryGetAll();
	}

	protected static function register(string $name, Sound $sound): void {
		self::_registryRegister($name, $sound);
	}
}
