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
                            <h3 class="widget-title">Patients List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable_patient" class="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient ID</th>
                                            <th>Patient Name</th>
                                            <th>Patient Age</th>
                                            <th>Phone</th>
                                            <th>Blood</th>
                                            <th>Admission</th>
                                            <th>Status</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select *, DATE(patient_creation_time) as patient_creation_time from patient order by patient_id DESC";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            echo '<td>'.$count.'</td>';
                                            echo '<td>' . $data['patient_id'] . '</td>';
                                            echo '<td>' . $data['patient_name'] . '</td>';
                                            echo '<td>' . $data['patient_age'] . '</td>';
                                            echo '<td>' . $data['patient_phone'] . '</td>';
                                            echo '<td>' . $data['patient_blood_group'] . '</td>';
                                            echo '<td>' . $data['patient_creation_time'] . '</td>';
                                            echo '<td>' . $data['patient_status'] . '</td>';
                                            echo '<td><a href="patient_details.php?patient_id=' . $data['patient_id'] . '"><i class="ti ti-eye" style="font-size:24px"></i></a></td>';
                                            echo '</tr>';
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
    $('#datatable_patient').dataTable({
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