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
                            // print_r($indoor_patient);
                            ?>
                            <div class="row">
                                <div class="col-md-8">
                                    <p>Patient Name : <?php echo $indoor_patient[0]['patient_name'] ?></p>
                                    <p>Patient ID : <?php echo $indoor_patient[0]['patient_id'] ?></p>
                                    <p>Patient Age : <?php echo $indoor_patient[0]['patient_age'] ?></p>
                                    <p>Consultant Name : <?php echo $indoor_patient[0]['patient_id'] ?></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Admission Date : <?php echo $indoor_patient[0]['indoor_treatment_creation_time'] ?></p>
                                    <p>Bill up to Date : <?php echo $indoor_patient[0]['indoor_treatment_creation_time'] ?></p>
                                </div>
                            </div>
                            <table class="Report_table" style="width: 100%;">
                                <thead>
                                    <tr>

                                        <td>Invoice</td>
                                        <td style="width: 40%;">Details</td>
                                        <td>Issue Date</td>
                                        <td>Discount</td>

                                        <td>Payment</td>

                                        <td>Bill</td>
                                        <td>Action</td>
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
                                                <a class="" data-toggle="collapse" href="#indoor_Allotment" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Indoor Allotment</a>
                                                <div class="collapse multi-collapse" id="indoor_Allotment">
                                                    <div class="card card-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    </div>
                                                </div>
                                                </td>
                                               
                                                <td>' . $services_names . '</td>
                                                <td>' . $indoor_invoice['indoor_treatment_creation_time'] . '</td>
                                                
                                                <td>' . $indoor_invoice['indoor_treatment_discount_pc'] . '</td>
                                                
                                                <td>' . $indoor_invoice['indoor_treatment_total_paid'] . '</td>
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
                                        <a class="" data-toggle="collapse" href="#Services" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"> Invoice no. ' . $Service['outdoor_treatment_id'] . '</a>
                                        <div class="collapse multi-collapse" id="Services">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                    
                                        <td>' . $services_names . '</td>
                                        <td>' . $Service['outdoor_treatment_creation_time'] . '</td>
                                        <td>' . $Service['outdoor_treatment_discount_pc'] . '</td>
                                        <td>' . $Service['outdoor_treatment_total_paid'] . '</td>
                                        <td>' . $Service['outdoor_treatment_total_bill_after_discount'] . '</td>
                                        
                                        <td><a href="edit_patient_treatment.php?outdoor_treatment_id=' . $Service['outdoor_treatment_id'] . '">Update</a></td>
                                    </tr>';
                                        }
                                    } ?>



                                    <?php

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
                                        <td>' . $pharmacy_sell['pharmacy_sell_discount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_grand_total'] . '</td>
                                        
                                        <td>' . $pharmacy_sell['pharmacy_sell_paid_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_due_amount'] . '</td>
                                        
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