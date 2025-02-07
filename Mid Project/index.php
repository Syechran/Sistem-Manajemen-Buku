<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: /Mid Project/login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "sistemmanajemenbuku";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Koneksi Gagal: " . $connection->connect_error);
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM book WHERE user_id = ?";
$statement = $connection->prepare($sql);
$statement->bind_param("i", $user_id);
$statement->execute();
$result = $statement->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>List of Books</h2>
        <a class="btn btn-primary" href="/Mid Project/create.php" role="button">New Book</a>
        <a class="btn btn-danger" href="logout.php">Logout</a>
        <br><br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Pages</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["author"]; ?></td>
                        <td><?php echo $row["publisher"]; ?></td>
                        <td><?php echo $row["number_of_page"]; ?></td>
                        <td><?php echo $row["created_at"]; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/Mid Project/edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a class="btn btn-danger btn-sm" href="/Mid Project/delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
