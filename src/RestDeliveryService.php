<?php

namespace Amorphine\DeliveryTest;

use Amorphine\DeliveryTest\Exceptions\RestServiceConnectionException;

abstract class RestDeliveryService implements DeliveryService
{
    protected string $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Query API for delivery cost data
     *
     * @param array $payload - delivery service payload
     *
     * @return string
     *
     * @throws RestServiceConnectionException
     */
    abstract protected function fetchDeliveryCost(array $payload): string;

    /**
     * Parse delivery service response
     *
     * @param array $response
     * @param DeliveryCost $cost
     *
     * @return DeliveryCost
     */
    abstract function parseDeliveryCost(array $response, DeliveryCost $cost): DeliveryCost;

    /**
     * @inheritDoc
     */
    public function calculateDeliveryCost(string $sourceKladr, string $targetKladr, float $weight): DeliveryCost {
        $cost = new DeliveryCost(0, "", "");

        if (!($sourceKladr && $targetKladr && $weight)) {
            $cost->setError("Invalid delivery parameters");
            return $cost;
        }

        try {
            $data = $this->fetchDeliveryCost(
                compact('sourceKladr', 'targetKladr', 'weight')
            );

            $json = json_decode($data, true);

            if (!$json) {
                $cost->setError("Unknown response");
                return $cost;
            }

            return $this->parseDeliveryCost($json, $cost);
        } catch (Exceptions\RestServiceConnectionException $e) {
            $cost->setError($e->getMessage() ?: "Failed data receive");
        }

        return $cost;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }
}
