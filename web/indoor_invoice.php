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
                                    $indoor_treatment_id  = $_GET['treatment_id'];
                                    if (!isset($_GET['treatment_id']) || is_null($_GET['treatment_id'])) {
                                        header("Location: https://google.com");
                                        exit();
                                    }
                                    $total_bill = 0;
                                    $discount = 0;
                                    $discounted_amount = 0;
                                    $bill_after_discount = 0;
                                    $paid = 0;
                                    $due = 0;
                                    $request_user_id  = $_SESSION['user_id'];
                                    $get_content_user = "select * from user where user_id = '$request_user_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content_user);
                                    $getJson->execute();
                                    $result_content_user = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                    $get_content = "select * from indoor_treatment as it
                                    left join patient as p on p.patient_id = it.indoor_treatment_patient_id
                                    left join doctor as d on d.doctor_id = it.indoor_treatment_referer_doctor_id
                                    where it.indoor_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_indoor_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    $referer_doctor = $result_content_indoor_treatment[0]['doctor_name'];



                                    $get_content = "select * from indoor_treatment_bed as itb
                                    left join indoor_bed as ib on ib.indoor_bed_id=itb.indoor_treatment_bed_bed_id
                                    where itb.indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_indoor_treatment_bed = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                    $get_content = "select * from indoor_treatment_doctor as itd
                                    left join doctor as d on d.doctor_id = itd.indoor_treatment_doctor_doctor_id
                                    where indoor_treatment_doctor_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_indoor_treatment_doctor= $getJson->fetchAll(PDO::FETCH_ASSOC);

                                    $get_content = "select * from indoor_treatment_service as its
                                    left join outdoor_service as os on os.outdoor_service_id=its.indoor_treatment_service_service_id
                                    where indoor_treatment_service_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_indoor_treatment_service= $getJson->fetchAll(PDO::FETCH_ASSOC);

                                    $get_content = "select * from indoor_pathology_investigation_test as ipit
                                    left join pathology_test as pt on pt.pathology_test_id=ipit.pathology_investigation_test_pathology_test_id
                                    where pathology_investigation_test_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_indoor_treatment_investigation= $getJson->fetchAll(PDO::FETCH_ASSOC);

                                    $get_content = "select * from indoor_pharmacy_sell_medicine AS ipsm
                                    left join pharmacy_medicine pm ON ipsm.indoor_pharmacy_sell_medicine_medicine_id=pm.pharmacy_medicine_id
                                    left join medicine m on pm.pharmacy_medicine_medicine_id = m.medicine_id
                                    where indoor_pharmacy_sell_medicine_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_indoor_treatment_pharmacy_item = $getJson->fetchAll(PDO::FETCH_ASSOC);


                                    $get_content = "select * from ot_treatment_item 
                                    where ot_treatment_item_treatment_id='$indoor_treatment_id'";
                                    //echo $get_content;
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_ot_item = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    $invoice_no = "IPT-002";
                                    $patient_id  = $result_content_indoor_treatment[0]['indoor_treatment_patient_id'];
                                    $invoice_no = $invoice_no . $patient_id . $indoor_treatment_id;
                                    $indoor_treatment_total_bill  = $result_content_indoor_treatment[0]['indoor_treatment_total_bill'];
                                    $indoor_treatment_service_charge  = $result_content_indoor_treatment[0]['indoor_treatment_service_charge'];
                                    $indoor_treatment_discount_pc   = $result_content_indoor_treatment[0]['indoor_treatment_discount_pc'];
                                    $indoor_treatment_total_bill_after_discount  = $result_content_indoor_treatment[0]['indoor_treatment_total_bill_after_discount'];
                                    $indoor_treatment_total_paid  = $result_content_indoor_treatment[0]['indoor_treatment_total_paid'];
                                    $indoor_treatment_total_due  = $result_content_indoor_treatment[0]['indoor_treatment_total_due'];
                                    $indoor_treatment_payment_type   = $result_content_indoor_treatment[0]['indoor_treatment_payment_type'];
                                    $indoor_treatment_payment_type_no  = $result_content_indoor_treatment[0]['indoor_treatment_payment_type_no'];
                                    $indoor_treatment_note   = $result_content_indoor_treatment[0]['indoor_treatment_note'];
                                   
                                    $sub_total_bill = $indoor_treatment_total_bill;
                                    $discount = $indoor_treatment_discount_pc != 0 || $indoor_treatment_discount_pc != '' || $indoor_treatment_discount_pc != null ? $indoor_treatment_discount_pc : 0;
                                    $discounted_amount = $sub_total_bill * $discount / 100;
                                    $bill_after_discount = $indoor_treatment_total_bill_after_discount;
                                    $paid = $indoor_treatment_total_paid;
                                    $due = $indoor_treatment_total_due != 0 || $indoor_treatment_total_due != '' || $indoor_treatment_total_due != null ? $indoor_treatment_total_due : 0;

                                    $patient_name = $result_content_indoor_treatment[0]['patient_name'];
                                    $patient_phone = $result_content_indoor_treatment[0]['patient_phone'];
                                    $patient_gender = ucwords($result_content_indoor_treatment[0]['patient_gender']);
                                    $patient_age = $result_content_indoor_treatment[0]['patient_age'];

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
                                            <div class="text-grey-m2">
                                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?php echo $patient_phone; ?></b></div>
                                            </div>
                                        </div>
                                        <!-- /.col -->

                                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                            <hr class="d-sm-none" />
                                            <div class="text-grey-m2">
                                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> <?php echo date("M j,Y");?></div>
                                                <?php 
                                                if(!is_null($referer_doctor) || !empty($referer_doctor) || $referer_doctor != '')
                                                {
                                                    echo '<div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Referer Doctor:</span> '.$referer_doctor.'</div>';
                                                }
                                                ?>
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
                                            $serial = 1;
                                            $count_service = 0;
                                            foreach( $result_content_indoor_treatment_bed as $rowservice) {
                                                $bed_name = $rowservice['indoor_bed_name'];
                                                $room_no = $rowservice['indoor_bed_room_no'];
                                                $bed_price  = $rowservice['indoor_bed_price'];
                                                $bed_total_bill = $rowservice['indoor_treatment_bed_total_bill'];   
                                                echo '<div class="row mb-2 mb-sm-0 py-25">
                                                <div class="d-none d-sm-block col-1">'.$serial.'</div>
                                                <div class="col-9 col-sm-5">'.$bed_name .'/'.$room_no.'</div>
                                                <div class="d-none d-sm-block col-2">'.$bed_price.' Tk</div>
                                                <div class="d-none d-sm-block col-2 text-95">'.($bed_total_bill/$bed_price).' Days</div>
                                                <div class="col-2 text-secondary-d2">'.$bed_total_bill.' TK</div>
                                                </div>';
                                                    
                                                $count_service = $count_service + 1;
                                                $serial = $serial + 1;
                                            }
                                            $count_service =0;
                                            foreach($result_content_indoor_treatment_doctor as $rowservice) {
                                                    $doctor_visit_fee  = $rowservice['doctor_visit_fee'];
                                                    $doctor_total_bill  = $rowservice['indoor_treatment_doctor_total_bill'];
                                                    $doctor_name = $rowservice['doctor_name'];
                                                    echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">'.$serial.'</div>
                                                    <div class="col-9 col-sm-5">'.$doctor_name.'</div>
                                                    <div class="d-none d-sm-block col-2">'.$doctor_visit_fee.' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">'.($doctor_total_bill/$doctor_visit_fee).' Days</div>
                                                    <div class="col-2 text-secondary-d2">'.$doctor_total_bill.' TK</div>
                                                    </div>';
                                                    $count_service = $count_service + 1;
                                                    $serial = $serial + 1;
                                            }
                                            $count_service =0;
                                            foreach($result_content_indoor_treatment_service as $rowservice) {
                                                    $service_quantity  = $rowservice['indoor_treatment_service_service_quantity'];
                                                    $service_rate  = $rowservice['outdoor_service_rate'];
                                                    $service_name = $rowservice['outdoor_service_name'];
                                                    $service_total = $rowservice['indoor_treatment_service_service_total'];
                                                    echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">'.$serial.'</div>
                                                    <div class="col-9 col-sm-5">'.$service_name.'</div>
                                                    <div class="d-none d-sm-block col-2">'.$service_rate.' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">'.$service_quantity.'</div>
                                                    <div class="col-2 text-secondary-d2">'.$service_total.' TK</div>
                                                    </div>';
                                                    $count_service = $count_service + 1;
                                                    $serial = $serial + 1;
                                            }
                                            $count_service =0;
                                            foreach($result_content_indoor_treatment_investigation as $rowservice) {
                                                    $test_quantity  = $rowservice['pathology_investigation_test_quantity'];
                                                    $test_price  = $rowservice['pathology_test_price'];
                                                    $test_name = $rowservice['pathology_test_name'];
                                                    $total_bill = $rowservice['pathology_investigation_test_total_bill'];
                                                    echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">'.$serial.'</div>
                                                    <div class="col-9 col-sm-5">'.$test_name.'</div>
                                                    <div class="d-none d-sm-block col-2">'.$test_price.' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">'.$test_quantity.'</div>
                                                    <div class="col-2 text-secondary-d2">'.$total_bill.' TK</div>
                                                    </div>';
                                                    $count_service = $count_service + 1;
                                                    $serial = $serial + 1;
                                            }
                                            $count_service =0;
                                            foreach($result_content_indoor_treatment_pharmacy_item as $rowservice) {
                                                    // print_r($rowservice);
                                                    $item_qty  = $rowservice['indoor_pharmacy_sell_medicine_selling_piece'];
                                                    $pp_price  = $rowservice['indoor_pharmacy_sell_medicine_per_piece_price'];
                                                    $medicine_name = $rowservice['medicine_name'];
                                                    $item_bill = $rowservice['indoor_pharmacy_sell_medicine_total_selling_price'];
                                                    echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">'.$serial.'</div>
                                                    <div class="col-9 col-sm-5">'.$medicine_name .'</div>
                                                    <div class="d-none d-sm-block col-2">'.$pp_price.' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">'.$item_qty.'</div>
                                                    <div class="col-2 text-secondary-d2">'.$item_bill.' TK</div>
                                                    </div>';
                                                    $count_service = $count_service + 1;
                                                    $serial = $serial + 1;
                                            }
                                            $count_service =0;
                                            foreach($result_content_ot_item as $rowservice) {
                                                    $item_qty  = $rowservice['ot_treatment_item_qty'];
                                                    $item_price  = $rowservice['ot_treatment_item_price'];
                                                    $item_name = $rowservice['ot_treatment_item_name'];
                                                    $item_bill = $rowservice['ot_treatment_item_total'];
                                                    echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">'.$serial.'</div>
                                                    <div class="col-9 col-sm-5">'.$item_name .'</div>
                                                    <div class="d-none d-sm-block col-2">'.$item_price.' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">'.$item_qty.'</div>
                                                    <div class="col-2 text-secondary-d2">'.$item_bill.' TK</div>
                                                    </div>';
                                                    $count_service = $count_service + 1;
                                                    $serial = $serial + 1;
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
                                                        <span class="text-120 text-secondary-d1"><?php echo $sub_total_bill; ?> Tk</span>
                                                    </div>
                                                </div>

                                                <div class="row my-2">
                                                    <div class="col-7 text-right">
                                                        Discount (<?php echo $discount; ?>%)
                                                    </div>
                                                    <div class="col-5">
                                                        <span class="text-110 text-secondary-d1"><?php echo $discounted_amount; ?> Tk</span>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-7 text-right">
                                                        Service Charge (10%)
                                                    </div>
                                                    <div class="col-5">
                                                        <span class="text-110 text-secondary-d1"><?php echo $indoor_treatment_service_charge; ?> Tk</span>
                                                    </div>
                                                </div>

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
    
    function print_div()
        {

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

            setTimeout(function () {
            mywindow.print();
            mywindow.close();
            }, 1000)
            return true;
        }
</script>
</html>
