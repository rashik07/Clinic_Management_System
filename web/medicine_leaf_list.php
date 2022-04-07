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
            <h3 class="widget-title">Medicine Unit List</h3>
            <div class="table-responsive mb-3">
                <table id="datatable_medicine_leaf" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Medicine Leaf Name</th>
                        <th>Leaf Per Box</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();

                    $conn = $connection->getConnection();

                    $get_content = "select *, DATE(medicine_leaf_creation_time) as medicine_leaf_creation_time from medicine_leaf order by medicine_leaf_creation_time desc";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        echo '<tr>';
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['medicine_leaf_name'].'</td>';
                        echo '<td>'.$data['medicine_leaf_total_per_box'].'</td>';
                        echo '<td>'.$data['medicine_leaf_description'].'</td>';
                        echo '<td><a href="edit_medicine_leaf.php?medicine_leaf_id='.$data['medicine_leaf_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
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
    $('#datatable_medicine_leaf').dataTable({
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
