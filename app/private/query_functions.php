<?php

function find_session_badges($session_id) {
    global $db;

    $query = "SELECT * FROM Badge
                INNER JOIN Category on Category.category_id = Badge.category_id
                WHERE session_id = ?
                ORDER BY badge_order ASC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $result = $stmt->execute();
    
    $badge_set = $stmt->get_result();

    $stmt->close();

    return $badge_set;
}

?>