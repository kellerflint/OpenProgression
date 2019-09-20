<?php require_once '../../private/initialize.php'; ?>
<?php include_once SHARED_PATH . '/default_header.php'; ?>

<div id="category-menu">
</div>

<div id="badges">

<?php

// Creates each badge element from set
$badge_set = find_session_badges(1);
while($badge = mysqli_fetch_assoc($badge_set)) {
    create_badge($badge);
}

?>
</div>

<!--<script src="badge_events.js"></script>-->

<?php include_once SHARED_PATH . '/default_header.php'; 

function create_badge($badge) {
?>
    
<?php }

?>