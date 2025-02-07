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

$name = "";
$author = "";
$publisher = "";
$number_of_page = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $author = $_POST["author"];
    $publisher = $_POST["publisher"];
    $number_of_page = (int)$_POST["number_of_page"];
    $user_id = $_SESSION["user_id"];

    do {
        if (empty($name) || empty($author) || empty($publisher) || empty($number_of_page)) {
            $errorMessage = "All fields are required";
            break;
        }

        $sql = "INSERT INTO book (name, author, publisher, number_of_page, user_id, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $statement = $connection->prepare($sql);
        $statement->bind_param("sssii", $name, $author, $publisher, $number_of_page, $user_id);
        $result = $statement->execute();

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $name = $author = $publisher = $number_of_page = "";
        $successMessage = "Book added successfully";
        header("Location: /Mid Project/index.php");
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
    <title>New Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>New Book</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <form method="post">
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
                <label class="form-label">Number of Pages</label>
                <input type="number" class="form-control" name="number_of_page" value="<?php echo $number_of_page; ?>">
            </div>
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/Mid Project/index.php" class="btn btn-outline-primary">Cancel</a>
        </form>
    </div>
</body>
</html>
