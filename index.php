<?php
// Koneksi ke database
$servername = "localhost";
$username = "superuser"; // Ganti dengan username database Anda
$password = "kamisama123"; // Ganti dengan password database Anda
$dbname = "database"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk validasi input
function validateInput($data)
{
    // Menghilangkan spasi di awal dan akhir string
    $data = trim($data);
    // Menghapus karakter backslash (\)
    $data = stripslashes($data);
    // Mencegah serangan XSS (Cross Site Scripting)
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk memasukkan data ke dalam database
function insertData($nama, $jenis, $hp, $komentar, $conn)
{
    $nama = validateInput($nama);
    $jenis = validateInput($jenis);
    $hp = validateInput($hp);
    $komentar = validateInput($komentar);

    // Memeriksa apakah HP kosong, jika iya, set ke NULL
    $hp = !empty($hp) ? $hp : NULL;

    // Menyiapkan statement SQL untuk memasukkan data
    $sql = "INSERT INTO tabel_data (nama, jenis, hp, komentar) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nama, $jenis, $hp, $komentar);

    // Menjalankan statement SQL
    if ($stmt->execute()) {
        echo "Data berhasil disimpan ke dalam database.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup statement
    $stmt->close();
}

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah semua field telah diisi
    if (empty($_POST["nama"]) || empty($_POST["jenis"]) || empty($_POST["komentar"])) {
        echo "Nama, jenis, dan komentar wajib diisi.";
    } else {
        // Memasukkan data ke dalam database
        $nama = $_POST["nama"];
        $jenis = $_POST["jenis"];
        $hp = $_POST["hp"];
        $komentar = $_POST["komentar"];

        insertData($nama, $jenis, $hp, $komentar, $conn);
    }
}

// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM tabel_data";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Full Stack</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Komponen 1: Header -->
    <header>
        <img src="https://dashindo.com/testfullstack/derpface.png" alt="Logo">
    </header>

    <!-- Komponen 2: Form Input -->
    <section class="form-container">
        <form id="input-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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

    <script src="script.js"></script>
</body>

</html>

<?php
// Menutup koneksi database
$conn->close();
?>
