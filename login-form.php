<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>

<body>
    <h2>User Login</h2>
    <form action="login-form.php" method="post">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "SELECT * FROM users WHERE Email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['Password'])) {
                session_start();
                $_SESSION['username'] = $row['Username'];
                header("Location: welcome.php");
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }
    }
    ?>
</body>

</html>