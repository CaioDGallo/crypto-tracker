<?php

declare(strict_types=1);

namespace App\Provider;

use App\Interface\ExchangeAPIInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Di\Annotation\Inject;

class ExchangeServiceProvider
{
	#[Inject]
	private ContainerInterface $container;

	public function getExchanges(): array
	{
		$exchanges = [];

		$exchangeKeys = [
			'exchange.binance',
			// 'exchange.coinbase',
		];

		foreach ($exchangeKeys as $key) {
			if ($this->container->has($key)) {
				$exchange = $this->container->get($key);
				if ($exchange instanceof ExchangeAPIInterface) {
					$exchanges[] = $exchange;
				}
			}
		}

		return $exchanges;
	}
}
