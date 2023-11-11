<html>
<?php
include 'resource/head.php';
?>

<body>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 card shadow my-5">
            <form action="" method="POST">
                <h2 class='text-center my-3'>Student Login page</h2>
                <hr>
                <div class="form-group">
                    <label>Student ID</label>
                    <input type="text" class="form-control" name="staffid">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <button class='btn btn-warning my-2'>Login</button>
                </div>

            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>

</html>