<?php

declare(strict_types=1);

namespace App\Interface;

interface ExchangeAPIInterface
{
	/**
	 * @return TickerPriceDto[]
	 */
	public function getTickersPrice(array $tickers): array;
	public function getName(): string;
}
