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
            <div class="page-header text-blue-d2">

                <div class="page-tools">
                    <div class="action-buttons">
                        <button class="btn bg-white btn-light mx-1px text-95" onclick="print_div();">
                            <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>
            <div id="print_bill">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Widget Item -->
                        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
                        <link href="../assets/css/invoice.css" rel="stylesheet">

                        <div class="page-content container">

                            <div class="container px-0">
                                <div class="row mt-4">
                                    <div class="col-12 col-lg-10 offset-lg-1">
                                        <div class="row">
                                            <div class="col-12">
                                                <img class="center" src="../assets/images/logo.png" style="height: 100px; display: block; margin-left: auto; margin-right: auto;" alt="logo" class="logo-default">
                                                <div class="text-center text-150">
                                                    <p style="font-size: 20px; margin:0px; padding:0px;">MOMTAJ TRAUMA CENTER</p>
                                                    <p style="font-size: 15px; margin:0px; padding:0px;">House 56(2nd Floor), Road 4 Dhaka Real State, Katasur, Dhaka-1207</p>
                                                    <p style="font-size: 15px; margin:0px; padding:0px;">For Serial: +88 01844080671, +88 01844 080 674, +88 01844 080 676</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .row -->

                                        <hr class="row brc-default-l1 mx-n1 mb-4" />
                                        <?php
                                        require_once("../apis/Connection.php");
                                        require_once("../apis/related_func.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();
                                        $total_bill = 0;
                                        $discount = 0;
                                        $discounted_amount = 0;
                                        $bill_after_discount = 0;
                                        $paid = 0;
                                        $due = 0;
                                        $request_user_id  = $_POST['request_user_id'];
                                        $get_content_user = "select * from user where user_id = '$request_user_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_user = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        if ($_POST['content'] == 'pharmacy_medicine_sell') {
                                            // $invoice_no = "OPT-001";
                                            $pharmacy_sell_id  = $_POST['pharmacy_sell_id'];
                                            $patient_id  = $_POST['pharmacy_sell_patient_id'];
                                            $pharmacy_sell_grand_total  = if_empty($_POST['pharmacy_sell_grand_total']);            
                                            
                                            $total_bill = $pharmacy_sell_grand_total;
                                            $discount = $outdoor_treatment_discount_pc != 0 || $outdoor_treatment_discount_pc != '' || $outdoor_treatment_discount_pc != null ? $outdoor_treatment_discount_pc : 0;
                                            if ($discount > 0) {
                                                $discounted_amount = $total_bill * $discount / 100;
                                            } else {
                                                $discounted_amount = 0;
                                            }

                                            $bill_after_discount = $outdoor_treatment_total_bill_after_discount;
                                            $paid = $outdoor_treatment_total_paid;
                                            $due = $outdoor_treatment_total_due != 0 || $outdoor_treatment_total_due != '' || $outdoor_treatment_total_due != null ? $outdoor_treatment_total_due : 0;

                                            $get_content_user = "select * from pharmacy_sell where pharmacy_sell_id = '$pharmacy_sell_id'";
                                            //echo $get_content;
                                            $getJson = $conn->prepare($get_content_user);
                                            $getJson->execute();
                                            $result_content_pharmacy_sell = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                          
                                            $invoice_no = $result_content_pharmacy_sell[0]['pharmacy_sell_invoice_id'];
                                            $treatment_id = $result_content_pharmacy_sell[0]['pharmacy_sell_indoor_treatment_id'];
                                       
                                        


                                    
                                        }



                                        $get_content = "select * from patient where patient_id = '$patient_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $patient_name = if_empty($result_content_patient[0]['patient_name']);
                                        $patient_phone = if_empty($result_content_patient[0]['patient_phone']);
                                        $patient_gender = if_empty(ucwords($result_content_patient[0]['patient_gender']));
                                        $patient_age = if_empty($result_content_patient[0]['patient_age']);

                                        ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Invoice No:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $invoice_no; ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Prepared By:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $result_content_user[0]['username']; ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Patient Name:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $patient_name; ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Gender:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $patient_gender; ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Age:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $patient_age; ?></span>
                                                </div>
                                                <!-- <div class="text-grey-m2">
                                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600">
                                                    <?php
                                                    // echo $patient_phone; 
                                                    ?>
                                                </b></div>
                                            </div> -->
                                              

                                            </div>
                                            <!-- /.col -->

                                            <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                <hr class="d-sm-none" />
                                                <div class="text-grey-m2">

                                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> <?php echo date("M j,Y"); ?></div>
                                                    <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?php echo $patient_phone; ?></b></div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <div class="mt-4">
                                            <div class="row text-600 text-white bgc-default-tp1 py-25">
                                                <div class="d-none d-sm-block col-1">#</div>
                                                <div class="col-9 col-sm-5">Particulars</div>
                                                <div class="d-none d-sm-block col-4 col-sm-2">Rate</div>
                                                <div class="d-none d-sm-block col-sm-2">Quantity</div>
                                                <div class="col-2">Amount</div>
                                            </div>
                                            <div class="text-95 text-secondary-d3">
                                                <?php
                                                if ($_POST['content'] == 'pharmacy_medicine_sell') {
                                                    $outdoor_service_id = $_POST['outdoor_service_id'];
                                                    $outdoor_service_quantity  = $_POST['outdoor_service_quantity'];
                                                    $outdoor_service_rate  = $_POST['outdoor_service_rate'];
                                                    $outdoor_service_total  = $_POST['outdoor_service_total'];
                                                    $count_service = 0;
                                                    $count_service = 0;
                                                    foreach ($ot_treatment_pharmacy_item_medicine_id as $rowservice) {

                                                        $medicine_id  = $ot_treatment_pharmacy_item_medicine_id[$count_service];
                                                        $get_content = "select * from pharmacy_medicine as pm left join medicine m on pm.pharmacy_medicine_medicine_id = m.medicine_id
                                                     where pharmacy_medicine_id = '$medicine_id'";
                                                        $getJson = $conn->prepare($get_content);
                                                        $getJson->execute();
                                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                                        $medicine_name = $result_content[0]['medicine_name'];

                                                        $batch_id  = $ot_treatment_pharmacy_item_batch_id[$count_service];
                                                        $stock_qty = $ot_treatment_pharmacy_item_stock_qty[$count_service];
                                                        $pp_price = $ot_treatment_pharmacy_item_per_piece_price[$count_service];
                                                        $item_qty = $ot_treatment_pharmacy_item_quantity[$count_service];
                                                        $item_bill = $ot_treatment_pharmacy_item_bill[$count_service];
                                                        $item_note = $ot_treatment_pharmacy_item_note[$count_service];

                                                        if ($medicine_name == '') continue;
                                                        echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">' . $serial . '</div>
                                                    <div class="col-9 col-sm-5">' . $medicine_name . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $pp_price . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">' . $item_qty . '</div>
                                                    <div class="col-2 text-secondary-d2">' . $item_bill . ' TK</div>
                                                    </div>';

                                                        $count_service = $count_service + 1;
                                                        $serial = $serial + 1;
                                                    }
                                                } else if ($_POST['content'] == 'ot_allotment') {
                                                    $ot_treatment_doctor_doctor_id = if_empty($_POST['ot_treatment_doctor_doctor_id']);
                                                    $ot_treatment_doctor_bill   = if_empty($_POST['ot_treatment_doctor_bill']);
                                                    $ot_treatment_doctor_note  = if_empty($_POST['ot_treatment_doctor_note']);

                                                    $ot_treatment_guest_doctor_doctor_name = if_empty($_POST['ot_treatment_guest_doctor_doctor_name']);
                                                    $ot_treatment_guest_doctor_bill  = if_empty($_POST['ot_treatment_guest_doctor_bill']);
                                                    $ot_treatment_guest_doctor_note = if_empty($_POST['ot_treatment_guest_doctor_note']);

                                                    $ot_treatment_item_name = if_empty($_POST['ot_treatment_item_name']);
                                                    $ot_treatment_item_price = if_empty($_POST['ot_treatment_item_price']);
                                                    $ot_treatment_item_note = if_empty($_POST['ot_treatment_item_note']);

                                                    $ot_treatment_pharmacy_item_medicine_id = if_empty($_POST['ot_treatment_pharmacy_item_medicine_id']);
                                                    $ot_treatment_pharmacy_item_batch_id = if_empty($_POST['ot_treatment_pharmacy_item_batch_id']);
                                                    $ot_treatment_pharmacy_item_stock_qty = if_empty($_POST['ot_treatment_pharmacy_item_stock_qty']);
                                                    $ot_treatment_pharmacy_item_per_piece_price = if_empty($_POST['ot_treatment_pharmacy_item_per_piece_price']);
                                                    $ot_treatment_pharmacy_item_quantity = if_empty($_POST['ot_treatment_pharmacy_item_quantity']);
                                                    $ot_treatment_pharmacy_item_bill = if_empty($_POST['ot_treatment_pharmacy_item_bill']);
                                                    $ot_treatment_pharmacy_item_note = if_empty($_POST['ot_treatment_pharmacy_item_note']);

                                                    $serial = 1;
                                                    $count_service = 0;
                                                    foreach ($ot_treatment_doctor_doctor_id as $rowservice) {

                                                        $doctor_id  = $ot_treatment_doctor_doctor_id[$count_service];

                                                        $get_content = "select * from doctor where doctor_id = '$doctor_id'";
                                                        $getJson = $conn->prepare($get_content);
                                                        $getJson->execute();
                                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                                        $doctor_name = $result_content[0]['doctor_name'];

                                                        $bed_name = $result_content[0]['indoor_bed_name'];
                                                        $room_no = $result_content[0]['indoor_bed_room_no'];

                                                        $doctor_bill  = $ot_treatment_doctor_bill[$count_service];
                                                        $doctor_note  = $ot_treatment_doctor_note[$count_service];
                                                        echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">' . $serial . '</div>
                                                    <div class="col-9 col-sm-5">' . $doctor_name . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $doctor_bill . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95"> 1 </div>
                                                    <div class="col-2 text-secondary-d2">' . $doctor_bill . ' TK</div>
                                                    </div>';

                                                        $count_service = $count_service + 1;
                                                        $serial = $serial + 1;
                                                    }
                                                    $count_service = 0;
                                                    foreach ($ot_treatment_guest_doctor_doctor_name as $rowservice) {

                                                        $doctor_name  = $ot_treatment_guest_doctor_doctor_name[$count_service];
                                                        $doctor_bill  = $ot_treatment_guest_doctor_bill[$count_service];
                                                        $doctor_note = $ot_treatment_guest_doctor_note[$count_service];

                                                        if ($doctor_name == '') continue;
                                                        echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">' . $serial . '</div>
                                                    <div class="col-9 col-sm-5">' . $doctor_name . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $doctor_bill . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95"> 1 </div>
                                                    <div class="col-2 text-secondary-d2">' . $doctor_bill . ' TK</div>
                                                    </div>';

                                                        $count_service = $count_service + 1;
                                                        $serial = $serial + 1;
                                                    }
                                                    $count_service = 0;
                                                    foreach ($ot_treatment_item_name as $rowservice) {

                                                        $item_name  = $ot_treatment_item_name[$count_service];
                                                        $item_price  = $ot_treatment_item_price[$count_service];
                                                        $item_note = $ot_treatment_item_note[$count_service];

                                                        if ($item_name == '') continue;
                                                        echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">' . $serial . '</div>
                                                    <div class="col-9 col-sm-5">' . $item_name . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $item_price . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95"> 1 </div>
                                                    <div class="col-2 text-secondary-d2">' . $item_price . ' TK</div>
                                                    </div>';

                                                        $count_service = $count_service + 1;
                                                        $serial = $serial + 1;
                                                    }
                                                    $count_service = 0;
                                                    foreach ($ot_treatment_pharmacy_item_medicine_id as $rowservice) {

                                                        $medicine_id  = $ot_treatment_pharmacy_item_medicine_id[$count_service];
                                                        $get_content = "select * from pharmacy_medicine as pm left join medicine m on pm.pharmacy_medicine_medicine_id = m.medicine_id
                                                     where pharmacy_medicine_id = '$medicine_id'";
                                                        $getJson = $conn->prepare($get_content);
                                                        $getJson->execute();
                                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                                        $medicine_name = $result_content[0]['medicine_name'];

                                                        $batch_id  = $ot_treatment_pharmacy_item_batch_id[$count_service];
                                                        $stock_qty = $ot_treatment_pharmacy_item_stock_qty[$count_service];
                                                        $pp_price = $ot_treatment_pharmacy_item_per_piece_price[$count_service];
                                                        $item_qty = $ot_treatment_pharmacy_item_quantity[$count_service];
                                                        $item_bill = $ot_treatment_pharmacy_item_bill[$count_service];
                                                        $item_note = $ot_treatment_pharmacy_item_note[$count_service];

                                                        if ($medicine_name == '') continue;
                                                        echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">' . $serial . '</div>
                                                    <div class="col-9 col-sm-5">' . $medicine_name . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $pp_price . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">' . $item_qty . '</div>
                                                    <div class="col-2 text-secondary-d2">' . $item_bill . ' TK</div>
                                                    </div>';

                                                        $count_service = $count_service + 1;
                                                        $serial = $serial + 1;
                                                    }
                                                }
                                                ?>
                                            </div>


                                            <div class="row border-b-2 brc-default-l2"></div>

                                            <!-- or use a table instead -->
                                            <!--
                                <div class="table-responsive">
                                    <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                        <thead class="bg-none bgc-default-tp1">
                                            <tr class="text-white">
                                                <th class="opacity-2">#</th>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th width="140">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-95 text-secondary-d3">
                                            <tr></tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Domain registration</td>
                                                <td>2</td>
                                                <td class="text-95">$10</td>
                                                <td class="text-secondary-d2">$20</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                                -->

                                            <div class="row mt-3">
                                                <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">

                                                </div>

                                                <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                                    <div class="row my-2">
                                                        <div class="col-7 text-right">
                                                            SubTotal
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-120 text-secondary-d1"><?php echo $total_bill; ?> Tk</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($discount > 0) {
                                                        echo  '<div class="row my-2">
                                                            <div class="col-7 text-right">
                                                                Discount (  ' . $discount . ' %)
                                                            </div>
                                                        <div class="col-5">
                                                            <span class="text-110 text-secondary-d1">'
                                                            . $discounted_amount . '  Tk.</span>
                                                        </div>
                                                        </div>';
                                                    } else {
                                                        echo    "";
                                                    }



                                                    ?>
                                                    <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                                        <div class="col-7 text-right">
                                                            Total Adjusted Amount
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-150 text-success-d3 opacity-2"><?php echo $bill_after_discount ?> Tk</span>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                                        <div class="col-7 text-right">
                                                            Paid
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-150 text-success-d3 opacity-2"><?php echo $paid ?> Tk</span>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                                        <div class="col-7 text-right">
                                                            Due
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-150 text-success-d3 opacity-2"><?php echo $due ?> Tk</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </br>
                                            </br>
                                            </br>
                                            <div class="row">
                                                <div class="col-sm-6" style="float:left;">
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle">-------------------------------------------</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle">Customer Signature</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle">Date:</span>
                                                    </div>

                                                </div>
                                                <!-- /.col -->

                                                <div class="col-sm-4 offset-sm-2" style="float:right;">
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle" style="text-align:right;">-------------------------------------------</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle">Authority Signature</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle">Date:</span>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <hr />

                                            <div>
                                                <span class="text-secondary-d1 text-105">Thank you for your business</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Widget Item -->
                    </div>
                </div>

            </div>
        </div>

        <?php include 'footer.php'
        ?>
</body>
<script>
    function print_div() {

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head>');
        mywindow.document.write("<link href=\"../assets/css/invoice.css\" rel=\"stylesheet\">");
        mywindow.document.write("<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">");
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('print_bill').innerHTML);
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