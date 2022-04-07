<?php
// need to enable on production
require_once('check_if_pathalogy_manager.php');
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
                        <h3 class="widget-title">Pathology Investigation List</h3>
                        <div class="table-responsive mb-3">
                            <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Date</th>
                                    <th>Test Names</th>
                                    <th>Total Bill</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                require_once("../apis/Connection.php");
                                $connection = new Connection();

                                $conn = $connection->getConnection();

                                $get_content = "select *,DATE(pathology_investigation_date) as pathology_investigation_date from patient 
    join pathology_investigation pi on patient.patient_id = pi.pathology_investigation_patient_id";
                                $getJson = $conn->prepare($get_content);
                                $getJson->execute();

                                $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                $body = '';
                                $count = 1;
                                foreach ($result_content as $data) {
                                    echo '<tr>';
                                    echo '<td>'.$count.'</td>';
                                    echo '<td>'.$data['patient_name'].'</td>';
                                    echo '<td>'.$data['pathology_investigation_date'].'</td>';
                                    $investigation_id = $data['pathology_investigation_id'];

                                    $get_content = "select * from pathology_investigation 
                                    left join pathology_investigation_test pit on pathology_investigation.pathology_investigation_id = pit.pathology_investigation_test_investigation_id
                                    left join pathology_test pt on pt.pathology_test_id = pit.pathology_investigation_test_pathology_test_id
                                    where pathology_investigation_id = '$investigation_id'";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content_tests = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    $test_list = array();

                                    foreach ($result_content_tests as $services) {
                                        array_push($test_list, $services['pathology_test_name']);
                                    }
                                    $test_names = implode(', ',$test_list);

                                    echo '<td>'.$test_names.'</td>';
                                    echo '<td>'.$data['pathology_investigation_total_bill_after_discount'].'</td>';
                                    echo '<td>'.$data['pathology_investigation_total_paid'].'</td>';
                                    echo '<td>'.$data['pathology_investigation_total_due'].'</td>';
                                    echo '<td><a href="edit_pathology_investigation.php?pathology_investigation_id='.$data['pathology_investigation_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                    $count = $count+1;
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
