<div class="container-fluid home">

    <div class="row">
        <!-- Widget Item -->
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">Upcoming Medicing Expiery</h3>
                <div class="table-responsive">
                    <table id="datatable_medicine_exp" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Medicine Name</th>
                                <th>Generic Name</th>
                                <!-- <th>Batch ID</th> -->
                                <th>Manufacturer</th>
                                <th>Stock</th>
                                <!-- <th>Exp Date</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("../apis/Connection.php");
                            $connection = new Connection();

                            $conn = $connection->getConnection();

                            //         $get_content = "select *,
                            //         (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id ) as total_quantity,
                            //         (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
                            //   LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
                            //   WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id) as total_sell
                            //  from medicine

                            //              left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf

                            //              left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
                            //              left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
                            //              left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id";
                            $get_content = "select *,
                     (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=1 ) as total_quantity,
                         (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
               LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
               WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pharmacy_medicine.pharmacy_medicine_medicine_id) as total_sell
              from medicine
              
            
                          left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
                          left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer";
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();

                            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                            $body = '';
                            $count = 1;
                            foreach ($result_content as $data) {
                                // $date=date_create($data['pharmacy_medicine_exp_date']);
                                echo '<tr>';
                                echo '<td>' . $count . '</td>';
                                echo '<td>' . $data['medicine_name'] . '</td>';
                                echo '<td>' . $data['medicine_generic_name'] . '</td>';
                                // echo '<td>'.$data['pharmacy_medicine_batch_id'].'</td>';
                                echo '<td>' . $data['medicine_manufacturer_name'] . '</td>';
                                echo '<td>' . $data['total_quantity'] - $data['total_sell'] . '</td>';
                                // echo '<td>'.date_format($date,"Y/m/d").'</td>';
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