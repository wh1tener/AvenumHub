<?php

declare(strict_types=1);

namespace codevink\avenum\translation;

use codevink\avenum\Loader;
use codevink\avenum\utils\StaticTrait;
use pocketmine\command\CommandSender;
use pocketmine\command\RconCommandSender;
use pocketmine\player\Player;
use Symfony\Component\Filesystem\Path;
use function is_string;
use function sprintf;
use const INI_SCANNER_RAW;

final class Translator {
	use StaticTrait;

	public const DEFAULT_LOCALE = self::ENGLISH;
	public const ENGLISH        = 'en_US';
	public const RUSSIAN        = 'ru_RU';

	public const LOCALES = [
		self::ENGLISH,
		self::RUSSIAN,
	];

	/** @var string[][] */
	private static array $translations = [];

	public static function initialize(Loader $plugin): void {
		foreach (self::LOCALES as $locale) {
			$plugin->saveResource($path = Path::join('locale', $locale . '.ini'), true);
			self::$translations[$locale] = array_map(
				'\stripcslashes',
				parse_ini_file(Path::join($plugin->getDataFolder(), $path), false, INI_SCANNER_RAW)
			);
		}
		self::setInitialized();
	}

	public static function translate(string $key, CommandSender|string $locale = self::DEFAULT_LOCALE, array $args = []): string {
		if ($locale instanceof Player) {
			$locale  = $locale->getLocale();
		} elseif ($locale instanceof RconCommandSender) {
			$locale = self::RUSSIAN;
		} elseif (!is_string($locale)) {
			$locale = self::DEFAULT_LOCALE;
		}

		if (!(isset(self::$translations[$locale]))) {
			$locale = self::DEFAULT_LOCALE;
		}

		$translation = self::$translations[$locale][$key] ?? self::$translations[self::DEFAULT_LOCALE][$key] ?? $key;

		return [] === $args ? $translation : sprintf($translation, ...$args);
	}
}
