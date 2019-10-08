<?php require_once '../private/initialize.php';
$style = "/style/login.css";

if (request_is_post()) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = find_user_by_username($username);
    if ($user) {
        if ($password == $user['user_password']) {
            // Starts user in first session returned from DB query
            $_SESSION['session_id'] = mysqli_fetch_assoc(find_user_sessions($user['user_id']))['session_id'];

            $permission = find_user_permission($_SESSION['session_id'], $user['user_id']);
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

<div class="container">
    <h2>Login to MyMakerSite</h2>
    <form action="index.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="input" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary" value="login">Submit</button>
        <?php echo display_errors($errors); ?>
    </form>
</div>

<?php include_once SHARED_PATH . '/default_header.php'; ?>