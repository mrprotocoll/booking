<?php
require __DIR__ .'/../../vendor/autoload.php';

use App\Controller\AppointmentController;

header('Content-Type: application/json');

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $appointmentController = new AppointmentController();
    $response = $appointmentController->index($page, $limit, $search);
    echo json_encode($response);
}
catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


