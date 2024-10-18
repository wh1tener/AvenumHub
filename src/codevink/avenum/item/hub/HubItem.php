<?php

declare(strict_types=1);

namespace codevink\avenum\item\hub;

use codevink\avenum\item\CustomItem;
use pocketmine\player\Player;

interface HubItem extends CustomItem {
	public function onUse(Player $player): void;
}
