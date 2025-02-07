<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sistemmanajemenbuku";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Koneksi Gagal: " . $connection->connect_error);
}

$name = "";
$author = "";
$publisher = "";
$number_of_page = "";
$user_id = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: /Mid Project/index.php");
        exit;
    }

    $id = $_GET["id"];

    $sql = "SELECT * FROM book WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /Mid Project/index.php");
        exit;
    }

    $name = $row["name"];
    $author = $row["author"];
    $publisher = $row["publisher"];
    $number_of_page = $row["number_of_page"];
    $user_id = $row["user_id"];
} 

else {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $author = $_POST["author"];
    $publisher = $_POST["publisher"];
    $number_of_page = $_POST["number_of_page"];
    $user_id = $_POST["user_id"];

    do {
        if (empty($name) || empty($author) || empty($publisher) || empty($number_of_page) || empty($user_id)) {
            $errorMessage = "All fields are required";
            break;
        }

        $sql = "UPDATE book SET 
                name = '$name', 
                author = '$author', 
                publisher = '$publisher', 
                number_of_page = '$number_of_page', 
                user_id = '$user_id' 
                WHERE id = $id";

        $result = $connection->query($sql);
        if (!$result) {
            $errorMessage = "Invalid Query: ". $connection->error;
            break;
        }

        $successMessage = "Book updated successfully";

        header("location: /Mid Project/index.php");
        exit;
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Book</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Author</label>
                <input type="text" class="form-control" name="author" value="<?php echo $author; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Publisher</label>
                <input type="text" class="form-control" name="publisher" value="<?php echo $publisher; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Number of Page</label>
                <input type="number" class="form-control" name="number_of_page" value="<?php echo $number_of_page; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">User ID</label>
                <input type="number" class="form-control" name="user_id" value="<?php echo $user_id; ?>">
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong><?php echo $successMessage; ?></strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            <?php endif; ?>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-outline-primary" href="/Mid Project/index.php" role="button">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
