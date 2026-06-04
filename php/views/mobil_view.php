<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil - Dashboard Armada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-main: #060913;
            --bg-card: rgba(16, 22, 40, 0.7);
            --bg-card-hover: rgba(22, 30, 54, 0.85);
            --border-glass: rgba(255, 255, 255, 0.08);
            --accent-cyan: #00f2fe;
            --accent-blue: #4facfe;
            --accent-purple: #7928ca;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --color-success: #10b981;
            --color-danger: #ef4444;
            --font-family: 'Outfit', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            background-image: 
                radial-gradient(at 10% 20%, rgba(79, 172, 254, 0.1) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(121, 40, 202, 0.12) 0px, transparent 50%);
            background-attachment: fixed;
            padding: 2.5rem 1.5rem;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Header Style */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-glass);
            padding-bottom: 1.5rem;
        }

        .header-title h1 {
            font-weight: 700;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.25rem;
        }

        .header-title p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .badge-system {
            background: rgba(79, 172, 254, 0.1);
            border: 1px solid rgba(79, 172, 254, 0.25);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            color: var(--accent-blue);
            font-weight: 500;
        }

        /* Notifications */
        .alert {
            padding: 1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: fadeIn 0.4s ease;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        /* Layout Grid */
        .layout-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 900px) {
            .layout-grid {
                grid-template-columns: 350px 1fr;
            }
        }

        /* Cards and Glassmorphism */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            border-left: 3px solid var(--accent-blue);
            padding-left: 0.75rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            background: rgba(8, 12, 24, 0.8);
            border: 1px solid var(--border-glass);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            font-family: var(--font-family);
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 2px rgba(79, 172, 254, 0.2);
        }

        select.form-control {
            cursor: pointer;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: var(--font-family);
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.75rem 1.2rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            color: white;
            width: 100%;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.35);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-glass);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .btn-edit {
            background: rgba(79, 172, 254, 0.1);
            border: 1px solid rgba(79, 172, 254, 0.2);
            color: var(--accent-blue);
        }

        .btn-edit:hover {
            background: var(--accent-blue);
            color: white;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--color-danger);
        }

        .btn-delete:hover {
            background: var(--color-danger);
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        /* Table & Lists */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        .table-custom th {
            color: var(--text-secondary);
            font-weight: 500;
            padding: 1rem;
            border-bottom: 2px solid var(--border-glass);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table-custom td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-glass);
            color: var(--text-primary);
        }

        .table-custom tr {
            transition: background-color 0.2s;
        }

        .table-custom tr:hover {
            background-color: var(--bg-card-hover);
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 0.35rem;
        }

        .status-badge::before {
            content: '';
            display: block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-tersedia {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--color-success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-tersedia::before {
            background-color: var(--color-success);
            box-shadow: 0 0 8px var(--color-success);
        }

        .status-disewa {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--color-danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-disewa::before {
            background-color: var(--color-danger);
            box-shadow: 0 0 8px var(--color-danger);
        }

        .car-identity {
            display: flex;
            flex-direction: column;
        }

        .car-merek {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .car-model {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <div class="header-title">
                <h1>Dashboard Rental Mobil</h1>
                <p>UAS Basis Data — Manajemen Armada Mobil (MVC Web App)</p>
            </div>
            <div class="badge-system">PHP & MySQL MVC</div>
        </header>

        <!-- Status Notifications -->
        <?php if ($success): ?>
            <div class="alert alert-success">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Main Content Grid -->
        <div class="layout-grid">
            
            <!-- Left Side: Form Create/Edit -->
            <div class="glass-card">
                <?php if ($edit_car): ?>
                    <h2 class="card-title">Edit Data Mobil</h2>
                    <form action="index.php?action=update" method="POST">
                        <input type="hidden" name="id_mobil" value="<?= intval($edit_car['id_mobil']) ?>">
                        
                        <div class="form-group">
                            <label for="merek">Merek Mobil</label>
                            <input type="text" id="merek" name="merek" class="form-control" placeholder="Contoh: Toyota" value="<?= htmlspecialchars($edit_car['merek']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="model">Model / Tipe</label>
                            <input type="text" id="model" name="model" class="form-control" placeholder="Contoh: Avanza" value="<?= htmlspecialchars($edit_car['model']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="plat_nomor">Plat Nomor</label>
                            <input type="text" id="plat_nomor" name="plat_nomor" class="form-control" placeholder="Contoh: B 1234 ABC" value="<?= htmlspecialchars($edit_car['plat_nomor']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="harga_sewa_perhari">Tarif Sewa (Per Hari)</label>
                            <input type="number" id="harga_sewa_perhari" name="harga_sewa_perhari" class="form-control" placeholder="Tarif Rupiah" value="<?= intval($edit_car['harga_sewa_perhari']) ?>" required min="1">
                        </div>

                        <div class="form-group">
                            <label for="status">Status Ketersediaan</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="Tersedia" <?= $edit_car['status'] === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="Disewa" <?= $edit_car['status'] === 'Disewa' ? 'selected' : '' ?>>Disewa</option>
                            </select>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan Perubahan</button>
                            <a href="index.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                <?php else: ?>
                    <h2 class="card-title">Tambah Armada Baru</h2>
                    <form action="index.php?action=create" method="POST">
                        <div class="form-group">
                            <label for="merek">Merek Mobil</label>
                            <input type="text" id="merek" name="merek" class="form-control" placeholder="Contoh: Toyota" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="model">Model / Tipe</label>
                            <input type="text" id="model" name="model" class="form-control" placeholder="Contoh: Avanza" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="plat_nomor">Plat Nomor</label>
                            <input type="text" id="plat_nomor" name="plat_nomor" class="form-control" placeholder="Contoh: B 1234 ABC" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="harga_sewa_perhari">Tarif Sewa (Per Hari)</label>
                            <input type="number" id="harga_sewa_perhari" name="harga_sewa_perhari" class="form-control" placeholder="Tarif Rupiah" required min="1">
                        </div>

                        <div class="form-group">
                            <label for="status">Status Ketersediaan</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Disewa">Disewa</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Tambah ke Armada</button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Right Side: Car List -->
            <div class="glass-card">
                <h2 class="card-title">Daftar Armada Mobil</h2>
                
                <div class="table-responsive">
                    <?php if (count($cars) > 0): ?>
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mobil / Armada</th>
                                    <th>Plat Nomor</th>
                                    <th>Tarif Sewa</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cars as $car): ?>
                                    <tr>
                                        <td>#<?= intval($car['id_mobil']) ?></td>
                                        <td>
                                            <div class="car-identity">
                                                <span class="car-merek"><?= htmlspecialchars($car['merek']) ?></span>
                                                <span class="car-model"><?= htmlspecialchars($car['model']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <code style="background: rgba(255,255,255,0.05); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--border-glass);">
                                                <?= htmlspecialchars($car['plat_nomor']) ?>
                                            </code>
                                        </td>
                                        <td>
                                            <strong style="color: var(--accent-cyan);">
                                                Rp <?= number_format($car['harga_sewa_perhari'], 0, ',', '.') ?>
                                            </strong>
                                            <span style="color: var(--text-secondary); font-size: 0.8rem;">/hari</span>
                                        </td>
                                        <td>
                                            <?php if ($car['status'] === 'Disewa'): ?>
                                                <span class="status-badge status-disewa">Disewa</span>
                                            <?php else: ?>
                                                <span class="status-badge status-tersedia">Tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" style="justify-content: flex-end;">
                                                <a href="index.php?action=edit&id=<?= intval($car['id_mobil']) ?>" class="btn btn-sm btn-edit">Edit</a>
                                                <a href="index.php?action=delete&id=<?= intval($car['id_mobil']) ?>" class="btn btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')">Hapus</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.5;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p>Tidak ada armada mobil terdaftar. Silakan tambahkan melalui form di samping.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
