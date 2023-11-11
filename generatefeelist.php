<html>
<?php
include 'resource/head.php';
include 'resource/db.php';
include 'resource/functionad.php';

if (isset($_GET['feeid'])) {
    $id = $_GET['feeid'];

    /* $sql = "delete from fee where id = $id";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        header("location:generatefeelist.php");
    } else {
        die(mysqli_error($connect));
    }
    */
    MyApp::deleteitemurl($connect, 'fee', 'id', $id, 'generatefeelist.php');
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

            <h2 class="text-danger text-center my-2">Generate Fee List</h2>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <form action="" method="POST">
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
                            <label>Term</label>
                            <select name="term" class='form-control'>
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                        <button type="submit" name='submit' class='btn btn-info'>Submit</button>
                    </form>
                </div>
                <div class="col-md-9">
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Class</th>
                                <th>Term</th>
                                <th>Amount</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['submit'])) {
                                $year = $_POST['year'];
                                $term = $_POST['term'];

                                $sql = "select * from fee where acadamicyear = '$year' and term = '$term'";
                                $result = mysqli_query($connect, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $year = $row['acadamicyear'];
                                    $class = $row['class'];
                                    $term = $row['term'];
                                    $amount = $row['amount'];

                                    echo '<tr>
                                    <td>' . $year . '</td>
                                    <td>' . $class . '</td>
                                    <td>' . $term . '</td>
                                    <td>' . $amount . '</td>
                                    <td>
                                    <a href="deletefee.php?feeid=' . $id . '" class="btn btn-danger btn-sm">x</a>
                                    </td>
                                    
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