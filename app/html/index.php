<?php require_once '../private/initialize.php'; ?>
<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php
$db = db_connect();
$id = 1;
$query = "SELECT * FROM User WHERE user_id = ?";
$stmt = $db->prepare($query);
// You should have something checking if the prepare method returned false before attempting to bind. 
// That's what the boolean bind error is about
$stmt->bind_param("i", $id);
$stmt->execute();
$set = $stmt->get_result();
$stmt->close();

while ($item = mysqli_fetch_assoc($set)) {
    echo $item['user_name'];
}
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>