<?php
session_start();
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["user_name"] = $name;
        header("Location: html/index.php");
        exit;
    } else {
        $message = "Invalid email or password!";
    }

    $stmt->close();
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DesiQnA Login</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/theme.css">

    <style>
        body {
            background: #f6f5fc;
        }

        .login-card {
            max-width: 420px;
            margin: 100px auto;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .login-btn {
            background: #55a1f9;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
        }

        .login-btn:hover {
            background: #3988e5;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="login-card">

        <h2 class="text-center mb-2">DesiQnA</h2>
        <p class="text-center text-muted mb-4">Welcome Back! Login to continue</p>

        <p class="text-center">
            <?php echo $message; ?>
        </p>

        <form method="POST">

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email"
                       class="form-control"
                       placeholder="Enter your email" required>
            </div>

            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password"
                       class="form-control"
                       placeholder="Enter password" required>
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>

        </form>

        <p class="text-center mt-4">
            Don't have an account?
            <a href="register.php">Register</a>
        </p>

    </div>
</div>

</body>
</html>
