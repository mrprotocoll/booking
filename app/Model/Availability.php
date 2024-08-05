<?php

namespace App\Model;

class Availability extends Model {
    protected $table = 'available_dates';
    // Add a new availability
    public function create($date, $time) {
        $stmt = $this->prepare("INSERT INTO {$this->table} (date, time) VALUES (?, ?)");
        $jsonTimes = json_encode($time);
        $stmt->bind_param('ss', $date, $jsonTimes);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Fetch all available dates
    public function all() {
        $result = $this->query("SELECT * FROM {$this->table}");

        $availabilities = [];
        while ($row = $result->fetch_assoc()) {
            $availabilities[] = $row;
        }

        return $availabilities;
    }

    public function getTimeByDate($date) {
        $result = $this->query("SELECT time FROM {$this->table} WHERE `date` = '$date'");

        $availabilities = [];
        while ($row = $result->fetch_assoc()) {
            $availabilities[] = $row['time'];
        }

        return $availabilities;
    }

    // Update an availability
    public function update($id, $date, $times)
    {
        $stmt = $this->prepare("UPDATE $this->table SET date = ?, time = ? WHERE id = ?");
        $jsonTimes = json_encode($times);
        $stmt->bind_param('sss', $date, $jsonTimes, $id);

        return $stmt->execute();
    }

    // Delete an availability
    public function delete($id)
    {
        $stmt = $this->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param('s', $id);

        return $stmt->execute();
    }

}
