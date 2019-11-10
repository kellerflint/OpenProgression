<?php
if (isset($_GET["action_type"])) {
    if ($_GET["action_type"] == "edit") { ?>
        <h2 class="text-center">Edit Badge</h2>
    <?php } else if ($_GET["action_type"] == "create") { ?>
        <h2 class="text-center">Create Badge</h2>
    <?php } ?>
    <form action="progression_edit.php" METHOD="POST">
        <?php
        if ($_GET["action_type"] == "edit") {
            $badge = find_badge_by_id($_GET["badge_id"]);;
        } else {
            $badge["badge_id"] = 0;
            $badge["category_id"] = $_GET["category_id"];
        }
        ?>
        <input type="hidden" name="badge_id" value="<?php echo $badge["badge_id"]; ?>">
        <div class="form-group">
            <label for="badge-name">Name</label>
            <input type="text" class="form-control" id="badge-name" name="badge_name"
                   value="<?php echo $badge["badge_name"]; ?>">
        </div>
        <div class="form-group">
            <label for="badge-description">Description</label>
            <textarea class="form-control" id="badge-description" name="badge_description"
                      rows="3"><?php echo $badge["badge_description"]; ?></textarea>
        </div>
        <div class="form-group">
            <label for="badge-experience">Experience</label>
            <input type="number" class="form-control" id="badge-experience" name="badge_experience"
                   value="<?php echo $badge["badge_experience"]; ?>">
        </div>
        <div class="form-group">
            <label for="select-category">Category</label>
            <select class="form-control" id="select-category" name="category_id">
                <option value="-1">select...</option>
                <?php
                $category_set = find_session_categories($_SESSION["session_id"]);
                while ($category = mysqli_fetch_assoc($category_set)) {
                    ?>
                    <option value="<?php echo $category["category_id"]; ?>" <?php if ($category["category_id"] == $badge["category_id"]) echo "selected"; ?>>
                        <?php echo $category["category_name"]; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="select-prereq">Prerequisite</label>
            <select class="form-control" id="select-prereq" name="badge_prereq_id">
                <option value="NULL">No Prerequisite</option>
                <?php
                $badge_set = find_badges_by_session($_SESSION["session_id"]);
                while ($badge_item = mysqli_fetch_assoc($badge_set)) {
                    ?>
                    <option value="<?php echo $badge_item["badge_id"]; ?>" <?php if ($badge_item["badge_id"] == $badge["badge_prereq_id"]) echo "selected"; ?>>
                        <?php echo $badge_item["badge_name"]; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
        <button type="submit" class="btn btn-danger" name="remove" value="remove">Remove</button>
        <div class="float-right">
            <?php if (find_badge_order_max($badge["category_id"])["max"] != $badge["badge_order"]) { ?>
                <button type="submit" class="btn btn-secondary" name="down" value="down">Down</button>
            <?php }
            if ((find_badge_order_min($badge["category_id"])["min"] != $badge["badge_order"])) { ?>
                <button type="submit" class="btn btn-secondary" name="up" value="up">Up</button>
            <?php } ?>
        </div>
    </form>
<?php } ?>