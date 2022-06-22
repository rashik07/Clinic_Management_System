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
                            <h3 class="widget-title">Medicine List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable_medicine" class="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Medicine Name</th>
                                            <th>Generic Name</th>
                                            <!-- <th>Category</th> -->
                                            <th>Supplier</th>
                                            <th>Selling Price</th>
                                            <th>Supplier Price</th>
                                        <?php    if ($_SESSION['user_type_access_level'] <= 2) {
                                        echo    '<th>Action</th>';
                                        echo    '<th>Delete</th>';
                                        }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select *, DATE(medicine_creation_time) as medicine_creation_time from medicine
                    left join medicine_manufacturer mm on medicine.medicine_manufacturer = mm.medicine_manufacturer_id
                    order by medicine_creation_time desc";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $data['medicine_name'] . '</td>';
                                            echo '<td>' . $data['medicine_generic_name'] . '</td>';
                                            // echo '<td>' . $data['medicine_category_name'] . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_name'] . '</td>';
                                            echo '<td>' . $data['medicine_selling_price'] . '</td>';
                                            echo '<td>' . $data['medicine_purchase_price'] . '</td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                            echo '<td><a href="edit_medicine.php?medicine_id=' . $data['medicine_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            echo '<td> <button type="button" class="btn btn-danger mb-3" onclick="delete_data('.$data['medicine_id'].');">Delete</button></td>';
                                            }
                                            echo '</tr>'
                                            
                                            ;
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
    var spinner = $('#loader');

function delete_data(medicine_id) {
   
  
    if (confirm('Are you sure you want to Delete This Content?')) {
        // yes
        spinner.show();
        $.ajax({
            type: 'POST',
            url: '../apis/delete_medicine.php',
            cache: false,
            //dataType: "json", // and this
            data: {
                request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                token: "<?php echo $_SESSION['token']; ?>",
                medicine_id: medicine_id,
                content: "medicine"
            },
            success: function(response) {
                //alert(response);
                spinner.hide();
                var obj = JSON.parse(response);
                alert(obj.message);
                //alert(obj.status);
                if (obj.status) {
                    //location.reload();
                    window.open("medicine_list.php", "_self");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                spinner.hide();
                alert("alert : " + errorThrown);
            }
        });
    } else {
        // Do nothing!
        console.log('Said No');
    }
}
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