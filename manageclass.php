<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

if (isset($_POST['submit'])) {
    $class = $_POST['class'];
    $chk = MyApp::fetchcount($connect, 'class', 'class', $class);
    if ($chk > 0) {
        MyApp::notify("Class Already Registered");
    } else {
        $classdata = array($class);
        MyApp::insertvalue($connect, 'class', $classdata, true);
    }
}
?>

<body>
    <div class="row">
        <div class="col-md-2 my-2">
            <?php
            include 'resource/sidebar.php'
            ?>
        </div>
        <div class="col-md-10 p-4 card shadow">
            <div class="card-body">
                <div class="card-title">
                    <h2 class="text-danger text-center my-2">Manage Class</h2>
                    <hr>
                </div>
                <form action="" method="POST" class='row'>
                    <div class='col-md-6'>
                        <div class="form-group ">
                            <label>Add Class</label>
                            <input type="text" name="class" class="form-control" required>
                        </div>
                        <button class="btn btn-success" name='submit'>Submit</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>