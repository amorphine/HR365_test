<?php

namespace Amorphine\DeliveryTest\Examples;

use Amorphine\DeliveryTest\DeliveryCost;
use Amorphine\DeliveryTest\RestDeliveryService;

class SlowDeliveryService extends RestDeliveryService
{
    public const ENDPOINT = "https://slow-delivery.ru/api/v1";
    public const BASE_PRICE = 150;
    public const PUBLIC_NAME = "Slow delivery service";

    public function __construct(string $baseUrl = '')
    {
        parent::__construct($baseUrl ?: static::ENDPOINT);
    }

    /**
     * @inheritDoc
     */
    function fetchDeliveryCost(array $payload): string
    {
        // emulating request
        $today = (new \DateTime())->add(new \DateInterval("P15D"));
        return json_encode([
            'coefficient' => 0.1 * $payload['weight'],
            'date' => $today->format('Y-m-d'),
            'error' => '',
        ]);
    }

    /**
     * @inheritDoc
     */
    function parseDeliveryCost(array $response, DeliveryCost $cost): DeliveryCost
    {
        $cost->setPrice($response['coefficient']*self::BASE_PRICE);
        $cost->setDate($response['date']);
        $cost->setError($response['error']);

        return $cost;
    }

    /**
     * @inheritDoc
     */
    function getPublicName(): string
    {
        return static::PUBLIC_NAME;
    }
}
