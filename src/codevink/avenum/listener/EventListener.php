<?php

declare(strict_types=1);

namespace codevink\avenum\listener;

use codevink\avenum\item\hub\HubItem;
use codevink\avenum\item\hub\HubItems;
use codevink\avenum\translation\Translator;
use codevink\avenum\utils\HubUtils;
use codevink\avenum\world\sound\HubSound;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\QueryRegenerateEvent;

final class EventListener implements Listener {
	/**
	 * @priority HIGHEST
	 */
	public function handlePlayerJoin(PlayerJoinEvent $event): void {
		$player = $event->getPlayer();
		$nickname = $player->getName();
		$event->setJoinMessage("§8[§a+§8] §f$nickname");
		$player->teleport($player->getWorld()->getSafeSpawn());
		$player->getInventory()->setItem(0, HubItems::SERVER_SELECTION()->setCustomName(Translator::translate("item.server_selection.name", $player)));
		$player->getWorld()->addSound($player->getPosition(), HubSound::JOIN(), [$player]);
		$player->sendTitle(Translator::translate("join.title", $player), Translator::translate("join.subtitle", $player));
	}

	public function handlePlayerQuit(PlayerQuitEvent $event): void {
		$player = $event->getPlayer();
		$nickname = $player->getName();
		$event->setQuitMessage("§8[§c-§8] §f$nickname");
		$player->getInventory()->clearAll();
	}

	/**
	 * @handleCancelled
	 */
	public function handleItemUse(PlayerItemUseEvent $event): void {
		$player = $event->getPlayer();
		$item = $event->getItem();
		$event->cancel();
		if ($item instanceof HubItem) {
			$item->onUse($player);
		}
	}

	public function handleBlockBreak(BlockBreakEvent $event): void {
		$event->cancel();
	}

	public function handleBlockPlace(BlockPlaceEvent $event): void {
		$event->cancel();
	}

	public function handleBlockUpdate(BlockUpdateEvent $event): void {
		$event->cancel();
	}

	public function handlePlayerInteract(PlayerInteractEvent $event): void {
		$event->cancel();
	}

	public function handlePlayerDropItem(PlayerDropItemEvent $event): void {
		$event->cancel();
	}

	public function handlePlayerChat(PlayerChatEvent $event): void {
		$event->cancel();
	}

	public function handleEntityDamage(EntityDamageEvent $event): void {
		$event->cancel();
	}
}