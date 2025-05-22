<?php
session_start();
include "../koneksi/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar User</title>
</head>
<body>

    <h2>List User</h2>
    <p><a href="../logout.php">Logout</a></p>
    <p><a href="tambah.php">+ Tambah User</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                // Gunakan gambar default jika foto tidak ada
                $foto = !empty($row['foto']) ? $row['foto'] : '../uploads/default.png';

                echo "<tr>
                        <td>$no</td>
                        <td><img src='{$foto}' width='60' height='60' style='object-fit:cover;'></td>
                        <td>{$row['nama']}</td>
                        <td>{$row['username']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}'>Edit</a> | 
                            <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin hapus user ini?\")'>Hapus</a>
                        </td>
                      </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

</body>
</html>
