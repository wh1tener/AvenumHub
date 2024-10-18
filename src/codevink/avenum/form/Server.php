<?php

declare(strict_types=1);

namespace codevink\avenum\form;

enum Server {
    case AVENUM;
    case ESPADA;

    public function getName(): string {
        return match ($this) {
            self::AVENUM => "§l§aAvenum Network [RU]",
            self::ESPADA => "§dEspada Practice [RU]",
        };
    }

    public function getIp(): string {
        return match ($this) {
            self::AVENUM => "soulsburn.com",
            self::ESPADA => "espada-pe.ru",
        };
    }

    public function getPort(): int {
        return match ($this) {
            self::AVENUM => 19132,
            self::ESPADA => 19133,
        };
    }
}