<?php require_once '../private/initialize.php' ?>

<?php 
unset($_SESSION['user_name']);
unset($_SESSION['permission']);
unset($_SESSION['user_id']);
unset_session();
redirect_to(url_for('index.php'));
?>