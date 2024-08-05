<?php
require __DIR__ .'/../../vendor/autoload.php';

use App\Controller\AvailabilityController;

header('Content-Type: application/json');

try {
    $date = $_GET['date'];
    if(!isset($_GET['date'])){
        echo json_encode(['status' => 'error', 'message' => "Date not provided"]);
    }
    $availability = new AvailabilityController();
    $response = $availability->getTime($date);
    echo json_encode($response);
}
catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


