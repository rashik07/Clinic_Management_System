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
                            <h3 class="widget-title">Medicine Sell List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable_medicine" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice Number</th>
                                            <th>Patient ID</th>
                                            <th>Patient</th>
                                            <th>Sell Date</th>
                                            <th>Total</th>
                                            <th>Due</th>

                                            <th>Due Collection</th>
                                            <th>Return</th>
                                            <th>Invoice</th>

                                            <?php if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo    '<th>Action</th>';
                                                echo    '<th>Delete</th>';
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select *, DATE(pharmacy_sell_date) as pharmacy_sell_date  from pharmacy_sell
                    left join patient p on p.patient_id = pharmacy_sell.pharmacy_sell_patient_id
                     ORDER BY pharmacy_sell_id DESC";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $data['pharmacy_sell_invoice_id'] . '</td>';
                                            echo '<td>' . $data['patient_id'] . '</td>';
                                            echo '<td>' . $data['patient_name'] . '</td>';
                                            echo '<td>' . $data['pharmacy_sell_date'] . '</td>';
                                            echo '<td>' . $data['pharmacy_sell_grand_total'] . '</td>';
                                            echo '<td>' . $data['pharmacy_sell_due_amount'] . '</td>';


                                            echo '<td><a href="edit_medicine_sell_due_collection.php?medicine_sell_id=' . $data['pharmacy_sell_id'] . '">Due_Collection</a></td>';

                                            echo '<td><a href="return_medicine_sell.php?medicine_sell_id=' . $data['pharmacy_sell_id'] . '">Return</a></td>';
                                            echo '<td><a href="medicine_sell_invoice.php?medicine_sell_id=' . $data['pharmacy_sell_id'] . '">Invoice</td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<td><a href="edit_medicine_sell.php?medicine_sell_id=' . $data['pharmacy_sell_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                                echo '<td> <button type="button" class="btn btn-danger mb-3" onclick="delete_data(' . $data['pharmacy_sell_id'] . ');">Delete</button></td>';
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
    var spinner = $('#loader');

    function delete_data(pharmacy_sell_id) {


        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete _medicine_sell_list.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    pharmacy_sell_id: pharmacy_sell_id,
                    content: "medicine_sell_list"
                },
                success: function(response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    // alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("medicine_sell_list.php", "_self");
                    }
                   
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    spinner.hide();
                    alert("alert : " + textStatus);
                }
            });
        } else {
            // Do nothing!
            console.log('Said No');
        }
    }
    $('#datatable_medicine').dataTable({
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