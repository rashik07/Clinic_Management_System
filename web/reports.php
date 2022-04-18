<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
?>
<?php include 'header.php';
$start_date = "";
$end_date = "";
if (isset($_POST["min"])) {
    $start_date = $_POST["min"];
}
if (isset($_POST["max"])) {
    $end_date = $_POST["max"];
}
?>



<body>
    <div class="wrapper">

        <?php
        include 'sidebar.php';
        ?>


        <div id="content">

            <?php
            include 'top_navbar.php';

            ?>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <!-- <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="indoor_Allotment multiCollapseExample2">Close all</button>
                            </p> -->

                            <form class="form-horizontal form-material mb-0" id="medicine_form" method="post" enctype="multipart/form-data">
                                <div class="row" style="border-bottom: 2px solid lightgray; margin-bottom: 20px">
                                    <div class="form-group col-md-4">
                                        <label for="pharmacy_sell_date">Start Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Selling Date" class="form-control" id="min" name="min" value=<?php echo $start_date ?>>
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="pharmacy_sell_date">End Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Selling Date" class="form-control" id="max" name="max" value=<?php echo $end_date ?>>
                                    </div>
                                    <div class="col-md-4 text-right mt-4">
                                        <div class="">
                                            <input class="btn btn-primary" type="button" value="Print" onclick="printDiv()">
                                            <button type="submit" class="btn btn-success">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>



                            </form>
                            <div id="printD">
                                <h3 style="text-align: center; margin-bottom: 20px;background: lightyellow;">OUTDOOR REPORT</h3>
                                <h4>Services</h4>
                                <table class="Report_table" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td style="width: 40%;">Details</td>
                                            <td>QTY</td>
                                            <td>Per Unit</td>
                                            <td>Issue Date</td>
                                            <td>Bill</td>
                                            <td>Discount</td>
                                            <td>Payment</td>
                                            <td>Due</td>
                                            <td>Total</td>
                                            <!-- <td>Action</td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();
                                        $get_content = "SELECT * FROM `outdoor_service`";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        if (count($services) > 0) {
                                            foreach ($services as $service) {
                                                if ($start_date != "" && $end_date != "") {
                                                    require_once("../apis/Connection.php");
                                                    $connection = new Connection();
                                                    $conn = $connection->getConnection();
                                                    // $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                                    $get_content = "SELECT * FROM outdoor_treatment_service left join outdoor_treatment on outdoor_treatment_service.outdoor_treatment_service_treatment_id = outdoor_treatment.outdoor_treatment_id WHERE (`outdoor_treatment_service_creation_time` BETWEEN '$start_date' AND '$end_date') AND (`outdoor_treatment_service_service_id` = '$service[outdoor_service_id]') AND (outdoor_treatment_indoor_treatment_id IS NULL)";
                                                    $getJson = $conn->prepare($get_content);
                                                    $getJson->execute();
                                                    $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                                    $total_bill = 0;
                                                    // $total_discount = 0;
                                                    $total_payment = 0;
                                                    $total_due = 0;

                                                    if (count($pharmacy_sells) > 0) {
                                                        foreach ($pharmacy_sells as $pharmacy_sell) {
                                                            $total_bill += (int)$pharmacy_sell['outdoor_treatment_service_service_total'];
                                                        }
                                                        echo '<tr class="main_row">
                                                            <td>' . $service['outdoor_service_name'] . '
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>' . $total_bill . '</td>

                                                        </tr>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>


                                    </tbody>
                                </table>



                                <h4>Investigatioons</h4>
                                <table class="Report_table" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td style="width: 40%;">Details</td>
                                            <td>QTY</td>
                                            <td>Per Unit</td>
                                            <td>Issue Date</td>
                                            <td>Bill</td>
                                            <td>Discount</td>
                                            <td>Payment</td>
                                            <td>Due</td>
                                            <td>Total</td>
                                            <!-- <td>Action</td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();
                                        $get_content = "SELECT * FROM `pathology_test`";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $pathology_tests = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        if (count($pathology_tests) > 0) {
                                            foreach ($pathology_tests as $pathology_test) {
                                                if ($start_date != "" && $end_date != "") {
                                                    require_once("../apis/Connection.php");
                                                    $connection = new Connection();
                                                    $conn = $connection->getConnection();
                                                    // $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                                    $get_content = "SELECT * FROM pathology_investigation_test left join pathology_investigation on pathology_investigation_test.pathology_investigation_test_id = pathology_investigation.pathology_investigation_id WHERE (pathology_investigation_test.pathology_investigation_creation_time BETWEEN '$start_date' AND '$end_date') AND (pathology_investigation_test.pathology_investigation_test_pathology_test_id = '$pathology_test[pathology_test_id]') AND (pathology_investigation.pathology_investigation_indoor_treatment_id IS NULL)";
                                                    // echo $get_content;
                                                    $getJson = $conn->prepare($get_content);
                                                    $getJson->execute();
                                                    $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                                    $total_bill = 0;
                                                    // $total_discount = 0;
                                                    $total_payment = 0;
                                                    $total_due = 0;

                                                    if (count($pharmacy_sells) > 0) {
                                                        foreach ($pharmacy_sells as $pharmacy_sell) {
                                                            $total_bill += (int)$pharmacy_sell['pathology_investigation_test_total_bill'];
                                                        }
                                                        echo '<tr class="main_row">
                                                            <td>' . $pathology_test['pathology_test_name'] . '
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>' . $total_bill . '</td>

                                                        </tr>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>


                                    </tbody>
                                </table>

                                <h3 style="text-align: center; margin-bottom: 20px;background: lightyellow;">INDOOR REPORT</h3>
                                <table class="Report_table" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td style="width: 40%;">Details</td>
                                            <td>QTY</td>
                                            <td>Per Unit</td>
                                            <td>Issue Date</td>
                                            <td>Bill</td>
                                            <td>Discount</td>
                                            <td>Payment</td>
                                            <td>Due</td>
                                            <td>Total</td>
                                            <!-- <td>Action</td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($start_date != "" && $end_date != "") {
                                            require_once("../apis/Connection.php");
                                            $connection = new Connection();
                                            $conn = $connection->getConnection();
                                            // $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                            $get_content = "SELECT * FROM indoor_treatment WHERE (indoor_treatment_creation_time BETWEEN '$start_date' AND '$end_date')";
                                            // echo $get_content;
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $total_bill = 0;
                                            // $total_discount = 0;
                                            $total_payment = 0;
                                            $total_due = 0;

                                            if (count($pharmacy_sells) > 0) {
                                                foreach ($pharmacy_sells as $pharmacy_sell) {
                                                    $total_bill += (int)$pharmacy_sell['indoor_treatment_total_bill_after_discount'];
                                                    echo '<tr class="main_row">
                                                            <td>' . $pharmacy_sell['indoor_treatment_admission_id'] . '
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>' . (int)$pharmacy_sell['indoor_treatment_total_bill_after_discount'] . '</td>

                                                        </tr>';
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
            </div>
            <div>





            </div>
            <?php include 'footer.php'
            ?>
</body>


</html>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById("printD").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }
</script>