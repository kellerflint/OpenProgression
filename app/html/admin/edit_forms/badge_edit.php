<h2>Edit Badge</h2>
<form action="progression_edit.php" METHOD="POST">
    <?php $badge = find_badge_by_id($_GET["badge_id"]); ?>
    <input type="hidden" name="badge_id" value="<?php echo $badge["badge_id"]; ?>">
    <div class="form-group">
        <label for="badge-name">Name</label>
        <input type="text" class="form-control" id="badge-name" name="badge_name" value="<?php echo $badge["badge_name"]; ?>">
    </div>
    <div class="form-group">
        <label for="badge-description">Description</label>
        <textarea class="form-control" id="badge-description" name="badge_description" rows="3"><?php echo $badge["badge_description"]; ?></textarea>
    </div>
    <div class="form-group">
        <label for="badge-experience">Experience</label>
        <input type="number" class="form-control" id="badge-experience" name="badge_experience" value="<?php echo $badge["badge_experience"]; ?>">
    </div>
    <div class="form-group">
        <label for="select-category">Category</label>
        <select class="form-control" id="select-category">
            <option value="none">select...</option>
            <!--list of other badges in session, ordered by category then badge_order-->
        </select>
    </div>
    <div class="form-group">
        <label for="select-prereq">Prerequisite</label>
        <select class="form-control" id="select-prereq">
            <option value="none">select...</option>
            <!--list of other badges in session, ordered by category then badge_order-->
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>