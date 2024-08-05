<?php
require __DIR__ .'/../../vendor/autoload.php';

use App\Controller\AppointmentController;

header('Content-Type: application/json');

try {
    $appointmentController = new AppointmentController();
    $response = $appointmentController->create();
    echo json_encode($response);
}
catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


