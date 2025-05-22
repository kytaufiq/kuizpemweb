<?php
include "../koneksi/db.php";
$id = $_GET['id'];

// Ambil data user berdasarkan ID
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

if (isset($_POST['update'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah password diubah atau tidak
    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username', password='$hashed' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username' WHERE id=$id");
    }

    echo "<script>alert('Data berhasil diupdate'); window.location='list.php';</script>";
}
?>

<h2>Edit User</h2>
<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= $data['nama'] ?>" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" value="<?= $data['username'] ?>" required><br><br>

    <label>Password (kosongkan jika tidak diubah):</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit" name="update">Update</button>
    <a href="list.php">Kembali</a>
</form>
