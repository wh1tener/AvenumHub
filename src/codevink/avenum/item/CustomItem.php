<?php

declare(strict_types=1);

namespace codevink\avenum\item;

use pocketmine\utils\TextFormat;

interface CustomItem {
	public const MAX_STACK_SIZE = 1;
	public const LORE           = [TextFormat::RESET . TextFormat::AQUA . 'avenum.fun'];
}
