<?php

namespace App\Controller;

use App\Model\Appointment;
use Exception;

class AppointmentController extends Controller
{
    protected $appointment;
    public function __construct(){
        Parent::__construct();
        $this->appointment = new Appointment();
    }

    public function create(): array
    {
        try {
            if($this->appointment->create($this->post)){
                return ['status' => 'success', 'message' => 'Appointment created successfully'];
            }
            return ['status' => 'error', 'message' => 'Failed to create appointment'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function index($page = 1, $limit = 10, $search = ''): array
    {
        try {
            $total = $this->appointment->getTotalAppointments($search);
            $appointment = $this->appointment->getAppointments($page, $limit, $search);

            return [
                'status' => 'success',
                'data' => $appointment,
                'total' => $total,
                'page' => $page,
                'limit' => $limit
            ];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


}