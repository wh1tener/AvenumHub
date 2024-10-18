<?php

declare(strict_types=1);

namespace codevink\avenum\gui\form;

use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use pocketmine\utils\Utils;
use function count;
use function is_int;

class SimpleForm extends AbstractForm {
	final public const IMAGE_TYPE_NONE = -1;
	final public const IMAGE_TYPE_PATH = 0;
	final public const IMAGE_TYPE_URL  = 1;

	private string $content = '';
	private array $labelMap = [];

	public function __construct(?\Closure $callback = null) {
		if ($callback instanceof \Closure) {
			Utils::validateCallableSignature(function (Player $player, ?int $data = null): void {}, $callback);
		}
		parent::__construct($callback);

		$this->data['type']    = 'form';
		$this->data['title']   = '';
		$this->data['content'] = $this->content;
		$this->data['buttons'] = [];
	}

	public function setCallback(?\Closure $callback): void {
		if ($callback instanceof \Closure) {
			Utils::validateCallableSignature(function (Player $player, ?int $data = null): void {}, $callback);
		}
		parent::setCallback($callback);
	}

	public function processData(mixed &$data): void {
		if (null !== $data) {
			if (!is_int($data)) {
				$data = (int) $data;
			}

			$count = count($this->data['buttons']);
			if ($data >= $count || $data < 0) {
				throw new FormValidationException('Button ' . $data . ' does not exist');
			}

			$data = $this->labelMap[$data] ?? null;
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

	public function addButton(string $text, int $imageType = self::IMAGE_TYPE_NONE, string $imagePath = '', ?string $label = null): void {
		if (self::IMAGE_TYPE_NONE !== $imageType && self::IMAGE_TYPE_PATH !== $imageType && self::IMAGE_TYPE_URL !== $imageType) {
			throw new FormValidationException('Unknown image type: ' . $imageType);
		}

		$content = ['text' => $text];
		if (self::IMAGE_TYPE_NONE !== $imageType) {
			$content['image']['type'] = self::IMAGE_TYPE_PATH === $imageType ? 'path' : 'url';
			$content['image']['data'] = $imagePath;
		}

		$this->data['buttons'][] = $content;
		$this->labelMap[]        = $label ?? count($this->labelMap);
	}
}
