<?php require_once '../private/initialize.php';
require_login();
$style = "/style/sessions.css";

if (request_is_post()) {
    $_SESSION['session_id'] = $_POST['session_id'];
    redirect_to(url_for("/user/badges.php"));
}

include_once '../private/shared/default_header.php'; ?>

    <div class="content">
        <h2 class="heading text-center">My Sessions</h2>
        <?php
        $session_set = find_user_sessions($_SESSION['user_id']);
        while ($session = mysqli_fetch_assoc($session_set)) {
            ?>
            <form action="sessions.php" class="session border bg-light" method="POST">
                <input class="hidden" name="session_id" type="text" value="<?php echo $session['session_id'] ?>">
                <h5><?php echo $session['session_name']; ?></h5>
                <p><?php echo $session['session_description']; ?></p>
                <button type="submit" name="submit" class="btn btn-primary" value="connect">Connect</button>
                <br>
                <div class="descript hidden">
                    <p><?php echo $session["session_description"]; ?></p>
                </div>
            </form>
        <?php } ?>
        <?php
        // This is not a good solution, need to add a boolean for isOwner to user database but until then...
        if ($_SESSION["permission"] == OWN) { ?>
            <form action="sessions.php" class="session border bg-light" method="POST">
                <input class="hidden" name="session_id" type="text" value="<?php echo $session['session_id'] ?>">

                <h5>Create New Session</h5>
            </form>
        <?php } ?>

    </div>

<?php include_once '../private/shared/default_footer.php'; ?>