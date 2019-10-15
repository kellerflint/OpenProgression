<h2 class="text-center">Edit Req</h2>
<form action="progression_edit.php" METHOD="POST">
    <?php $req = find_req_by_id($_GET["req_id"]); ?>
    <input type="hidden" name="req_id" value="<?php echo $req["req_id"]; ?>">
    <div class="form-group">
        <label for="req-name">Name</label>
        <input type="text" class="form-control" id="req-name" name="req_name" value="<?php echo $req["req_name"]; ?>">
    </div>
    <div class="form-group">
        <label for="req_text">Text</label>
        <textarea class="form-control" id="req-text" name="req_text" rows="3"><?php echo $req["req_text"]; ?></textarea>
    </div>
    <div class="form-group">
        <label for="req_link">Link</label>
        <textarea class="form-control" id="req-link" name="req_link" rows="2"><?php echo $req["req_link"]; ?></textarea>
    </div>
    <div class="form-group">
        <label for="select-badge">Badge</label>
        <select class="form-control" id="select-badge" name="badge_id">
            <?php
            $badge_set =  find_badges_by_session($_SESSION["session_id"]);
            while ($badge_item = mysqli_fetch_assoc($badge_set)) {
                ?>
                <option value="<?php echo $badge_item["badge_id"]; ?>" <?php if ($badge_item["badge_id"] == $req["badge_id"]) echo "selected"; ?>>
                    <?php echo $badge_item["badge_name"]; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>