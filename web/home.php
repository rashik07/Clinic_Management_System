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
                            <th>*</th>
                            <th>Medicine Name</th>
                            <th>Generic Name</th>
                            <th>Batch ID</th>
                            <th>Manufacturer</th>
                            <th>Exp Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();

                    $conn = $connection->getConnection();

                    $get_content = "select *, DATE(medicine_creation_time) as medicine_creation_time,
                    DATE(pharmacy_medicine_exp_date) as pharmacy_medicine_exp_date from medicine
                    left join pharmacy_medicine on medicine.medicine_id = pharmacy_medicine.pharmacy_medicine_medicine_id
                    left join medicine_manufacturer mm on medicine.medicine_manufacturer = mm.medicine_manufacturer_id
                    where pharmacy_medicine_exp_date <= CURDATE() + INTERVAL 7 DAY
                    order by medicine_creation_time desc";
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();

                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $body = '';
                    $count = 1;
                    foreach ($result_content as $data) {
                        echo '<tr>';
                        echo '<td>'.$count.'</td>';
                        echo '<td>'.$data['medicine_name'].'</td>';
                        echo '<td>'.$data['medicine_generic_name'].'</td>';
                        echo '<td>'.$data['pharmacy_medicine_batch_id'].'</td>';
                        echo '<td>'.$data['medicine_manufacturer_name'].'</td>';
                        echo '<td>'.$data['pharmacy_medicine_exp_date'].'</td>';
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


