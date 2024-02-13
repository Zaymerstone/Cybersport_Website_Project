<!DOCTYPE html>
<html lang="en">
<?php
include("./includes/head.php")
?>
<?php
include("./logics/profile.php")
?>

<body>
    <?php
    include("./includes/header.php")
    ?>
    <!-- User Profile Section -->
    <div class="user-profile">
        <img src="<?php echo $_SESSION["avatar_url"] ?  $_SESSION["avatar_url"] : './assets/user.png' ?>" alt="User Profile Picture" id='avatar-img'>
        <div class="user-details-profile">
            <h2>User Profile</h2>
            <p class="user-email"><?php echo $_SESSION["email"] ?></p>
            <p class="post-count">Number of Posts: <?php echo formatNumber($profileData["userPosts"]) ?></p>
        </div>
        <input type="file" id="fileInput" style="display: none;" accept="image/png, image/jpg, image/jpeg" onchange="displaySelectedImage()">
        <button class="change-avatar-btn" onclick="openFileInput()" id="changeAvatar">Change Picture</button>
        <?php
        if ($_SESSION['errors']['general']) {
        ?>
            <span class="error-message"><?php echo $_SESSION['errors']['general']; ?></span>
        <?php
        }
        ?>
    </div>
    <?php
    include("./includes/footer.php")
    ?>
    <?php
    include("./scripts/script.php")
    ?>
    <?php
    include("./scripts/profile_script.php")
    ?>



</body>

</html>