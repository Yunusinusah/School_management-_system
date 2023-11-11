<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

?>

<body>
    <div class="row">
        <div class="col-md-2 my-2">
            <?php
            include 'resource/sidebar.php'
            ?>
        </div>
        <div class="col-md-10 p-4 card shadow">

            <h2 class="text-danger text-center my-2">Class List</h2>
            <div class="row">
                <div class="col-md-2">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Select Year</label>
                            <select name="year" class="form-control">
                                <option></option>
                                <option>
                                    <?php
                                    echo MyApp::fetchallrecord($connect, 'acadamicyear', array('year'), true);
                                    ?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select class</label>
                            <select name="class" class="form-control">
                                <option></option>
                                <option>
                                    <?php
                                    echo MyApp::fetchallrecord($connect, 'class', array('class'), true);
                                    ?>
                                </option>
                            </select>
                        </div>
                        <button class='btn btn-info my-2' name='generate'>Generate</button>
                    </form>
                </div>
                <div class="col-md-10">
                    <table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>Sn.</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Guidian Telephone</th>
                                <th>Address</th>
                                <th>Hostel</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['generate'])) {
                                $year = $_POST['year'];
                                $class = $_POST['class'];

                                $sql = "select * from student where year='$year' and class='$class'";
                                $result = mysqli_query($connect, $sql);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $studentid = $row['studentid'];
                                        $name = $row['studentfullname'];
                                        $class = $row['class'];
                                        $gender = $row['gender'];
                                        $guidiannumber = $row['guidiannumber'];
                                        $Address = $row['address'];
                                        $hostel = $row['hostel'];
                                        echo '
                                    <tr>
                                    <td>' . $id . '</td>
                                    <td>' . $studentid . '</td>
                                    <td>' . $name . '</td>
                                    <td>' . $class . '</td>
                                    <td>' . $gender . '</td>
                                    <td>' . $guidiannumber . '</td>
                                    <td>' . $Address . '</td>
                                    <td>' . $hostel . '</td>
                                    <td>
                                    <a href="update.php? classid=' . $id . '" class="btn btn-success">Update</a>
                                    <a href="deletestu.php? deleteid = ' . $id . '" class="btn btn-danger">Delete</a>
                                    </td>
                                    </tr>
                            
                                    ';
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>