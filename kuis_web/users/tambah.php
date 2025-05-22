<?php
include "../koneksi/db.php";

$folderTujuan = "../uploads/";
if (!file_exists($folderTujuan)) {
    mkdir($folderTujuan, 0755, true); // Buat folder jika belum ada
}

if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Proses upload foto
    $foto_path = '';
    if (!empty($_FILES['foto']['name'])) {
        $folder = "../uploads/";
        $nama_file = time() . '_' . basename($_FILES['foto']['name']);
        $foto_path = $folder . $nama_file;

        // Pastikan folder uploads ada
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);
    }

    // Simpan data ke database termasuk path foto
    mysqli_query($conn, "INSERT INTO users (nama, username, password, foto) VALUES ('$nama', '$username', '$password', '$foto_path')");

    echo "<script>alert('User berhasil ditambahkan'); window.location='list.php';</script>";
}
?>

<h2>Tambah User</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Foto Profil:</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="list.php">Kembali</a>
</form>
