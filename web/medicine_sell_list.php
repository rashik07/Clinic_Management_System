<?php
// need to enable on production
require_once('check_if_pharmacy_manager.php');
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
            <h3 class="widget-title">Medicine Purchase List</h3>
            <div class="table-responsive mb-3">
                <table id="datatable_medicine" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient ID</th>
                        <th>Patient</th>
                        <th>Sell Date</th>
                        <th>Total</th>
                        <th>Due</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();

                    $conn = $connection->getConnection();

                    $get_content = "select *, DATE(pharmacy_sell_date) as pharmacy_sell_date  from pharmacy_sell
                    left join patient p on p.patient_id = pharmacy_sell.pharmacy_sell_patient_id
                    order by pharmacy_sell_creation_time";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        echo '<tr>';
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['patient_id'].'</td>';
                        echo '<td>'.$data['patient_name'].'</td>';
                        echo '<td>'.$data['pharmacy_sell_date'].'</td>';
                        echo '<td>'.$data['pharmacy_sell_grand_total'].'</td>';
                        echo '<td>'.$data['pharmacy_sell_due_amount'].'</td>';

                        echo '<td><a href="edit_medicine_sell.php?medicine_sell_id='.$data['pharmacy_sell_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                        echo '</tr>';
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
    </div>
    <?php include 'footer.php'
    ?>
</body>
<script>
    $('#datatable_medicine').dataTable({
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