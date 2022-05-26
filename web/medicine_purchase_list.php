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
                        <th>Supplier</th>
                        <th>Purchase Date</th>
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

                    $get_content = "select *, DATE(pharmacy_purchase_date) as pharmacy_purchase_date  from pharmacy_purchase
                    left join medicine_manufacturer mm on mm.medicine_manufacturer_id = pharmacy_purchase.pharmacy_purchase_manufacturer_id
                    order by pharmacy_purchase_creation_time";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        echo '<tr>';
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['medicine_manufacturer_name'].'</td>';
                        echo '<td>'.$data['pharmacy_purchase_date'].'</td>';
                        echo '<td>'.$data['pharmacy_purchase_grand_total'].'</td>';
                        echo '<td>'.$data['pharmacy_purchase_due_amount'].'</td>';

                        echo '<td><a href="edit_medicine_purchase.php?medicine_purchase_id='.$data['pharmacy_purchase_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
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