<?php

namespace Amorphine\DeliveryTest;

interface DeliveryService
{
    /**
     * Calculate delivery cost
     *
     * @param string $sourceKladr
     * @param string $targetKladr
     * @param float $weight
     *
     * @return DeliveryCost
     */
    function calculateDeliveryCost(string $sourceKladr, string $targetKladr, float $weight): DeliveryCost;

    /**
     * Get public name
     *
     * @return string
     */
    function getPublicName(): string;
}
