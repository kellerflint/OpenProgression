<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/user_edit.css";

if (request_is_post()) {
    $user_nickname = $_POST['nickname'];
    add_user($user_nickname);
}


include_once '../../private/shared/default_header.php'; ?>

<div>
    <h2>Add User</h2>
    <form action="user_edit.php" method="POST">
        <label for="nickname">Name: </label>
        <input type="text" name="nickname" id="nickname">
        <button name="submit" value="add">Add User</button>
    </form>
</div>

<div>
    <h2>Edit User</h2>
</div>

<?php include_once '../../private/shared/default_footer.php'; ?>