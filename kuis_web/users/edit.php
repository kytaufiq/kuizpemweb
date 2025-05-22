<?php
include "../koneksi/db.php";
$id = $_GET['id'];

$folderTujuan = "../uploads/";
if (!file_exists($folderTujuan)) {
    mkdir($folderTujuan, 0755, true); // Buat folder jika belum ada
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

if (isset($_POST['update'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fotoLama = $data['foto'];

    // Cek apakah ada file foto yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $namaFile = $_FILES['foto']['name'];
        $tmpName = $_FILES['foto']['tmp_name'];
        $folderTujuan = "../uploads/";

        // Rename file agar unik
        $namaBaru = uniqid() . '_' . $namaFile;
        move_uploaded_file($tmpName, $folderTujuan . $namaBaru);

        // Simpan nama file baru ke DB
        $fotoPath = $folderTujuan . $namaBaru;

        // Hapus foto lama jika ada
        if (!empty($fotoLama) && file_exists($fotoLama)) {
            unlink($fotoLama);
        }
    } else {
        $fotoPath = $fotoLama; // tidak diganti
    }

    // Update query
    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username', password='$hashed', foto='$fotoPath' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username', foto='$fotoPath' WHERE id=$id");
    }

    echo "<script>alert('Data berhasil diupdate'); window.location='list.php';</script>";
}
?>

<h2>Edit User</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= $data['nama'] ?>" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" value="<?= $data['username'] ?>" required><br><br>

    <label>Password (kosongkan jika tidak diubah):</label><br>
    <input type="password" name="password"><br><br>

    <label>Foto Saat Ini:</label><br>
    <img src="<?= !empty($data['foto']) ? $data['foto'] : '../uploads/default.png' ?>" width="100"><br><br>

    <label>Ubah Foto Profil:</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit" name="update">Update</button>
    <a href="list.php">Kembali</a>
</form>
