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
            <h3 class="widget-title">Bed List</h3>
            <div class="table-responsive mb-3">
                <table id="datatable_medicine_type" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Bed Name</th>
                        <th>Category</th>
                        <th>Room No</th>
                        <th>Price</th>
                        <th>Status</th>
                        <?php if ($_SESSION['user_type_access_level'] <= 2 ) { ?>
                        <th>Action</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();

                    $conn = $connection->getConnection();

                    $get_content = "select *, DATE(indoor_bed_creation_time) as indoor_bed_creation_time from indoor_bed
                    left join indoor_bed_category ibc on ibc.indoor_bed_category_id = indoor_bed.indoor_bed_category_id
                    order by indoor_bed_creation_time desc";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        if($data['indoor_bed_status']=="available"){
                            echo '<tr style="background-color: darkgreen;color:white;">';
                        }
                        else{
                            echo '<tr style="background-color: darkred;color:white;">';
                        }
                     
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['indoor_bed_name'].'</td>';
                        echo '<td>'.$data['indoor_bed_category_name'].'</td>';
                        echo '<td>'.$data['indoor_bed_room_no'].'</td>';
                        echo '<td>'.$data['indoor_bed_price'].'</td>';
                        echo '<td>'.$data['indoor_bed_status'].'</td>';
                         if ($_SESSION['user_type_access_level'] <= 2 ) { 
                        echo '<td><a href="edit_indoor_bed.php?bed_id='.$data['indoor_bed_id'].'"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                         }
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
    $('#datatable_medicine_type').dataTable({
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
