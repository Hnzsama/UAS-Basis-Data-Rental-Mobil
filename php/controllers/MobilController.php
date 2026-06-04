<?php
require_once __DIR__ . '/../models/Mobil.php';

class MobilController {
    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $error = null;
        $success = null;

        // Handle POST actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'create') {
                $merek = trim($_POST['merek'] ?? '');
                $model = trim($_POST['model'] ?? '');
                $plat = trim($_POST['plat_nomor'] ?? '');
                $harga = intval($_POST['harga_sewa_perhari'] ?? 0);
                $status = trim($_POST['status'] ?? 'Tersedia');

                if (empty($merek) || empty($model) || empty($plat) || $harga <= 0) {
                    $error = "Semua field harus diisi dengan benar!";
                } else {
                    if (Mobil::create($merek, $model, $plat, $harga, $status)) {
                        $success = "Mobil berhasil ditambahkan!";
                        header("Location: index.php?success=" . urlencode($success));
                        exit;
                    } else {
                        $error = "Gagal menambahkan mobil. Plat nomor mungkin sudah terdaftar.";
                    }
                }
            } elseif ($action === 'update') {
                $id = intval($_POST['id_mobil'] ?? 0);
                $merek = trim($_POST['merek'] ?? '');
                $model = trim($_POST['model'] ?? '');
                $plat = trim($_POST['plat_nomor'] ?? '');
                $harga = intval($_POST['harga_sewa_perhari'] ?? 0);
                $status = trim($_POST['status'] ?? 'Tersedia');

                if ($id <= 0 || empty($merek) || empty($model) || empty($plat) || $harga <= 0) {
                    $error = "Semua field harus diisi dengan benar!";
                } else {
                    if (Mobil::update($id, $merek, $model, $plat, $harga, $status)) {
                        $success = "Data mobil berhasil diperbarui!";
                        header("Location: index.php?success=" . urlencode($success));
                        exit;
                    } else {
                        $error = "Gagal memperbarui data mobil.";
                    }
                }
            }
        }

        // Handle GET actions
        if ($action === 'delete') {
            $id = intval($_GET['id'] ?? 0);
            if ($id > 0) {
                if (Mobil::delete($id)) {
                    $success = "Mobil berhasil dihapus!";
                    header("Location: index.php?success=" . urlencode($success));
                    exit;
                } else {
                    $error = "Gagal menghapus mobil.";
                }
            }
        }

        // Prepare variables for the View
        $cars = Mobil::getAll();
        $edit_car = null;
        if ($action === 'edit') {
            $edit_id = intval($_GET['id'] ?? 0);
            if ($edit_id > 0) {
                $edit_car = Mobil::getById($edit_id);
            }
        }

        if (isset($_GET['success'])) {
            $success = $_GET['success'];
        }

        // Load the view template
        require_once __DIR__ . '/../views/mobil_view.php';
    }
}
