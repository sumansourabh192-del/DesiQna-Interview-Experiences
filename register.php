
<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

   $captchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (empty($captchaResponse)) {
    $message = "Please complete the CAPTCHA!";
} else {
require_once "C:/xampp/private/desiqna-secrets.php";

$verifyURL = "https://www.google.com/recaptcha/api/siteverify";

$data = [
    "secret" => $secretKey,
    "response" => $captchaResponse
];

$options = [
    "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded",
        "method" => "POST",
        "content" => http_build_query($data)
    ]
];

$context = stream_context_create($options);
 $result = @file_get_contents($verifyURL, false, $context);

if ($result === false) {
    $captchaData = null;
} else {
    $captchaData = json_decode($result);
}


 if ($captchaData && $captchaData->success) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Please enter a valid email address!";
}

    $domain = strtolower(substr(strrchr($email, "@"), 1));

     $allowedDomains = [
    "gmail.com" => true,
    "yahoo.com" => true,
    "outlook.com" => true,
    "hotmail.com" => true,
    "icloud.com" => true,
    "proton.me" => true,
    "protonmail.com" => true,
    "zoho.com" => true,
    "aol.com" => true,
    "mail.com" => true,
    "gmx.com" => true,
    "gmx.net" => true,
    "yandex.com" => true,
    "yandex.ru" => true,
    "live.com" => true,
    "msn.com" => true,
    "me.com" => true,
    "mac.com" => true,
    "fastmail.com" => true,
    "tutanota.com" => true,
    "tuta.com" => true,
    "hey.com" => true,
    "rediffmail.com" => true,
    "rediff.com" => true,
    "inbox.com" => true,
    "hushmail.com" => true,
    "mail.ru" => true,
    "bk.ru" => true,
    "list.ru" => true,
    "inbox.ru" => true,
    "qq.com" => true,
    "163.com" => true,
    "126.com" => true,
    "yeah.net" => true,
    "sina.com" => true,
    "sohu.com" => true,
    "naver.com" => true,
    "daum.net" => true,
    "hanmail.net" => true,
    "web.de" => true,
    "t-online.de" => true,
    "freenet.de" => true,
    "orange.fr" => true,
    "laposte.net" => true,
    "free.fr" => true,
    "wanadoo.fr" => true,
    "libero.it" => true,
    "virgilio.it" => true,
    "tin.it" => true,
    "alice.it" => true,
    "seznam.cz" => true,
    "email.cz" => true,
    "centrum.cz" => true,
    "wp.pl" => true,
    "onet.pl" => true,
    "interia.pl" => true,
    "o2.pl" => true,
    "abv.bg" => true,
    "ukr.net" => true,
    "i.ua" => true,
    "bigpond.com" => true,
    "optusnet.com.au" => true,
    "telstra.com" => true,
    "shaw.ca" => true,
    "rogers.com" => true,
    "sympatico.ca" => true,
    "btinternet.com" => true,
    "virginmedia.com" => true,
    "sky.com" => true,
    "talktalk.net" => true,
    "blueyonder.co.uk" => true,
    "comcast.net" => true,
    "att.net" => true,
    "verizon.net" => true,
    "sbcglobal.net" => true,
    "bellsouth.net" => true,
    "cox.net" => true,
    "charter.net" => true,
    "earthlink.net" => true,
    "frontier.com" => true,
    "windstream.net" => true,
    "centurylink.net" => true,
    "juno.com" => true,
    "lycos.com" => true,
    "excite.com" => true,
    "aim.com" => true,
    "duck.com" => true,
    "disroot.org" => true,
    "riseup.net" => true,
    "posteo.de" => true,
    "mailbox.org" => true,
    "runbox.com" => true,
    "kolabnow.com" => true,
    "startmail.com" => true,
    "mailfence.com" => true,
    "hush.ai" => true,
    "naver.jp" => true,
    "hotmail.co.uk" => true,
    "yahoo.co.uk" => true,
    "yahoo.co.in" => true,
    "outlook.in" => true,
    "rediffmail.in" => true,
    "yahoo.co.jp" => true
];

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Please enter a valid email address!";
} elseif (!isset($allowedDomains[$domain])) {

        $message = "Email domain is not allowed!";

    } else {

        $password = $_POST["password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Registration failed. Email may already exist.";
        }

        $stmt->close();
    }

} else {
    if ($result === false) {
    $message = "Could not connect to Google CAPTCHA!";
} elseif (!empty($captchaData->{'error-codes'})) {
    $message = "CAPTCHA Error: " . implode(", ", $captchaData->{'error-codes'});
} else {
    $message = "CAPTCHA verification failed!";
}
}
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DesiQnA Registration</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/theme.css">

    <style>
        body {
            background: #f6f5fc;
        }

        .register-card {
            max-width: 450px;
            margin: 70px auto;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .register-btn {
            background: #55a1f9;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
        }

        .register-btn:hover {
            background: #3988e5;
        }

        .captcha-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="register-card">

        <h2 class="text-center mb-2">DesiQnA</h2>

        <p class="text-center text-muted mb-4">
            Create your account to continue
        </p>

        <p class="text-center">
            <?php echo htmlspecialchars($message); ?>
        </p>

        <form action="register.php" method="POST">

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name"
                       class="form-control"
                       placeholder="Enter your name" required>
            </div>

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
                       placeholder="Create password" required>
            </div>

            <div class="captcha-container">
                <div class="g-recaptcha"
                     data-sitekey="6LciLwguAAAAAG93Hd2Smovf-udjSUVxN-r3bSya">
                </div>
            </div>

            <button type="submit" class="register-btn">
                Register
            </button>

        </form>

        <p class="text-center mt-4">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>
