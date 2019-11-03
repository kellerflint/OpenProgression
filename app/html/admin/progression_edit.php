<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/progression_edit.css";

$url = "?";

if (request_is_post()) {

    // if clicked the remove submit button
    if (isset($_POST["remove"])) {
        if (isset($_POST["category_name"])) {
            remove_category($_POST["category_id"]);
        } else if (isset($_POST["badge_name"])) {
            remove_badge($_POST["badge_id"]);
            $url .= "category_id=" . $_POST["category_id"];
        } else if (isset($_POST["req_name"])) {
            remove_req($_POST["req_id"]);
            $url .= "category_id=" . $_POST["category_id"] . "&badge_id=" . $_POST["badge_id"];
        }
    } else if (isset($_POST["submit"])) {
        // if category was target create or update category depending on if valid id passed
        if (isset($_POST["category_name"])) {
            $id = "";
            if ($_POST["category_id"] == 0) {
                create_category($_POST["category_name"], $_POST["category_description"], $_SESSION["session_id"]);
            } else {
                update_category($_POST["category_id"], $_POST["category_name"], $_POST["category_description"]);
                $id = $_POST["category_id"];
            }
            // building url for GET
            $url .= "category_id=" . $id;
            // if badge was target create or update badge depending on if valid id passed
        } else if (isset($_POST["badge_name"])) {
            $id = "";
            if ($_POST["badge_id"] == 0) {
                create_badge($_POST["category_id"], $_POST["badge_name"], $_POST["badge_description"], $_POST["badge_experience"], $_POST["badge_prereq_id"]);
            } else {
                update_badge($_POST["badge_id"], $_POST["badge_name"], $_POST["badge_description"], $_POST["badge_prereq_id"], $_POST["category_id"], $_POST["badge_experience"]);
                $id = "&badge_id=" . $_POST["badge_id"];
            }
            // building url for GET
            $url .= "category_id=" . $_POST["category_id"] . $id;
            // if req was target create or update req depending on if valid id passed
        } else if (isset($_POST["req_name"])) {
            $id = "";
            if ($_POST["req_id"] == 0) {
                create_req($_POST["badge_id"], $_POST["req_name"], $_POST["req_text"], $_POST["req_link"]);
            } else {
                update_req($_POST["req_id"], $_POST["req_name"], $_POST["req_text"], $_POST["badge_id"], $_POST["req_link"]);
                $id = "&req_id=" . $_POST["req_id"];
            }
            // building url for GET
            $url .= "category_id=" . $_POST["category_id"] . "&badge_id=" . $_POST["badge_id"] . "&req_id=" . $id;
        }
        // move item up
    } else if (isset($_POST["up"])) {
        if (isset($_POST["category_name"])) {
            move_category($_POST["category_id"], -1);
        } else if (isset($_POST["badge_name"])) {
            $url .= "category_id=" . $_POST["category_id"];
            move_badge($_POST["badge_id"], -1);
        } else if (isset($_POST["req_name"])) {
            $url .= "category_id=" . $_POST["category_id"] . "&badge_id=" . $_POST["badge_id"];
            move_req($_POST["req_id"], -1);
        }
        // move item down
    } else if (isset($_POST["down"])) {
        if (isset($_POST["category_name"])) {
            move_category($_POST["category_id"], 1);
        } else if (isset($_POST["badge_name"])) {
            $url .= "category_id=" . $_POST["category_id"];
            move_badge($_POST["badge_id"], 1);
        } else if (isset($_POST["req_name"])) {
            $url .= "category_id=" . $_POST["category_id"] . "&badge_id=" . $_POST["badge_id"];
            move_req($_POST["req_id"], 1);
        }
    }

    // sets GET url for all selected items
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
            <form action="progression_edit.php"
                  class="category-item border text-center <?php if ($category["category_id"] == $_GET["category_id"]) echo "selected"; ?>"
                  method="GET">
                <h4><?php echo $category["category_name"]; ?></h4>
                <input type="hidden" name="category_id" value="<?php echo $category["category_id"]; ?>">
                <input type="hidden" name="action_type" value="edit">
                <button type="submit" class="edit-category btn btn-primary">Edit</button>
            </form>
        <?php } ?>
        <form action="progression_edit.php" class="category-item border text-center" method="GET">
            <input type="hidden" name="category_id" value="0">
            <input type="hidden" name="action_type" value="create">
            <button class="btn btn-secondary">Add Category</button>
        </form>

    </div>

    <div class="forms">
        <?php
        if (isset($_GET["category_id"]) && $_GET["category_id"] > 0) {
            echo "<h2 class=\"text-center\">Badges</h2>";
            $badge_set = find_badges_by_category($_GET["category_id"]);
            while ($badge = mysqli_fetch_assoc($badge_set)) {
                ?>
                <form action="progression_edit.php"
                      class="badge-item border text-center <?php if ($badge["badge_id"] == $_GET["badge_id"]) echo "selected"; ?>"
                      method="GET">
                    <h4><?php echo $badge["badge_name"]; ?></h4>
                    <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                    <input type="hidden" name="badge_id" value="<?php echo $badge["badge_id"]; ?>">
                    <input type="hidden" name="action_type" value="edit">
                    <button type="submit" class="edit-badge btn btn-primary">Edit</button>
                </form>
            <?php } ?>
            <form action="progression_edit.php" class="badge-item border text-center" method="GET">
                <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                <input type="hidden" name="badge_id" value="0">
                <input type="hidden" name="action_type" value="create">
                <button class="btn btn-secondary">Add Badge</button>
            </form>
        <?php } ?>
    </div>

    <div class="forms">
        <?php
        if (isset($_GET["badge_id"]) && $_GET["badge_id"] > 0) {
            echo "<h2 class=\"text-center\">Reqs</h2>";
            $req_set = find_reqs_by_badge_id($_GET["badge_id"]);
            while ($req = mysqli_fetch_assoc($req_set)) {
                ?>
                <form action="progression_edit.php"
                      class="req-item border text-center <?php if ($req["req_id"] == $_GET["req_id"]) echo "selected"; ?>"
                      method="GET">
                    <h4><?php echo $req["req_name"]; ?></h4>
                    <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                    <input type="hidden" name="badge_id" value="<?php echo $_GET["badge_id"]; ?>">
                    <input type="hidden" name="req_id" value="<?php echo $req["req_id"]; ?>">
                    <input type="hidden" name="action_type" value="edit">
                    <button type="submit" class="edit-badge btn btn-primary">Edit</button>
                </form>
            <?php } ?>
            <form action="progression_edit.php" class="badge-item border text-center" method="GET">
                <input type="hidden" name="category_id" value="<?php echo $_GET["category_id"]; ?>">
                <input type="hidden" name="badge_id" value="<?php echo $_GET["badge_id"]; ?>">
                <input type="hidden" name="req_id" value="0">
                <input type="hidden" name="action_type" value="create">
                <button class="btn btn-secondary">Add Req</button>
            </form>
        <?php } ?>
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