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

            <h2 class="text-danger text-center my-2">Payment Report</h2>
            <div class="row">
                <div class="col-md-2">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Academic Year</label>
                            <select name="acadamicyear" class="form-control">
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
                            <select name="class" class="form-control" required>
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
                            <select name="term" class="form-control">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                        <button class='btn btn-info' name='generate'>Generate</button>
                    </form>
                </div>
                <div class="col-md-10">
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Sn.</th>
                                <th>Student id</th>
                                <th>Academic Year</th>
                                <th>Class</th>
                                <th>Term</th>
                                <th>Mode of Payment</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['generate'])) {
                                $acadamicyear = $_POST['acadamicyear'];
                                $class = $_POST['class'];
                                $term = $_POST['term'];

                                $sql = "select * from payment where acadamicyear = '$acadamicyear' and class = '$class' and term = '$term '";
                                $result = mysqli_query($connect, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $studentid = $row['studentid'];
                                    $acadamicyear = $row['acadamicyear'];
                                    $term = $row['term'];
                                    $class = $row['class'];
                                    $mop = $row['mop'];
                                    $amount = $row['amount'];
                                    $date = $row['date'];
                                    $adminid = $row['adminid'];
                                    echo '
                                    <tr>
                                    <td>' . $id . '</td>
                                    <td>' . $studentid . '</td>
                                    <td>' . $acadamicyear . '</td>
                                    <td>' . $term . '</td>
                                    <td>' . $class . '</td>
                                    <td>' . $mop . '</td>
                                    <td>' . $amount . '</td>
                                    <td>' . $date . '</td>
                                    <td>' . $adminid . '</td>
                                    <td><a href="" class="btn btn-danger">x</a></td>
                                </tr>';
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