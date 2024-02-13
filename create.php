<!DOCTYPE html>
<html lang="en">
<?php
include("./includes/head.php")
?>
<?php
include("./logics/post.php")
?>

<body>
    <?php
    include("./includes/header.php")
    ?>
    <!-- Blog Post Form -->
    <div class="post-blog-form">
        <h2>Post Blog</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="cover_url">Image:</label>
            <input type="file" id="cover_url" name="cover_url" accept="image/png, image/jpg, image/jpeg" required>
            <?php
            if ($_SESSION['errors']['cover']) {
            ?>
                <span class="error-message"><?php echo $_SESSION['errors']['cover'][0]; ?></span>
            <?php
            }
            ?>
            <input type="hidden" name="action" value="create_post">
            <button type="submit" class="button">Post</button>
        </form>
    </div>
    <?php
    include("./includes/footer.php")
    ?>
    <?php
    include("./scripts/script.php")
    ?>
</body>

</html>