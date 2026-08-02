<?php
require_once "connection.php";
$conn = connection();
$search = !empty($_GET["search_data"]) ? $_GET["search_data"] : 0;

if ($search == 0) {
    $sql = "SELECT * FROM users ORDER BY created_at";
} else {
    $sql = "SELECT * FROM users WHERE user_name LIKE '%$search%' ORDER BY created_at";
}
$result = $conn->query($sql);
?>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"];
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header("Location: auth.php");
} ?>


<form action="index.php" method="GET">
    <input type="text" name="search_data">
    <input type="submit" value="Search">
</form>
<table border="2">
    <thead>
        <tr>
            <th>Id</th>
            <th>User</th>
            <th>Type</th>
            <th>Actions</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($data = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $data["user_id"] ?></td>
                <td><?= $data["user_name"] ?></td>
                <td><?= $data["user_type"] ?></td>
                <td><a href="editauth.php?id=<?= $data["user_id"] ?>">Edit User</a></td>
                <td>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $data["user_id"] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endwhile ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5"><a href="create.php">Add Data</a></th>
        </tr>
    </tfoot>
</table>