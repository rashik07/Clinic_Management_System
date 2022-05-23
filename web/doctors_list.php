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
                        <h3 class="widget-title">Doctor List</h3>
                        <div class="table-responsive mb-3">
                            <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Doctor Name</th>
                                    <th>Doctor Age</th>
                                    <th>Phone</th>
                                    <th>Blood</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                require_once("../apis/Connection.php");
                                $connection = new Connection();

                                $conn = $connection->getConnection();

                                $get_content = "select * from doctor order by doctor_creation_time desc";
                                $getJson = $conn->prepare($get_content);
                                $getJson->execute();

                                $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                $body = '';
                                $count = 1;
                                foreach ($result_content as $data) {
                                    echo '<tr>';
                                    echo '<td>'.$count.'</td>';
                                    echo '<td>'.$data['doctor_name'].'</td>';
                                    echo '<td>'.$data['doctor_age'].'</td>';
                                    echo '<td>'.$data['doctor_phone'].'</td>';
                                    echo '<td>'.$data['doctor_blood_group'].'</td>';
                                    echo '<td>'.$data['doctor_specialization'].'</td>';
                                    echo '<td>'.$data['doctor_status'].'</td>';
                                    echo '<td><a href="doctor_details.php?doctor_id='.$data['doctor_id'].'"><i class="ti ti-eye" style="font-size:24px"></i></a></td>';
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
