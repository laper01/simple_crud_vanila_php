<?php

require_once 'config.php';
session_start(); // Add this line

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM tabel_data ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Full Stack</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/3859b6ad3b.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <!-- Komponen 1: Header -->
  <header>

    <div class="row justify-content-start align-items-center">
      <div class="col-4 col-lg-1">
        <img src="https://dashindo.com/testfullstack/derpface.png" alt="Logo">
      </div>
      <div class="col-8">
        <h6 class="text-dark">Full Stack Programmer Test</h6>
      </div>
    </div>


  </header>

  <!-- Komponen 2: Form Input -->


  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <h3 class="mt-4">Form Input</h3>
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-6">
              <div class="card">
                <section class="form-container">
                  <!-- session success -->
                  <?php
                  if (isset($_SESSION['success_message'])) {
                    // Display success message
                    echo "<div class='alert alert-success' role='alert'>" . $_SESSION['success_message'] . "</div>";
                    // Unset the session variable to remove the message after displaying it
                    unset($_SESSION['success_message']);
                  }

                  if (isset($_SESSION['error_message'])) {
                    // Display success message
                    echo "<div class='alert alert-warning' role='alert'>" . $_SESSION['error_message'] . "</div>";
                    // Unset the session variable to remove the message after displaying it
                    unset($_SESSION['error_message']);
                  }
                  ?>
                  <!-- session success -->

                  <form id="input-form" method="post" action="savePos.php">
                    <div class="form-group">
                      <label for="nama">Nama:</label>
                      <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                      <label for="jenis">Jenis:</label>
                      <select  class="form-select" id="jenis" name="jenis" required>
                      <option disabled selected>Pilih salah satu</option>
                        <option value="Manusia">Manusia</option>
                        <option value="Elf">Elf</option>
                        <option value="Tumbuhan">Tumbuhan</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="hp">HP:</label>
                      <input placeholder="Nomor Handphone, hanya angka (opsional)" type="text" id="hp" name="hp">
                    </div>
                    <div class="form-group">
                      <label for="komentar">Komentar:</label>
                      <textarea placeholder="Gunakan Kalimat Sopan" id="komentar" name="komentar" rows="4"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit" id="save-btn"> <i
                        class="fa-solid fa-floppy-disk me-2"></i>
                      Save</button>
                  </form>
                </section>
              </div>
            </div>
          </div>


          <!-- Komponen 4: Hasil input -->
          <section class="result-container">
            <h2>Saved Data</h2>
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
                <?php
                // Menampilkan data dalam bentuk tabel HTML
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["nama"] . "</td><td>" . $row["jenis"] . "</td><td>";

                    // Check if "hp" is null
                    if ($row["hp"] === null) {
                      echo "-";
                    } else {
                      echo $row["hp"];
                    }

                    echo "</td><td><pre>" . $row["komentar"] . "</pre></td></tr>";
                  }
                } else {
                  echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </section>

        </div>
      </div>
    </div>



    <script src="script.js"></script>
</body>

</html>

<?php
// Menutup koneksi database
$conn->close();
?>