<html>

<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

$id = $_SESSION['userid'];

$staffdata = mysqli_fetch_assoc(mysqli_query($connect, "select * from staff where id = '$id'"));
?>

<body>
    <div class="row ">
        <div class="col-md-2 my-2 bg-dark">
            <?php
            include 'resource/sidebar.php';

            ?>
        </div>
        <div class="col-md-10 p-4 card shadow">

            <h2 class="text-danger text-center my-2">Welcome <?php echo $staffdata['fullname'] ?></h2>
            <hr>
        </div>
    </div>
</body>

</html>