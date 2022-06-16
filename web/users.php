<?php
// need to enable on production
require_once('check_if_admin.php');
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
                                <table id="datatable_patient" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th>Username</th> -->
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <!-- <th>Created At</th> -->
                                            <th>Status</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select * from user left join user_type on user_type.user_type_id = user.user_type_id where user.user_type_id != 1 order by user_id DESC";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            //echo '<td>'.$count.'</td>';
                                            echo '<td>' . $data['user_id'] . '</td>';
                                            // echo '<td>' . $data['username'] . '</td>';
                                            echo '<td>' . $data['user_Full_Name'] . '</td>';
                                            echo '<td>' . $data['user_PhoneNo'] . '</td>';
                                            echo '<td>' . $data['user_Email'] . '</td>';
                                            echo '<td>' . $data['user_type_Name'] . '</td>';
                                            // echo '<td>' . $data['user_creation_time'] . '</td>';
                                            echo '<td>' . $data['user_Status'] . '</td>';
                                            echo '<td><a href="edit_user.php?user_id=' . $data['user_id'] . '"><i class="ti ti-pencil-alt" style="font-size:24px"></i></a></td>';
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