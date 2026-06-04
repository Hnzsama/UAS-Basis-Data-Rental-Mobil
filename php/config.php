<?php

// Load environment variables
function load_dotenv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            $value = trim($value, "\"'");
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

load_dotenv(__DIR__ . '/.env');

class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            $host = getenv("DB_HOST") ?: "localhost";
            $user = getenv("DB_USER") ?: "root";
            $pass = getenv("DB_PASSWORD") ?: "";
            $db   = getenv("DB_DATABASE") ?: "uas_rental_mobil";

            // Disable display of raw SQL errors to users for security
            mysqli_report(MYSQLI_REPORT_OFF);
            self::$conn = new mysqli($host, $user, $pass, $db);
            if (self::$conn->connect_error) {
                error_log("Database connection failed: " . self::$conn->connect_error);
                die("Koneksi database gagal. Silakan periksa kembali konfigurasi Anda.");
            }
        }
        return self::$conn;
    }
}
