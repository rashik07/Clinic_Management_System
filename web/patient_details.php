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

                    // $get_content = "select *, DATE(patient_creation_time) as patient_creation_time from patient 
                    // left join pathology_investigation pi on patient.patient_id = pi.pathology_investigation_patient_id
                    // where patient_id='$patient_id'";
                    // $getJson = $conn->prepare($get_content);
                    // $getJson->execute();
                    // $result_content_pathology = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    // $get_content = "select SUM(pathology_investigation_total_bill_after_discount) as total_bill,SUM(pathology_investigation_total_due) as total_due  from patient 
                    // left join pathology_investigation pi on patient.patient_id = pi.pathology_investigation_patient_id
                    // where patient_id='$patient_id'";
                    // $getJson = $conn->prepare($get_content);
                    // $getJson->execute();
                    // $result_content_pathology_billing = $getJson->fetchAll(PDO::FETCH_ASSOC);


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

                    // $get_content = "select *, DATE(ot_treatment_creation_time) as ot_treatment_creation_time from patient 
                    // left join ot_treatment ot on patient.patient_id = ot.ot_treatment_patient_id
                    // where patient_id='$patient_id'";

                    // $getJson = $conn->prepare($get_content);
                    // $getJson->execute();
                    // $result_content_ot = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    // $get_content = "select SUM(ot.ot_treatment_total_bill_after_discount) as total_bill, SUM(ot.ot_treatment_total_due) as total_due from patient 
                    // left join ot_treatment ot on patient.patient_id = ot.ot_treatment_patient_id
                    // where patient_id='$patient_id'";
                    // $getJson = $conn->prepare($get_content);
                    // $getJson->execute();
                    // $result_content_ot_billing = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
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
                            <?php if ($_SESSION['user_type_access_level'] <= 2) { ?>
                                <button type="button" class="btn btn-danger mb-3" onclick="delete_data();">Delete</button>
                            <?php } ?>
                            <!--<a type="button" class="btn btn-danger mb-3"><span class="ti-trash"></span> Delete Patient</a>-->
                        </div>
                    </div>

                    <!-- <div class="col-md-6">
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
                                        <tr>
                                            <td>3</td>
                                            <td>Pathology</td>
                                            <td><?php echo $result_content_pathology_billing[0]['total_bill']; ?></td>
                                            <td><?php echo $result_content_pathology_billing[0]['total_due']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>O.T</td>
                                            <td><?php echo $result_content_ot_billing[0]['total_bill']; ?></td>
                                            <td><?php echo $result_content_ot_billing[0]['total_due']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Pharmacy</td>
                                            <td><?php echo $result_content_pharmacy_billing[0]['total_bill']; ?></td>
                                            <td><?php echo $result_content_pharmacy_billing[0]['total_due']; ?></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->
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
                                            <?php
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo "<th>Action</th>";
                                            }
                                            ?>
                                            <th>Collection</th>
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
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<td><a href="edit_patient_treatment.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                                $count = $count + 1;
                                            }
                                            if ($data['outdoor_treatment_total_due'] > 0) {
                                                echo '<td><a href="edit_patient_treatment_due.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '">Collection</a></td>';
                                            } else {
                                                echo '<td> - </td>';
                                            }
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
                                            echo '<td><a href="edit_indoor_treatment.php?indoor_treatment_id=' . $treatment_id . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            $count = $count + 1;
                                            echo '</tr>';
                                        }
                                        ?>




                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- /Widget Item -->
                    <!-- Widget Item -->
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <!-- <h3 class="widget-title">Patient Payment Transactions</h3> -->
                            <div class="table-responsive">
                                <!-- <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Cost</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Invoive</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$300</td>
                                            <td>15%</td>
                                            <td>Check</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$130</td>
                                            <td>5%</td>
                                            <td>Credit Card</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$30</td>
                                            <td>5%</td>
                                            <td>Credit Card</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-danger">Cancelled</span></td>
                                        </tr>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$30</td>
                                            <td>5%</td>
                                            <td>Cash</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$30</td>
                                            <td>5%</td>
                                            <td>Credit Card</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$30</td>
                                            <td>5%</td>
                                            <td>Insurance</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>12-03-2018</td>
                                            <td>$30</td>
                                            <td>5%</td>
                                            <td>Credit Card</td>
                                            <td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
                                            <td><span class="badge badge-success">Completed</span></td>
                                        </tr>
                                    </tbody>
                                </table> -->

                                <!--Export links-->
                                <!-- <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center export-pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#"><span class="ti-download"></span> csv</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><span class="ti-printer"></span> print</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><span class="ti-file"></span> PDF</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><span class="ti-align-justify"></span> Excel</a>
                                        </li>
                                    </ul>
                                </nav> -->
                                <!-- /Export links-->
                            </div>
                        </div>
                    </div>
                    <!-- /Widget Item -->
                </div>
            </div>
            <div>

            </div>
            <?php include 'footer.php'
            ?>
</body>
<script>
    var spinner = $('#loader');

    function delete_data() {
        var data_id = <?php echo $patient_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_patient.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    patient_id: data_id,
                    content: "patient"
                },
                success: function(response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("patients_list.php", "_self");
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