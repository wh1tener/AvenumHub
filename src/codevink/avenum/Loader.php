<?php

declare(strict_types=1);

namespace codevink\avenum;

use codevink\avenum\command\CommandManager;
use codevink\avenum\item\ItemManager;
use codevink\avenum\listener\EventListener;
use codevink\avenum\translation\Translator;
use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase {
	protected function onEnable(): void {
		$this->registerManagers();
		$this->registerEvents();
	}

	protected function registerManagers(): void {
		Translator::initialize($this);
		ItemManager::initialize($this);
		CommandManager::initialize($this);
	}

	protected function registerEvents(): void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}
}