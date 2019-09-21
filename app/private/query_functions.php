<?php

// Returns all badge data for a user in a session
function find_session_badges($session_id, $user_id) {
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
function find_badge_reqs($user_id, $badge_id) {
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
function find_session_categories($session_id) {
    global $db;

    $query = "SELECT * FROM makersite.Category
                WHERE session_id = ?;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();

    $category_set = $stmt->get_result();

    $stmt->close();

    return $category_set;
}

?>


<?php
/*
Select req like badges (if I use it)

SELECT Req.req_id, Req.badge_id, Req.req_name, Req.req_text, Req.req_order, Req.req_link, 'true' AS has_req FROM Req
JOIN Badge ON Badge.badge_id = Req.badge_id
JOIN Category ON Category.category_id = Badge.category_id
WHERE req_id IN (SELECT req_id FROM User_Req WHERE user_id = 1)
AND Category.session_id = 1
UNION ALL
SELECT Req.req_id, Req.badge_id, Req.req_name, Req.req_text, Req.req_order, Req.req_link, 'false' AS has_req FROM Req 
JOIN Badge ON Badge.badge_id = Req.badge_id
JOIN Category ON Category.category_id = Badge.category_id
WHERE req_id NOT IN (SELECT req_id FROM User_Req WHERE user_id = 1)
AND Category.session_id = 1
ORDER BY req_order ASC;

*/
?>