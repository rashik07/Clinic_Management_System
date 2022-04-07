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
                    <!-- Widget Item -->
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();
                    $conn = $connection->getConnection();

                    $patient_id = $_GET['patient_id'];
                    $get_content = "select * from patient where patient_id='$patient_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);


                    $get_content = "select *,DATE(outdoor_treatment_creation_time) as outdoor_treatment_creation_time from patient 
                    left join outdoor_treatment ot on patient.patient_id = ot.outdoor_treatment_patient_id
                    where patient_id='$patient_id'";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_outdoor = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select SUM(outdoor_treatment_total_bill_after_discount) as total_bill,SUM(outdoor_treatment_total_due) as total_due from patient 
                    left join outdoor_treatment ot on patient.patient_id = ot.outdoor_treatment_patient_id
                    where patient_id='$patient_id' group by patient_id";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_outdoor_billing = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select *, DATE(patient_creation_time) as patient_creation_time from patient 
                    left join indoor_treatment it on patient.patient_id = it.indoor_treatment_patient_id
                    where patient_id='$patient_id'";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_indoor = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select SUM(indoor_treatment_total_bill_after_discount) as total_bill,SUM(indoor_treatment_total_due) as total_due  from patient 
                    left join indoor_treatment it on patient.patient_id = it.indoor_treatment_patient_id
                    where patient_id='$patient_id'";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_indoor_billing = $getJson->fetchAll(PDO::FETCH_ASSOC);

                   

                    $get_content = "select *, DATE(pharmacy_sell_creation_time) as pharmacy_sell_creation_time from patient 
                    left join pharmacy_sell ps on patient.patient_id = ps.pharmacy_sell_patient_id
                    where patient_id='$patient_id'";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pharmacy = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select SUM(ps.pharmacy_sell_grand_total) as total_bill, SUM(ps.pharmacy_sell_due_amount) as total_due from patient 
                    left join pharmacy_sell ps on patient.patient_id = ps.pharmacy_sell_patient_id
                    where patient_id='$patient_id'";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pharmacy_billing = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="col-md-6">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Details</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><?php echo $result_content_patient[0]['patient_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Of Birth</strong> </td>
                                            <td><?php echo $result_content_patient[0]['patient_dob']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gender</strong></td>
                                            <td><?php echo $result_content_patient[0]['patient_gender']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address</strong></td>
                                            <td><?php echo $result_content_patient[0]['patient_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone </strong></td>
                                            <td><?php echo $result_content_patient[0]['patient_phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td><?php echo $result_content_patient[0]['patient_email']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <a type="button" class="btn btn-success mb-3" href="edit_patient.php?patient_id=<?php echo $result_content_patient[0]['patient_id']; ?>"><span class="ti-pencil-alt"></span> Edit Patient</a>
                            <!--<a type="button" class="btn btn-danger mb-3"><span class="ti-trash"></span> Delete Patient</a>-->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Bill History</h3>
                            <div class="table-responsive">
                                <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Department</th>
                                            <th>Total Bill</th>
                                            <th>Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Out Door</td>
                                            <td><?php echo $result_content_outdoor_billing[0]['total_bill']; ?></td>
                                            <td><?php echo $result_content_outdoor_billing[0]['total_due']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>In Door</td>
                                            <td><?php echo $result_content_indoor_billing[0]['total_bill']; ?></td>
                                            <td><?php echo $result_content_indoor_billing[0]['total_due']; ?></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Outdoor History</h3>
                            <div class="table-responsive">
                                <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Treatment</th>
                                            <th>Total Bill</th>
                                            <th>Discount%</th>
                                            <th>After Discount</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Visit Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content_outdoor as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            $treatment_id = $data['outdoor_treatment_id'];

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

                                            echo '<td>' . $services_names . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_bill'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_discount_pc'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_bill_after_discount'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_paid'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_due'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_creation_time'] . '</td>';
                                            echo '<td><a href="edit_patient_treatment.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            $count = $count + 1;
                                            echo '</tr>';
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Indoor History</h3>
                            <div class="table-responsive">
                                <table id="datatable3" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Doctor Name</th>
                                            <th>Last Bed</th>
                                            <th>Total Bill</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content_indoor as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';

                                            $treatment_id = $data['indoor_treatment_id'];

                                            $get_content = "select * from indoor_treatment_doctor 
                                    left join doctor d on d.doctor_id = indoor_treatment_doctor.indoor_treatment_doctor_doctor_id
                                    where indoor_treatment_doctor_treatment_id = '$treatment_id'";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $last_doctor_name = "";
                                            foreach ($result_content_doctor as $doctor) {
                                                $last_doctor_name = $doctor['doctor_name'];
                                            }

                                            $get_content = "select * from indoor_treatment_bed
                                    left join indoor_bed ib on ib.indoor_bed_id = indoor_treatment_bed.indoor_treatment_bed_bed_id
                                    where indoor_treatment_bed_treatment_id = '$treatment_id'";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $result_content_bed = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $last_bed_name = "";
                                            foreach ($result_content_bed as $bed) {
                                                $last_bed_name = $bed['indoor_bed_name'];
                                            }

                                            echo '<td>' . $last_doctor_name . '</td>';
                                            echo '<td>' . $last_bed_name . '</td>';
                                            echo '<td>' . $data['indoor_treatment_total_bill_after_discount'] . '</td>';
                                            echo '<td>' . $data['indoor_treatment_total_paid'] . '</td>';
                                            echo '<td>' . $data['indoor_treatment_total_due'] . '</td>';
                                            echo '<td><a href="edit_indoor_treatmentQ.php?indoor_treatment_id=' . $treatment_id . '"><i class="ti ti-settings" style="font-size:24px"></i></a><a href="indoor_invoice.php?treatment_id=' . $treatment_id . '" target="_blank"><i class="ti ti-files" style="font-size:24px; margin-left:10px"></i></a></td>';
                                            $count = $count + 1;
                                            echo '</tr>';
                                        }
                                        ?>




                                    </tbody>
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
    $('#datatable0').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable1').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable2').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable3').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id

    $('#datatable4').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id

    $('#datatable5').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable6').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
</script>

</html>