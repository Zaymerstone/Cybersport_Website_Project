<!DOCTYPE html>
<html lang="en">
<?php
include("./includes/head.php")
?>
<?php
include("./logics/authorization.php")
?>

<!-- Login Form -->
<div class="login-form">
    <h2>Login</h2>
    <form action="#" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <?php
        if ($_SESSION['errors']['general']) {
        ?>
            <span class="error-message"><?php echo $_SESSION['errors']['general']; ?></span>
        <?php
        }
        ?>


        <button type="submit" class="button">Login</button>
        <input type="hidden" name="action" value="login">
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</div>
<?php
include("./includes/footer.php")
?>
</body>

</html>