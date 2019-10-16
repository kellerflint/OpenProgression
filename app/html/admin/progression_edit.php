<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/progression_edit.css";

$url = "?";

if (request_is_post()) {
    if (isset($_POST["category_name"])) {
        update_category($_POST["category_id"], $_POST["category_name"], $_POST["category_description"]);
        $url .= "category_id=" . $_POST["category_id"];
    } else if (isset($_POST["badge_name"])) {
        update_badge($_POST["badge_id"], $_POST["badge_name"], $_POST["badge_description"], $_POST["badge_prereq_id"], $_POST["category_id"], $_POST["badge_experience"]);
        $url .= "category_id=" . $_POST["category_id"] . "&badge_id=" . $_POST["badge_id"];
    } else if (isset($_POST["req_name"])) {
        update_req($_POST["req_id"], $_POST["req_name"], $_POST["req_text"], $_POST["badge_id"], $_POST["req_link"]);
        $url .= "category_id=" . $_POST["category_id"] . "&badge_id=" . $_POST["badge_id"] . "&req_id=" . $_POST["req_id"];
    }
    redirect_to("progression_edit.php" . $url);
}

include_once '../../private/shared/default_header.php';

?>

<div class="forms">
    <h2 class="text-center">Categories</h2>
    <?php
    $category_set = find_session_categories($_SESSION["session_id"]);
    while ($category = mysqli_fetch_assoc($category_set)) {
        ?>
        <form action="progression_edit.php" class="category-item border text-center <?php if ($category["category_id"] == $_GET["category_id"]) echo "selected"; ?>" method="GET">
            <h4><?php echo $category["category_name"]; ?></h4>
            <input type="hidden" name="category_id" value="<?php echo $category["category_id"]; ?>">
            <button type="submit" class="edit-category btn btn-primary">Edit</button>
        </form>
    <?php } ?>
</div>

<div class="forms">
    <?php
    if (isset($_GET["category_id"])) {
        echo "<h2 class=\"text-center\">Badges</h2>";
        $badge_set = find_badges_by_category($_GET["category_id"]);
        while ($badge = mysqli_fetch_assoc($badge_set)) {
            ?>
            <form action="progression_edit.php" class="badge-item border text-center <?php if ($badge["badge_id"] == $_GET["badge_id"]) echo "selected"; ?>" method="GET">
                <h4><?php echo $badge["badge_name"]; ?></h4>
                <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                <input type="hidden" name="badge_id" value="<?php echo $badge["badge_id"]; ?>">
                <button type="submit" class="edit-badge btn btn-primary">Edit</button>
            </form>
    <?php }
    } ?>
</div>

<div class="forms">
    <?php
    if (isset($_GET["badge_id"])) {
        echo "<h2 class=\"text-center\">Reqs</h2>";
        $req_set = find_reqs_by_badge_id($_GET["badge_id"]);
        while ($req = mysqli_fetch_assoc($req_set)) {
            ?>
            <form action="progression_edit.php" class="req-item border text-center <?php if ($req["req_id"] == $_GET["req_id"]) echo "selected"; ?>" method="GET">
                <h4><?php echo $req["req_name"]; ?></h4>
                <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                <input type="hidden" name="badge_id" value="<?php echo $_GET["badge_id"]; ?>">
                <input type="hidden" name="req_id" value="<?php echo $req["req_id"]; ?>">
                <button type="submit" class="edit-badge btn btn-primary">Edit</button>
            </form>
    <?php }
    } ?>
</div>

<div class="edit-item">
    <?php
    if (isset($_GET["req_id"])) {
        include_once "edit_forms/req_edit.php";
    } else if (isset($_GET["badge_id"])) {
        include_once "edit_forms/badge_edit.php";
    } else if (isset($_GET["category_id"])) {
        include_once "edit_forms/category_edit.php";
    }
    ?>
</div>
<script src="<?php echo url_for("scripts/progression_events.js") ?>"></script>
<?php include_once '../../private/shared/default_footer.php'; ?>