<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login-form.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>You have successfully logged in.</p>
    <a href="logout.php">Logout</a>
</body>

</html>