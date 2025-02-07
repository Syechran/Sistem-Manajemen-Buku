<?php
ob_start();
include "layout/header.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required!";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        include "tools/db.php";
        $dbConnection = getDatabaseConnection();

        $statement = $dbConnection->prepare("SELECT username FROM users WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $error = "Username already taken!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertStatement = $dbConnection->prepare(
                "INSERT INTO users (username, password, created_at) VALUES (?, ?, NOW())"
            );
            $insertStatement->bind_param('ss', $username, $hashedPassword);

            if ($insertStatement->execute()) {
                header("Location: login.php?register=success");
                exit;
            } else {
                $error = "Failed to register. Please try again.";
            }

            $insertStatement->close();
        }

        $statement->close();
        $dbConnection->close();
    }
}
?>

<div class="container py-5">
    <div class="mx-auto border shadow p-4" style="width: 400px">
        <h2 class="text-center mb-4">Register</h2>
        <hr />

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= htmlspecialchars($error) ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input class="form-control" name="username" value="<?= htmlspecialchars($username ?? '') ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input class="form-control" name="password" type="password" />
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input class="form-control" name="confirm_password" type="password" />
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
        </form>
    </div>
</div>

<?php include "layout/footer.php"; ?>
