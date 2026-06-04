<?php
require_once __DIR__ . '/../models/Mobil.php';
require_once __DIR__ . '/../models/Pelanggan.php';

class MobilController {
    public function handleRequest() {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'mobil';
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $error = null;
        $success = null;

        // Handle POST Actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- MOBIL ACTIONS ---
            if ($action === 'create_mobil') {
                $merek = trim($_POST['merek'] ?? '');
                $model = trim($_POST['model'] ?? '');
                $plat = trim($_POST['plat_nomor'] ?? '');
                $harga = intval($_POST['harga_sewa_perhari'] ?? 0);
                $status = trim($_POST['status'] ?? 'Tersedia');

                if (empty($merek) || empty($model) || empty($plat) || $harga <= 0) {
                    $error = "Semua field mobil harus diisi dengan benar!";
                } else {
                    if (Mobil::create($merek, $model, $plat, $harga, $status)) {
                        $success = "Mobil berhasil ditambahkan!";
                        header("Location: index.php?tab=mobil&success=" . urlencode($success));
                        exit;
                    } else {
                        $error = "Gagal menambahkan mobil. Plat nomor mungkin sudah terdaftar.";
                    }
                }
            } elseif ($action === 'update_mobil') {
                $id = intval($_POST['id_mobil'] ?? 0);
                $merek = trim($_POST['merek'] ?? '');
                $model = trim($_POST['model'] ?? '');
                $plat = trim($_POST['plat_nomor'] ?? '');
                $harga = intval($_POST['harga_sewa_perhari'] ?? 0);
                $status = trim($_POST['status'] ?? 'Tersedia');

                if ($id <= 0 || empty($merek) || empty($model) || empty($plat) || $harga <= 0) {
                    $error = "Semua field mobil harus diisi dengan benar!";
                } else {
                    if (Mobil::update($id, $merek, $model, $plat, $harga, $status)) {
                        $success = "Data mobil berhasil diperbarui!";
                        header("Location: index.php?tab=mobil&success=" . urlencode($success));
                        exit;
                    } else {
                        $error = "Gagal memperbarui data mobil.";
                    }
                }
            }
            
            // --- PELANGGAN ACTIONS ---
            elseif ($action === 'create_pelanggan') {
                $nama = trim($_POST['nama'] ?? '');
                $ktp = trim($_POST['no_ktp'] ?? '');
                $telp = trim($_POST['no_telp'] ?? '');
                $alamat = trim($_POST['alamat'] ?? '');

                if (empty($nama) || empty($ktp) || empty($telp) || empty($alamat)) {
                    $error = "Semua field pelanggan harus diisi!";
                } else {
                    if (Pelanggan::create($nama, $ktp, $telp, $alamat)) {
                        $success = "Pelanggan berhasil ditambahkan!";
                        header("Location: index.php?tab=pelanggan&success=" . urlencode($success));
                        exit;
                    } else {
                        $error = "Gagal menambahkan pelanggan. KTP mungkin sudah terdaftar.";
                    }
                }
            } elseif ($action === 'update_pelanggan') {
                $id = intval($_POST['id_pelanggan'] ?? 0);
                $nama = trim($_POST['nama'] ?? '');
                $ktp = trim($_POST['no_ktp'] ?? '');
                $telp = trim($_POST['no_telp'] ?? '');
                $alamat = trim($_POST['alamat'] ?? '');

                if ($id <= 0 || empty($nama) || empty($ktp) || empty($telp) || empty($alamat)) {
                    $error = "Semua field pelanggan harus diisi dengan benar!";
                } else {
                    if (Pelanggan::update($id, $nama, $ktp, $telp, $alamat)) {
                        $success = "Data pelanggan berhasil diperbarui!";
                        header("Location: index.php?tab=pelanggan&success=" . urlencode($success));
                        exit;
                    } else {
                        $error = "Gagal memperbarui data pelanggan.";
                    }
                }
            }
        }

        // Handle GET Actions for deletion
        if ($action === 'delete_mobil') {
            $id = intval($_GET['id'] ?? 0);
            if ($id > 0) {
                if (Mobil::delete($id)) {
                    $success = "Mobil berhasil dihapus!";
                    header("Location: index.php?tab=mobil&success=" . urlencode($success));
                    exit;
                } else {
                    $error = "Gagal menghapus mobil.";
                }
            }
        } elseif ($action === 'delete_pelanggan') {
            $id = intval($_GET['id'] ?? 0);
            if ($id > 0) {
                if (Pelanggan::delete($id)) {
                    $success = "Pelanggan berhasil dihapus!";
                    header("Location: index.php?tab=pelanggan&success=" . urlencode($success));
                    exit;
                } else {
                    $error = "Gagal menghapus pelanggan.";
                }
            }
        }

        // Prepare variables for the View
        $cars = Mobil::getAll();
        $customers = Pelanggan::getAll();
        
        $edit_car = null;
        $edit_customer = null;
        
        if ($action === 'edit_mobil') {
            $edit_id = intval($_GET['id'] ?? 0);
            if ($edit_id > 0) {
                $edit_car = Mobil::getById($edit_id);
            }
        } elseif ($action === 'edit_pelanggan') {
            $edit_id = intval($_GET['id'] ?? 0);
            if ($edit_id > 0) {
                $edit_customer = Pelanggan::getById($edit_id);
            }
        }

        if (isset($_GET['success'])) {
            $success = $_GET['success'];
        }

        // Load the view template
        require_once __DIR__ . '/../views/mobil_view.php';
    }
}
