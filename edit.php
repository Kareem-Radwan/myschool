<?php
require_once "connection.php";
$conn = connection();
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = isset($_POST["student_id"]) ? $_POST["student_id"] : 0;
    $student_name = $student_age = "";

    $student_name = htmlspecialchars($_POST["student_name"]);

    if (filter_var($_POST["student_age"], FILTER_VALIDATE_INT)) {
        $student_age = htmlspecialchars($_POST["student_age"]);
    }

    $sql = "UPDATE students SET student_name = '$student_name', student_age = $student_age, updated_at = NOW() WHERE student_id = $student_id";

    $conn->query($sql);
    header("Location: index.php");
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM students WHERE student_id = {$_GET['id']}";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
?>
    <form action="edit.php" method="POST">
        <input type="hidden" name="student_id" value="<?= $_GET["id"] ?>">
        <input type="text" value="<?= $student["student_name"] ?>" name="student_name" required>
        <input type="number" value="<?= $student["student_age"] ?>" name="student_age" required>
        <input type="submit" value="Edit Student">
    </form>
<?php } ?>