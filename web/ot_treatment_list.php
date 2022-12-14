<?php
// need to enable on production
require_once('check_if_ot_manager.php');
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
                        <h3 class="widget-title">OT Treatment List</h3>
                        <div class="table-responsive mb-3">
                            <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Patient Phone</th>
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

                                $get_content = "select * from patient 
    join ot_treatment ot on patient.patient_id = ot.ot_treatment_patient_id";
                                $getJson = $conn->prepare($get_content);
                                $getJson->execute();

                                $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                $body = '';
                                $count = 1;
                                foreach ($result_content as $data) {
                                    echo '<tr>';
                                    echo '<td>'.$count.'</td>';
                                    echo '<td>'.$data['patient_name'].'</td>';
                                    echo '<td>'.$data['patient_phone'].'</td>';

                                    $treatment_id = $data['ot_treatment_id'];

                                    
                                    echo '<td>'.$data['ot_treatment_total_bill_after_discount'].'</td>';
                                    echo '<td>'.$data['ot_treatment_total_paid'].'</td>';
                                    $due = $data['ot_treatment_total_due'] == NULL || !isset($data['ot_treatment_total_due'])  || empty($data['ot_treatment_total_due']) ? 0 : $data['ot_treatment_total_due'];
                                    echo '<td>'.$due.'</td>';
                                    echo '<td><a href="edit_ot_treatment.php?ot_treatment_id='.$data['ot_treatment_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
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
