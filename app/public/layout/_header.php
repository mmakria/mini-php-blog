<header class="navbar">
    <nav class="navbar-content">
        <a href="/" class="navbar-logo">My first App PHP</a>
        <ul class="navbar-links">
            <li class="navbar-item">
                <a href="/index.php">Home</a>
            </li>
            <li class="navbar-item">
                <a href="/myProfile.php">Profil</a>
            </li>
            <li class="navbar-item">
                <a href="/blog.php">Blog</a>
            </li>
        </ul>
        <ul class="navbar-buttons">
            <?php if (!empty($_SESSION['user'])): ?>
                <?php if (in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) : ?>
                    <li class="navbar-item">
                        <a href="/admin/users" class="btn-nav btn-light">Admin user</a>
                    </li>
                    <li class="navbar-item">
                        <a href="/admin/articles/create.php" class="btn-nav btn-light">Create post</a>
                    </li>
                    <li class="navbar-item">
                        <a href="/admin/articles/modify.php" class="btn-nav btn-light">Posts</a>
                    </li>
                    <li class="navbar-item">
                        <a href="/admin/categories/dashboard.php" class="btn-nav btn-light">Categories</a>
                    </li>

                <?php endif; ?>
                <li class="navbar-item">
                    <a href="/logout.php" class="btn-nav btn-danger">Logout</a>
                </li>
            <?php else: ?>
                <li class="navbar-item">
                    <a href="/login.php" class="btn-nav btn-secondary">Login</a>
                </li>
                <li class="navbar-item">
                    <a href="/register.php" class="btn-nav btn-light">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>