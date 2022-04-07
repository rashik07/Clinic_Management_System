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
            <h3 class="widget-title">Pathology Test List</h3>
            <div class="table-responsive mb-3">
                <table id="datatable_medicine_category" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Test Name</th>
                        <th>Description</th>
                        <th>Room No</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();

                    $conn = $connection->getConnection();

                    $get_content = "select *, DATE(pathology_test_creation_time) as pathology_test_creation_time from pathology_test order by pathology_test_creation_time desc";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        echo '<tr>';
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['pathology_test_name'].'</td>';
                        echo '<td>'.$data['pathology_test_description'].'</td>';
                        echo '<td>'.$data['pathology_test_room_no'].'</td>';
                        echo '<td>'.$data['pathology_test_price'].'</td>';
                        echo '<td><a href="edit_pathology_test.php?pathology_test_id='.$data['pathology_test_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
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
            <div>
            
    </div>
    <?php include 'footer.php'
    ?>
</body>
<script>
    $('#datatable_medicine_category').dataTable({
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
