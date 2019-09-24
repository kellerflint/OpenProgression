<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>MyMakerSite</title>
        <link rel="stylesheet" href="<?php echo url_for('style/default.css'); ?>">
        <link rel="stylesheet" href="<?php echo $style; ?>">
    </head>

    <body>
    
        <nav>
            <ul>
            <?php if (is_logged_in()) { ?>
                <div class="dropdown">
                    <a href="<?php echo url_for('/user/profile.php') . '?user_id=' . $_SESSION['user_id']; ?>"><button
                            class="dropdown-button">
                            <?php echo $_SESSION['user_name'] ?? ''; ?></button></a>
                    <div class="dropdown-content">
                        <a href="<?php echo url_for('sessions.php'); ?>">Sessions</a>
                        <a href="<?php echo url_for('logout.php'); ?>">Logout</a>
                    </div>
                </div>
                <li><a href="<?php echo url_for('/user/badges.php'); ?>">Badges</a></li>
                <?php } else { ?>
                <li><a href="<?php echo url_for("index.php"); ?>">Login</a></li>
                <?php } ?>
            </ul>
        </nav>
