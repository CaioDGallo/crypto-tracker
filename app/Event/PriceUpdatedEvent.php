<?php

declare(strict_types=1);

namespace App\Event;

class PriceUpdatedEvent
{
    public array $prices;

    public function __construct(array $prices)
    {
        $this->prices = $prices;
    }
}
