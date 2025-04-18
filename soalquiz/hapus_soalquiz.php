<?php
$koneksi = new mysqli("localhost", "root", "", "quiz_db");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (!isset($_GET['id_kuis'])) {
    die("ID kuis tidak tersedia.");
}

$id_kuis = intval($_GET['id_kuis']);

// Tangani penghapusan soal
if (isset($_GET['hapus_id'])) {
    $hapus_id = intval($_GET['hapus_id']);
    $query_hapus = "DELETE FROM soal WHERE id_soal = ?";
    $stmt_hapus = $koneksi->prepare($query_hapus);
    $stmt_hapus->bind_param("i", $hapus_id);

    if ($stmt_hapus->execute()) {
        echo "<script>alert('Soal berhasil dihapus!'); window.location.href = '?page=soalquiz&item=daftar_soal&id_soal=" . $id_kuis . "';</script>";
    } else {
        echo "<script>alert('Gagal menghapus soal: " . $koneksi->error . "');</script>";
    }
}

$query = "SELECT * FROM soal WHERE id_kuis = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_kuis);
$stmt->execute();
$result = $stmt->get_result();
?>