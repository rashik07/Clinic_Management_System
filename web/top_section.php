<?php
require_once("../apis/Connection.php");
$connection = new Connection();

$conn = $connection->getConnection();
$get_content = "SELECT COUNT(patient_id) as patient_id
FROM `patient`;";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);

$get_content = "SELECT COUNT(doctor_id) as doctor_id
FROM `doctor`;";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);


$get_content = "select *,
                                        (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
                                        (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
                                  LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
                                  WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell
                                 from medicine
                                        
                                           
                                             left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
                                             left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
                                             left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id ";
$getJson = $conn->prepare($get_content);
$getJson->execute();
$count = 0;
$result_content_stock = $getJson->fetchAll(PDO::FETCH_ASSOC);
foreach ($result_content_stock as $data) {
    if ($data['total_quantity'] - $data['total_sell'] < 50) {
        // $date=date_create($data['pharmacy_medicine_exp_date']);
        // $res_quantity=$data['total_quantity'] - $data['total_sell'];

        $count = $count + 1;
    }
}


?>



    <div class="row">
        <!-- Widget Item -->
        <div class="col-md-4">
            <a href="./patients_list.php">
                <div class="widget-area proclinic-box-shadow ">
                    <div class="widget-left">
                        <span class="ti-user"></span>
                    </div>
                    <div class="widget-right">
                        <h4 class="wiget-title">Total Patients</h4>
                        <span class="numeric"><?php echo $result_content[0]['patient_id']; ?></span>
                        <!-- <p class="inc-dec mb-0"><span class="ti-angle-up"></span> +20% Increased</p> -->
                    </div>
                </div>
            </a>

        </div>
        <!-- /Widget Item -->
        <!-- Widget Item -->
        <div class="col-md-4">
            <a href="./doctors_list.php">
                <div class="widget-area proclinic-box-shadow color-green">
                    <div class="widget-left">
                        <span class="ti-bar-chart"></span>
                    </div>
                    <div class="widget-right">
                        <h4 class="wiget-title">Total Doctor</h4>
                        <span class="numeric color-green"><?php echo $result_content_doctor[0]['doctor_id']; ?></span>
                        <!-- <p class="inc-dec mb-0"><span class="ti-angle-down"></span> -15% Decreased</p> -->
                    </div>
                </div>
            </a>
        </div>
        <!-- /Widget Item -->
        <!-- Widget Item -->
        <div class="col-md-4">
            <a href="./stock_alert.php">
                <div class="widget-area proclinic-box-shadow color-red">
                    <div class="widget-left">
                        <span class="ti-alert"></span>
                    </div>
                    <div class="widget-right">
                        <h4 class="wiget-title">Stock Alert</h4>
                        <span class="numeric color-red"><?php echo $count; ?></span>
                        <!-- <p class="inc-dec mb-0"><span class="ti-angle-up"></span> +10% Increased</p> -->
                    </div>
                </div>

            </a>

        </div>
        <!-- /Widget Item -->

    </div>




