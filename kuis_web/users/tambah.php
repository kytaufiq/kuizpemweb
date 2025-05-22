<?php
include "../koneksi/db.php";

if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    // Simpan ke database
    mysqli_query($conn, "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$password')");
    
    echo "<script>alert('User berhasil ditambahkan'); window.location='list.php';</script>";
}
?>

<h2>Tambah User</h2>
<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="list.php">Kembali</a>
</form>
