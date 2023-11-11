<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

if (isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $class = $_POST['class'];
    $acadamicyear = $_POST['acadamicyear'];
    $mop = $_POST['mop'];
    $term = $_POST['term'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    $feedata = array($studentid,  $acadamicyear, $term, $class, $mop, $amount, $date, '');
    MyApp::insertvalue($connect, "payment", $feedata, true);
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
                    <h2 class="text-danger text-center my-2">Payment</h2>
                    <hr>
                </div>
                <form method="POST" class="row">
                    <div class="form-group col-md-6">
                        <label>Student ID</label>
                        <input type="text" name="studentid" class='form-control' required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Class</label>
                        <select name="class" class="form-control">
                            <option></option>
                            <?php
                            echo MyApp::fetchallrecord($connect, 'class', array('class'), true);
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Acadamic Year</label>
                        <select name="acadamicyear" class="form-control">
                            <option></option>
                            <?php
                            echo MyApp::fetchallrecord($connect, 'acadamicyear', array('year'), true);
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Mode Of Payment</label>
                        <select name="mop" class="form-control">
                            <option>Momo</option>
                            <option>Bank</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Term</label>
                        <select name="term" class="form-control">
                            <option></option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Amount</label>
                        <input step='0.01' type="number" class='form-control' name='amount' required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Date</label>
                        <input type="date" class='form-control' name='date' required>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name='submit' class='btn btn-success'>Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>