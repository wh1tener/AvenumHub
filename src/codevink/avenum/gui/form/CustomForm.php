<?php

declare(strict_types=1);

namespace codevink\avenum\gui\form;

use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use pocketmine\utils\Utils;
use function count;
use function gettype;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_string;

class CustomForm extends AbstractForm {
	private array $labelMap          = [];
	private array $validationMethods = [];

	public function __construct(?\Closure $callback = null) {
		if ($callback instanceof \Closure) {
			Utils::validateCallableSignature(function (Player $player, ?array $data = null): void {}, $callback);
		}
		parent::__construct($callback);

		$this->data['type']    = 'custom_form';
		$this->data['title']   = '';
		$this->data['content'] = [];
	}

	public function setCallback(?\Closure $callback): void {
		if ($callback instanceof \Closure) {
			Utils::validateCallableSignature(function (Player $player, ?array $data = null): void {}, $callback);
		}
		parent::setCallback($callback);
	}

	public function processData(mixed &$data): void {
		if (null !== $data && !is_array($data)) {
			throw new FormValidationException('Expected an array response, got ' . gettype($data));
		}

		if (is_array($data)) {
			if (count($data) !== count($this->validationMethods)) {
				throw new FormValidationException('Expected an array response with the size ' . count($this->validationMethods) . ', got ' . count($data));
			}

			$new = [];
			foreach ($data as $i => $v) {
				$validationMethod = $this->validationMethods[$i] ?? null;

				if (null === $validationMethod) {
					throw new FormValidationException('Invalid element ' . $i);
				}

				if (!$validationMethod($v)) {
					throw new FormValidationException('Invalid type given for element ' . $this->labelMap[$i]);
				}

				$new[$this->labelMap[$i]] = $v;
			}
			$data = $new;
		}
	}

	public function setTitle(string $title): void {
		$this->data['title'] = $title;
	}

	public function getTitle(): string {
		return $this->data['title'];
	}

	public function addLabel(string $text, ?string $label = null): void {
		$this->addContent(['type' => 'label', 'text' => $text]);
		$this->labelMap[]          = $label ?? count($this->labelMap);
		$this->validationMethods[] = static fn ($v) => null === $v;
	}

	public function addToggle(string $text, ?bool $default = null, ?string $label = null): void {
		$content = ['type' => 'toggle', 'text' => $text];
		if (null !== $default) {
			$content['default'] = $default;
		}

		$this->addContent($content);
		$this->labelMap[]          = $label ?? count($this->labelMap);
		$this->validationMethods[] = static fn ($v) => is_bool($v);
	}

	public function addSlider(string $text, int $min, int $max, int $step = -1, int $default = -1, ?string $label = null): void {
		$content = ['type' => 'slider', 'text' => $text, 'min' => $min, 'max' => $max];
		if (-1 !== $step) {
			$content['step'] = $step;
		}

		if (-1 !== $default) {
			$content['default'] = $default;
		}

		$this->addContent($content);
		$this->labelMap[]          = $label ?? count($this->labelMap);
		$this->validationMethods[] = static fn ($v) => (is_float($v) || is_int($v)) && $v >= $min && $v <= $max;
	}

	public function addStepSlider(string $text, array $steps, int $defaultIndex = -1, ?string $label = null): void {
		$content = ['type' => 'step_slider', 'text' => $text, 'steps' => $steps];
		if (-1 !== $defaultIndex) {
			$content['default'] = $defaultIndex;
		}

		$this->addContent($content);
		$this->labelMap[]          = $label ?? count($this->labelMap);
		$this->validationMethods[] = static fn ($v) => is_int($v) && isset($steps[$v]);
	}

	public function addDropdown(string $text, array $options, ?int $default = null, ?string $label = null): void {
		$this->addContent(['type' => 'dropdown', 'text' => $text, 'options' => $options, 'default' => $default]);
		$this->labelMap[]          = $label ?? count($this->labelMap);
		$this->validationMethods[] = static fn ($v) => is_int($v) && isset($options[$v]);
	}

	public function addInput(string $text, string $placeholder = '', ?string $default = null, ?string $label = null): void {
		$this->addContent(['type' => 'input', 'text' => $text, 'placeholder' => $placeholder, 'default' => $default]);
		$this->labelMap[]          = $label ?? count($this->labelMap);
		$this->validationMethods[] = static fn ($v) => is_string($v);
	}

	private function addContent(array $content): void {
		$this->data['content'][] = $content;
	}
}
