<?php
include 'resource/db.php';

$id = $_GET['feeid'];

$sql = "delete from fee where id = $id";
$result = mysqli_query($connect, $sql);
if ($result) {
    header("location:generatefeelist.php");
} else {
    die(mysqli_error($connect));
}
