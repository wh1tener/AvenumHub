<?php

declare(strict_types=1);

namespace codevink\avenum\gui\form;

use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class AbstractForm implements Form {
	protected array $data = [];

	public function __construct(private ?\Closure $callback = null) {
	}

	public function setCallback(?\Closure $callback): void {
		$this->callback = $callback;
	}

	public function getCallback(): ?\Closure {
		return $this->callback;
	}

	public function handleResponse(Player $player, mixed $data): void {
		$this->processData($data);
		if ($this->callback instanceof \Closure) {
			($this->callback)($player, $data);
		}
	}

	abstract public function processData(mixed &$data): void;

	public function jsonSerialize(): array {
		return $this->data;
	}
}
