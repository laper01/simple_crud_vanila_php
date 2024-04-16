<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Test Full Stack</title>
<link rel="stylesheet" href="styles.css">
</hyead>
<body>

<!-- Komponen 1: Header -->
<header>
    <img src="https://dashindo.com/testfullstack/derpface.png" alt="Logo">
</header>
<?php ob_start(); // Start output buffering ?>
<!-- Komponen 2: Form Input -->
<section class="form-container">
    <form id="input-form" method="post" action="savePos.php">
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="jenis">Jenis:</label>
            <select id="jenis" name="jenis" required>
                <option value="Manusia">Manusia</option>
                <option value="Elf">Elf</option>
                <option value="Tumbuhan">Tumbuhan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="hp">HP:</label>
            <input type="text" id="hp" name="hp">
        </div>
        <div class="form-group">
            <label for="komentar">Komentar:</label>
            <textarea id="komentar" name="komentar" rows="4"></textarea>
        </div>
        <button type="submit" id="save-btn">Save</button>
    </form>
</section>

<!-- Komponen 4: Hasil input -->
<section class="result-container">
    <table id="result-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>HP</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan ditambahkan secara dinamis menggunakan JavaScript -->
        </tbody>
    </table>
</section>

<script src="script.js"></script>
</body>
</html>
