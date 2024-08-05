<?php

namespace App\Controller;

use App\Model\Availability;
use Exception;

class AvailabilityController extends Controller
{
    public function __construct(){
        Parent::__construct();
        $this->availability = new Availability();
    }

    public function index($page = 1, $limit = 10, $search = ''): array
    {
        try {
            $availability = $this->availability->all();

            return [
                'status' => 'success',
                'data' => $availability,
            ];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getTime($date)
    {
        try {
            $availability = $this->availability->getTimeByDate($date);

            return [
                'status' => 'success',
                'data' => $availability,
            ];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getDate($date)
    {
        try {
            $availability = $this->availability->getDates($date);

            return [
                'status' => 'success',
                'data' => $availability,
            ];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function create(): array
    {
        try {
            $date = $this->post['date'];
            $times = $this->post['time'];

            if($this->availability->create($date, $times)){
                return ['status' => 'success', 'message' => 'Availability created successfully'];
            }
            return ['status' => 'error', 'message' => 'Failed to create availability'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update()
    {
        try {
            $id = $this->post['id'];
            $date = $this->post['date'];
            $times = $this->post['time'];

            if ($this->availability->update($id, $date, $times)) {
                return ['status' => 'success', 'message' => 'Availability updated successfully'];
            }

            return ['status' => 'error', 'message' => 'Failed to update availability'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function delete()
    {
        try {
            $id = $this->post['id'];

            if ($this->availability->delete($id)) {
                return ['status' => 'success', 'message' => 'Availability deleted successfully'];
            }

            return ['status' => 'error', 'message' => 'Failed to delete availability'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}