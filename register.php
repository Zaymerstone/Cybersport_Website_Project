<!DOCTYPE html>
<html lang="en">
<?php
include("./includes/head.php")
?>
<?php
include("./logics/authorization.php")
?>

<body>

    <!-- Registration Form -->
    <div class="registration-form">
        <h2>Register</h2>
        <form action="#" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="password-repeat">Repeat Password:</label>
            <input type="password" id="password-repeat" name="password-repeat" required>

            <?php
            if ($_SESSION['errors']['general']) {
            ?>
                <span class="error-message"><?php echo $_SESSION['errors']['general']; ?></span>
            <?php
            }
            ?>

            <button type="submit" class="button">Register</button>
            <input type="hidden" name="action" value="register">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
    <?php
    include("./includes/footer.php")
    ?>
</body>

</html>