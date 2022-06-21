<?php
require_once './vendor/autoload.php';

$registry = new \Amorphine\DeliveryTest\Examples\Registry();

$weight = $_GET['weight'] ?? 0;
$sourceKladr = $_GET['source'] ?? '';
$targetKladr= $_GET['target'] ?? '';

$response = [];

foreach ($registry->getServiceList() as $name => $service) {
    $cost = $service->calculateDeliveryCost($sourceKladr, $targetKladr, $weight);
    $response[] = array_merge(
        (array)$cost,
        [
          'price' => round($cost->getPrice(), 2)
        ],
        [
            'name' => $name,
        ]
    );
}

header('Content-Type: application/json');

echo json_encode($response)

?>
