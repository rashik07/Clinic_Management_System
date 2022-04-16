<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
?>
<?php include 'header.php'
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
                            <!-- <h3 class="widget-title">Patient Release</h3> -->
                            <!-- Widget Item -->
                            <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="indoor_Allotment multiCollapseExample2">Close all</button>
                            </p>
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
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    $get_content = "select * from indoor_treatment where indoor_treatment_id='$indoor_treatment_id'";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $indoor_allotment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($indoor_allotment);
                                    if (count($indoor_allotment) > 0) {
                                        foreach ($indoor_allotment as $indoor_invoice) {
                                            // $last_bed_name = $bed['indoor_bed_name'];
                                            if ($indoor_invoice['indoor_treatment_discount_pc'] == "") {
                                                $indoor_invoice['indoor_treatment_discount_pc'] = 0;
                                            }
                                            echo '
                                            <tr class="main_row">
                                                <td> 
                                                <a class="" data-toggle="collapse" href="#indoor_Allotment" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Indoor Allotment</a>
                                                <div class="collapse multi-collapse" id="indoor_Allotment">
                                                    <div class="card card-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    </div>
                                                </div>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>' . $indoor_invoice['indoor_treatment_creation_time'] . '</td>
                                                <td>' . $indoor_invoice['indoor_treatment_total_bill'] . '</td>
                                                <td>' . $indoor_invoice['indoor_treatment_discount_pc'] . '%</td>
                                                <td>' . $indoor_invoice['indoor_treatment_total_paid'] . '</td>
                                                <td>' . $indoor_invoice['indoor_treatment_total_due'] . '</td>
                                                <td>' . $indoor_invoice['indoor_treatment_total_bill_after_discount'] . '</td>
                                                <td><a href="edit_indoor_treatment.php?indoor_treatment_id=' . $indoor_treatment_id . '">Update</a></td>
                                            </tr>';

                                            $get_content = "select * from indoor_treatment where indoor_treatment_id='$indoor_treatment_id'";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $indoor_allotment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        }
                                    }
                                    ?>



                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    $get_content = "select * from outdoor_treatment where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id'";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $Services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($Services);
                                    if (count($Services) > 0) {
                                        foreach ($Services as $Service) {
                                            // $last_bed_name = $bed['indoor_bed_name'];
                                            if ($Service['outdoor_treatment_discount_pc'] == "") {
                                                $Service['outdoor_treatment_discount_pc'] = 0;
                                            }
                                            echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a class="" data-toggle="collapse" href="#Services" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Services</a>
                                        <div class="collapse multi-collapse" id="Services">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>' . $Service['outdoor_treatment_creation_time'] . '</td>
                                        <td>' . $Service['outdoor_treatment_total_bill'] . '</td>
                                        <td>' . $Service['outdoor_treatment_discount_pc'] . '%</td>
                                        <td>' . $Service['outdoor_treatment_total_paid'] . '</td>
                                        <td>' . $Service['outdoor_treatment_total_due'] . '</td>
                                        <td>' . $Service['outdoor_treatment_total_bill_after_discount'] . '</td>
                                        <td><a href="edit_patient_treatment.php?outdoor_treatment_id=' . $Service['outdoor_treatment_id'] . '">Update</a></td>
                                    </tr>';
                                        }
                                    } ?>

                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    $get_content = "select * from ot_treatment where ot_treatment_indoor_treatment_id='$indoor_treatment_id'";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $OT = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($Services);
                                    if (count($OT) > 0) {
                                        foreach ($OT as $operation) {
                                            // $last_bed_name = $bed['indoor_bed_name'];
                                            if ($operation['ot_treatment_discount_pc'] == "") {
                                                $operation['ot_treatment_discount_pc'] = 0;
                                            }
                                            echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a class="" data-toggle="collapse" href="#OT" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">OT</a>
                                        <div class="collapse multi-collapse" id="OT">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>' . $operation['ot_treatment_creation_time'] . '</td>
                                        <td>' . $operation['ot_treatment_total_bill'] . '</td>
                                        <td>' . $operation['ot_treatment_discount_pc'] . '%</td>
                                        <td>' . $operation['ot_treatment_total_paid'] . '</td>
                                        <td>' . $operation['ot_treatment_total_due'] . '</td>
                                        <td>' . $operation['ot_treatment_total_bill_after_discount'] . '</td>
                                        <td><a href="edit_ot_treatment.php?ot_treatment_id=' . $operation['ot_treatment_id'] . '">Update</a></td>
                                    </tr>';
                                        }
                                    } ?>

                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    $get_content = "select * from pathology_investigation LEFT JOIN pathology_investigation_test on pathology_investigation.pathology_investigation_id = pathology_investigation_test.pathology_investigation_test_investigation_id
                                    LEFT JOIN pathology_test on pathology_investigation_test.pathology_investigation_test_pathology_test_id = pathology_test.pathology_test_id
                                    where pathology_investigation_indoor_treatment_id='$indoor_treatment_id'";
                                    // echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $pathology_investigation = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($pathology_investigation);
                                    if (count($pathology_investigation) > 0) {
                                        foreach ($pathology_investigation as $investigation) {
                                            // $last_bed_name = $bed['indoor_bed_name'];
                                            if ($investigation['pathology_investigation_discount_pc'] == "") {
                                                $investigation['pathology_investigation_discount_pc'] = 0;
                                            }
                                            echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a class="" data-toggle="collapse" href="#OT" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">' . $investigation['pathology_test_name'] . '</a>
                                        <div class="collapse multi-collapse" id="OT">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>' . $investigation['pathology_investigation_creation_time'] . '</td>
                                        <td>' . $investigation['pathology_investigation_total_bill'] . '</td>
                                        <td>' . $investigation['pathology_investigation_discount_pc'] . '%</td>
                                        <td>' . $investigation['pathology_investigation_total_paid'] . '</td>
                                        <td>' . $investigation['pathology_investigation_total_due'] . '</td>
                                        <td>' . $investigation['pathology_investigation_total_bill_after_discount'] . '</td>
                                        <td><a href="edit_pathology_investigation.php?pathology_investigation_id=' . $investigation['pathology_investigation_id'] . '">Update</a></td>
                                    </tr>';
                                        }
                                    } ?>

                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    $get_content = "select * from pharmacy_sell where pharmacy_sell_indoor_treatment_id='$indoor_treatment_id'";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($pharmacy_sells);
                                    if (count($pharmacy_sells) > 0) {
                                        foreach ($pharmacy_sells as $pharmacy_sell) {
                                            // $last_bed_name = $bed['indoor_bed_name'];
                                            if ($pharmacy_sell['pharmacy_sell_discount'] == "") {
                                                $pharmacy_sell['pharmacy_sell_discount'] = 0;
                                            }
                                            echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a class="" data-toggle="collapse" href="#pharmacy_sell" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Medicine</a>
                                        <div class="collapse multi-collapse" id="pharmacy_sell">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_creation_time'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_sub_total'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_discount'] . '%</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_paid_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_due_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_grand_total'] . '</td>
                                        <td><a href="edit_medicine_sell.php?medicine_sell_id=' . $pharmacy_sell['pharmacy_sell_id'] . '">Update</a></td>
                                    </tr>';
                                        }
                                    } ?>
                                </tbody>
                            </table>


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