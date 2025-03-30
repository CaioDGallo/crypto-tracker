<?php

declare(strict_types=1);

namespace App\Dto;

class TickerPriceDto
{
	public function __construct(
		public string $ticker,
		public string $price,
	) {}

	public function toArray(): array
	{
		return [
			'ticker' => $this->ticker,
			'price' => $this->price,
		];
	}
}
