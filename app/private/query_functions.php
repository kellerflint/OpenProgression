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

// Returns req assoc
function find_req_by_id($id)
{
    global $db;

    $query = "SELECT * FROM Req
                WHERE req_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $req_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($req_set);
}

// returns req set for a badge
function find_reqs_by_badge_id($id)
{
    global $db;

    $query = "SELECT * FROM Req WHERE badge_id = ? ORDER BY req_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $req_set = $stmt->get_result();

    $stmt->close();

    return $req_set;
}

// returns assoc for badge by given id
function find_badge_by_id($id)
{
    global $db;

    $query = "SELECT * FROM Badge
                WHERE badge_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($badge_set);
}

function find_badges_by_session($session_id)
{
    global $db;

    $query = "SELECT badge_id, badge_name, badge_prereq_id, badge_order, category_order, Badge.category_id, session_id FROM Badge
                JOIN Category ON Category.category_id = Badge.category_id
                WHERE session_id = ?
                ORDER BY category_order ASC, badge_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return $badge_set;
}

// returns badge_set from given category id
function find_badges_by_category($category_id)
{
    global $db;

    $query = "SELECT * FROM Badge
                WHERE category_id = ?
                ORDER BY badge_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $category_id);
    $result = $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return $badge_set;
}

// Returns category data for a session
function find_session_categories($session_id)
{
    global $db;

    $query = "SELECT * FROM Category
                WHERE session_id = ?
                ORDER BY category_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();

    $category_set = $stmt->get_result();

    $stmt->close();

    return $category_set;
}

// given category id, return category assoc
function find_category_by_id($id)
{
    global $db;

    $query = "SELECT * FROM Category
                WHERE category_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $category_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($category_set);
}

// Returns the assoc for the given user by id
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

// Returns the assoc for the given user by id
function find_user_by_id($id)
{
    global $db;

    $query = "SELECT * FROM User
                WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
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

// Returns all users in session
function find_users_by_session($session_id)
{
    global $db;

    $query = "SELECT User.user_id, user_name, user_nickname, user_password, session_id FROM User
                JOIN User_Session ON User_Session.user_id = User.user_id
                WHERE session_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();

    $user_set = $stmt->get_result();

    $stmt->close();

    return $user_set;
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

// Adds a user and populates required fields
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
            return $new_id;
        } else {
            return -1;
        }



        $stmt->close();
    }
}

// Adds user to the session
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

// updates user username, nickname and password
// TODO: Validation needed to prevent duplicate usernames
function update_user($id, $username, $nickname, $password)
{
    global $db;

    $query = "UPDATE User
                SET user_name = ?, user_nickname = ?, user_password = ?
                WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("sssi", $username, $nickname, $password, $id);
    $result = $stmt->execute();

    return $result;

    $stmt->close();
}

// needs validation to make sure category is in admin's sessions
function update_category($id, $name, $description)
{
    global $db;

    $query = "UPDATE Category
                SET category_name = ?, category_description = ?
                WHERE category_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssi", $name, $description, $id);
    $result = $stmt->execute();

    return $result;

    $stmt->close();
}

// 
function update_badge($id, $name, $description, $prereq_id, $category_id, $experience)
{
    global $db;

    if ($prereq_id == "NULL")
        $prereq_id = NULL;

    $query = "UPDATE Badge
                SET badge_name = ?, badge_description = ?, badge_prereq_id = ?, category_id = ?, badge_experience = ?
                WHERE badge_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssiiii", $name, $description, $prereq_id, $category_id, $experience, $id);
    $result = $stmt->execute();
    return $result;

    $stmt->close();
}

//
function update_req($id, $name, $text, $badge_id, $link)
{
    global $db;

    if ($link == "NULL")
        $link = NULL;

    $query = "UPDATE Req
                SET req_name = ?, req_text = ?, badge_id = ?, req_link = ?
                WHERE req_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssisi", $name, $text, $badge_id, $link, $id);
    $result = $stmt->execute();
    return $result;

    $stmt->close();
}

function create_category($name, $description, $session_id)
{
    global $db;

    $max = find_category_order_max($session_id)["max"] + 1;

    $query = "INSERT INTO Category VALUES (DEFAULT, ?, ?, ?, ?);";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssii", $name, $description, $session_id, $max);
    $result = $stmt->execute();
    $stmt->close();
}

function find_category_order_max($session_id)
{
    global $db;

    $query = "SELECT MAX(category_order) AS max FROM Category WHERE session_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();
    $max_set = $stmt->get_result();
    $stmt->close();

    return mysqli_fetch_assoc($max_set);
}

function find_category_order_min($session_id)
{
    global $db;

    $query = "SELECT MIN(category_order) AS min FROM Category WHERE session_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();
    $min_set = $stmt->get_result();
    $stmt->close();

    return mysqli_fetch_assoc($min_set);
}

function create_badge($category_id, $name, $description, $experience, $prereq_id)
{

    global $db;


    if ($prereq_id == "NULL")
        $prereq_id = NULL;

    $max = find_badge_order_max($category_id)["max"] + 1;
    $query = "INSERT INTO Badge VALUES (DEFAULT, ?, ?, ?, ?, ?, ?);";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssiiii", $name, $description, $prereq_id, $category_id, $experience, $max);
    $result = $stmt->execute();
    $stmt->close();
}

function find_badge_order_max($category_id)
{
    global $db;

    $query = "SELECT MAX(badge_order) AS max FROM Badge WHERE category_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $category_id);
    $result = $stmt->execute();
    $max_set = $stmt->get_result();
    $stmt->close();

    return mysqli_fetch_assoc($max_set);
}

function find_badge_order_min($category_id)
{
    global $db;

    $query = "SELECT MIN(badge_order) AS min FROM Badge WHERE category_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $category_id);
    $result = $stmt->execute();
    $min_set = $stmt->get_result();
    $stmt->close();

    return mysqli_fetch_assoc($min_set);
}

function create_req($badge_id, $name, $description, $link)
{

    global $db;

    $max = find_req_order_max($badge_id)["max"] + 1;
    $query = "INSERT INTO Req VALUES (DEFAULT, ?, ?, ?, ?, ?);";

    $stmt = $db->prepare($query);
    $stmt->bind_param("issii", $badge_id, $name, $description, $max, $link);
    $result = $stmt->execute();
    $stmt->close();
}

function find_req_order_max($badge_id)
{
    global $db;

    $query = "SELECT MAX(req_order) AS max FROM Req WHERE badge_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $badge_id);
    $result = $stmt->execute();
    $max_set = $stmt->get_result();
    $stmt->close();

    return mysqli_fetch_assoc($max_set);
}

function find_req_order_min($badge_id)
{
    global $db;

    $query = "SELECT MIN(req_order) AS min FROM Req WHERE badge_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $badge_id);
    $result = $stmt->execute();
    $min_set = $stmt->get_result();
    $stmt->close();

    return mysqli_fetch_assoc($min_set);
}

function remove_req($req_id)
{
    global $db;

    remove_user_req($req_id);

    $query = "DELETE FROM Req WHERE req_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $req_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

// remove item from User_Req talbe
function remove_user_req($req_id)
{
    global $db;

    $query = "DELETE FROM User_Req WHERE req_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $req_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_badge($badge_id)
{
    global $db;

    // removing all reqs from badge
    $req_set = find_reqs_by_badge_id($badge_id);
    while ($req = mysqli_fetch_assoc($req_set)) {
        remove_user_req($req["req_id"]);
        remove_req($req["req_id"]);
    }

    remove_user_badge($badge_id);

    $query = "DELETE FROM Badge WHERE badge_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $badge_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_user_badge($badge_id)
{
    global $db;

    $query = "DELETE FROM User_Badge WHERE badge_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $badge_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_category($category_id)
{
    global $db;

    // removing all badges from category
    $badge_set = find_badges_by_category($category_id);
    while ($badge = mysqli_fetch_assoc($badge_set)) {
        remove_user_badge($badge["badge_id"]);
        remove_badge($badge["badge_id"]);
    }

    $query = "DELETE FROM Category WHERE category_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $category_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}


// moves cateogry order up or down
// @param move: -1 for move order down, 1 for move order up
function move_category($category_id, $move)
{
    global $db;

    // find the current category
    $category1 = find_category_by_id($category_id);
    $current_order = $category1["category_order"];

    // find id for category above/below it
    $category2 = find_category_id_by_order($current_order + $move);

    switch_category_order(
        $category1["category_id"],
        $category1["category_order"],
        $category2["category_id"],
        $category2["category_order"]
    );
}

// returns category assoc found by the category order
function find_category_id_by_order($order)
{
    global $db;

    $query = "SELECT * FROM Category
                WHERE category_order = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $order);
    $result = $stmt->execute();

    $category_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($category_set);
}

function switch_category_order($id1, $order1, $id2, $order2)
{
    global $db;

    $query = "UPDATE Category SET category_order = ? WHERE category_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $order1, $id2);
    $result = $stmt->execute();

    $stmt->bind_param("ii", $order2, $id1);
    $result = $stmt->execute();
    $stmt->close();
}


// moves badge order up or down
// @param move: -1 for move order down, 1 for move order up
function move_badge($badge_id, $move)
{
    global $db;

    // find the current badge
    $badge1 = find_badge_by_id($badge_id);
    $current_order = $badge1["badge_order"];

    // find id for badge above/below it
    $badge2 = find_badge_id_by_order($current_order + $move);

    switch_badge_order(
        $badge1["badge_id"],
        $badge1["badge_order"],
        $badge2["badge_id"],
        $badge2["badge_order"]
    );
}

// returns badge assoc found by the badge order
function find_badge_id_by_order($order)
{
    global $db;

    $query = "SELECT * FROM Badge
                WHERE badge_order = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $order);
    $result = $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($badge_set);
}

function switch_badge_order($id1, $order1, $id2, $order2)
{
    global $db;

    $query = "UPDATE Badge SET badge_order = ? WHERE badge_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $order1, $id2);
    $result = $stmt->execute();

    $stmt->bind_param("ii", $order2, $id1);
    $result = $stmt->execute();
    $stmt->close();
}



// moves req order up or down
// @param move: -1 for move order down, 1 for move order up
function move_req($req_id, $move)
{
    global $db;

    // find the current req
    $req1 = find_req_by_id($req_id);
    $current_order = $req1["req_order"];

    // find id for req above/below it
    $req2 = find_req_id_by_order($current_order + $move);

    switch_req_order(
        $req1["req_id"],
        $req1["req_order"],
        $req2["req_id"],
        $req2["req_order"]
    );
}

// returns req assoc found by the req order
function find_req_id_by_order($order)
{
    global $db;

    $query = "SELECT * FROM Req
                WHERE req_order = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $order);
    $result = $stmt->execute();

    $req_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($req_set);
}

function switch_req_order($id1, $order1, $id2, $order2)
{
    global $db;

    $query = "UPDATE Req SET req_order = ? WHERE req_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $order1, $id2);
    $result = $stmt->execute();

    $stmt->bind_param("ii", $order2, $id1);
    $result = $stmt->execute();
    $stmt->close();
}

function update_user_reqs($user_id, $badge_id, $new_req_ids)
{
    remove_user_badge_reqs($badge_id, $user_id);
    remove_user_badge_by_user_badge($badge_id, $user_id);

    if (empty($new_req_ids)) {
        return;
    }

    foreach ($new_req_ids as $req_id) {
        give_user_req($req_id, $user_id);
        if (find_req_by_id($req_id)["req_order"] == find_req_order_max($badge_id)["max"]) {
            give_user_badge($badge_id, $user_id);
        }
    }
}

function remove_user_badge_reqs($badge_id, $user_id)
{
    global $db;

    // removing all badges reqs from user_reqs
    $req_set = find_reqs_by_badge_id($badge_id);
    while ($req = mysqli_fetch_assoc($req_set)) {
        remove_user_req_by_user_req($req["req_id"], $user_id);
    }
}

function remove_user_req_by_user_req($req_id, $user_id)
{
    global $db;

    $query = "DELETE FROM User_Req WHERE req_id = ? AND user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $req_id, $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function give_user_req($req_id, $user_id)
{
    global $db;

    $query = "INSERT INTO User_Req VALUES (?, ?, NOW())";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $req_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function give_user_badge($badge_id, $user_id)
{
    global $db;

    $query = "INSERT INTO User_Badge VALUES (?, ?, NOW())";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $badge_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_user_badge_by_user_badge($badge_id, $user_id)
{
    global $db;

    $query = "DELETE FROM User_Badge WHERE badge_id = ? AND user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $badge_id, $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_user($user_id)
{
    remove_user_req_by_user($user_id);
    remove_user_badge_by_user($user_id);
    remove_user_session_by_user($user_id);
    remove_user_by_id($user_id);
}

function remove_user_req_by_user($user_id)
{
    global $db;

    $query = "DELETE FROM User_Req WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}


function remove_user_badge_by_user($user_id)
{
    global $db;

    $query = "DELETE FROM User_Badge WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_user_session_by_user($user_id)
{
    global $db;

    $query = "DELETE FROM User_Session WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function remove_user_by_id($user_id)
{
    global $db;

    $query = "DELETE FROM User WHERE user_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}
