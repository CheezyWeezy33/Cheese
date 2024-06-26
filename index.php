<?php
session_start();

if (isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nad3a2";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM t_user WHERE username = '" . $_POST['username'] . "'";
    $result = $conn->query($sql);

    if ($result > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($_POST['password'], $row["password"])) {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $_POST['username'];

            header("Location: welcome.php");
            exit();
        } else {
            echo "Wrong password";
        }
    } else {
        echo "User not found";
    }

    $conn->close();
}
?>

<html>
<head>
    <title>Login form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <form action="index.php" method="post">
        <h1>Prihlaste sa</h1>
        <input type="text" name="username" placeholder="username" required autofocus><br>
        <input type="password" name="password" placeholder="password" required>
        <button type="submit" name="submit">Prihlasit sa</button>
        <a href="register.php" id="Register">Registrovat sa</a>
    </form>
</div>
</body>
</html>
