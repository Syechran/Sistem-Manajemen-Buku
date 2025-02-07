<?php
if (isset($_GET["id"])) { 
    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sistemmanajemenbuku";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Koneksi gagal: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("DELETE FROM book WHERE id = ?");
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        echo "Buku berhasil dihapus.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();

    header("Location: /Mid Project/index.php");
    exit;
} else {
    echo "ID tidak ditemukan.";
}
?>
