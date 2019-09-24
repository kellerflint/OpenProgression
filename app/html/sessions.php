<?php require_once '../private/initialize.php';

$style = "/style/sessions.css";

if (request_is_post()) {
    $_SESSION['session_id'] = $_POST['session_id'];
    redirect_to(url_for("/user/badges.php"));
}

include_once '../private/shared/default_header.php'; ?>

<div class="content">
    <h2>My Sessions</h2>
    <?php 
    $session_set = find_user_sessions($_SESSION['user_id']);
    while($session = mysqli_fetch_assoc($session_set)) {
    ?>
    <form action="sessions.php" method="POST">
        <input class="hidden" name="session_id" type="text" value="<?php echo $session['session_id'] ?>">
        <p><?php echo $session['session_name']; ?></p>
        <button name="submit" value="connect">Connect</button>
        <br>
        <div class="descript hidden">
            <p><?php echo $session["session_description"]; ?></p>
        </div>
    </form>
    <?php } ?>

</div>

<?php include_once '../private/shared/default_footer.php'; ?>