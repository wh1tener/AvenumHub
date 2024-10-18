<?php

declare(strict_types=1);

namespace codevink\avenum\gui\form;

use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use pocketmine\utils\Utils;
use function gettype;
use function is_bool;

class ModalForm extends AbstractForm {
	private string $content = '';

	public function __construct(?\Closure $callback = null) {
		if ($callback instanceof \Closure) {
			Utils::validateCallableSignature(function (Player $player, ?bool $data = null): void {}, $callback);
		}
		parent::__construct($callback);

		$this->data['type']    = 'modal';
		$this->data['title']   = '';
		$this->data['content'] = $this->content;
		$this->data['button1'] = '';
		$this->data['button2'] = '';
	}

	public function setCallback(?\Closure $callback): void {
		if ($callback instanceof \Closure) {
			Utils::validateCallableSignature(function (Player $player, ?bool $data = null): void {}, $callback);
		}
		parent::setCallback($callback);
	}

	/**
	 * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
	 */
	public function processData(mixed &$data): void {
		if (null !== $data && !is_bool($data)) {
			throw new FormValidationException('Expected a boolean response, got ' . gettype($data));
		}
	}

	public function setTitle(string $title): void {
		$this->data['title'] = $title;
	}

	public function getTitle(): string {
		return $this->data['title'];
	}

	public function getContent(): string {
		return $this->data['content'];
	}

	public function setContent(string $content): void {
		$this->data['content'] = $content;
	}

	public function setFirstButton(string $text): void {
		$this->data['button1'] = $text;
	}

	public function getFirstButton(): string {
		return $this->data['button1'];
	}

	public function setSecondButton(string $text): void {
		$this->data['button2'] = $text;
	}

	public function getSecondButton(): string {
		return $this->data['button2'];
	}
}
