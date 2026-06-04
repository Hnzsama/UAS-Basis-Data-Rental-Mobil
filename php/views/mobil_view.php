<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil - Dashboard Armada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Apply font and subtle radial background gradients */
        body {
            font-family: 'Outfit', sans-serif;
            background-image: 
                radial-gradient(at 10% 20%, rgba(59, 130, 246, 0.08) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(139, 92, 246, 0.08) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen px-4 py-10 md:px-8 md:py-16 flex justify-center selection:bg-blue-500/30">
    <div class="container max-w-6xl w-full flex flex-col gap-8">
        
        <!-- Header -->
        <header class="flex flex-col sm:flex-row justify-between sm:items-center border-b border-slate-800/80 pb-6 gap-4">
            <div class="header-title">
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent tracking-tight">
                    Dashboard Rental Mobil
                </h1>
                <p class="text-slate-400 text-sm mt-1">
                    UAS Basis Data — Manajemen Armada Mobil (MVC Web App)
                </p>
            </div>
            <div>
                <span class="bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-full text-sm text-blue-400 font-semibold tracking-wide">
                    PHP & MySQL MVC (Tailwind v4)
                </span>
            </div>
        </header>

        <!-- Status Notifications -->
        <?php if ($success): ?>
            <div class="alert bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl text-sm flex items-center gap-3 animate-pulse">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium"><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-[360px_1fr] gap-8">
            
            <!-- Left Side: Form Create/Edit -->
            <div>
                <div class="bg-slate-900/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 shadow-2xl hover:shadow-black/40 transition-all duration-300">
                    <?php if ($edit_car): ?>
                        <h2 class="text-xl font-bold mb-6 border-l-4 border-blue-500 pl-3 text-slate-100">
                            Edit Data Mobil
                        </h2>
                        <form action="index.php?action=update" method="POST" class="space-y-4">
                            <input type="hidden" name="id_mobil" value="<?= intval($edit_car['id_mobil']) ?>">
                            
                            <div>
                                <label for="merek" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Merek Mobil</label>
                                <input type="text" id="merek" name="merek" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Contoh: Toyota" value="<?= htmlspecialchars($edit_car['merek']) ?>" required>
                            </div>
                            
                            <div>
                                <label for="model" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Model / Tipe</label>
                                <input type="text" id="model" name="model" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Contoh: Avanza" value="<?= htmlspecialchars($edit_car['model']) ?>" required>
                            </div>
                            
                            <div>
                                <label for="plat_nomor" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Plat Nomor</label>
                                <input type="text" id="plat_nomor" name="plat_nomor" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Contoh: B 1234 ABC" value="<?= htmlspecialchars($edit_car['plat_nomor']) ?>" required>
                            </div>
                            
                            <div>
                                <label for="harga_sewa_perhari" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Tarif Sewa (Per Hari)</label>
                                <input type="number" id="harga_sewa_perhari" name="harga_sewa_perhari" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Tarif Rupiah" value="<?= intval($edit_car['harga_sewa_perhari']) ?>" required min="1">
                            </div>

                            <div>
                                <label for="status" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Status Ketersediaan</label>
                                <select id="status" name="status" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 cursor-pointer" required>
                                    <option value="Tersedia" <?= $edit_car['status'] === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                    <option value="Disewa" <?= $edit_car['status'] === 'Disewa' ? 'selected' : '' ?>>Disewa</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-3 pt-2">
                                <button type="submit" class="flex-1 btn bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-semibold text-sm py-2.5 rounded-lg shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer border-0">
                                    Simpan
                                </button>
                                <a href="index.php" class="btn bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm py-2.5 px-4 rounded-lg transition-all duration-200 text-center flex items-center justify-center">
                                    Batal
                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <h2 class="text-xl font-bold mb-6 border-l-4 border-blue-500 pl-3 text-slate-100">
                            Tambah Armada Baru
                        </h2>
                        <form action="index.php?action=create" method="POST" class="space-y-4">
                            <div>
                                <label for="merek" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Merek Mobil</label>
                                <input type="text" id="merek" name="merek" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Contoh: Toyota" required>
                            </div>
                            
                            <div>
                                <label for="model" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Model / Tipe</label>
                                <input type="text" id="model" name="model" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Contoh: Avanza" required>
                            </div>
                            
                            <div>
                                <label for="plat_nomor" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Plat Nomor</label>
                                <input type="text" id="plat_nomor" name="plat_nomor" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Contoh: B 1234 ABC" required>
                            </div>
                            
                            <div>
                                <label for="harga_sewa_perhari" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Tarif Sewa (Per Hari)</label>
                                <input type="number" id="harga_sewa_perhari" name="harga_sewa_perhari" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" placeholder="Tarif Rupiah" required min="1">
                            </div>

                            <div>
                                <label for="status" class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Status Ketersediaan</label>
                                <select id="status" name="status" class="w-full bg-slate-950/60 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-100 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 cursor-pointer" required>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Disewa">Disewa</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full btn bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-semibold text-sm py-2.5 rounded-lg shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer border-0 mt-2">
                                Tambah ke Armada
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Side: Car List -->
            <div>
                <div class="bg-slate-900/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 shadow-2xl hover:shadow-black/40 transition-all duration-300">
                    <h2 class="text-xl font-bold mb-6 border-l-4 border-blue-500 pl-3 text-slate-100">
                        Daftar Armada Mobil
                    </h2>
                    
                    <div class="overflow-x-auto w-full">
                        <?php if (count($cars) > 0): ?>
                            <table class="w-full border-collapse text-left text-sm">
                                <thead>
                                    <tr class="border-b border-slate-800/80">
                                        <th class="text-slate-400 font-medium p-4 text-xs uppercase tracking-wider">ID</th>
                                        <th class="text-slate-400 font-medium p-4 text-xs uppercase tracking-wider">Mobil / Armada</th>
                                        <th class="text-slate-400 font-medium p-4 text-xs uppercase tracking-wider">Plat Nomor</th>
                                        <th class="text-slate-400 font-medium p-4 text-xs uppercase tracking-wider">Tarif Sewa</th>
                                        <th class="text-slate-400 font-medium p-4 text-xs uppercase tracking-wider">Status</th>
                                        <th class="text-slate-400 font-medium p-4 text-xs uppercase tracking-wider text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/60">
                                    <?php foreach ($cars as $car): ?>
                                        <tr class="hover:bg-slate-800/30 transition-colors duration-150">
                                            <td class="p-4 text-slate-400 font-medium">#<?= intval($car['id_mobil']) ?></td>
                                            <td class="p-4">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-200"><?= htmlspecialchars($car['merek']) ?></span>
                                                    <span class="text-xs text-slate-400"><?= htmlspecialchars($car['model']) ?></span>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <code class="bg-slate-950/80 border border-slate-800 px-2.5 py-1 rounded text-xs text-cyan-400 font-mono">
                                                    <?= htmlspecialchars($car['plat_nomor']) ?>
                                                </code>
                                            </td>
                                            <td class="p-4">
                                                <span class="font-bold text-blue-400">
                                                    Rp <?= number_format($car['harga_sewa_perhari'], 0, ',', '.') ?>
                                                </span>
                                                <span class="text-slate-400 text-xs">/hari</span>
                                            </td>
                                            <td class="p-4">
                                                <?php if ($car['status'] === 'Disewa'): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                                        Disewa
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
                                                        Tersedia
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="p-4 text-right">
                                                <div class="inline-flex gap-2">
                                                    <a href="index.php?action=edit&id=<?= intval($car['id_mobil']) ?>" class="bg-blue-500/10 border border-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-md text-xs font-bold transition-all duration-150">
                                                        Edit
                                                    </a>
                                                    <a href="index.php?action=delete&id=<?= intval($car['id_mobil']) ?>" class="bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-md text-xs font-bold transition-all duration-150" onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')">
                                                        Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="text-center py-12 text-slate-400">
                                <svg class="w-12 h-12 mx-auto stroke-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <p class="text-sm">Tidak ada armada mobil terdaftar. Silakan tambahkan melalui form di samping.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
