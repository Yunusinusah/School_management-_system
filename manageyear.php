<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

if (isset($_POST['submit'])) {
    $year = $_POST['year'];
    $chk = MyApp::fetchcount($connect, 'acadamicyear', 'year', $year);
    if ($chk > 0) {
        MyApp::notify("Year Already Registered");
    } else {
        $yeardata = array($year);
        MyApp::insertvalue($connect, 'acadamicyear', $yeardata, true);
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
                    <h2 class="text-danger text-center my-2">Manage Year</h2>
                    <hr>
                </div>
                <form action="" method="POST" class='row'>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label>Add Year</label>
                            <input type="text" name="year" class="form-control" required>
                        </div>
                        <button class="btn btn-success" name='submit'>Submit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>