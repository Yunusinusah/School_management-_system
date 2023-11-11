<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

if (isset($_POST['submit'])) {
    $acadamicyear = $_POST['acadamicyear'];
    $class = $_POST['class'];
    $term = $_POST['term'];
    $amount = $_POST['amount'];

    $select = "SELECT * FROM fee WHERE acadamicyear='$acadamicyear' and class='$class' and term='$term'";
    $result = mysqli_query($connect, $select);
    $chk = mysqli_num_rows($result);
    if ($chk > 0) {
        MyApp::notify("Fee Already Registered");
    } else {
        $feedata = array($acadamicyear, $term, $amount, $class);
        MyApp::insertvalue($connect, "fee", $feedata, true);
    }
}
?>

<body>
    <div class="row">
        <div class="col-md-2 my-2">
            <?php
            include 'resource/sidebar.php';
            ?>
        </div>
        <div class="col-md-10 p-4 card shadow">
            <div class="card-title">
                <h2 class="text-danger text-center my-2">Setup Fee</h2>
                <hr>
            </div>
            <div class="row">

                <div class="col-md-3"></div>

                <div class="col-md-8">
                    <div class="card-body">

                        <form action="" method='POST'>
                            <div class="form-group">
                                <label>Acadamic Year</label>
                                <select name="acadamicyear" class='form-control'>
                                    <option></option>
                                    <option>
                                        <?php
                                        echo MyApp::fetchallrecord($connect, 'acadamicyear', array('year'), true);
                                        ?>
                                    </option>
                                </select>
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
                                <label>Term</label>
                                <select name="term" class='form-control'>
                                    <option></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <!--Step =0.01 is to allow decimal numbers-->
                                <input step='0.01' type="number" class='form-control' name='amount' required>
                            </div>
                            <button name='submit' class=' btn btn-success'>Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>