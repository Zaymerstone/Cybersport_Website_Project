<!DOCTYPE html>
<html lang="en">
<?php
include("./includes/head.php")
?>
<?php
include("./logics/dashboard.php")
?>

<body>
    <?php
    include("./includes/header.php")
    ?>
    <div class="dashboard">
        <div class="blogs">
            <?php
            foreach ($posts as $key => $post) {
            ?>
                <!-- Blog Container -->
                <div class="blog-container">
                    <img src="<?php echo $post["cover_url"] ?>" alt="Blog Image">
                    <div class="blog-details">
                        <h2><?php echo $post["title"] ?></h2>
                        <p class="blog-description"><?php echo $post["description"] ?></p>
                        <div class="user-details">
                            <img src="<?php echo $post["avatar_url"] ?  $post["avatar_url"] : './assets/user.png' ?>" alt="User Profile Picture">
                            <p class="username"><?php echo $post["email"] ?></p>
                        </div>
                        <p class="date"><?php echo formatDate($post["created_at"]) ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    include("./includes/footer.php")
    ?>
    <?php
    include("./scripts/script.php")
    ?>
</body>

</html>