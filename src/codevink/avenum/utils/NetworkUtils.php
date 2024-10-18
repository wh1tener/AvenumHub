<?php

declare(strict_types=1);

namespace codevink\avenum\utils;

use raklib\protocol\UnconnectedPing;
use function strlen;

class NetworkUtils {
	public static function getOnline(string $ip, int $port): int {
		try {
			$socket = fsockopen("udp://" . $ip, $port);
			stream_set_timeout($socket, 30);

			if ($socket === false) {
				return -1;
			}

			$pk = new UnconnectedPing();
			$pk->sendPingTime = (int) (microtime(true) * 1000);
			$pk->clientId = PHP_INT_MAX;
			$buffer = $pk->buffer;
			$pk->encodePayload($buffer);

			fwrite($socket, $buffer);

			$data = fread($socket, 4096);

			if ($data !== false && strlen($data) > 35) {
				return (int) explode(";", substr($data, 35))[4];
			}
		} catch (\Exception $exception) {
			return -1;
		}
		return 0;
	}
}