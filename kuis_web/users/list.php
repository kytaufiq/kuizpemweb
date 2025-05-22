<?php
session_start();
include "../koneksi/db.php";

// Jika belum login, alihkan ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil semua data user dari database
$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6 font-sans">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar User</h2>
        <a href="../logout.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Logout</a>
    </div>

    <a href="tambah.php" class="inline-block mb-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">+ Tambah User</a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Username</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='border-b hover:bg-gray-50'>
                            <td class='py-3 px-4'>$no</td>
                            <td class='py-3 px-4'>{$row['nama']}</td>
                            <td class='py-3 px-4'>{$row['username']}</td>
                            <td class='py-3 px-4 space-x-2'>
                                <a href='edit.php?id={$row['id']}' class='px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition'>Edit</a>
                                <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin hapus user ini?\")' class='px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition'>Hapus</a>
                            </td>
                          </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
