<?php

namespace Amorphine\DeliveryTest;

class ServiceRegistry
{
    private array $serviceList = [];

    /**
     * Add service to registry
     *
     * @param string $name
     * @param DeliveryService $service
     * @return void
     */
    public function addService(string $name, DeliveryService $service) {
        $this->serviceList[$name] = $service;
    }

    /**
     * Resolve service by name
     *
     * @param string $name
     * @return DeliveryService|null
     */
    public function getService(string $name): ?DeliveryService {
        return $this->serviceList[$name] ?? null;
    }

    /**
     * Get registered service list
     *
     * @return DeliveryService[]
     */
    public function getServiceList(): array {
        return $this->serviceList;
    }
}
