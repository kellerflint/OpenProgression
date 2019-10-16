<?php if ($_GET["action_type"] == "edit") { ?>
    <h2 class="text-center">Edit Category</h2>
<?php } else if ($_GET["action_type"] == "create") { ?>
    <h2 class="text-center">Create Category</h2>
<?php } ?>
<form action="progression_edit.php" METHOD="POST">
    <?php
    if ($_GET["action_type"] == "edit") {
        $category = find_category_by_id($_GET["category_id"]);
    }
    ?>
    <input type="hidden" name="category_id" value="<?php echo $category["category_id"]; ?>">
    <div class="form-group">
        <label for="category-name">Name</label>
        <input type="text" class="form-control" id="category-name" name="category_name" value="<?php echo $category["category_name"]; ?>">
    </div>
    <div class="form-group">
        <label for="category-description">Description</label>
        <textarea class="form-control" id="category-description" name="category_description" rows="3"><?php echo $category["category_description"]; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>