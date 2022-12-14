<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
?>
<?php include 'header.php';
$start_date = "";
$end_date = "";
$outdoor_treatment_consultant = "";
// $end_date = "";
$final_bill = 0;
$final_due = 0;
$final_payment = 0;
$final_discount = 0;
if (isset($_POST["min"])) {
    $start_date = $_POST["min"];
}
if (isset($_POST["max"])) {
    $end_date = $_POST["max"];
}
if (isset($_POST["outdoor_treatment_consultant"])) {
    $outdoor_treatment_consultant = $_POST["outdoor_treatment_consultant"];
}

require_once("../apis/Connection.php");
$connection = new Connection();
$conn = $connection->getConnection();

$get_content = "select * from doctor";
//echo $get_content;
$getJson = $conn->prepare($get_content);
$getJson->execute();
$result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);
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
                                    <div class="form-group col-md-3">
                                        <label for="pharmacy_sell_date">Start Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Selling Date" class="form-control" id="min" name="min" value=<?php echo $start_date ?>>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="pharmacy_sell_date">End Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Selling Date" class="form-control" id="max" name="max" value=<?php echo $end_date ?>>
                                    </div>

                                    <!-- <div class="form-group col-md-3">
                                        <label for="outdoor_treatment_consultant">Consultant Name</label><i class="text-danger"> * </i>
                                        <select id="outdoor_treatment_consultant" class="form-control outdoor_treatment_consultant" name="outdoor_treatment_consultant" placeholder="Pick a Service...">
                                            <option value="">Select Doctor...</option>
                                            <?php
                                            foreach ($result_content_doctor as $data) {
                                                echo '<option value="' . $data['doctor_id'] . '">' . $data['doctor_name'] . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div> -->
                                    <div class="col-md-3 text-right mt-4">
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

                                <h3 style="text-align: center; margin-bottom: 20px;background: lightyellow;">INDOOR REPORT</h3>



                                <?php

                                if ($start_date != "" && $end_date != "") {

                                    // $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    if ($outdoor_treatment_consultant > 0) {
                                        $get_content = "SELECT * FROM indoor_treatment_payment LEFT JOIN indoor_treatment on indoor_treatment.indoor_treatment_id=indoor_treatment_payment.indoor_treatment_payment_treatment_id WHERE (indoor_treatment_payment_creation_time BETWEEN '$start_date' AND '$end_date') AND (outdoor_treatment_consultant = '$outdoor_treatment_consultant')";
                                    } else {
                                        $get_content = "SELECT * FROM indoor_treatment_payment LEFT JOIN indoor_treatment on indoor_treatment.indoor_treatment_id=indoor_treatment_payment.indoor_treatment_payment_treatment_id WHERE (indoor_treatment_payment_creation_time BETWEEN '$start_date' AND '$end_date') ORDER BY indoor_treatment_payment_creation_time ASC";
                                    }
                                    // echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    $total_bill = 0;
                                    $total_discount = 0;
                                    $total_payment = 0;
                                    $total_due = 0; ?>
                                    <h4 class="text-center">Advance Collection</h4>
                                    <table class="Report_table" id="datatable_report_doctor_visit" style="width: 100%;">
                                        <thead>
                                            <tr>

                                                <!-- <td style="width: 40%;">Doctor Visit Details</td> -->
                                                <td>Payment Details</td>

                                                <td>Issue Date</td>


                                                <td style="text-align: right;">Payment</td>
                                                <!-- <td>Action</td> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (count($pharmacy_sells) > 0) {
                                                foreach ($pharmacy_sells as $pharmacy_sell) {
                                                    if ($pharmacy_sell['indoor_treatment_payment_released'] != "1") {
                                                        $total_bill += (int)$pharmacy_sell['indoor_treatment_payment_amount'];
                                                        // $total_discount += (int)$pharmacy_sell['outdoor_treatment_discount_pc'];
                                                        // $total_payment += (int)$pharmacy_sell['outdoor_treatment_total_paid'];
                                                        // $total_due += (int)$pharmacy_sell['outdoor_treatment_total_due'];
                                                        $sell_Date = date("m/d/Y", strtotime($pharmacy_sell['indoor_treatment_payment_creation_time']));
                                                        echo '<tr class="main_row">
                                                            
                                                            <td>' . $pharmacy_sell['indoor_treatment_payment_details'] . ' from Admission id : ' . $pharmacy_sell['indoor_treatment_admission_id'] . '</td>
                                                            
                                                            <td>' . $sell_Date . '</td>
                                                            
                                                            <td style="text-align: right;">' . (int)$pharmacy_sell['indoor_treatment_payment_amount'] . '</td>

                                                        </tr>';
                                                    }
                                                }
                                                echo '
                                                <tr class="footer_row">
                                                    <td> Total
                                                    </td>
                                                    <td></td>
                                                   
                                                    <td style="text-align: right;">' . $total_bill . '</td>

                                                </tr>';
                                                $final_bill += $total_bill;
                                                $final_payment += $total_payment;
                                                $final_due += $total_due;
                                                $final_discount += $total_discount;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- <div id="footer_doctor_visit"></div> -->
                                    <div style="min-height: 40px"></div>
                                    <?php

                                    $total_bill = 0;
                                    $total_discount = 0;
                                    $total_payment = 0;
                                    $total_due = 0;
                                    ?>
                                    <h4 class="text-center">Release Collection</h4>
                                    <table class="Report_table" id="datatable_report_doctor_visit" style="width: 100%;">
                                        <thead>
                                            <tr>

                                                <!-- <td style="width: 40%;">Doctor Visit Details</td> -->
                                                <td>Payment Details</td>

                                                <td>Issue Date</td>


                                                <td style="text-align: right;">Payment</td>
                                                <!-- <td>Action</td> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (count($pharmacy_sells) > 0) {
                                                foreach ($pharmacy_sells as $pharmacy_sell) {
                                                    if ($pharmacy_sell['indoor_treatment_payment_released'] == "1") {
                                                        $total_bill += (int)$pharmacy_sell['indoor_treatment_payment_amount'];
                                                        // $total_discount += (int)$pharmacy_sell['outdoor_treatment_discount_pc'];
                                                        // $total_payment += (int)$pharmacy_sell['outdoor_treatment_total_paid'];
                                                        // $total_due += (int)$pharmacy_sell['outdoor_treatment_total_due'];
                                                        $sell_Date = date("m/d/Y", strtotime($pharmacy_sell['indoor_treatment_payment_creation_time']));
                                                        echo '<tr class="main_row">
                                                            
                                                            <td>' . $pharmacy_sell['indoor_treatment_payment_details'] . ' from Admission id : ' . $pharmacy_sell['indoor_treatment_admission_id'] . '</td>
                                                            
                                                            <td>' . $sell_Date . '</td>
                                                            
                                                            <td style="text-align: right;">' . (int)$pharmacy_sell['indoor_treatment_payment_amount'] . '</td>

                                                        </tr>';
                                                    }
                                                }
                                                echo '
                                                <tr class="footer_row">
                                                    <td> Total
                                                    </td>
                                                    <td></td>
                                                   
                                                    <td style="text-align: right;">' . $total_bill . '</td>

                                                </tr>';
                                                $final_bill += $total_bill;
                                                $final_payment += $total_payment;
                                                $final_due += $total_due;
                                                $final_discount += $total_discount;
                                                echo '</tbody>
                                            </table>
                                            <!-- <div id="footer_doctor_visit"></div> -->
                                            <div style="min-height: 40px"></div>';
                                            }


                                            ?>

                                            <h4 style="text-align: center; margin-bottom: 20px;">Total Indoor Collection</h4>
                                            <table style="border: 1px solid gray; width: 100%;">
                                                <tr>
                                                    <td>Total Collection</td>
                                                    <td style="text-align: right;"><?php echo $final_bill ?></td>
                                                </tr>

                                            </table>
                                            <div style="min-height: 40px"></div>





                                        <?php
                                    }

                                        ?>













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
        var x = document.getElementsByClassName("dt-buttons");
        // var y = document.getElementsByClassName("dataTables_filter");
        var i;
        for (i = 0; i < x.length; i++) {
            x[i].style.display = 'none';
            // y[i].style.display = 'none';
        }
        var printContents = document.getElementById("printD").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        for (i = 0; i < x.length; i++) {
            x[i].style.display = 'inline-flex';
            // y[i].style.display = 'block';
        }

    }
</script>