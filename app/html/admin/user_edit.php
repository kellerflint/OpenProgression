<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/user_edit.css";

if (request_is_post() && $_POST['add'] == "add") {
    $user_nickname = $_POST['nickname'];
    add_user($user_nickname, $_SESSION['session_id']);
} else if (request_is_post() && $_POST['get'] == "get") {
    // TODO: THINGS
} else if (request_is_post() && $_POST['apply'] == "apply") { }


include_once '../../private/shared/default_header.php'; ?>


<div class="container">
    <h2 id="add-user-h2">Add User</h2>
    <form action="user_edit.php" method="POST" id="add-user">
        <div class="form-group">
            <label for="nickname">Name</label>
            <input type="text" class="form-control" id="nickname" name="nickname" placeholder="First L">
        </div>
        <button type="submit" class="btn btn-primary" name="add" value="add">Add User</button>
    </form>

    <h2 id="edit-user-h2">Edit User</h2>
    <div>
        <div class="form-group">
            <form action="user_edit.php" method="POST" id="get-user">
                <label for="user-select">Select User</label>
                <select class="form-control" id="user-select" name="user_id">
                    <?php
                    $user_set = find_users_by_session($_SESSION["session_id"]);

                    while ($user = mysqli_fetch_assoc($user_set)) {
                        ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['user_name']; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary" name="get" value="get">Get User</button>
            </form>
        </div>
    </div>
    <form action="user_edit.php" method="POST" id="edit-user">
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="text" class="form-control" id="nickname" name="nickname">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="apply" value="apply">Apply Changes</button>
    </form>
</div>


<?php include_once '../../private/shared/default_footer.php'; ?>

<!--
<div>
    <h2>Add User</h2>
    <form action="user_edit.php" method="POST">
        <label for="nickname">Name: </label>
        <input type="text" name="nickname" id="nickname">
        <button name="submit" value="add">Add User</button>
    </form>
</div>
-->