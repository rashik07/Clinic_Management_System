<?php
// need to enable on production
require_once('check_if_indoor_manager.php');
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
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Treatment List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Admission ID</th>
                                            <th>Patient Name</th>
                                            <th>Doctor Name</th>
                                            <th>Last Bed</th>
                                            <th>Status</th>
                                            <!-- <th>Total Bill</th>
                                            <th>Paid</th>
                                            <th>Due</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select * from indoor_treatment
                                left join patient p on p.patient_id = indoor_treatment.indoor_treatment_patient_id ORDER BY indoor_treatment_id DESC";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
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
                                            echo '<td>' . $data['indoor_treatment_admission_id'] . '</td>';
                                            echo '<td>' . $data['patient_name'] . '</td>';
                                            echo '<td>' . $last_doctor_name . '</td>';
                                            echo '<td>' . $last_bed_name . '</td>';
                                            echo '<td>' . ($data['indoor_treatment_released'] == 1 ? "Released" : "Admitted") . '</td>';
                                            // echo '<td>' . $data['indoor_treatment_total_paid'] . '</td>';
                                            // echo '<td>' . $data['indoor_treatment_total_due'] . '</td>';
                                            echo '<td>
                                            <a class="btn btn-success" href="admission_form.php?indoor_treatment_id=' . $treatment_id . '">Form</a> | 
                                            <a class="btn btn-success" href="admission_invoice.php?indoor_treatment_id=' . $treatment_id . '">Invoice</a> |
                                            <a class="btn btn-success" href="edit_indoor_treatment.php?indoor_treatment_id=' . $treatment_id . '">Edit</a>
                                            
                                            </td>';
                                            $count = $count + 1;
                                            // <a href="edit_indoor_treatment.php?indoor_treatment_id=' . $treatment_id . '"><i class="ti ti-settings" style="font-size:24px"></i>
                                            // </a>
                                        }
                                        ?>




                                    </tbody>
                                </table>

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
    $('#datatable1').dataTable({
        // dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
</script>

</html>