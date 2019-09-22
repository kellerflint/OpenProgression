<?php require_once '../../private/initialize.php'; ?>
<?php 
$style = url_for('/style/badges.css');
include_once SHARED_PATH . '/default_header.php'; ?>

<div id="category-menu">
<?php
$category_set = find_session_categories(1);
$first = true;
while ($category = mysqli_fetch_assoc($category_set)) {
?>
<!-- Category Heading -->
<h3 class="category <?php 
if ($first == true) echo "category-selected"; $first = false; 
?>" data-category="<?php echo $category['category_id']; ?>">
<?php echo $category['category_name']; ?>
</h3>
<?php
}
?>
</div>

<div id="badges">
<?php
$badge_set = find_session_badges(1,2);
while ($badge = mysqli_fetch_assoc($badge_set)) {
    create_badge($badge);
}
?>
</div>

<script src="badge_events.js"></script>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php
// badges functions

// generates html for a new badge
function create_badge($badge) {
    $has_prereq = true;
?>
    <div class="badge inactive <?php
    if (!has_prereq($badge)) {
        echo "locked";
        $has_prereq = false;
    } else if ($badge["has_badge"] == "false") {
        echo "missing";
    }
    ?>" data-category="<?php echo $badge['category_id']; ?>">
        <img class="badge-image" src="<?php 
        if ($has_prereq == false) {
            echo url_for('/style/img/lock.png'); 
        } else {
            echo url_for('/style/img/badge.png'); 
        }
        ?>" alt="badge">
        <h2 class="badge-title"><?php echo $badge['badge_name']; ?></h2>
        <div class="reqs hide">
        <?php 
        $req_set = find_badge_reqs(2, $badge['badge_id']);
        while ($req = mysqli_fetch_assoc($req_set)) {
            add_req($req);
        }
        ?>
        </div>
    </div>
<?php }

// adds req to a badge
function add_req($req) {
?>
<div class="req">
    <img class="req-image" src="<?php
    if ($req['has_req'] == "true") {
        echo url_for('style/img/true.png');
    } else {
        echo url_for('style/img/false.png');
    }
    ?>" alt="<?php
    if ($req['has_req'] == "true") {
        echo 'true';
    } else {
        echo 'false';
    }?>
    ">
    <h3 class="req-title"><?php echo $req['req_name']; ?></h3>
    <p class="req-text"><?php echo $req['req_text']; ?></p>
</div>
<?php
}

// returns true if user has prereq for badge
function has_prereq($badge) {
    // TODO: $badge_set is null if I don't re-run the query? Find out why
    $badge_set = find_session_badges(1,2);
    if ($badge['badge_prereq_id'] === NULL) {
        return true;
    } else {
        while ($item = mysqli_fetch_assoc($badge_set)) {
            if ($item['badge_id'] == $badge["badge_prereq_id"]) {
                if ($item['has_badge'] == "true") {
                    return true;
                }
            }
        }
        return false;
    }
}

?>
