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
                                            <th>Invoice No</th>
                                            <th>Supplier</th>
                                            <th>Purchase Date</th>
                                            <th>Total</th>
                                            <th>Due</th>
                                           <?php if ($_SESSION['user_type_access_level'] <= 2) {
                                            echo '<th>Action</th>';
                                            echo '<th>Delete</th>';
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select *, DATE(pharmacy_purchase_date) as pharmacy_purchase_date  from pharmacy_purchase
                    left join medicine_manufacturer mm on mm.medicine_manufacturer_id = pharmacy_purchase.pharmacy_purchase_manufacturer_id
                    left join pharmacy_purchase_medicine  on pharmacy_purchase_medicine.pharmacy_purchase_medicine_purchase_id = pharmacy_purchase.pharmacy_purchase_id
                    left join pharmacy_medicine  on pharmacy_medicine.pharmacy_medicine_id = pharmacy_purchase_medicine.pharmacy_purchase_medicine_medicine_id
                   
                    
                    order by pharmacy_purchase_creation_time";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);


                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                           
                                            echo '<tr>';
                                          
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $data['pharmacy_purchase_invoice_no'] . '</td>';
                                            echo '<td>' . $data['medicine_manufacturer_name'] . '</td>';
                                            echo '<td>' . $data['pharmacy_purchase_date'] . '</td>';
                                            echo '<td>' . $data['pharmacy_purchase_grand_total'] . '</td>';
                                            echo '<td>' . $data['pharmacy_purchase_due_amount'] . '</td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                            echo '<td><a href="edit_medicine_purchase.php?medicine_purchase_id=' . $data['pharmacy_purchase_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            echo '<td> <button type="button" class="btn btn-danger mb-3" onclick="delete_data(' . $data['pharmacy_purchase_id'].','.$data['pharmacy_purchase_medicine_medicine_id'].','.$data['pharmacy_purchase_medicine_batch_id'] . ');">Delete</button></td>';
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

    function delete_data(pharmacy_purchase_id,pharmacy_purchase_medicine_medicine_id,pharmacy_purchase_medicine_batch_id) {
        console.log(pharmacy_purchase_medicine_batch_id);


        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_medicine_purchase_list.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    pharmacy_purchase_id: pharmacy_purchase_id,
                    pharmacy_purchase_medicine_medicine_id:pharmacy_purchase_medicine_medicine_id,
                    pharmacy_purchase_medicine_batch_id:pharmacy_purchase_medicine_batch_id,
                    
                    content: "medicine_purchase_list"
                },
                success: function(response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        location.reload();
                        // window.open("medicine_purchase_list.php", "_self");
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