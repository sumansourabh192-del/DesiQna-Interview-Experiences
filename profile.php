<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$name = htmlspecialchars($_SESSION["user_name"]);
$userId = (int) $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - DesiQnA</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/theme.css">

    <style>
        body {
            background: #f6f5fc;
        }
        .profile-card {
            max-width: 450px;
            margin: 100px auto;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }
        .profile-btn {
            display: block;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            background: #55a1f9;
            color: white;
            text-decoration: none;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-card">
            <h2 class="text-center">My Profile</h2>
            <p class="text-center text-muted">Welcome to DesiQnA!</p>

            <hr>

            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>User ID:</strong> <?php echo $userId; ?></p>

            <a href="html/index.php" class="profile-btn">Go to Homepage</a>
            <a href="logout.php" class="profile-btn">Logout</a>
        </div>
    </div>
</body>
</html>
