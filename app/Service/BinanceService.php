<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\TickerPriceDto;
use App\Interface\ExchangeAPIInterface;
use Hyperf\Guzzle\ClientFactory;
use GuzzleHttp\Client;

class BinanceService implements ExchangeAPIInterface
{
    private string $baseTicker = 'USDT';
    private Client $client;

    public function __construct(
        private ClientFactory $clientFactory,
    )
    {
        $this->client = $this->clientFactory->create();
    }

    /**
     * @return TickerPriceDto[]
     */
    public function getTickersPrice(array $tickers): array
    {
        $url = 'https://api.binance.com/api/v3/ticker/price';

        $basedTickers = array_map(function ($ticker) {
            return "\"$ticker$this->baseTicker\"";
        }, $tickers);

        $params = [
            'symbols' => "[".implode(',', $basedTickers)."]",
        ];

        $requestUrl = $url . '?' . http_build_query($params);

        $response = $this->client->request('GET', $requestUrl);

        $prices = json_decode($response->getBody()->getContents(), true);
        return array_map(function ($price) {
            return new TickerPriceDto($price['symbol'], $price['price']);
        }, $prices);
    }

    public function getName(): string
    {
        return 'Binance';
    }
}
