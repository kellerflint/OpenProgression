<?php

define("USR", "user");
define("ADM", "admin");
define("OWN", "owner");

function log_in($user, $permission)
{
    session_regenerate_id();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['permission'] = $permission;
    return true;
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function require_login()
{
    if (!is_logged_in()) {
        redirect_to(url_for('/index.php'));
    }
}

// Redirects to sessions if permissions are invalid, redirects to login if not logged in
// @param permission title required
function require_permission($required)
{
    require_login();

    // owners have full access
    if ($_SESSION['permission'] == OWN) {
        return;
    }

    if ($required != $_SESSION['permission']) {
        redirect_to(url_for("/index.php"));
    }
}

function unset_session()
{
    if (isset($_SESSION['session_id'])) {
        unset($_SESSION['session_id']);
    }

    if (isset($_SESSION['permissions'])) {
        unset($_SESSION['permissions']);
    }
}
