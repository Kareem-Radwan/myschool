<?php
require_once "connection.php";
$conn = connection();
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : 0;
    $user_name = $user_type = "";

    $user_name = htmlspecialchars($_POST["user_name"]);

    if($user_type == 'admin' or $user_type == 'teacher' or $user_type == 'student' or $user_type == 'parent'){
        $user_type = htmlspecialchars($_POST["user_type"]);
    } else {
        die("Error in student Type");
    }

    // created_at format acceptable for database as timestamp
    $created_at = date("Y-m-d H:i:s");
    $sql = "UPDATE users SET user_name = ?, user_type = ?, updated_at = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $user_name, $user_type, $created_at, $user_id);
    $stmt->execute();
    header("Location: auth.php");
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM users WHERE user_id = {$_GET['id']}";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
?>
    <form action="editauth.php" method="POST">
        <input type="hidden" name="user_id" value="<?= $_GET["id"] ?>">
        <input type="text" value="<?= $student["user_name"] ?>" name="user_name" required>
        <input type="text" value="<?= $student["user_type"] ?>" name="user_type" required>
        <input type="submit" value="Edit Student">
    </form>
<?php } ?>