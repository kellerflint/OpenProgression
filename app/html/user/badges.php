<?php require_once '../../private/initialize.php'; ?>
<?php include_once SHARED_PATH . '/default_header.php'; ?>

<div id="category-menu">

</div>

<div id="badges">
<?php
$badge_set = find_session_badges(1,1);
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
?>
    <div class="badge inactive">
        <img class="badge-image" src="<?php echo url_for('/style/img/badge.png'); ?>" alt="badge">
        <h2 class="badge-title"><?php echo $badge['badge_name']; ?></h2>
        <div class="reqs hide">
        <?php 
        $req_set = find_badge_reqs(1, $badge['badge_id']);
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
    <img class="req-image" src="" alt="">
    <h3 class="req-title"><?php echo $req['req_name']; ?></h3>
</div>
<?php
}

?>
