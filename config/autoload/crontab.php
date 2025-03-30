<?php

declare(strict_types=1);

use Hyperf\Crontab\Crontab;

return [
    "enable" => true,
    "crontab" => [
        (new Crontab())
            ->setName('fetch-prices')
            ->setRule('*/10 * * * * *')
            ->setCallback([App\Service\PriceFetcherService::class, 'fetchAndDispatch'])
            ->setMemo('Fetch crypto prices periodically'),
    ],
];
