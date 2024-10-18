<?php

declare(strict_types=1);

namespace codevink\avenum\form;

use codevink\avenum\gui\form\SimpleForm;
use codevink\avenum\translation\Translator;
use codevink\avenum\utils\NetworkUtils;
use pocketmine\player\Player;

final class ServerSelectionForm {
	public static function sendMainForm(Player $player): void {
		$form = new SimpleForm(function (Player $player, ?int $data = null): void {
			if ($data === null) {
				return;
			}

			$servers = Server::cases();
			if (isset($servers[$data])) {
				$server = $servers[$data];
				$player->transfer($server->getIp(), $server->getPort());
			}
		});

		$form->setTitle(Translator::translate('server.selection_form.title', $player));
		$form->setContent(Translator::translate('server.selection_form.content', $player));

		foreach (Server::cases() as $server) {
			$form->addButton(Translator::translate('server.selection_form.server_button', $player, [$server->getName(), NetworkUtils::getOnline($server->getIp(), $server->getPort())]));
		}

		$player->sendForm($form);
	}
}