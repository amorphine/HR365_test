<?php

namespace Amorphine\DeliveryTest\Examples;

use Amorphine\DeliveryTest\DeliveryCost;
use Amorphine\DeliveryTest\RestDeliveryService;

class FastDeliveryService extends RestDeliveryService
{
    public const ENDPOINT = "https://fast-delivery.ru/api/v1";
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
        return json_encode([
            'price' => 0.1,
            'period' => 10,
            'error' => '',
        ]);
    }

    /**
     * @inheritDoc
     */
    function parseDeliveryCost(array $response, DeliveryCost $cost): DeliveryCost
    {
        $error = $response['error'];

        // no sense to process all fields on error
        if ($error) {
            $cost->setError($error);

            return  $cost;
        }

        $cost->setPrice($response['price']);

        // check time to increase the delivery day by one due to the freight may be processed next day
        $date = new \DateTime();

        $increase = (int)$response['period'];

        $hours = (int)$date->format("H");

        if ($hours >= 18) {
            $increase += 1;
        }

        $date->add(new \DateInterval("P{$increase}D"));

        $cost->setDate($date->format('Y-m-d'));

        return $cost;
    }

    function getPublicName(): string
    {
        return static::PUBLIC_NAME;
    }
}
