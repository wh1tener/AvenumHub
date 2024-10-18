<?php

declare(strict_types=1);

namespace codevink\avenum\command;

use codevink\avenum\Loader;

final class CommandManager {
	private static Loader $plugin;

	public static function initialize(Loader $plugin): void {
		self::$plugin = $plugin;
		self::unregisterCommands();
	}

	private static function unregisterCommands(): void {
		$commandMap = self::$plugin->getServer()->getCommandMap();
		$commands = $commandMap->getCommands();

		foreach ($commands as $command) {
			$commandMap->unregister($command);
		}
	}
}
