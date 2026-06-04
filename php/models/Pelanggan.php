<?php
require_once __DIR__ . '/../config.php';

class Pelanggan {
    public static function getAll() {
        $db = Database::connect();
        $result = $db->query("SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
        $customers = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            $result->free();
        }
        return $customers;
    }

    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $customer = $result->fetch_assoc();
            $stmt->close();
            return $customer;
        }
        return null;
    }

    public static function create($nama, $no_ktp, $no_telp, $alamat) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO pelanggan (nama, no_ktp, no_telp, alamat) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $nama, $no_ktp, $no_telp, $alamat);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }

    public static function update($id, $nama, $no_ktp, $no_telp, $alamat) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE pelanggan SET nama = ?, no_ktp = ?, no_telp = ?, alamat = ? WHERE id_pelanggan = ?");
        if ($stmt) {
            $stmt->bind_param("ssssi", $nama, $no_ktp, $no_telp, $alamat, $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }
}
