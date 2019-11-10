<?php require_once '../private/initialize.php';
require_login();
$style = "/style/sessions.css";

$edit_mode = 0;

if (request_is_post()) {
    if ($_POST["connect"] == "connect") {
        $_SESSION['session_id'] = $_POST['session_id'];
        redirect_to(url_for("/user/badges.php"));
    } else if ($_POST["create"] == "create") {
        create_session($_SESSION["user_id"]);
    } else if ($_POST["edit"] == "edit") {
        $edit_mode = $_POST["session_id"];
    } else if ($_POST["remove"] == "remove") {
        remove_session($_POST["session_id"]);
    } else if ($_POST["update"] == "update") {
        update_session($_POST["session_id"], $_POST["name"], $_POST["description"]);
    }

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
                <?php
                if ($edit_mode == $session["session_id"]) {
                    ?>
                    <input type="text" name="name" value="<?php echo $session['session_name']; ?>">
                    <br>
                    <textarea name="description"><?php echo $session['session_description']; ?></textarea>
                    <br>
                    <?php
                } else {
                    ?>
                    <h5><?php echo $session['session_name']; ?></h5>
                    <p><?php echo $session['session_description']; ?></p>
                    <?php
                }
                if ($session["user_session_permission"] == OWN) { ?>
                    <button type="submit" name="edit" class="btn btn-secondary" value="edit">Edit</button>
                <?php }
                if ($edit_mode > 0) {
                    ?>
                    <button type="submit" name="update" class="btn btn-primary" value="update">Update</button>
                    <?php
                } else {
                    ?>
                    <button type="submit" name="connect" class="btn btn-primary" value="connect">Connect</button>
                    <?php
                }
                if ($session["user_session_permission"] == OWN) { ?>
                    <button type="submit" name="remove" class="btn btn-danger" value="remove">Remove</button>
                <?php } ?>
                <br>
            </form>
        <?php } ?>
        <?php
        // This is not a good solution, need to add a boolean for isOwner to user database but until then...
        if ($_SESSION["user_access"] == CREATOR) { ?>
            <form action="sessions.php" class="session border bg-light" method="POST">
                <button type="submit" name="create" class="btn btn-success" value="create">Create Session</button>
            </form>
        <?php } ?>

    </div>

<?php include_once '../private/shared/default_footer.php'; ?>