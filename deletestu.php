<?php
include 'resource/db.php';


$id = $_GET['deleteid'];
$sql = "delete from student where id='$id'";
$result = mysqli_query($con, $sql);
if ($result) {
    header("Location:display.php");
} else {
    die(mysqli_error($con));
}
