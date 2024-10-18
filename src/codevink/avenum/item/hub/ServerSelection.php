<?php

declare(strict_types=1);

namespace codevink\avenum\item\hub;

use codevink\avenum\form\ServerSelectionForm;
use pocketmine\item\Compass;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class ServerSelection extends Compass implements HubItem {
	public function __construct() {
		parent::__construct(new ItemIdentifier(ItemTypeIds::COMPASS), 'ServerSelection');

		$this->setCustomName(TextFormat::RESET . 'Server Selection');
		$this->setLore(self::LORE);
	}

	public function onUse(Player $player): void {
		ServerSelectionForm::sendMainForm($player);
	}

	public function getMaxStackSize(): int {
		return self::MAX_STACK_SIZE;
	}
}
