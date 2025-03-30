<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\PriceUpdatedEvent;
use App\Service\AlertCheckerService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class PriceUpdatedListener implements ListenerInterface
{
    private AlertCheckerService $alertCheckerService;

    public function __construct(AlertCheckerService $alertCheckerService)
    {
        $this->alertCheckerService = $alertCheckerService;
    }

    public function listen(): array
    {
        return [
            PriceUpdatedEvent::class,
        ];
    }

    public function process(object $event): void
    {
        $this->alertCheckerService->handlePriceUpdatedEvent($event);
    }
}

