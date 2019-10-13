<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OpenProgression</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo url_for('style/default.css'); ?>">
    <link rel="stylesheet" href="<?php echo $style; ?>">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">OpenProgression</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (!is_logged_in()) { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="">Login <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['user_name'] ?? ''; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo url_for('sessions.php'); ?>">Sessions</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo url_for('logout.php'); ?>">Logout</a>
                        </div>
                    </li>
                    <?php if ($_SESSION['permission'] == ADM) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo url_for('/admin/user_edit.php'); ?>">Users</a>
                                <a class="dropdown-item" href="<?php echo url_for('/admin/progression_edit.php'); ?>">Progression</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo url_for('logout.php'); ?>">EDIT SESSION</a>
                            </div>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url_for('/user/badges.php'); ?>">Badges</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <!--
    <?php if (is_logged_in()) { ?>

                <div class="dropdown">
                    <a href="<?php echo url_for('/user/profile.php') . '?user_id=' . $_SESSION['user_id']; ?>"><button class="dropdown-button">
                            <?php echo $_SESSION['user_name'] ?? ''; ?></button></a>
                    <div class="dropdown-content">
                        <a href="<?php echo url_for('sessions.php'); ?>">Sessions</a>
                        <a href="<?php echo url_for('logout.php'); ?>">Logout</a>
                    </div>
                </div>
                <li><a href="<?php echo url_for('/user/badges.php'); ?>">Badges</a></li>
                <?php if ($_SESSION['permission'] == ADM) { ?>
                    <li><a href="<?php echo url_for('/admin/user_edit.php'); ?>">Users</a></li>
                <?php }
                } else { ?>
                <li><a href="<?php echo url_for("index.php"); ?>">Login</a></li>
            <?php } ?>
-->