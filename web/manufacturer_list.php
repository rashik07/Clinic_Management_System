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
                            <h3 class="widget-title">Medicine Supplier List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable_medicine_manufacturer" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <?php if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo     '<th>Action</th>';
                                            } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select *, DATE(medicine_manufacturer_creation_time) as medicine_manufacturer_creation_time from medicine_manufacturer order by medicine_manufacturer_creation_time desc";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_name'] . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_address'] . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_mobile'] . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_city'] . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_state'] . '</td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<td><a href="edit_manufacturer.php?medicine_manufacturer_id=' . $data['medicine_manufacturer_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            }
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

        </div>

        <?php include 'footer.php'
        ?>
</body>
<script>
    $('#datatable_medicine_manufacturer').dataTable({
        // dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
</script>

</html>