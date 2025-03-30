<?php

declare(strict_types=1);

namespace App\Service;

use App\Event\PriceUpdatedEvent;
use App\Interface\ExchangeAPIInterface;
use App\Logger\Log;
use App\Provider\ExchangeServiceProvider;
use Hyperf\Coroutine\Parallel;
use Psr\EventDispatcher\EventDispatcherInterface;

class PriceFetcherService
{
	private EventDispatcherInterface $eventDispatcher;

	/**
	 * @var ExchangeAPIInterface[]
	 */
	private array $exchangeAPIs;

	public function __construct(
		EventDispatcherInterface $eventDispatcher,
		ExchangeServiceProvider $exchangeProvider
	) {
		$this->eventDispatcher = $eventDispatcher;
		$this->exchangeAPIs = $exchangeProvider->getExchanges();
	}

	public function fetchAndDispatch()
	{
		$prices = $this->fetchPrices();
		Log::get()->info('Prices fetched!', compact('prices'));
		$this->eventDispatcher->dispatch(new PriceUpdatedEvent($prices));
	}

	public function fetchPrices(): array
	{
		Log::get()->info('Fetching ticker prices...');

		$tickers = ['BTC', 'ETH', 'LTC'];

		$prices = [];
		$parallel = new Parallel();
		foreach ($this->exchangeAPIs as $exchangeAPI) {
			$parallel->add(function () use (&$prices, $exchangeAPI, $tickers) {
				$prices[$exchangeAPI->getName()] = $exchangeAPI->getTickersPrice($tickers);
			});
		}
		$parallel->wait();

		return $prices;
	}
}
