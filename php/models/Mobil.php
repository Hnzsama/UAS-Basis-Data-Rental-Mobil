<?php
require_once __DIR__ . '/../config.php';

class Mobil {
    public static function getAll() {
        $db = Database::connect();
        $result = $db->query("SELECT * FROM mobil ORDER BY id_mobil DESC");
        $cars = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cars[] = $row;
            }
            $result->free();
        }
        return $cars;
    }

    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM mobil WHERE id_mobil = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $car = $result->fetch_assoc();
            $stmt->close();
            return $car;
        }
        return null;
    }

    public static function create($merek, $model, $plat_nomor, $harga_sewa, $status = 'Tersedia') {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO mobil (merek, model, plat_nomor, harga_sewa_perhari, status) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssis", $merek, $model, $plat_nomor, $harga_sewa, $status);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }

    public static function update($id, $merek, $model, $plat_nomor, $harga_sewa, $status) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE mobil SET merek = ?, model = ?, plat_nomor = ?, harga_sewa_perhari = ?, status = ? WHERE id_mobil = ?");
        if ($stmt) {
            $stmt->bind_param("sssisi", $merek, $model, $plat_nomor, $harga_sewa, $status, $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM mobil WHERE id_mobil = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }
}
