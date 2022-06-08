<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
?>
<?php include 'header.php';
$totoal_bill = 0;
$total_paid = 0;
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
                        <div class="widget-area-2 proclinic-box-shadow">
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

                            $indoor_treatment_id = $_GET['indoor_treatment_id'];
                            $get_content = "select * from indoor_treatment_payment where indoor_treatment_payment_treatment_id='$indoor_treatment_id'";
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $indoor_payments = $getJson->fetchAll(PDO::FETCH_ASSOC);
                            // print_r($indoor_patient);

                            if (count($indoor_payments) > 0) {
                                foreach ($indoor_payments as $payment) {
                                    $total_paid += (int)$payment['indoor_treatment_payment_amount'];
                                }
                            }

                            ?>
                            <button class="btn btn-primary mx-1px text-95" style="float: right;" onclick="print_invoice();">
                                <i class="mr-1 fa fa-print text-white-m1 text-120 w-2"></i>
                                Print
                            </button>
                            <div id="print_invoice">
                                <div class="row border-bottom">
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
                                <div class="row  mt-2 mb-2">
                                    <div class="col-md-8">
                                        <p class="mb-0">Patient Name : <?php echo $indoor_patient[0]['patient_name'] ?></p>
                                        <p class="mb-0">Patient ID : <?php echo $indoor_patient[0]['patient_id'] ?></p>
                                        <p class="mb-0">Patient Age : <?php echo $indoor_patient[0]['patient_age'] ?></p>
                                        <!-- <p class="mb-0">Consultant Name : <?php echo $indoor_patient[0]['patient_id'] ?></p> -->
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p class="mb-0">Admission ID : <?php echo $indoor_patient[0]['indoor_treatment_admission_id'] ?></p>
                                        <p class="mb-0">Admission Date : <?php echo $indoor_patient[0]['indoor_treatment_creation_time'] ?></p>
                                        <p class="mb-0">Bill up to Date : <?php echo isset($indoor_patient[0]['indoor_treatment_modification_time']) ? $indoor_patient[0]['indoor_treatment_modification_time'] : $indoor_patient[0]['indoor_treatment_creation_time']  ?></p>
                                    </div>
                                </div>
                                <table class="Report_table border" style="width: 100%;">
                                    <thead>
                                        <tr>

                                            <td>Invoice</td>
                                            <td style="width: 40%;">Details</td>
                                            <td>Issue Date</td>
                                            <td class="text-right">Discount</td>

                                            <!-- <td class="text-right">Payment</td> -->

                                            <td class="text-right">Bill</td>
                                            <!-- <td style="width: 5%;">Action</td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from indoor_treatment where indoor_treatment_id='$indoor_treatment_id'";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $indoor_allotment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($indoor_allotment);
                                        if (count($indoor_allotment) > 0) {
                                            foreach ($indoor_allotment as $indoor_invoice) {
                                                // $last_bed_name = $bed['indoor_bed_name'];
                                                $treatment_id = $indoor_treatment_id;
                                                $service_list = array();

                                                $get_content = "select * from indoor_treatment_bed  
                                    where indoor_treatment_bed_treatment_id = '$treatment_id'";
                                                $getJson = $conn->prepare($get_content);
                                                $getJson->execute();
                                                $result_content_services = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($result_content_services as $services) {
                                                    array_push($service_list, $services['indoor_treatment_bed_category_name']);
                                                }

                                                $get_content = "select * from indoor_treatment_admission inner join outdoor_service on  indoor_treatment_admission.outdoor_service_id = outdoor_service.outdoor_service_id
                                    where indoor_treatment_id = '$treatment_id'";
                                                $getJson = $conn->prepare($get_content);
                                                $getJson->execute();
                                                $result_content_services = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($result_content_services as $services) {
                                                    array_push($service_list, $services['outdoor_service_name']);
                                                }

                                                $get_content = "select * from indoor_treatment_doctor inner join doctor on  indoor_treatment_doctor.indoor_treatment_doctor_doctor_id = doctor.doctor_id
                                    where indoor_treatment_doctor_treatment_id = '$treatment_id'";
                                                // echo $get_content;
                                                $getJson = $conn->prepare($get_content);
                                                $getJson->execute();
                                                $result_content_services = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($result_content_services as $services) {
                                                    array_push($service_list, $services['doctor_name']);
                                                }

                                                $services_names = implode(', ', $service_list);

                                                if ($indoor_invoice['indoor_treatment_discount_pc'] == "") {
                                                    $indoor_invoice['indoor_treatment_discount_pc'] = 0;
                                                }

                                                echo '
                                            <tr class="main_row">
                                                <td> 
                                                <a  href="admission_invoice.php?indoor_treatment_id=' . $indoor_treatment_id . '" target="blank">Indoor Allotment</a>
                                               
                                                </td>                             
                                                <td>' . $services_names . '</td>
                                                <td>' . $indoor_invoice['indoor_treatment_creation_time'] . '</td>
                                                
                                                <td class="text-right">' . $indoor_invoice['indoor_treatment_discount_pc'] . '</td>
                                                
                                             
                                                <td class="text-right">' . $indoor_invoice['indoor_treatment_total_bill_after_discount'] . '</td>
                                                
                                                </tr>';

                                                $totoal_bill += (int)$indoor_invoice['indoor_treatment_total_bill_after_discount'];
                                                $total_paid += (int)$indoor_invoice['indoor_treatment_total_paid'];
                                                $total_discount += (int)$indoor_invoice['indoor_treatment_discount_pc'];
                                                // $total_exemption += (int)$indoor_invoice['indoor_treatment_discount_pc'];


                                                $get_content = "select * from indoor_treatment where indoor_treatment_id='$indoor_treatment_id'";
                                                $getJson = $conn->prepare($get_content);
                                                $getJson->execute();
                                                $indoor_allotment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            }
                                        }
                                        ?>

                                        <?php
                                        $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                        $get_content = "select * from outdoor_treatment where outdoor_treatment_indoor_treatment_id='$indoor_treatment_id'";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $Services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // print_r($Services);
                                        if (count($Services) > 0) {
                                            foreach ($Services as $Service) {
                                                // $last_bed_name = $bed['indoor_bed_name'];
                                                $treatment_id = $Service['outdoor_treatment_id'];

                                                $get_content = "select * from outdoor_treatment_service 
                                    left join outdoor_service os on os.outdoor_service_id = outdoor_treatment_service.outdoor_treatment_service_service_id 
                                    where outdoor_treatment_service_treatment_id = '$treatment_id'";
                                                $getJson = $conn->prepare($get_content);
                                                $getJson->execute();
                                                $result_content_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                                $service_list = array();

                                                foreach ($result_content_services as $services) {
                                                    array_push($service_list, $services['outdoor_service_name']);
                                                }
                                                $services_names = implode(', ', $service_list);

                                                if ($Service['outdoor_treatment_discount_pc'] == "") {
                                                    $Service['outdoor_treatment_discount_pc'] = 0;
                                                }
                                                echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a href="doctor_visit_invoice.php?outdoor_treatment_id=' . $Service['outdoor_treatment_id'] . '" target="blank"> Invoice no. ' . $Service['outdoor_treatment_id'] . '</a>
                                        
                                    
                                        <td>' . $services_names . '</td>
                                        <td>' . $Service['outdoor_treatment_creation_time'] . '</td>
                                        <td class="text-right">' . $Service['outdoor_treatment_discount_pc'] . '</td>
                                        
                                        <td class="text-right">' . $Service['outdoor_treatment_total_bill_after_discount'] . '</td>
                                        
                                        </tr>';

                                                $totoal_bill += (int)$Service['outdoor_treatment_total_bill_after_discount'];
                                                $total_paid += (int)$Service['outdoor_treatment_total_paid'];
                                                $total_discount += (int)$Service['outdoor_treatment_discount_pc'];
                                                $total_exemption += (int)$Service['outdoor_treatment_exemption'];
                                            }
                                        } ?>

                                        <?php
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
                                                if ($pharmacy_sell['pharmacy_sell_discount'] == "") {
                                                    $pharmacy_sell['pharmacy_sell_discount'] = 0;
                                                }
                                                echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a  href="medicine_sell_invoice.php?medicine_sell_id=' . $pharmacy_sell['pharmacy_sell_id'] . '" target="blank" >Medicine Purchase</a></td>
                                        <td>-</td>
                                        
                                        <td>' . $pharmacy_sell['pharmacy_sell_creation_time'] . '</td>
                                        
                                        <td class="text-right">' . $pharmacy_sell['pharmacy_sell_discount'] . '</td>
                                        <td class="text-right">' . $pharmacy_sell['pharmacy_sell_grand_total'] . '</td>
                                        
                                        
                                    </tr>';
                                            }
                                            $totoal_bill += (int)$pharmacy_sell['pharmacy_sell_grand_total'];
                                            $total_paid += (int)$pharmacy_sell['pharmacy_sell_paid_amount'];
                                            $total_discount += (int)$pharmacy_sell['pharmacy_sell_discount'];
                                            $total_exemption += (int)$pharmacy_sell['pharmacy_selling_exemption'];
                                        }


                                        ?>


                                    </tbody>
                                </table>
                                <table style="width: 100%;" class="border-top mb-3">
                                    <tr class="main_row">
                                        <td style="width: 40%;"></td>
                                        <td style="width: 20%;"></td>
                                        <td class="text-center border " style="width: 25%;">Gross Amount</td>
                                        <td class="text-right border p-1"><?php echo $totoal_bill ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Discount</td>
                                        <td class="text-right border p-1"><?php echo $total_discount ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Advance</td>
                                        <td class="text-right border p-1"><?php echo $indoor_patient[0]['indoor_treatment_released'] == 0 ? $total_paid : 0 ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Exemption</td>
                                        <td class="text-right border p-1"><?php echo $total_exemption ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Net Payable Amount</td>
                                        <td class="text-right border p-1"><?php echo $indoor_patient[0]['indoor_treatment_released'] == 0 ? 0 : $total_paid  ?></td>
                                    </tr>
                                    <tr class="main_row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-center border">Net Due Amount</td>
                                        <td class="text-right border p-1"><?php echo $indoor_patient[0]['indoor_treatment_released'] == 0 ? 0 : ($totoal_bill - $total_paid)  ?></td>
                                    </tr>
                                </table>
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
                    </div>
                    <div class="col-md-6">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h5>Add Naw Payment</h5>

                            <form class="form-horizontal form-material mb-0" id="indoor_treatment_payment" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="indoor_treatment_payment_treatment_id" value="<?php echo $_GET['indoor_treatment_id']; ?>">
                                <input type="hidden" name="content" value="indoor_payment">
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
                    <div class="col-md-6">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <button class="btn btn-primary mx-1px text-95" onclick="print_history();">
                                <i class="mr-1 fa fa-print text-white-m1 text-120 w-2"></i>
                                Print
                            </button>
                            <div id="print_history">


                                <!-- <div class="row border-bottom">
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
                                </div> -->
                                <div class="row  mt-2 mb-4">
                                    <div class="col-md-5">
                                        <p class="mb-0">Patient Name : <?php echo $indoor_patient[0]['patient_name'] ?></p>
                                        <p class="mb-0">Patient ID : <?php echo $indoor_patient[0]['patient_id'] ?></p>
                                        <p class="mb-0">Patient Age : <?php echo $indoor_patient[0]['patient_age'] ?></p>
                                        <!-- <p class="mb-0">Consultant Name : <?php echo $indoor_patient[0]['patient_id'] ?></p> -->
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <p class="mb-0">Admission ID : <?php echo $indoor_patient[0]['indoor_treatment_admission_id'] ?></p>
                                        <p class="mb-0">Admission Date : <?php echo $indoor_patient[0]['indoor_treatment_creation_time'] ?></p>
                                        <p class="mb-0">Bill up to Date : <?php echo isset($indoor_patient[0]['indoor_treatment_modification_time']) ? $indoor_patient[0]['indoor_treatment_modification_time'] : $indoor_patient[0]['indoor_treatment_creation_time']  ?></p>
                                    </div>
                                </div>
                                <table class="Report_table border mb-4 p-4" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <td>Payment history</td>
                                            <td>Date</td>
                                            <td class="text-right">Amount</td>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (count($indoor_payments) > 0) {
                                        foreach ($indoor_payments as $payment) {
                                            echo '<tr class="main_row">
                                    <td>' . $payment["indoor_treatment_payment_details"] . '</td>
                                    <td>' . $payment["indoor_treatment_payment_creation_time"] . '</td>
                                    <td class="text-right">' . $payment["indoor_treatment_payment_amount"] . '</td>
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
    $(document).ready(function() {
        $('form#indoor_treatment_payment').on('submit', function(event) {
            // alert("payment");
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
                    console.log(obj);
                    if (obj.status) {
                        location.reload();
                        // window.open("doctor_visit_invoice.php?outdoor_treatment_id=" + obj.outdoor_treatment_id, "_self");

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


        });


        $('form#patient_release').on('submit', function(event) {

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
                    var obj = JSON.parse(data);
                    // alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        location.reload();
                        // window.open("admission_invoice.php?indoor_treatment_id=" + obj.indoor_treatment_id, "_self");

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("alert : " + errorThrown);
                    // spinner.hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
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