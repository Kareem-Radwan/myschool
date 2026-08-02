<?php 
function connection(){
    $serveName = "localhost";
    $username = "root";
    $password = "";
    $dbName = "session_9";

    // MySQLi Procedural
    // $conn = mysqli_connect($serveName, $username, $password, $dbName);

    // MySQLi OOP
    $conn = new mysqli($serveName, $username, $password, $dbName);

    if (!$conn){
        die("Connection Failed OMG!");
    }

    return $conn;
}
?>