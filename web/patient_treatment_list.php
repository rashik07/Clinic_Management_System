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
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Treatment List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice No</th>
                                            <th>Patient Name</th>
                                            <th>Services</th>
                                            <th>Total Bill</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <?php if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo "<th>Edit</th>";
                                            }

                                            ?>
                                            <th>Collection</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select * from patient 
    join outdoor_treatment ot on patient.patient_id = ot.outdoor_treatment_patient_id ORDER BY outdoor_treatment_id DESC";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_invoice_id'] . '</td>';
                                            echo '<td>' . $data['patient_name'] . '</td>';

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
                                            echo '<td>' . $data['outdoor_treatment_total_bill_after_discount'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_paid'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_due'] . '</td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<td><a href="edit_patient_treatment.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            }
                                            if ($data['outdoor_treatment_total_due'] > 0) {
                                                echo '<td><a href="edit_patient_treatment_due.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '">Collection</a></td>';
                                            } else {
                                                echo '<td> - </td>';
                                            }

                                            echo '<td><a href="doctor_visit_invoice.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '"><i class="ti ti-save" style="font-size:24px"></i></a></td>';

                                            $count = $count + 1;
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