<?php

namespace App\Model;

use mysqli;
use Dotenv\Dotenv;
require __DIR__ .'/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

abstract class Model {
    protected static $db = null;
    public static function conn() {
        if (self::$db === null) {
            try {
                self::$db = new mysqli(
                    $_ENV["DB_HOST"],
                    $_ENV["DB_USERNAME"],
                    $_ENV["DB_PASSWORD"],
                    $_ENV["DB_DATABASE"]
                );
            } catch (\Exception $e) {
                echo "Connection failed: " . $e->getMessage();
                exit;
            }
        }
    }

    // Reconnect if the connection is lost
    protected static function reconnect() {
        if (self::$db === null || !self::$db->ping()) {
            self::reconnect();
            self::conn();
        }
    }

    // Execute a query
    protected function query($sql) {
        self::reconnect();
        return self::$db->query($sql);
    }

    // Prepare a statement
    protected function prepare($sql) {
        return self::$db->prepare($sql);
    }

    public static function treat($data){
        $data = mysqli_real_escape_string(self::$db, trim($data));
        $data = htmlspecialchars($data);
        return $data;
    }
}
