<!-- Navigation -->
<nav class="navbar">
    <div class="logo"><a href="dashboard.php">Cybersport News</a></div>
    <ul class="nav-list">
        <li><a href="#">Home</a></li>
        <li><a href="#">News</a></li>
        <li><a href="#">Blogs</a></li>
        <li><a href="#">About</a></li>
        <li><a href="contactus.php">Contact</a></li>
    </ul>

    <!-- Updated login button to include a dropdown -->
    <?php
    if ($_SESSION['authorized']) {
    ?>
        <li class="dropdown">
            <span class="button" onclick="toggleMenu()"><?php echo $_SESSION["email"] ?></span>
            <form action="#" method="post">
                <ul class="dropdown-content" id="dropdown">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="create.php">Create blog</a></li>
                    <li><button class="logout" type="submit">
                            Logout
                        </button></li>
                </ul>
                <input type="hidden" value="logout" name="action">
            </form>
        </li>
    <?php
    } else {
    ?>
        <button>
            <a href="login.php">Login</a>
        </button>
    <?php
    }
    ?>

</nav>