<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
?>
<?php include 'header.php';
$totoal_bill = 0;
$total_paid = 0;
$total_advance = 0;
$total_discount = 0;
$total_exemption = 0;
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
                        <div class="widget-area-2 proclinic-box-shadow text-600">
                            <!-- <h3 class="widget-title">Patient Release</h3> -->
                            <!-- Widget Item -->
                            <!-- <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="indoor_Allotment multiCollapseExample2">Close all</button>
                            </p> -->
                            <?php
                            require_once("../apis/Connection.php");
                            $connection = new Connection();
                            $conn = $connection->getConnection();
                            $indoor_treatment_id = $_GET['indoor_treatment_id'];
                            $get_content = "select * from indoor_treatment inner join patient on patient.patient_id = indoor_treatment.indoor_treatment_patient_id where indoor_treatment_id='$indoor_treatment_id'";
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $indoor_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                            // Indoor payment from bill
                            $indoor_treatment_id = $_GET['indoor_treatment_id'];
                            $get_content = "select * from indoor_treatment_payment where indoor_treatment_payment_treatment_id='$indoor_treatment_id'";
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $indoor_payments = $getJson->fetchAll(PDO::FETCH_ASSOC);
                            // print_r($indoor_patient);

                            if (count($indoor_payments) > 0) {
                                foreach ($indoor_payments as $payment) {
                                    $total_paid += (int)$payment['indoor_treatment_payment_amount'];
                                    if ($payment['indoor_treatment_payment_released'] == "0") {
                                        $total_advance += (int)$payment['indoor_treatment_payment_amount'];
                                    }
                                }
                            }

                            // Indoor payment from admission
                            $indoor_treatment_id = $_GET['indoor_treatment_id'];
                            $get_content = "select * from indoor_treatment where indoor_treatment_id='$indoor_treatment_id'";
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $indoor_payments_treatments = $getJson->fetchAll(PDO::FETCH_ASSOC);
                            // print_r($indoor_patient);

                            if (count($indoor_payments_treatments) > 0) {
                                foreach ($indoor_payments_treatments as $indoor_payments_treatment) {
                                    $total_paid += (int)$indoor_payments_treatment['indoor_treatment_total_paid'];
                                    $total_advance += (int)$indoor_payments_treatment['indoor_treatment_total_paid'];
                                }
                            }

                            // Indoor payment from OT
                            $indoor_treatment_id = $_GET['indoor_treatment_id'];
                            $get_content = "select * from outdoor_treatment where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id' and outdoor_treatment_outdoor_service_Category='OT'";
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $indoor_payments_ots = $getJson->fetchAll(PDO::FETCH_ASSOC);
                            // print_r($indoor_patient);
                            $total_discount += (int)$indoor_patient[0]['indoor_treatment_discount'];
                            $total_exemption += (int)$indoor_patient[0]['indoor_treatment_exemption'];

                            if (count($indoor_payments_ots) > 0) {
                                foreach ($indoor_payments_ots as $indoor_payments_ot) {
                                    $total_paid += (int)$indoor_payments_ot['outdoor_treatment_total_paid'];
                                    $total_advance += (int)$indoor_payments_ot['outdoor_treatment_total_paid'];
                                }
                            }

                            ?>
                            <button class="btn btn-primary mx-1px text-95" style="float: right;" onclick="print_invoice();">
                                <i class="mr-1 fa fa-print text-white-m1 text-120 w-2"></i>
                                Print
                            </button>

                            <div id="print_invoice">
                                <div class="row ">
                                    <div class="col-12  justify-content-center">
                                        <div class="float-left">
                                            <img class="center" src="../assets/images/logo.png" style="height: 60px; display: block; margin-left: auto; margin-right: auto;" alt="logo" class="logo-default">
                                        </div>

                                        <div class=" text-center text-600">
                                            <p style="font-size: 18px; margin:0px; padding:0px;">MOMTAJ TRAUMA CENTER</p>
                                            <p style="font-size: 14px; margin:0px; padding:0px;">House #56, Road #03, Dhaka Real State, Kaderabad housing,Mohammadpur, Dhaka-1207</p>
                                            <p style="font-size: 14px; margin:0px; padding:0px;">For Serial: +88 01844080671 , +88 028101496, +88 01844 080 675, +88 01844 080 676</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center" style="margin-top: 10px;">
                                    <h4 style="display: inline;border: 1px solid black;padding: 5px 20px;margin-top: 15px;margin-left: 10px;"><?php echo $indoor_patient[0]['indoor_treatment_released'] == 0 ? "Draft Bill" : "Final Bill" ?></h4>
                                </div>
                                <div class="row  mt-4 mb-4">
                                    <div class="col-md-8">
                                        <p class="mb-0">Patient Name : <?php echo $indoor_patient[0]['patient_name'] ?></p>
                                        <p class="mb-0">Patient ID : <?php echo $indoor_patient[0]['patient_id'] ?></p>
                                        <p class="mb-0">Patient Age : <?php echo $indoor_patient[0]['patient_age'] ?></p>
                                        <!-- <p class="mb-0">Consultant Name : <?php echo $indoor_patient[0]['patient_id'] ?></p> -->
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p class="mb-0">Admission ID : <?php echo $indoor_patient[0]['indoor_treatment_admission_id'] ?></p>
                                        <p class="mb-0">Admission Date : <?php echo date("m/d/Y", strtotime($indoor_patient[0]['indoor_treatment_creation_time'])) ?></p>
                                        <p class="mb-0">Bill up to Date : <?php echo isset($indoor_patient[0]['indoor_treatment_modification_time']) ? date("m/d/Y", strtotime($indoor_patient[0]['indoor_treatment_modification_time'])) : date("m/d/Y", strtotime($indoor_patient[0]['indoor_treatment_creation_time']))  ?></p>
                                    </div>
                                </div>

                                <table class="Report_table border" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <!-- <td>Invoice</td> -->
                                            <td style="width: 70%;">Details</td>
                                            <td>Qty</td>
                                            <td>Per Unit</td>
                                            <td class="text-right">Total Amount</td>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <!-- Indoor Admission report -->
                                        <?php
                                        $bill = 0;
                                        $qty = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from indoor_treatment_admission where indoor_treatment_id='$indoor_treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_admissions = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_admissions) > 0) {
                                            foreach ($indoor_treatment_admissions as $indoor_treatment_admission) {
                                                $bill += (int)$indoor_treatment_admission['outdoor_service_rate'];
                                                $qty += 1;
                                                echo '
                                                <tr class="main_row">
                                                <td>Admission Fee</td>
                                                <td> ' . $qty . ' </td>
                                                    <td>' . $indoor_treatment_admission['outdoor_service_rate'] . ' </td>
                                                    <td class="text-right">' . $indoor_treatment_admission['outdoor_service_rate'] . '</td>
                                                </tr>';
                                            }

                                            $totoal_bill += $bill;
                                        }
                                        ?>

                                        <!-- Indoor bed report -->
                                        <?php
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from indoor_treatment_bed inner join indoor_bed on indoor_bed.indoor_bed_id
                                        = indoor_treatment_bed.indoor_treatment_bed_bed_id where indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_beds = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_beds) > 0) {
                                            foreach ($indoor_treatment_beds as $indoor_treatment_bed) {
                                                $start = strtotime($indoor_treatment_bed['indoor_treatment_bed_entry_time']);
                                                $end = strtotime($indoor_treatment_bed['indoor_treatment_bed_discharge_time']);

                                                $days_between = ceil(abs($end - $start) / 86400);

                                                echo '
                                                <tr class="main_row">
                                                <td>' . $indoor_treatment_bed['indoor_treatment_bed_category_name'] . ' (' . $indoor_treatment_bed['indoor_bed_name'] . ')' . '    ' . date("M d, Y", strtotime($indoor_treatment_bed['indoor_treatment_bed_entry_time'])) . '  - ' . date("M d, Y", strtotime($indoor_treatment_bed['indoor_treatment_bed_discharge_time'])) . '</td>
                                                <td> ' . $days_between . ' </td>
                                                    <td>' . $indoor_treatment_bed['indoor_bed_price'] . '</td>
                                                    <td class="text-right">' . $indoor_treatment_bed['indoor_treatment_bed_total_bill'] . '</td>
                                                </tr>';
                                            }
                                            $totoal_bill += (int)$indoor_treatment_bed['indoor_treatment_bed_total_bill'];
                                        }
                                        ?>


                                        <!-- Indoor Doctor report -->
                                        <?php
                                        $bill = 0;
                                        $qty = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from indoor_treatment_doctor inner join doctor on doctor.doctor_id
                                        = indoor_treatment_doctor.indoor_treatment_doctor_doctor_id where indoor_treatment_doctor_treatment_id='$indoor_treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_doctors = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_doctors) > 0) {
                                            foreach ($indoor_treatment_doctors as $indoor_treatment_doctor) {
                                                $bill += (int)$indoor_treatment_doctor['indoor_treatment_doctor_total_bill'];
                                                $start = strtotime($indoor_treatment_doctor['indoor_treatment_doctor_entry_time']);
                                                $end = strtotime($indoor_treatment_doctor['indoor_treatment_doctor_discharge_time']);

                                                $days_between = ceil(abs($end - $start) / 86400);
                                                $qty += $days_between;
                                                echo '
                                                <tr class="main_row">
                                                <td>' . $indoor_treatment_doctor['doctor_name'] . ' (' . $indoor_treatment_doctor['doctor_specialization'] . ')</td>
                                                <td>' . $days_between . ' </td>
                                                    <td> - </td>
                                                    <td class="text-right">' . $indoor_treatment_doctor['indoor_treatment_doctor_total_bill'] . '</td>
                                                </tr>';
                                            }

                                            $totoal_bill += $bill;
                                        }
                                        ?>

                                        <!-- Indoor Service report Investigation-->
                                        <?php
                                        $bill = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from outdoor_treatment  where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id' and outdoor_treatment_outdoor_service_Category='Investigation/Test'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_services) > 0) {
                                            foreach ($indoor_treatment_services as $indoor_treatment_service) {
                                                $bill += (int)$indoor_treatment_service['outdoor_treatment_total_due'];
                                            }
                                            if ($bill > 0) {
                                                echo '
                                                <tr class="main_row">
                                                <td>Investigation</td>
                                                <td> - </td>
                                                    <td> - </td>
                                                    <td class="text-right">' . $bill . '</td>
                                                </tr>';

                                                $totoal_bill += $bill;
                                            }
                                        }
                                        ?>

                                        <!-- Indoor Service report Procedures-->
                                        <?php
                                        $bill = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from outdoor_treatment  where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id' and outdoor_treatment_outdoor_service_Category='Procedures'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_services) > 0) {
                                            foreach ($indoor_treatment_services as $indoor_treatment_service) {
                                                $bill += (int)$indoor_treatment_service['outdoor_treatment_total_due'];
                                            }
                                            if ($bill > 0) {
                                                echo '
                                                <tr class="main_row">
                                                <td>Procedures</td>
                                                <td> - </td>
                                                    <td> - </td>
                                                    <td class="text-right">' . $bill . '</td>
                                                </tr>';

                                                $totoal_bill += $bill;
                                            }
                                        }
                                        ?>

                                        <!-- Indoor Service report Physiotherapy-->
                                        <?php
                                        $bill = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from outdoor_treatment  where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id' and outdoor_treatment_outdoor_service_Category='Physiotherapy'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_services) > 0) {
                                            foreach ($indoor_treatment_services as $indoor_treatment_service) {
                                                $bill += (int)$indoor_treatment_service['outdoor_treatment_total_due'];
                                            }
                                            if ($bill > 0) {
                                                echo '
                                                <tr class="main_row">
                                                <td>Physiotherapy</td>
                                                <td> - </td>
                                                    <td> - </td>
                                                    <td class="text-right">' . $bill . '</td>
                                                </tr>';

                                                $totoal_bill += $bill;
                                            }
                                        }
                                        ?>

                                        <!-- Indoor Service report Doctor Visit-->
                                        <?php
                                        $bill = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from outdoor_treatment  where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id' and outdoor_treatment_outdoor_service_Category='Doctor Visit'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_treatment_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($indoor_treatment_services) > 0) {
                                            foreach ($indoor_treatment_services as $indoor_treatment_service) {
                                                $bill += (int)$indoor_treatment_service['outdoor_treatment_total_due'];
                                            }
                                            if ($bill > 0) {
                                                echo '
                                                <tr class="main_row">
                                                <td>Doctor Visit</td>
                                                <td> - </td>
                                                    <td> - </td>
                                                    <td class="text-right">' . $bill . '</td>
                                                </tr>';

                                                $totoal_bill += $bill;
                                            }
                                        }
                                        ?>

                                        <!-- Indoor Service report OT-->
                                        <?php

                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from outdoor_service  where outdoor_service_Category='OT'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $OT_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);

                                        foreach ($OT_services as $OT_service) {
                                            // $bill += (int)$indoor_treatment_service['outdoor_treatment_total_due'];
                                            $bill = 0;
                                            $qty = 0;
                                            $service_id = $OT_service['outdoor_service_id'];
                                            $get_content = "select * from outdoor_treatment inner join outdoor_treatment_service on  outdoor_treatment.outdoor_treatment_id =  outdoor_treatment_service.outdoor_treatment_service_treatment_id where outdoor_treatment_service.outdoor_treatment_service_service_id='$service_id' and outdoor_treatment_indoor_treatment_id='$indoor_treatment_id'";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            if (count($services) > 0) {
                                                foreach ($services as $service) {
                                                    $bill += (int)$service['outdoor_treatment_service_service_total'];
                                                    $qty += (int)$service['outdoor_treatment_service_service_quantity'];
                                                }
                                                if ($bill > 0) {
                                                    echo '
                                                        <tr class="main_row">
                                                        <td>' . $OT_service['outdoor_service_name'] . '</td>
                                                        <td>' . $qty . ' </td>
                                                            <td> ' . $OT_service['outdoor_service_rate'] . ' </td>
                                                            <td class="text-right">' . $bill . '</td>
                                                        </tr>';

                                                    $totoal_bill += $bill;
                                                }
                                            }
                                        }


                                        ?>



                                        <?php
                                        $bill = 0;
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from pharmacy_sell where pharmacy_sell_indoor_treatment_id='$indoor_treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($pharmacy_sells);
                                        if (count($pharmacy_sells) > 0) {
                                            foreach ($pharmacy_sells as $pharmacy_sell) {
                                                // $last_bed_name = $bed['indoor_bed_name'];
                                                if ($pharmacy_sell['pharmacy_sell_due_amount'] > 0) {
                                                    $bill += (int)$pharmacy_sell['pharmacy_sell_due_amount'];
                                                }
                                            }
                                            if ($bill > 0) {
                                                echo '
                                    <tr class="main_row">
                                        <td>Medicine Bill</td>
                                        <td>-</td>
                                        
                                        <td>-</td>
                                        
                                        
                                        <td class="text-right">' . $pharmacy_sell['pharmacy_sell_due_amount'] . '</td>
                                        
                                        
                                    </tr>';
                                            }
                                            $totoal_bill += (int)$pharmacy_sell['pharmacy_sell_due_amount'];
                                            // $total_paid += (int)$pharmacy_sell['pharmacy_sell_paid_amount'];
                                        }


                                        ?>


                                    </tbody>
                                </table>
                                <table style="width: 100%;" class="border-top mb-3 Report_table">
                                    <tr class="main_row">
                                        <td style="width: 40%;"></td>
                                        <td style="width: 20%;"></td>
                                        <td class="text-center border " style="width: 25%;">Gross Amount</td>
                                        <td class="text-right border "><?php echo $totoal_bill ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Discount</td>
                                        <td class="text-right border "><?php echo $total_discount ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Advance</td>
                                        <!-- <td class="text-right border "><?php echo  $total_paid  ?></td> -->
                                        <td class="text-right border "><?php echo  $total_advance  ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Exemption</td>
                                        <td class="text-right border "><?php echo $total_exemption ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Net Payable Amount</td>
                                        <?php if ($indoor_patient[0]['indoor_treatment_released'] != 0) { ?>
                                            <td class="text-right border "><?php echo  isset($indoor_payments[count($indoor_payments) - 1]["indoor_treatment_payment_amount"]) ? $indoor_payments[count($indoor_payments) - 1]["indoor_treatment_payment_amount"] : 0  ?></td>
                                        <?php } else { ?>
                                            <td class="text-right border ">0</td>
                                        <?php } ?>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Net Due Amount</td>
                                        <td class="text-right border "><?php echo ($totoal_bill - $total_paid - $total_discount - $total_exemption)  ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <form class="form-horizontal form-material mb-0" id="patient_release" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="indoor_treatment_id" value="<?php echo $_GET['indoor_treatment_id']; ?>">
                                    <!-- <input type="hidden" name="indoor_treatment_released" value="0"> -->
                                    <input type="hidden" name="content" value="indoor_allotment">
                                    <?php if ($indoor_patient[0]['indoor_treatment_released'] == 0) {
                                        echo '
                                            <button type="submit" class="btn btn-success" style="margin-top: -60px;">
                                        
                                        Release Patient
                                    </button>';
                                    } else {
                                        echo '<h1 style="margin-top: -60px;">Released</h1>';
                                    }
                                    ?>
                                </form>
                            </div>




                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget-area-2 proclinic-box-shadow" style="margin-right: 0px">
                            <h5>Bill Payment</h5>

                            <form class="form-horizontal form-material mb-0" id="indoor_treatment_payment" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="indoor_treatment_payment_treatment_id" value="<?php echo $_GET['indoor_treatment_id']; ?>">
                                <input type="hidden" name="content" value="indoor_payment">
                                <input type="hidden" name="indoor_treatment_payment_released" value="<?php echo $indoor_patient[0]['indoor_treatment_released']; ?>">
                                <div class="form-group">
                                    <label for="indoor_treatment_payment_details">Payment Details</label>
                                    <textarea placeholder="Details" class="form-control" id="indoor_treatment_payment_details" name="indoor_treatment_payment_details" required></textarea>
                                </div>
                                <div class=" form-group ">
                                    <label for=" indoor_treatment_payment_amount">Amount</label>
                                    <input type="numbera" placeholder="Amount" class="form-control" id="indoor_treatment_payment_amount" name="indoor_treatment_payment_amount" required>
                                </div>
                                <div class="form-group  mb-3">
                                    <button type="submit" class="btn btn-success ">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget-area-2 proclinic-box-shadow" style="margin-left: 0px">
                            <h5>Discount and Exemption</h5>

                            <form class="form-horizontal form-material mb-0" id="indoor_treatment_discount" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="indoor_treatment_id" value="<?php echo $_GET['indoor_treatment_id']; ?>">
                                <input type="hidden" name="content" value="indoor_allotment">
                                <div class=" form-group ">
                                    <label for=" indoor_treatment_discount">Discount</label>
                                    <input type="numbera" placeholder="Amount" class="form-control" id="indoor_treatment_discount" name="indoor_treatment_discount" value="<?php echo $indoor_patient[0]['indoor_treatment_discount'] ?>">
                                </div>
                                <div class=" form-group ">
                                    <label for=" indoor_treatment_exemption">Exemption</label>
                                    <input type="numbera" placeholder="Amount" class="form-control" id="indoor_treatment_exemption" name="indoor_treatment_exemption" value="<?php echo $indoor_patient[0]['indoor_treatment_exemption'] ?>">
                                </div>
                                <div class="form-group  mb-3">
                                    <button type="submit" class="btn btn-success ">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget-area-2 proclinic-box-shadow" style="margin-left: 0px">
                            <button class="btn btn-primary mx-1px text-95" onclick="print_history();">
                                <i class="mr-1 fa fa-print text-white-m1 text-120 w-2"></i>
                                Print
                            </button>
                            <div id="print_history">


                                <div class="row  mt-2 mb-4">
                                    <div class="col-md-5">
                                        <p class="mb-0">Patient Name : <?php echo $indoor_patient[0]['patient_name'] ?></p>
                                        <p class="mb-0">Patient ID : <?php echo $indoor_patient[0]['patient_id'] ?></p>
                                        <p class="mb-0">Patient Age : <?php echo $indoor_patient[0]['patient_age'] ?></p>
                                        <!-- <p class="mb-0">Consultant Name : <?php echo $indoor_patient[0]['patient_id'] ?></p> -->
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <p class="mb-0">Admission ID : <?php echo $indoor_patient[0]['indoor_treatment_admission_id'] ?></p>
                                        <p class="mb-0">Admission Date : <?php echo date("m/d/Y", strtotime($indoor_patient[0]['indoor_treatment_creation_time'])) ?></p>
                                        <p class="mb-0">Bill up to Date : <?php echo isset($indoor_patient[0]['indoor_treatment_modification_time']) ? date("m/d/Y", strtotime($indoor_patient[0]['indoor_treatment_modification_time'])) : date("m/d/Y", strtotime($indoor_patient[0]['indoor_treatment_creation_time']))  ?></p>
                                    </div>
                                </div>
                                <table class="Report_table border mb-4 p-4" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <td>Payment history</td>
                                            <td>Date</td>
                                            <td class="text-right">Amount</td>
                                            <td class="text-right">Receipt</td>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (count($indoor_payments) > 0) {
                                        foreach ($indoor_payments as $payment) {
                                            echo '<tr class="main_row">
                                    <td>' . $payment["indoor_treatment_payment_details"] . '</td>
                                    <td>' . $payment["indoor_treatment_payment_creation_time"] . '</td>
                                    <td class="text-right">' . $payment["indoor_treatment_payment_amount"] . '</td>
                                    <td class="text-center"> <a href="money_receipt.php?indoor_treatment_payment_id=' . $payment["indoor_treatment_payment_id"] . '"><i class="ti ti-receipt" style="font-size:24px"></i>
                                     </a>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<a href="" onclick="delete_data(' . $payment["indoor_treatment_payment_id"] . ');"><i class="ti ti-close" style="font-size:20px; color: red;"></i></a>';
                                            }

                                            echo '</td>
                                </tr>';
                                        }
                                    }
                                    ?>
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

<script>
    var spinner = $('#loader');

    function delete_data(indoor_treatment_payment_id) {


        if (confirm('Are you sure you want to Delete This Payment?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_indoor_bill_payment.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    indoor_treatment_payment_id: indoor_treatment_payment_id,
                    content: "indoor_treatment_payment"
                },
                success: function(response) {
                    // alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    // alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        location.reload();
                        // window.open("patient_treatment_list.php", "_self");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    spinner.hide();
                    alert("alert : " + errorThrown);
                }
            });
        } else {
            // Do nothing!
            console.log('Said No');
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('form#indoor_treatment_payment').on('submit', function(event) {
            // alert("payment");

            if (confirm('Are you sure you want to add  Payment?')) {
                spinner.show();
                event.preventDefault();
                var formData = new FormData(this);
                var currentdate = new Date();
                var datetime = currentdate.getDate().toString() +
                    (currentdate.getMonth() + 1).toString() +
                    currentdate.getFullYear().toString() +
                    currentdate.getHours().toString() +
                    currentdate.getMinutes().toString() +
                    currentdate.getSeconds().toString();
                console.log(datetime);
                formData.append('outdoor_treatment_invoice_id', datetime);

                $.ajax({
                    url: '../apis/create_indoor_payment.php',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        // spinner.hide();
                        var obj = JSON.parse(data);
                        // alert(obj.message);
                        // console.log(obj);
                        if (obj.status) {
                            // location.reload();
                            window.open("money_receipt.php?indoor_treatment_payment_id=" + obj.outdoor_service_id, "_self");

                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("alert : " + errorThrown);
                        spinner.hide();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        });


        $('form#patient_release').on('submit', function(event) {
            if (confirm('Are you sure you want to release this patient?')) {
                spinner.show();
                event.preventDefault();

                var formData = new FormData(this);
                formData.append('indoor_treatment_released', 1);
                // alert("release");
                $.ajax({
                    url: '../apis/update_indoor_patient_allotment_release.php',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        // alert("success");
                        //alert(data);
                        // console.log(data);
                        // alert(data);
                        // spinner.hide();
                        alert("Patient released Successfully");
                        location.reload();
                        // var obj = JSON.parse(data);
                        // alert(obj.message);
                        // //alert(obj.status);
                        // if (obj.status) {
                        //     // alert("Patient released Successfully");

                        //     // window.open("admission_invoice.php?indoor_treatment_id=" + obj.indoor_treatment_id, "_self");

                        // }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("alert : " + errorThrown);
                        // spinner.hide();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });


        $('form#indoor_treatment_discount').on('submit', function(event) {
            // if (confirm('Are you sure you want to save the discount?')) {
            spinner.show();
            // event.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: '../apis/update_indoor_patient_allotment_discount.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    var obj = JSON.parse(data);
                    alert(obj.message);
                    if (obj.status) {
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("alert : " + errorThrown);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            // }
        });
    });
</script>

<script>
    function print_invoice() {

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head>');
        mywindow.document.write("<link href=\"../assets/css/invoice.css\" rel=\"stylesheet\">");
        mywindow.document.write("<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">");
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('print_invoice').innerHTML);
        mywindow.document.write('</body></html>');
        console.log(mywindow.document);
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 1000)
        return true;
    }
</script>

<script>
    function print_history() {

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head>');
        mywindow.document.write("<link href=\"../assets/css/invoice.css\" rel=\"stylesheet\">");
        mywindow.document.write("<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">");
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('print_history').innerHTML);
        mywindow.document.write('</body></html>');
        console.log(mywindow.document);
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 1000)
        return true;
    }
</script>




</html>