<?php
if (!isset($_SESSION)) {
    session_start();
}
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

            <div class="container-fluid home">

                <div class="row">
                    <!-- Widget Item -->
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Medicine Stock</h3>
                            <div class="table-responsive">
                                <table id="datatable_medicine_exp" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Medicine Name</th>
                                            <th>Generic Name</th>
                                            <th>Batch ID</th>
                                            <th>Supplier</th>
                                            <th>Stock</th>
                                            <!-- <th>Exp Date</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content ="select *,(SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
                                        (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
                                  LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
                                  WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell,

  (SELECT SUM(pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_piece) from pharmacy_medicine
  LEFT JOIN pharmacy_sell_medicine_return on pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_medicine_id=pharmacy_medicine.pharmacy_medicine_id
            WHERE pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_medicine_id=pharmacy_medicine.pharmacy_medicine_id and pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_medicine_batch_id=pharmacy_medicine.pharmacy_medicine_batch_id
   
  ) as total_return

                                 from medicine

                                 

                                        
                                           
                                             left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
                                             left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
                                             left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id;";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            if ($data['total_quantity'] - $data['total_sell'] < 100) {
                                                // $date=date_create($data['pharmacy_medicine_exp_date']);
                                                $res_quantity=$data['total_quantity'] - $data['total_sell']+$data['total_return'];
                                                echo '<tr>';
                                                echo '<td>' . $count . '</td>';
                                                echo '<td>' . $data['medicine_name'] . '</td>';
                                                echo '<td>' . $data['medicine_generic_name'] . '</td>';
                                                echo '<td>'.$data['pharmacy_medicine_batch_id'].'</td>';
                                                echo '<td>' . $data['medicine_manufacturer_name'] . '</td>';
                                                echo '<td>' .  $res_quantity. '</td>';
                                                // echo '<td>'.date_format($date,"Y/m/d").'</td>';
                                                echo '</tr>';
                                                $count = $count + 1;
                                         
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Widget Item -->
                </div>
                <script>
                    $('#datatable_medicine_exp').dataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                        ]
                    }); //replace id with your first table's id
                </script>
            </div>






</body>
<?php include 'footer.php'
?>

</html>