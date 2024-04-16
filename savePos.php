<?php
// Koneksi ke database
session_start(); // Add this line
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
        // set succes session
        $_SESSION['success_message'] = "Data berhasil disimpan ke dalam database.";
        // Redirect to another page to prevent form resubmission
        header("Location: /");
        exit(); // Stop further execution
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

// Menutup koneksi database
$conn->close();