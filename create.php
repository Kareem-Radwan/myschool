<?php
require_once "connection.php";
$conn = connection();
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = isset($_POST["student_id"]) ? $_POST["student_id"] : 0;
    $student_name = $student_age = "";

    $student_name = htmlspecialchars($_POST["student_name"]);

    if(filter_var($_POST["student_id"], FILTER_VALIDATE_INT)){
        $student_id = (int) $_POST["student_id"];
    }

    if(filter_var($_POST["student_age"], FILTER_VALIDATE_INT)){
        $student_age = htmlspecialchars($_POST["student_age"]);
    }

    $sql = "INSERT INTO students(student_id, student_name, student_age) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $student_id, $student_name, $student_age);
    $stmt->execute();
    header("Location: index.php");
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "GET"): ?>
    <form action="create.php" method="POST">
        <input type="number" name="student_id" required>
        <input type="text" name="student_name" required>
        <input type="number" name="student_age" required>
        <input type="submit" value="Add Student">
    </form>
<?php endif ?>