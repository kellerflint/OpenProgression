<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/progression_edit.css";

include_once '../../private/shared/default_header.php';

if (request_is_post() && isset($_POST["category_name"])) {
    update_category($_POST["category_id"], $_POST["category_name"], $_POST["category_description"]);
}

?>

<div class="container">
    <div class="category-forms">
        <?php
        $category_set = find_session_categories($_SESSION["session_id"]);
        while ($category = mysqli_fetch_assoc($category_set)) {
            ?>
            <form action="progression_edit.php" class="category-item border <?php if ($category["category_id"] == $_GET["category_id"]) echo "selected"; ?>" method="GET">
                <h2><?php echo $category["category_name"]; ?></h2>
                <input type="hidden" name="category_id" value="<?php echo $category["category_id"]; ?>">
                <button type="submit" class="edit-category btn btn-primary">Edit</button>
            </form>
        <?php } ?>

        <?php
        if (isset($_GET["category_id"])) {
            $badge_set = find_badges_by_category($_GET["category_id"]);
            while ($badge = mysqli_fetch_assoc($badge_set)) {
                ?>
                <form action="progression_edit.php" class="badge-item border <?php if ($badge["badge_id"] == $_GET["badge_id"]) echo "selected"; ?>" method="GET">
                    <h2><?php echo $badge["badge_name"]; ?></h2>
                    <input type="hidden" name="badge_id" value="<?php echo $badge["badge_id"]; ?>">
                    <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                    <button type="submit" class="edit-badge btn btn-primary">Edit</button>
                </form>
        <?php }
        } ?>

    </div>
    <div class="edit-item">
        <?php
        if (isset($_GET["badge_id"])) {
            include_once "edit_forms/badge_edit.php";
        } else if (isset($_GET["category_id"])) {
            include_once "edit_forms/category_edit.php";
        } ?>
    </div>
</div>
<script src="<?php echo url_for("scripts/progression_events.js") ?>"></script>
<?php include_once '../../private/shared/default_footer.php'; ?>