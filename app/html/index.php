<?php require_once '../private/initialize.php';
if (request_is_post()) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = find_user_by_username($username);
    if ($user) {
        if ($password == $user['user_password']) {
            $_SESSION['session_id'] = mysqli_fetch_assoc(find_user_sessions($user['user_id']))['session_id'];
            $permission = find_user_permission(1, $user['user_id']);
            log_in($user, $permission);
            redirect_to(url_for('/user/badges.php'));
        } else {
            $errors[] = "Login failed. Invalid username or password.";
        }
    } else {
        $errors[] = "Login failed. Invalid username or password.";
    }
}
include_once SHARED_PATH . '/default_header.php';
?>

<div class="content">
    <h2>Login to MyMakerSite</h2>
    <?php echo display_errors($errors); ?>
    <form action="index.php" method="POST">
        <label for="username">Username</label>
        <br>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <button name="submit" id="submitBtn" value="login">Login</button>
    </form>
</div>

<?php include_once SHARED_PATH . '/default_header.php'; ?>