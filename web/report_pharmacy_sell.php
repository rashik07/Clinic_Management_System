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
$total_bill = 0;
// $total_discount = 0;
$total_payment = 0;
$total_exemption = 0;
$total_due = 0;
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
                             
                                <h3 style="text-align: center; margin-bottom: 20px;background: lightyellow;">INDOOR REPORT</h3>

                                <table class="Report_table" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td style="width: 40%;">Details</td>
                                            <td>Name</td>
                                            <td>Issue Date</td>
                                            <td>Bill</td>
                                            <td>Discount</td>
                                            <td>Exemption</td>
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
                                            $get_content = "SELECT * FROM `pharmacy_sell` LEFT JOIN patient on pharmacy_sell.pharmacy_sell_patient_id=patient.patient_id WHERE (`pharmacy_sell_date` BETWEEN '$start_date' AND '$end_date') AND (`pharmacy_sell_indoor_treatment_id` > 0) ";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $total_bill = 0;
                                            $total_discount = 0;
                                            $total_exemption= 0;
                                            $total_payment = 0;
                                            $total_due = 0;

                                            if (count($pharmacy_sells) > 0) {
                                                foreach ($pharmacy_sells as $pharmacy_sell) {
                                                    // $last_bed_name = $bed['indoor_bed_name'];
                                                    if ($pharmacy_sell['pharmacy_sell_discount'] == "") {
                                                        $pharmacy_sell['pharmacy_sell_discount'] = 0;
                                                    }
                                                    if (!isset($pharmacy_sell['patient_name'])) {
                                                        $pharmacy_sell['patient_name'] = "-";
                                                    }
                                                    $total_bill += (int)$pharmacy_sell['pharmacy_sell_grand_total'];
                                                    $total_discount += $pharmacy_sell['pharmacy_sell_discount'];
                                                    $total_payment += (int)$pharmacy_sell['pharmacy_sell_paid_amount'];
                                                    $total_exemption+= (int)$pharmacy_sell['pharmacy_selling_exemption'];
                                                    $total_due += (int)$pharmacy_sell['pharmacy_sell_due_amount'];
                                                    $sell_Date = date("m/d/Y", strtotime($pharmacy_sell['pharmacy_sell_creation_time']));

                                                    echo '
                                                
                                    <tr class="main_row">
                     
                                        <td> <a href="medicine_sell_invoice.php?medicine_sell_id='.$pharmacy_sell['pharmacy_sell_id'].'" target="_blank">Invoice no. ' . $pharmacy_sell['pharmacy_sell_invoice_id'] . '</a></td>
                                        <td>' . $pharmacy_sell['patient_name'] . '</td>
                                        <td>' . $sell_Date . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_sub_total'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_discount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_selling_exemption'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_paid_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_due_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_grand_total'] . '</td>
                                        </tr> 
                                       ';
                                                }
                                            }
                                        } ?>


                                    </tbody>
                                </table>
                                <div style="min-height: 40px"></div>
                                <h4 style="text-align: center; margin-bottom: 20px;">Indoor bill</h4>
                                <table style="border: 1px solid gray; width: 100%;">
                                    <tr>
                                        <td>Total Bill</td>
                                        <td style="text-align: right;"><?php echo $total_bill ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Payment</td>
                                        <td style="text-align: right;"><?php echo $total_payment ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Exemption</td>
                                        <td style="text-align: right;"><?php echo $total_exemption ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Due</td>
                                        <td style="text-align: right;"><?php echo $total_due ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td style="text-align: right;"><?php echo $total_discount ?></td>
                                    </tr>

                                </table>
                                <div style="min-height: 80px;"></div>

                                <h3 style="text-align: center;margin-bottom: 20px;background: lightyellow;">OUTDOOR REPORT</h3>

                                <table class="Report_table" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td style="width: 40%;">Details</td>
                                            <td>Name</td>
                                            <td>Issue Date</td>
                                            <td>Bill</td>
                                            <td>Discount</td>
                                            <td>Exemption</td>
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
                                            $get_content = "SELECT * FROM `pharmacy_sell` LEFT JOIN patient on pharmacy_sell.pharmacy_sell_patient_id=patient.patient_id WHERE (`pharmacy_sell_date` BETWEEN '$start_date' AND '$end_date') AND (`pharmacy_sell_indoor_treatment_id` IS NULL) ";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $total_bill = 0;
                                            $total_discount = 0;
                                            $total_exemption= 0;
                                            $total_payment = 0;
                                            $total_due = 0;

                                            if (count($pharmacy_sells) > 0) {
                                                foreach ($pharmacy_sells as $pharmacy_sell) {
                                                    // $last_bed_name = $bed['indoor_bed_name'];
                                                    if ($pharmacy_sell['pharmacy_sell_discount'] == "") {
                                                        $pharmacy_sell['pharmacy_sell_discount'] = 0;
                                                    }
                                                    if (!isset($pharmacy_sell['patient_name'])) {
                                                        $pharmacy_sell['patient_name'] = "-";
                                                    }
                                                    $total_bill += (int)$pharmacy_sell['pharmacy_sell_grand_total'];
                                                    $total_discount += $pharmacy_sell['pharmacy_sell_discount'];
                                                    $total_payment += (int)$pharmacy_sell['pharmacy_sell_paid_amount'];
                                                    $total_exemption+= (int)$pharmacy_sell['pharmacy_selling_exemption'];
                                                    $total_due += (int)$pharmacy_sell['pharmacy_sell_due_amount'];
                                                    $sell_Date = date("m/d/Y", strtotime($pharmacy_sell['pharmacy_sell_creation_time']));
                                                    $sell_Date = date("m/d/Y", strtotime($pharmacy_sell['pharmacy_sell_creation_time']));
                                                    echo '
                                    <tr class="main_row">
                                    <td> <a href="medicine_sell_invoice.php?medicine_sell_id='.$pharmacy_sell['pharmacy_sell_id'].'" target="_blank"> Invoice no. ' . $pharmacy_sell['pharmacy_sell_invoice_id'] . '</a></td>
                                    <td>' . $pharmacy_sell['patient_name'] . '</td>
                                        <td>' . $sell_Date . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_sub_total'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_discount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_selling_exemption'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_paid_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_due_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_grand_total'] . '</td>
                                        </tr>';
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                                <div style="min-height: 40px"></div>
                                <h4 style="text-align: center; margin-bottom: 20px;">Outdoor bill</h4>
                                <table style="border: 1px solid gray; width: 100%;">
                                    <tr>
                                        <td>Total Bill</td>
                                        <td style="text-align: right;"><?php echo $total_bill ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Payment</td>
                                        <td style="text-align: right;"><?php echo $total_payment ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Exemption</td>
                                        <td style="text-align: right;"><?php echo $total_exemption ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Due</td>
                                        <td style="text-align: right;"><?php echo $total_due ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td style="text-align: right;"><?php echo $total_discount ?></td>
                                    </tr>

                                </table>
                                <div style="min-height: 80px;"></div>

                                <h3 style="text-align: center;margin-bottom: 20px;background: lightyellow;">RETURN REPORT</h3>
                                <table class="Report_table" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td style="width: 40%;">Details</td>
                                            <td>Name</td>
                                            <td>Issue Date</td>

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
                                            $get_content = "select *, DATE(pharmacy_sell_return_date) as pharmacy_sell_return_date  from pharmacy_sell_return
                                            left join patient p on p.patient_id = pharmacy_sell_return.pharmacy_sell_return_patient_id WHERE (`pharmacy_sell_return_date` BETWEEN '$start_date' AND '$end_date')  ";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $pharmacy_sells_return = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $total_bill = 0;
                                            // $total_discount = 0;
                                            $total_payment = 0;
                                            $total_due = 0;

                                            if (count($pharmacy_sells_return) > 0) {
                                                foreach ($pharmacy_sells_return as $pharmacy_sells_return) {
                                                    // $last_bed_name = $bed['indoor_bed_name'];

                                                    if (!isset($pharmacy_sells_return['patient_name'])) {
                                                        $pharmacy_sells_return['patient_name'] = "-";
                                                    }
                                                    $total_bill += (int)$pharmacy_sells_return['pharmacy_sell_return_net_price'];
                                                    // $total_discount += $pharmacy_sell['pharmacy_sell_discount'];

                                                    $sell_Date = date("m/d/Y", strtotime($pharmacy_sells_return['pharmacy_sell_return_date']));
                                                    $sell_Date = date("m/d/Y", strtotime($pharmacy_sells_return['pharmacy_sell_return_date']));
                                                    echo '
                                    <tr class="main_row">
                                    <td> <a href="medicine_return_invoice.php?medicine_sell_id='.$pharmacy_sells_return['pharmacy_sell_medicine_sell_id'].'"  target="_blank"> Invoice no. ' . $pharmacy_sells_return['pharmacy_sell_return_invoice_id'] . '</a></td>
                                    <td>' . $pharmacy_sells_return['patient_name'] . '</td>
                                        <td>' . $sell_Date . '</td>
                               
                                        <td>' . $pharmacy_sells_return['pharmacy_sell_return_net_price'] . '</td>
                                        </tr>';
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                                <div style="min-height: 40px"></div>
                                <h4 style="text-align: center; margin-bottom: 20px;">Return bill</h4>
                                <table style="border: 1px solid gray; width: 100%;">
                                    <tr>
                                        <td>Total Bill</td>
                                        <td style="text-align: right;"><?php echo $total_bill ?></td>
                                    </tr>


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