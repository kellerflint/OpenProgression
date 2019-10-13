<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/progression_edit.css";

include_once '../../private/shared/default_header.php'; ?>

<div class="container">
    <form action="progression_edit.php" method="GET"><input type="text" name="category_id"><button type="submit">sub</button></form>
    <div class="edit-item">
        <h2>Edit Category</h2>
        <?php include_once "edit_forms/category_edit.php"; ?>
    </div>
</div>

<script src="<?php echo url_for('scripts/user_edit.js'); ?>"></script>
<?php include_once '../../private/shared/default_footer.php'; ?>