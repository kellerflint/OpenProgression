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
                <li><a href="<?php echo url_for('/'); ?>">Login</a></li>
                <li><a href="<?php echo url_for('/user/badges.php'); ?>">Badges</a></li>
            </ul>
        </nav>
