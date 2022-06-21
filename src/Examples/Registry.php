<?php

namespace Amorphine\DeliveryTest\Examples;

use Amorphine\DeliveryTest\ServiceRegistry;

class Registry extends ServiceRegistry
{
    public const SLOW_SERVICE_NAME = "Slow service";
    public const FAST_SERVICE_NAME = "Fast service";

    public function __construct()
    {
        $this->addService(self::FAST_SERVICE_NAME, new FastDeliveryService());
        $this->addService(self::SLOW_SERVICE_NAME, new SlowDeliveryService());
    }
}
