<?php 
include "layout/header.php";

if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit;
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadow p-4">
            <h2 class="text-center mb-4">Profile</h2>
            
            <div class="row mb-3">
                <div class="col-sm-4">Username</div>
                <div class="col-sm-8"><?= $_SESSION["username"] ?? 'Guest' ?></div>
            </div>

            <div class="text-center mt-3">
                <button class="btn btn-secondary" onclick="history.back()">Back</button>
            </div>

        </div>
    </div>
</div>

<?php
include "layout/footer.php";
?>
