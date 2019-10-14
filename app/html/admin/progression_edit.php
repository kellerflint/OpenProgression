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
            <form action="progression_edit.php" class="category-item border" id="category-select-form" method="get">
                <h2><?php echo $category["category_name"]; ?></h2>
                <input type="hidden" name="category_id" value="<?php echo $category["category_id"]; ?>">
                <button type="submit" class="edit-category btn btn-primary">Edit</button>
            </form>
        <?php } ?>
    </div>
    <div class="edit-item">
        <?php // if (req_is_set) else if (badge_is_set) else if (cat_is_set)...
        if (isset($_GET["badge_id"])) {
            include_once "edit_forms/badge_edit.php";
        } else if (isset($_GET["category_id"])) {
            include_once "edit_forms/category_edit.php";
        } ?>
    </div>
</div>
<script src="<?php echo url_for("scripts/progression_events.js") ?>"></script>
<?php include_once '../../private/shared/default_footer.php'; ?>