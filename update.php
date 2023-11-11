<html>
<?php

include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

$studentid = $_GET['classid'];
$sql = "select * from student where id='$studentid' ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

$id = $row['studentid'];
$name = $row['studentfullname'];
$class = $row['class'];
$gender = $row['gender'];
$guidiannumber = $row['guidiannumber'];
$Address = $row['address'];
$hostel = $row['hostel'];
$dob = $row['dob'];
$year = $row['year'];
$guidianname = $row['guidianname'];

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $fullname = $_POST['studentfullname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $year = $_POST['year'];
    $hostel = $_POST['hostel'];
    $guidianname = $_POST['guidianname'];
    $guidiantelephone = $_POST['guidiannumber'];

    $sql = "update student set id= $id, studentfullname='$fullname',gender='$gender',address='$address',
    dob='$dob',class='$class',year='$year',hostel='$hostel',guidianname='$guidianname',guidiannumber='$guidiantelephone' where id =$studentid ";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        header('location:classlist.php');
    } else {
        die(mysqli_error($connect));
    }
}
?>
<script>
    function getInfo(id) {
        $.ajax({
            type: "get",
            url: "ajax/get_user_info.php",
            data: {
                id: id
            },
            success: function(response) {
                var res = JSON.parse(response);
                $("#id").val(res["studentid"]);
                $("#name").val(res["studentfullname"]);
                $("#class").val(res["class"]);
                $("#gender").val(res["gender"]);
                $("#address").val(res['address']);
                $("#guidiannumber").val(res["guidiannumber"]);
                $("#hostel").val(res["hostel"]);
                $("#dob").val(res["dob"]);
                $("#year").val(res["year"]);
                $("#guidianname").val(res["guidianname"]);
                // show edit modal
                $("#edit-modal").modal('show');
            }

        });

        // update user info
        $(".edit-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "update.php?id=" + id,
                data: $(this).serialize(),
                success: function(response) {
                    $("#edit-modal").modal('hide');
                    alert(response);
                    readData();
                }
            });
        });
    }
</script>

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
                    <h2 class="text-danger text-center my-2">Update Student</h2>
                    <hr>
                </div>
                <form method="POST" class='row'>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class='form-control' name='id' required value='<?php echo $id; ?>'>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class='form-control'>
                                <option><?php echo $gender; ?></option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date Of Birth</label>
                            <input type="date" class='form-control' name='dob' value='<?php echo $dob; ?>'>
                        </div>
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year" class='form-control'>
                                <option><?php echo $year; ?></option>
                                <option>
                                    <?php
                                    echo MyApp::fetchallrecord($connect, 'acadamicyear', array('year'), true);
                                    ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Guidian Name</label>
                            <input type="text" class='form-control' name='guidianname' value='<?php echo $guidianname; ?>'>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class='form-control' name='studentfullname' value="<?php echo $name ?>">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class='form-control' name='address' value='<?php echo $Address; ?>'>
                        </div>

                        <div class="form-group">
                            <label>Class</label>
                            <select name="class" class='form-control'>
                                <option><?php echo $class; ?></option>
                                <option>
                                    <?php
                                    echo MyApp::fetchallrecord($connect, 'class', array('class'), true);
                                    ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hostel</label>
                            <input type="text" class='form-control' name='hostel' value='<?php echo $hostel; ?>'>
                        </div>
                        <div class="form-group">
                            <label>Guidian Telephone</label>
                            <input type="text" class='form-control' name='guidiannumber' value='<?php echo $guidiannumber; ?>'>
                        </div>
                    </div>
                    <button class='btn btn-success' name='submit'>Submit</button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>