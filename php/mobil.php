<?php

// Load environment variables from .env file
function load_dotenv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Remove outer quotes
            $value = trim($value, "\"'");
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Load from python/.env or current directory
load_dotenv(__DIR__ . '/../python/.env');
load_dotenv(__DIR__ . '/.env');

function connect_db() {
    $host = getenv("DB_HOST") ?: "localhost";
    $user = getenv("DB_USER") ?: "root";
    $pass = getenv("DB_PASSWORD") ?: "";
    $db   = getenv("DB_DATABASE") ?: "uas_rental_mobil";

    // Disable default mysqli error display to prevent leakage
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        // TODO(security): Log error diagnostics securely for developers. Do not expose SQL errors to users.
        error_log("Database connection failed: " . $conn->connect_error);
        die("Koneksi ke database gagal. Silakan coba beberapa saat lagi.\n");
    }
    return $conn;
}

// --- CRUD TABEL MOBIL ---
function create_mobil($merek, $model, $plat, $harga) {
    $conn = connect_db();
    $sql = "INSERT INTO mobil (merek, model, plat_nomor, harga_sewa_perhari) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare statement failed: " . $conn->error);
        echo "Error: Gagal memproses permintaan.\n";
        $conn->close();
        return;
    }
    $stmt->bind_param("sssi", $merek, $model, $plat, $harga);
    if ($stmt->execute()) {
        echo "Mobil berhasil ditambahkan!\n";
    } else {
        error_log("Execute statement failed: " . $stmt->error);
        echo "Error: Gagal menambahkan mobil.\n";
    }
    $stmt->close();
    $conn->close();
}

function read_mobil() {
    $conn = connect_db();
    $sql = "SELECT id_mobil, merek, model, plat_nomor, harga_sewa_perhari, status FROM mobil";
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Query failed: " . $conn->error);
        echo "Error: Gagal menampilkan daftar mobil.\n";
        $conn->close();
        return;
    }
    while ($row = $result->fetch_row()) {
        // Print output format similar to Python's print(row)
        printf("(%d, '%s', '%s', '%s', %d, '%s')\n", 
            $row[0], $row[1], $row[2], $row[3], $row[4], $row[5] ?? 'Tersedia'
        );
    }
    $result->free();
    $conn->close();
}

function update_mobil($id_mobil, $harga) {
    $conn = connect_db();
    $sql = "UPDATE mobil SET harga_sewa_perhari = ? WHERE id_mobil = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare statement failed: " . $conn->error);
        echo "Error: Gagal memproses permintaan.\n";
        $conn->close();
        return;
    }
    $stmt->bind_param("ii", $harga, $id_mobil);
    if ($stmt->execute()) {
        echo "Harga mobil berhasil diperbarui!\n";
    } else {
        error_log("Execute statement failed: " . $stmt->error);
        echo "Error: Gagal memperbarui harga mobil.\n";
    }
    $stmt->close();
    $conn->close();
}

function delete_mobil($id_mobil) {
    $conn = connect_db();
    $sql = "DELETE FROM mobil WHERE id_mobil = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare statement failed: " . $conn->error);
        echo "Error: Gagal memproses permintaan.\n";
        $conn->close();
        return;
    }
    $stmt->bind_param("i", $id_mobil);
    if ($stmt->execute()) {
        echo "Mobil berhasil dihapus!\n";
    } else {
        error_log("Execute statement failed: " . $stmt->error);
        echo "Error: Gagal menghapus mobil.\n";
    }
    $stmt->close();
    $conn->close();
}

function main() {
    // Check if running from CLI
    if (php_sapi_name() !== 'cli') {
        echo "Skrip ini hanya dapat dijalankan melalui CLI (Command Line Interface).\n";
        return;
    }

    while (true) {
        echo "\n=== MENU CRUD MOBIL (PHP) ===\n";
        echo "1. Tambah Mobil (Create)\n";
        echo "2. Tampilkan Daftar Mobil (Read)\n";
        echo "3. Perbarui Harga Sewa Mobil (Update)\n";
        echo "4. Hapus Mobil (Delete)\n";
        echo "5. Keluar\n";
        echo "Pilih menu (1-5): ";
        
        $pilihan = trim(fgets(STDIN));
        
        if ($pilihan === "1") {
            echo "\n--- Tambah Mobil ---\n";
            echo "Merek: ";
            $merek = trim(fgets(STDIN));
            echo "Model: ";
            $model = trim(fgets(STDIN));
            echo "Plat Nomor: ";
            $plat = trim(fgets(STDIN));
            echo "Harga Sewa Per Hari: ";
            $harga_input = trim(fgets(STDIN));
            
            if (is_numeric($harga_input)) {
                create_mobil($merek, $model, $plat, intval($harga_input));
            } else {
                echo "Error: Harga sewa harus berupa angka!\n";
            }
        } elseif ($pilihan === "2") {
            echo "\n--- Daftar Mobil ---\n";
            read_mobil();
        } elseif ($pilihan === "3") {
            echo "\n--- Perbarui Harga Sewa ---\n";
            echo "ID Mobil yang ingin diupdate: ";
            $id_input = trim(fgets(STDIN));
            echo "Harga Sewa Baru: ";
            $harga_input = trim(fgets(STDIN));
            
            if (is_numeric($id_input) && is_numeric($harga_input)) {
                update_mobil(intval($id_input), intval($harga_input));
            } else {
                echo "Error: ID Mobil dan Harga harus berupa angka!\n";
            }
        } elseif ($pilihan === "4") {
            echo "\n--- Hapus Mobil ---\n";
            echo "ID Mobil yang ingin dihapus: ";
            $id_input = trim(fgets(STDIN));
            
            if (is_numeric($id_input)) {
                delete_mobil(intval($id_input));
            } else {
                echo "Error: ID Mobil harus berupa angka!\n";
            }
        } elseif ($pilihan === "5") {
            echo "Keluar dari program. Terima kasih!\n";
            break;
        } else {
            echo "Pilihan tidak valid! Silakan masukkan 1-5.\n";
        }
    }
}

// Jalankan program utama
main();
