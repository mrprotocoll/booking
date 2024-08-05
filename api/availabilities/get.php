<?php
require __DIR__ .'/../../vendor/autoload.php';

use App\Controller\AvailabilityController;

header('Content-Type: application/json');

try {
    $availability = new AvailabilityController();
    $response = $availability->index();
    echo json_encode($response);
}
catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


