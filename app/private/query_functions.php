<?php
// Returns all badge data for a user in a session
function find_session_badges($session_id, $user_id)
{
    global $db;

    $query = "SELECT Badge.badge_id, Badge.badge_name, Badge.badge_description, Badge.badge_prereq_id, Badge.category_id, Badge.badge_experience, Badge.badge_order, 'true' AS has_badge FROM Badge
                JOIN Category ON Category.category_id = Badge.category_id
                WHERE badge_id IN (SELECT badge_id FROM User_Badge WHERE user_id = ?)
                AND Category.session_id = ?
                UNION ALL
                SELECT Badge.badge_id, Badge.badge_name, Badge.badge_description, Badge.badge_prereq_id, Badge.category_id, Badge.badge_experience, Badge.badge_order, 'false' AS has_badge FROM Badge 
                JOIN Category ON Category.category_id = Badge.category_id
                WHERE badge_id NOT IN (SELECT badge_id FROM User_Badge WHERE user_id = ?)
                AND Category.session_id = ?
                ORDER BY badge_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("iiii", $user_id, $session_id, $user_id, $session_id);
    $result = $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return $badge_set;
}

// Returns all req data for a user and badge
function find_badge_reqs($user_id, $badge_id)
{
    global $db;

    $query = "SELECT Req.req_id, Req.badge_id, Req.req_name, Req.req_text, Req.req_order, Req.req_link, 'true' AS has_req FROM Req
                JOIN Badge ON Badge.badge_id = Req.badge_id
                WHERE req_id IN (SELECT req_id FROM User_Req WHERE user_id = ?)
                AND Badge.badge_id = ?
                UNION ALL
                SELECT Req.req_id, Req.badge_id, Req.req_name, Req.req_text, Req.req_order, Req.req_link, 'false' AS has_req FROM Req 
                JOIN Badge ON Badge.badge_id = Req.badge_id
                WHERE req_id NOT IN (SELECT req_id FROM User_Req WHERE user_id = ?)
                AND Badge.badge_id = ?
                ORDER BY req_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("iiii", $user_id, $badge_id, $user_id, $badge_id);
    $result = $stmt->execute();

    $req_set = $stmt->get_result();

    $stmt->close();

    return $req_set;
}

// Returns category data for a session
function find_session_categories($session_id)
{
    global $db;

    $query = "SELECT * FROM Category
                WHERE session_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();

    $category_set = $stmt->get_result();

    $stmt->close();

    return $category_set;
}

// Returns the assoc for the given user
function find_user_by_username($username)
{
    global $db;

    $query = "SELECT * FROM User
                WHERE user_name = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $result = $stmt->execute();

    $user_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($user_set);
}

// Returns the permission level for the given user
function find_user_permission($session_id, $user_id)
{
    global $db;

    $query = "SELECT * FROM User_Session
                WHERE user_id = ? AND session_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $session_id);
    $result = $stmt->execute();

    $permission_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($permission_set)['user_session_permission'];
}

// Returns all sessions a user is in
function find_user_sessions($user_id)
{
    global $db;

    $query = "SELECT user_id, Session.session_id, session_name, session_description FROM Session
                JOIN User_Session ON Session.session_id = User_Session.session_id
                WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $result = $stmt->execute();

    $session_set = $stmt->get_result();

    $stmt->close();

    return $session_set;
}

// Returns current highest user_id
function find_highest_id()
{
    global $db;

    $query = "SELECT MAX(user_id) FROM User ORDER BY user_id DESC;";

    $stmt = $db->prepare($query);
    $result = $stmt->execute();

    $id = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($id)["MAX(user_id)"];
}


function add_user($user_nickname, $session_id)
{

    global $db;

    if (!is_empty($user_nickname)) {
        $user_nickname = explode(" ", $user_nickname);
        $user_nickname = strtolower($user_nickname[0]);
        $new_id = find_highest_id() + 1;
        $user_name = $user_nickname . $new_id;

        $words = [];
        if ($fh = fopen('../../private/words.txt', 'r')) {
            while (!feof($fh)) {
                $line = fgets($fh);
                array_push($words, $line);
            }
            fclose($fh);
        }

        $password = trim($words[rand(0, count($words) - 1)]) . trim(strval(rand(10, 99)));

        $query = "INSERT INTO User VALUES (DEFAULT, ?, ?, ?, ?, 0);";

        $stmt = $db->prepare($query);
        $stmt->bind_param("ssss", $user_name, $user_nickname, $password, $password);
        $result = $stmt->execute();

        if ($result) {
            add_user_session($new_id, $session_id);
        }

        return $result;

        $stmt->close();
    }
}

function add_user_session($user_id, $session_id)
{
    global $db;

    $query = "INSERT INTO User_Session VALUES (?, ?, 'user', NOW());";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $session_id);
    $result = $stmt->execute();

    return $result;

    $stmt->close();
}
