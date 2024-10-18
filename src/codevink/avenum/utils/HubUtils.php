<?php

declare(strict_types=1);

namespace codevink\avenum\utils;

use codevink\avenum\form\Server;
use pocketmine\Server as PMServer;
use function count;

class HubUtils {
	public static function getAllPlayers(): int {
		return array_sum(array_map(
			fn(Server $server) => NetworkUtils::getOnline($server->getIp(), $server->getPort()) ?? 0,
			Server::cases()
		)) + count(PMServer::getInstance()->getOnlinePlayers());
	}
}