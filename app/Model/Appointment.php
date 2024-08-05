<?php

namespace App\Model;

use DateTime;
use DateTimeZone;

class Appointment extends Model{
    protected $table = 'appointments';
    // Add a new appointment
    // Add a new appointment
    public function create($request) {
        $dateTime = new DateTime($request['date']);

        $dateTime->setTimezone(new DateTimeZone('Africa/Lagos'));

        $date = $dateTime->format('Y-m-d'); // e.g., 2024-08-15
        $time = $dateTime->format('H:i A');
        $stmt = $this->prepare("INSERT INTO $this->table (`name`, `email`, `date`, `time`, `comment`, `telephone`) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . self::$db->error);
        }

        // Bind parameters to the prepared statement
        $stmt->bind_param("ssssss", $request['name'], $request['email'], $date, $time, $request['comment'], $request['telephone']);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            return true;
        } else {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
    }

    // Fetch all appointments
    public function getAppointments($page, $limit, $search) {
        $offset = ($page - 1) * $limit;
        $search = '%' . $search . '%';

        if (empty($search)) {
            // Prepare the SQL query without search condition
            $stmt = $this->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
            $stmt->bind_param('ii', $limit, $offset);
        } else {
            // Prepare the SQL query with search condition
            $stmt = $this->prepare("SELECT * FROM $this->table WHERE `name` LIKE ? OR `email` LIKE ? OR `date` LIKE ? LIMIT ? OFFSET ?");
            $stmt->bind_param('sssii', $search, $search, $search, $limit, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }

        return $appointments;
    }

    // Get total number of appointments for pagination
    public function getTotalAppointments($search) {
        $search = '%' . $search . '%';
        $stmt = $this->prepare("SELECT COUNT(*) as total FROM $this->table WHERE `name` LIKE ? OR `email` LIKE ?");
        $stmt->bind_param('ss', $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total'];
    }
}
