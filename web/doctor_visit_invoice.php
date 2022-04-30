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
                                <div class="row mt-2">
                                    <div class="col-12 col-lg-10 offset-lg-1">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <div>
                                                    <img class="center" src="../assets/images/logo.png" style="height: 100px; display: block; margin-left: auto; margin-right: auto;" alt="logo" class="logo-default">
                                                </div>

                                                <div class="float-end text-right text-150">
                                                    <p style="font-size: 20px; margin:0px; padding:0px;">MOMTAJ TRAUMA CENTER</p>
                                                    <p style="font-size: 15px; margin:0px; padding:0px;">House #56, Road #03, Dhaka Real State, Kaderabad housing,Mohammadpur, Dhaka-1207</p>
                                                    <p style="font-size: 15px; margin:0px; padding:0px;">For Serial: +88 01844080671, +88 01844 080 674, +88 01844 080 676</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .row -->

                                        <hr class="row brc-default-l1 mx-n1 mb-1" />
                                        <?php
                                        require_once("../apis/Connection.php");
                                        require_once("../apis/related_func.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();



                                        $treatment_id  = $_GET['outdoor_treatment_id'];




                                        $get_content_user = "select * from outdoor_treatment  left join patient p on p.patient_id = outdoor_treatment.outdoor_treatment_patient_id left join outdoor_treatment_service ots on ots.outdoor_treatment_service_treatment_id = outdoor_treatment.outdoor_treatment_id left join outdoor_service os on os.outdoor_service_id = ots.outdoor_treatment_service_service_id  where outdoor_treatment_id = '$treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_outdoor_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // var_dump( $result_content_outdoor_treatment);
                                        $outdoor_treatment_consultant = $result_content_outdoor_treatment[0]['outdoor_treatment_consultant'];
                                        $invoice_no = if_empty(
                                            $result_content_outdoor_treatment[0]['outdoor_treatment_invoice_id']
                                        );
                                        $patient_name = $result_content_outdoor_treatment[0]['patient_name'];


                                        $get_content = "select * from doctor where doctor_id = '$outdoor_treatment_consultant'";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $doctor_name = if_empty($result_content[0]['doctor_name']);
                                        $user_id = $result_content_outdoor_treatment[0]['outdoor_treatment_service_user_added_id'];
                                        $get_content_user = "select * from user where user_id = '$user_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_user = $getJson->fetchAll(PDO::FETCH_ASSOC);



                                        ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Invoice No:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo  $invoice_no ?></span>
                                                </div>

                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Patient Name:</span>
                                                    <span class="text-600 text-110 text-blue align-middle">
                                                        <?php
                                                        echo $patient_name;
                                                        ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Gender:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $result_content_outdoor_treatment[0]['patient_gender']; ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Consultant:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $doctor_name ?></span>
                                                </div>




                                            </div>
                                            <!-- /.col -->

                                            <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                <hr class="d-sm-none" />
                                                <div class="text-grey-m2">

                                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> <?php echo date("M j,Y"); ?></div>
                                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Age:</span> <?php echo  $result_content_outdoor_treatment[0]['patient_age']; ?></div>
                                                    <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?php echo  $result_content_outdoor_treatment[0]['patient_phone']; ?></b></div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="row text-600 text-white bgc-default-tp1 py-20">
                                                <div class="d-none d-sm-block col-1">#</div>
                                                <div class="col-9 col-sm-5">Particulars</div>
                                                <div class="d-none d-sm-block col-4 col-sm-2">Rate</div>
                                                <div class="d-none d-sm-block col-sm-2">Quantity</div>
                                                <div class="col-2 text-right">Amount(TK)</div>
                                            </div>
                                            <div class="text-95 text-secondary-d3">
                                                <?php







                                                //   echo $result_content_pharmacy_medicine_sell;

                                                $count_service = 0;
                                                for ($i = 0; $i < count($result_content_outdoor_treatment); $i++) {


                                                    echo '<div class="row mb-2 mb-sm-0 py-20">
                                                    <div class="d-none d-sm-block col-1">' . ($count_service + 1) . '</div>
                                                    <div class="col-9 col-sm-5">' . $result_content_outdoor_treatment[$i]['outdoor_service_name'] . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $result_content_outdoor_treatment[$i]['outdoor_treatment_service_service_rate'] . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">' . $result_content_outdoor_treatment[$i]['outdoor_treatment_service_service_quantity'] . '</div>
                                                    <div class="col-2 text-secondary-d2 text-right">' . $result_content_outdoor_treatment[$i]['outdoor_treatment_service_service_total'] . ' </div>
                                                    </div>';

                                                    $count_service = $count_service + 1;
                                                }

                                                ?>
                                            </div>


                                            <div class="row border-b-2 brc-default-l2"></div>


                                            <div class="row mt-3">
                                                <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">

                                                </div>

                                                <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last ">
                                                    <div class="row my-2">
                                                        <div class="col-7 text-right">
                                                            SubTotal
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <span class="text-120 text-secondary-d1"><?php echo $result_content_outdoor_treatment[0]['outdoor_treatment_total_bill']; ?> </span>
                                                        </div>
                                                    </div>
                                                    <?php

                                                    if ($result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc'] != "") {
                                                        if ($result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc'][strlen($result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc']) - 1] != '%') {
                                                            echo  '<div class="row my-2">
                                                            <div class="col-7 text-right">
                                                                Discount (  ' . $result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc'] . ' )
                                                            </div>
                                                        <div class="col-5 text-right">
                                                            <span class="text-110 text-secondary-d1 ">'
                                                                .
                                                                $result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc']
                                                                . '  </span>
                                                        </div>
                                                        </div>';
                                                        } else {
                                                            echo  '<div class="row my-2">
                                                            <div class="col-7 text-right">
                                                                Discount (  ' . $result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc'] . ' )
                                                            </div>
                                                        <div class="col-5 text-right">
                                                            <span class="text-110 text-secondary-d1 ">'
                                                                .
                                                                $result_content_outdoor_treatment[0]['outdoor_treatment_total_bill'] * trim($result_content_outdoor_treatment[0]['outdoor_treatment_discount_pc'], "%") / 100
                                                                . '  </span>
                                                        </div>
                                                        </div>';
                                                        }
                                                    } else {
                                                        echo    "";
                                                    }



                                                    ?>
                                                    <div class="row my-2 align-items-center bgc-primary-l3 ">
                                                        <div class="col-7 text-right">
                                                            Total Adjusted Amount
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <span class="text-120 text-secondary-d1 text-right"><?php echo $result_content_outdoor_treatment[0]['outdoor_treatment_total_bill_after_discount'];  ?> </span>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2 align-items-center bgc-primary-l3">
                                                        <div class="col-7 text-right">
                                                            Paid
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <span class="text-120 text-secondary-d1"><?php echo $result_content_outdoor_treatment[0]['outdoor_treatment_total_paid']; ?> </span>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2 align-items-center bgc-primary-l3 ">
                                                        <div class="col-7 text-right">
                                                            Due
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <span class="text-120 text-secondary-d1"><?php echo $result_content_outdoor_treatment[0]['outdoor_treatment_total_due']; ?> </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="text-secondary-d1 text-105">Thank you for your business</span>
                                                </div>

                                                <div>
                                                    <span class="text-sm text-black-m2 align-middle">Prepared By: <?php echo $result_content_user[0]['username']; ?></span>

                                                </div>
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