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
                                            <div class="col-12  justify-content-center">
                                                <div class="float-left">
                                                    <img class="center" src="../assets/images/logo.png" style="height: 60px; display: block; margin-left: auto; margin-right: auto;" alt="logo" class="logo-default">
                                                </div>

                                                <div class=" text-center text-150">
                                                    <p style="font-size: 18px; margin:0px; padding:0px;">MOMTAJ TRAUMA CENTER</p>
                                                    <p style="font-size: 14px; margin:0px; padding:0px;">House #56, Road #03, Dhaka Real State, Kaderabad housing,Mohammadpur, Dhaka-1207</p>
                                                    <p style="font-size: 14px; margin:0px; padding:0px;">For Serial: +88 01844080671 , +88 028101496, +88 01844 080 675, +88 01844 080 676</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .row -->

                                        <hr class="row brc-default-l1 mx-n1 mb-4" />
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();

                                        $medicine_sell_id = $_GET['medicine_sell_id'];

                                        $get_content = "select * from medicine_manufacturer";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content_medicine_manufacturer = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $get_content = "select *,
       (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
       (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
 LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
 WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell
from medicine
           
            left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf
           
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
            left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content_medicine = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $get_content = "select *, DATE (pharmacy_sell_date) as pharmacy_sell_date from pharmacy_sell
                left join patient p on p.patient_id = pharmacy_sell.pharmacy_sell_patient_id left join indoor_treatment on pharmacy_sell.pharmacy_sell_indoor_treatment_id = indoor_treatment.indoor_treatment_id
                where pharmacy_sell_id='$medicine_sell_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content_medicine_sell = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $get_content = "select *, DATE(pharmacy_medicine_exp_date) as pharmacy_medicine_exp_date,
       (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id  and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
       (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
 LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
 WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell
from pharmacy_sell_medicine
                left join pharmacy_medicine pm on pharmacy_sell_medicine.pharmacy_sell_medicine_medicine_id = pm.pharmacy_medicine_id
                left join medicine m on m.medicine_id = pm.pharmacy_medicine_medicine_id
                where pharmacy_sell_medicine_sell_id='$medicine_sell_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content_pharmacy_medicine_sell = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $get_content = "select * from medicine_leaf";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content_medicine_leaf = $getJson->fetchAll(PDO::FETCH_ASSOC);



                                        ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Invoice No:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $result_content_medicine_sell[0]['pharmacy_sell_invoice_id'] ?></span>
                                                </div>
                                                <!-- <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Prepared By:</span>
                                                    <span class="text-600 text-110 text-blue align-middle">
                                                        <?php
                                                        // echo $result_content_user[0]['username']; 
                                                        ?></span>
                                                </div> -->
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Patient Name:</span>
                                                    <span class="text-600 text-110 text-blue align-middle">
                                                        <?php
                                                        echo $result_content_medicine_sell[0]['patient_name'];
                                                        ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Gender:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo $result_content_medicine_sell[0]['patient_gender']; ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">Age:</span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?php echo  $result_content_medicine_sell[0]['patient_age']; ?></span>
                                                </div>



                                            </div>
                                            <!-- /.col -->

                                            <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                <hr class="d-sm-none" />
                                                <div class="text-grey-m2">

                                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> <?php echo date("M j,Y"); ?></div>
                                                    <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?php echo  $result_content_medicine_sell[0]['patient_phone']; ?></b></div>
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


                                                //   echo $result_content_pharmacy_medicine_sell;

                                                $count_service = 0;
                                                for ($i = 0; $i < count($result_content_pharmacy_medicine_sell); $i++) {


                                                    echo '<div class="row mb-2 mb-sm-0 py-25">
                                                    <div class="d-none d-sm-block col-1">' . ($count_service + 1) . '</div>
                                                    <div class="col-9 col-sm-5">' . $result_content_pharmacy_medicine_sell[$i]['medicine_name'] . '</div>
                                                    <div class="d-none d-sm-block col-2">' . $result_content_pharmacy_medicine_sell[$i]['pharmacy_sell_medicine_per_piece_price'] . ' Tk</div>
                                                    <div class="d-none d-sm-block col-2 text-95">' . $result_content_pharmacy_medicine_sell[$i]['pharmacy_sell_medicine_selling_piece'] . '</div>
                                                    <div class="col-2 text-secondary-d2">' . $result_content_pharmacy_medicine_sell[$i]['pharmacy_sell_medicine_total_selling_price'] . ' TK</div>
                                                    </div>';

                                                    $count_service = $count_service + 1;
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
                                                    <div class="row my-1">
                                                        <div class="col-7 text-right">
                                                            SubTotal
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-120 text-secondary-d1"><?php echo $result_content_medicine_sell[0]['pharmacy_sell_sub_total']; ?> Tk</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($result_content_medicine_sell[0]['pharmacy_sell_discount'] > 0) {
                                                        echo  '<div class="row my-1">
                                                        <div class="col-7 text-right">
                                                        discount
                                                    </div>
                                                        <div class="col-5">
                                                            <span class="text-120 text-secondary-d1">'
                                                            . $result_content_medicine_sell[0]['pharmacy_sell_discount'] . '  Tk.</span>
                                                        </div>
                                                        </div>';
                                                    } else {
                                                        echo    "";
                                                    }



                                                    ?>

                                                    <div class="row my-1 align-items-center bgc-primary-l3 p-2">
                                                        <div class="col-7 text-right">
                                                            Total Adjusted Amount
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-120 text-secondary-d1"><?php echo $result_content_medicine_sell[0]['pharmacy_sell_grand_total']; ?>Tk</span>
                                                        </div>
                                                    </div>
                                                    <div class="row my-1 align-items-center bgc-primary-l3 p-2">
                                                        <div class="col-7 text-right">
                                                            Paid
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-120 text-secondary-d1"><?php echo $result_content_medicine_sell[0]['pharmacy_sell_paid_amount']; ?> Tk</span>
                                                        </div>
                                                    </div>
                                                    <div class="row my-1 align-items-center bgc-primary-l3 p-2">
                                                        <div class="col-7 text-right">
                                                            Due
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="text-120 text-secondary-d1"><?php
                                                                                                                if ($result_content_medicine_sell[0]['pharmacy_sell_due_amount']) {
                                                                                                                    echo $result_content_medicine_sell[0]['pharmacy_sell_due_amount'];
                                                                                                                } else {
                                                                                                                    echo '0';
                                                                                                                }
                                                                                                                ?> Tk</span>
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


                                                </div>
                                                <!-- /.col -->

                                                <div class="col-sm-4 offset-sm-2" style="float:right;">
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle" style="text-align:right;">-------------------------------------------</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm text-grey-m2 align-middle">Authority Signature</span>
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