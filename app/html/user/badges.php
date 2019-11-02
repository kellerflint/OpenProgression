<?php require_once '../../private/initialize.php'; ?>
<?php
require_login();
$style = url_for('/style/badges.css');
include_once SHARED_PATH . '/default_header.php';

$current_user = $_SESSION["user_id"];

if (request_is_post()) {
    if (isset($_POST["update"])) {
        update_user_reqs($_POST["user_id"], $_POST["badge_id"], $_POST["reqs"]);
        $current_user = $_POST["user_id"];
    } else {
        $current_user = $_POST["user_id"];
    }
}


if ($_SESSION["permission"] == ADM) {
    ?>
    <form action="badges.php" method="POST" id="get-user">
        <label for="user-select">Select User</label>
        <select class="form-control" id="user-select" name="user_id">
            <option value="0">select user</option>
            <?php
                $user_set = find_users_by_session($_SESSION["session_id"]);

                while ($user = mysqli_fetch_assoc($user_set)) {
                    ?>
                <option value="<?php echo $user['user_id']; ?>" <?php if ($user['user_id'] == $current_user) echo "selected"; ?>>
                    <?php echo $user['user_name']; ?>
                </option>
            <?php } ?>
        </select>
    </form>
<?php } ?>
<div id="category-menu">
    <?php
    $category_set = find_session_categories($_SESSION["session_id"]);
    $first = true;
    while ($category = mysqli_fetch_assoc($category_set)) {
        ?>
        <!-- Category Heading -->
        <h3 class="category 
        <?php
            if ($first == true) echo "category-selected";
            $first = false;
            ?>" data-category="<?php echo $category['category_id']; ?>">
            <?php echo $category['category_name']; ?>
        </h3>
    <?php
    }
    ?>
</div>

<div id="badges">
    <?php
    if ($_SESSION["permission"] == ADM) {
        $badge_set = find_session_badges($_SESSION['session_id'], $current_user);
    } else {
        $badge_set = find_session_badges($_SESSION['session_id'], $_SESSION['user_id']);
    }
    while ($badge = mysqli_fetch_assoc($badge_set)) {
        build_badge($badge, $current_user);
    }
    ?>
</div>

<script src=<?php echo url_for('/scripts/badge_events.js'); ?>></script>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php
// badges functions

// generates html for a new badge
function build_badge($badge, $current_user)
{
    $has_prereq = true;
    ?>
    <div class="badge inactive 
    <?php
        if (!has_prereq($badge, $current_user)) {
            echo "locked";
            $has_prereq = false;
        } else if ($badge["has_badge"] == "false") {
            echo "missing";
        }
        ?>" data-category="<?php echo $badge['category_id']; ?>">
        <img class="badge-image" src="
        <?php
            if ($has_prereq == false) {
                echo url_for('/style/img/lock.png');
            } else {
                echo url_for('/style/img/badge.png');
            }
            ?>" alt="badge">
        <h2 class="badge-title"><?php echo $badge['badge_name']; ?></h2>
        <div class="reqs hide">
            <?php
                if ($_SESSION["permission"] == ADM) {
                    $req_set = find_badge_reqs($current_user, $badge['badge_id']);
                } else {
                    $req_set = find_badge_reqs($_SESSION['user_id'], $badge['badge_id']);
                }

                if ($_SESSION["permission"] == ADM) {
                    echo "<form action=\"badges.php\" method=\"POST\">";
                    echo "<input type=\"hidden\" name=\"badge_id\" value=\"{$badge["badge_id"]}\">";
                    echo "<input type=\"hidden\" name=\"user_id\" class=\"user-input-hidden\" value=\"$current_user\">";
                }
                while ($req = mysqli_fetch_assoc($req_set)) {
                    add_req($req, $current_user);
                }
                if ($_SESSION["permission"] == ADM) {
                    echo "<button type=\"submit\" class=\"btn btn-primary\" name=\"update\" value=\"update\">Update</button>";
                    echo "</form>";
                }
                ?>
        </div>
    </div>
<?php }

// adds req to a badge
function add_req($req, $current_user)
{
    ?>
    <div class="req">
        <?php if ($_SESSION["permission"] == ADM) {
                if ($req['has_req'] == "true") {
                    ?>
                <input class="form-check-input" type="checkbox" name="reqs[]" value="<?php echo $req["req_id"]; ?>" id="req-<?php echo $req["req_id"]; ?>" checked>
            <?php
                    } else {
                        ?>
                <input class="form-check-input" type="checkbox" name="reqs[]" value="<?php echo $req["req_id"]; ?>" id="req-<?php echo $req["req_id"]; ?>">
        <?php
                }
            }
            ?>
        <img class="req-image" src="
        <?php
            if ($req['has_req'] == "true") {
                echo url_for('style/img/true.png');
            } else {
                echo url_for('style/img/false.png');
            }
            ?>" alt="
            <?php
                if ($req['has_req'] == "true") {
                    echo 'true';
                } else {
                    echo 'false';
                }
                ?>
    ">
        <label class="req-title" for="req-<?php echo $req["req_id"]; ?>"><?php echo $req['req_name']; ?></label>
        <p class="req-text"><?php echo $req['req_text']; ?></p>
        <p class="req-link"><a href="<?php echo $req['req_link']; ?>" target="_blank">(link)</a></p>
    </div>
<?php
}

// returns true if user has prereq for badge
function has_prereq($badge, $current_user)
{
    // TODO: $badge_set is null if I don't re-run the query? Find out why
    if ($_SESSION["permission"] == ADM) {
        $badge_set = find_session_badges($_SESSION['session_id'], $current_user);
    } else {
        $badge_set = find_session_badges($_SESSION['session_id'], $_SESSION['user_id']);
    }
    if ($badge['badge_prereq_id'] === NULL) {
        return true;
    } else {
        while ($item = mysqli_fetch_assoc($badge_set)) {
            if ($item['badge_id'] == $badge["badge_prereq_id"]) {
                if ($item['has_badge'] == "true") {
                    return true;
                }
            }
        }
        return false;
    }
}

?>