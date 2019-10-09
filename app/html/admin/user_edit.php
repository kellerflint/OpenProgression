<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/user_edit.css";

if (request_is_post() && $_POST['value'] == "add") {
    $user_nickname = $_POST['nickname'];
    add_user($user_nickname, $_SESSION['session_id']);
} else if (request_is_post() && $_POST['value'] == "edit") { }


include_once '../../private/shared/default_header.php'; ?>


<div class="container">
    <h2>Add User</h2>
    <form action="user_edit.php" method="POST">
        <div class="form-group">
            <label for="nickname">Name</label>
            <input type="text" class="form-control" id="nickname" name="nickname" placeholder="First Last">
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
    <h2>Edit User</h2>
    <form action="user_edit.php" method="POST">

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