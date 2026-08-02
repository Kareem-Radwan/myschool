<?php
require_once "connection.php";
$conn = connection();
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : 0;
    $user_name = $user_type = $user_password = "";
    $user_type = $_POST["user_type"];
    $user_name = htmlspecialchars($_POST["user_name"]);
    $user_password = password_hash(htmlspecialchars($_POST["user_password"]), PASSWORD_DEFAULT);

    if (filter_var($_POST["user_id"], FILTER_VALIDATE_INT)) {
        $user_id = (int) $_POST["user_id"];
    }

    if ($user_type == 'admin' or $user_type == 'teacher' or $user_type == 'student' or $user_type == 'parent') {
        $user_type = htmlspecialchars($_POST["user_type"]);
    } else {
        die("Error in student Type");
    }

    $sql = "INSERT INTO users(user_id, user_name, user_password, user_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $user_name, $user_password, $user_type);
    $stmt->execute();
    header("Location: auth.php");
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "GET"): ?>
    <form action="createauth.php" method="POST">
        <input type="number" name="user_id" required>
        <input type="text" name="user_name" required>
        <input type="password" placeholder="Password" name="user_password" required>
        <select name="user_type">
            <option value="admin">admin</option>
            <option value="teacher">teacher</option>
            <option value="student">student</option>
            <option value="parent">parent</option>
        </select>
        <input type="submit" value="Add User">
    </form>
<?php endif ?>