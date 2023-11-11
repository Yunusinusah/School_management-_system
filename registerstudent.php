<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

if (isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $fullname = $_POST['studentfullname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $year = $_POST['year'];
    $hostel = $_POST['hostel'];
    $guidianname = $_POST['guidianname'];
    $guidiantelephone = $_POST['guidiannumber'];
    //checking erro
    $studentdata = array($studentid, $fullname, $gender, $address, $dob, $class, $year, $hostel, $guidianname, $guidiantelephone);
    MyApp::insertvalue($connect, "student", $studentdata, true);
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
                    <h2 class="text-danger text-center my-2">Register Student</h2>
                    <hr>
                </div>
                <form method="POST" class='row'>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Student ID</label>
                            <input type="text" class='form-control' name='studentid'>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class='form-control'>
                                <option></option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date Of Birth</label>
                            <input type="date" class='form-control' name='dob'>
                        </div>
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year" class='form-control'>
                                <option></option>
                                <option>
                                    <?php
                                    echo MyApp::fetchallrecord($connect, 'acadamicyear', array('year'), true);
                                    ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Guidian Name</label>
                            <input type="text" class='form-control' name='guidianname'>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class='form-control' name='studentfullname'>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class='form-control' name='address'>
                        </div>

                        <div class="form-group">
                            <label>Class</label>
                            <select name="class" class='form-control'>
                                <option></option>
                                <option>
                                    <?php
                                    echo MyApp::fetchallrecord($connect, 'class', array('class'), true);
                                    ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hostel</label>
                            <input type="text" class='form-control' name='hostel'>
                        </div>
                        <div class="form-group">
                            <label>Guidian Telephone</label>
                            <input type="text" class='form-control' name='guidiannumber'>
                        </div>
                    </div>
                    <button class='btn btn-success' name='submit'>Submit</button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>