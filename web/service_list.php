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
            <h3 class="widget-title">Service List</h3>
            <div class="table-responsive mb-3">
                <table id="datatable_service" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Service Name</th>
                        <th>Service Category</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();

                    $conn = $connection->getConnection();

                    $get_content = "select *, DATE(outdoor_service_creation_time) as outdoor_service_creation_time from outdoor_service order by outdoor_service_creation_time desc";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        echo '<tr>';
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['outdoor_service_name'].'</td>';
                        echo '<td>'.$data['outdoor_service_Category'].'</td>';
                        echo '<td>'.$data['outdoor_service_rate'].'</td>';
                        echo '<td><a href="edit_service.php?outdoor_service_id='.$data['outdoor_service_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
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
    $('#datatable_service').dataTable({
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
