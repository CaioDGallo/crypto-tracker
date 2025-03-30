<?php

declare(strict_types=1);

namespace App\Service;

use App\Event\PriceUpdatedEvent;
use App\Model\Alert;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;

class AlertCheckerService
{
    private NotificationService $notificationService;
    private LoggerInterface $logger;

    public function __construct(NotificationService $notificationService, LoggerFactory $loggerFactory)
    {
        $this->notificationService = $notificationService;
        $this->logger = $loggerFactory->get('log', 'default');
    }

    public function handlePriceUpdatedEvent(PriceUpdatedEvent $event)
    {
        $this->logger->info('Handling PriceUpdatedEvent...');
        $this->checkAlerts($event->prices);
    }

    private function checkAlerts(array $prices)
    {
        $alerts = [];
        foreach ($alerts as $alert) {
            if ($this->isTriggered($alert, $prices[$alert->crypto_asset])) {
                $this->notificationService->sendEmail(
                    $alert->email,
                    "Price Alert Triggered",
                    "{$alert->crypto_asset} reached {$prices[$alert->crypto_asset]}!"
                );
            }
        }
    }

    protected function isTriggered(Alert $alert, float $price)
    {
        return $price >= $alert->threshold;
    }
}
