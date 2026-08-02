<?php
require_once "connection.php";
$conn = connection();
session_start();
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = $user_password = "";
    $user_name = htmlspecialchars($_POST["user_name"]);
    $user_password = htmlspecialchars($_POST["user_password"]);

    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $db_user = $result->fetch_assoc();
        if (password_verify($user_password, $db_user["user_password"])) {
            $_SESSION["user_name"] = $db_user["user_name"];
            $_SESSION["user_type"] = $db_user["user_type"];

            header("Location: auth.php");
        } else {
            echo "Incorrect Password";
        }
    } else {
        echo "Username not found";
    }
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "GET"): ?>
    <form action="login.php" method="POST">
        <input type="text" name="user_name" placeholder="username" required>
        <input type="password" name="user_password" placeholder="username" required>
        <input type="submit" value="Login">
    </form>
<?php endif ?>