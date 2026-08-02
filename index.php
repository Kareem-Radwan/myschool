<?php
/*
* Show all Data : Index page
* Delete: edit page, index page
* Edit: edit page,
* Show: show page,
* Create: create page
*/
require_once "connection.php";
$conn = connection();
$search = !empty($_GET["search_data"]) ? $_GET["search_data"] : 0 ;

if ($search == 0) {
    $sql = "SELECT * FROM students ORDER BY created_at";
} else {
    $sql = "SELECT * FROM students WHERE student_name LIKE '%$search%' ORDER BY created_at";
}
$result = $conn->query($sql);
?>

<?php if($_SERVER["REQUEST_METHOD"] === "POST"){
    $student_id = $_POST["student_id"];
    $sql = "DELETE FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    header("Location: index.php");
}?>


<form action="index.php" method="GET">
    <input type="text" name="search_data">
    <input type="submit" value="Search">
</form>
<table border="2">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Age</th>
            <th>Actions</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php while($data = $result->fetch_assoc()):?>
            <tr>
                <td><?= $data["student_id"] ?></td>
                <td><?= $data["student_name"] ?></td>
                <td><?= $data["student_age"] ?></td>
                <td><a href="edit.php?id=<?= $data["student_id"]?>">Edit Student</a></td>
                <td>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="student_id" value="<?= $data["student_id"] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endwhile?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2"><a href="create.php">Add Data</a></th>
            <th colspan="3"><a href="auth.php">Authenticate</a></th>
        </tr>
    </tfoot>
</table>