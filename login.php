<html>
<?php
include 'resource/head.php';
include 'resource/functionad.php';
include 'resource/db.php';

if (isset($_POST['login'])) {
    $staffid = $_POST['staffid'];
    $password = $_POST['password'];

    $select = "SELECT * FROM staff WHERE id ='$staffid' and password = '$password' ";
    $result = mysqli_query($connect, $select);
    $chk = mysqli_num_rows($result);

    if ($chk == 1) {
        $_SESSION['userid'] = $staffid;
        MyApp::redirect('dashboard.php');
    } else {
        MyApp::notify('Wrong details provided');
    }
}
?>

<body>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 card shadow my-5">
            <form action="" method="POST">
                <h2 class='text-center my-3'>Staff Login page</h2>
                <hr>
                <div class="form-group">
                    <label>Staff ID</label>
                    <input type="text" class="form-control" name="staffid">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <button name='login' class='btn btn-warning my-2'>Login</button>
                </div>

            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>

</html>