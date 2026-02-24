<?php
include_once('../middleware/checkSession.php');
include_once('../middleware/cache.php');   
include(__DIR__ . "/../config/db.php");
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Applicants List</title>
    <?php includeAndCache('../includes/admin_head.php'); ?>
    <link rel="stylesheet" href="../public/css/admin_index.css">
</head>
<body>
    <?php includeAndCache('../includes/admin_sidebar.php'); ?>

    <main>
        <div class="container">
          
        </div>
    </main>

    <script src="../public/js/admin_index.js"></script>
</body>
</html>