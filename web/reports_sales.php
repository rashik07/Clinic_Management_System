<div class="container-fluid home">
<?php
    $time = $_GET['t'];
?>
<div class="col-lg-5">
    <select class="form-control" id="time_frame" name="time_frame">
        <option>Select Timeframe</option>
        <option <?php if($time == 1){echo 'selected';} ?> value="1">Today</option>
        <option <?php if($time == 7){echo 'selected';} ?> value="7">Last 7 Days</option>
        <option <?php if($time == 15){echo 'selected';} ?> value="15">Last 15 Days</option>
        <option <?php if($time == 30){echo 'selected';} ?> value="30">Last 30 Days</option>
        <option <?php if($time == 60){echo 'selected';} ?> value="60">Last 60 Days</option>
    </select>
</div>
<?php
    $total_bill = 0;
    $total_paid = 0;
    $total_due = 0;
    require_once("../apis/Connection.php");
    $connection = new Connection();

    $conn = $connection->getConnection();
    $time = $time - 1;
    $time = $time * -1;
    $get_content = "select *,DATE(outdoor_treatment_creation_time) as outdoor_treatment_creation_time from outdoor_treatment
    left join patient on outdoor_treatment_patient_id = patient.patient_id
    where outdoor_treatment_creation_time >= DATE_ADD(CURDATE(), INTERVAL $time DAY)
    order by outdoor_treatment_creation_time desc";
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_outdoor_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_content_outdoor_treatment as $key => $value) {
        $total_bill += $value['outdoor_treatment_total_bill'];
        $total_paid += $value['outdoor_treatment_total_paid'];
        $total_due += $value['outdoor_treatment_total_due'];
    }


    $get_content = "select *,DATE(indoor_treatment_creation_time) as indoor_treatment_creation_time from indoor_treatment
    left join patient on indoor_treatment_patient_id = patient.patient_id
    where indoor_treatment_creation_time >= DATE_ADD(CURDATE(), INTERVAL $time DAY)
    order by indoor_treatment_creation_time desc";
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_indoor_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_content_indoor_treatment as $key => $value) {
        $total_bill += $value['indoor_treatment_total_bill'];
        $total_paid += $value['indoor_treatment_total_paid'];
        $total_due += $value['indoor_treatment_total_due'];
    }

    $get_content = "select *,DATE(pathology_investigation_creation_time) as pathology_investigation_creation_time from pathology_investigation
    left join patient on pathology_investigation_patient_id = patient.patient_id
    where pathology_investigation_creation_time >= DATE_ADD(CURDATE(), INTERVAL $time DAY)
    order by pathology_investigation_creation_time desc";
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_pathology_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_content_pathology_treatment as $key => $value) {
        $total_bill += $value['pathology_investigation_total_bill'];
        $total_paid += $value['pathology_investigation_total_paid'];
        $total_due += $value['pathology_investigation_total_due'];
    }

    $get_content = "select *,DATE(pharmacy_sell_creation_time) as pharmacy_sell_creation_time from pharmacy_sell
    left join patient on pharmacy_sell_patient_id = patient.patient_id
    where pharmacy_sell_creation_time >= DATE_ADD(CURDATE(), INTERVAL $time DAY)
    order by pharmacy_sell_creation_time desc";
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_pharmacy_bill = $getJson->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_content_pharmacy_bill as $key => $value) {
        $total_bill += $value['pharmacy_sell_total_bill'];
        $total_paid += $value['pharmacy_sell_total_paid'];
        $total_due += $value['pharmacy_sell_total_due'];
    }

    $get_content = "select *,DATE(ot_treatment_creation_time) as ot_treatment_creation_time from ot_treatment
    left join patient on ot_treatment_patient_id = patient.patient_id
    where ot_treatment_creation_time >= DATE_ADD(CURDATE(), INTERVAL $time DAY)
    order by ot_treatment_creation_time desc";
    
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_ot_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_content_ot_treatment as $key => $value) {
        $total_bill += $value['ot_treatment_total_bill'];
        $total_paid += $value['ot_treatment_total_paid'];
        $total_due += $value['ot_treatment_total_due'];
    }            
?>
<div class="row">
    <!-- Widget Item -->
    <div class="col-md-4">
        <div class="widget-area proclinic-box-shadow color-red">
            <div class="widget-left">
                <span class="ti-user"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Bill</h4>
                <span class="numeric color-red"><?php echo $total_bill; ?></span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-4">
        <div class="widget-area proclinic-box-shadow color-green">
            <div class="widget-left">
                <span class="ti-bar-chart"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Paid</h4>
                <span class="numeric color-green"><?php echo $total_paid; ?></span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-4">
        <div class="widget-area proclinic-box-shadow color-yellow">
            <div class="widget-left">
                <span class="ti-money"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Due</h4>
                <span class="numeric color-yellow"><?php echo $total_due; ?></span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
</div>

    <!-- Row Start -->
    <div class="row">
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">OutDoor Sales Report</h3>
                <div class="table-responsive">
                    <table id="datatable_outdoor" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>*</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        $body = '';
                        $count = 1;
                        foreach ($result_content_outdoor_treatment as $data) {
                            echo '<tr>';
                            echo '<td>'.$count.'</td>';
                            echo '<td>'.$data['patient_name'].'</td>';
                            echo '<td>'.$data['patient_phone'].'</td>';
                            echo '<td>'.$data['outdoor_treatment_total_bill_after_discount'].'</td>';
                            echo '<td>'.$data['outdoor_treatment_total_paid'].'</td>';
                            echo '<td>'.$data['outdoor_treatment_total_due'].'</td>';
                            echo '<td>'.$data['outdoor_treatment_creation_time'].'</td>';

                            echo '</tr>';
                            $count = $count+1;
                            
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <!-- Row Start -->
    <div class="row">
            <div class="col-md-12">
                <div class="widget-area-2 proclinic-box-shadow">
                    <h3 class="widget-title">InDoor Sales Report</h3>
                    <div class="table-responsive">
                        <table id="datatable_indoor" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>*</th>
                                    <th>Patient Name</th>
                                    <th>Patient Phone</th>
                                    <th>Total Bill</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            
                            $body = '';
                            $count = 1;
                            foreach ($result_content_indoor_treatment as $data) {
                                echo '<tr>';
                                echo '<td>'.$count.'</td>';
                                echo '<td>'.$data['patient_name'].'</td>';
                                echo '<td>'.$data['patient_phone'].'</td>';
                                echo '<td>'.$data['indoor_treatment_total_bill_after_discount'].'</td>';
                                echo '<td>'.$data['indoor_treatment_total_paid'].'</td>';
                                echo '<td>'.$data['indoor_treatment_total_due'].'</td>';
                                echo '<td>'.$data['indoor_treatment_creation_time'].'</td>';
                                echo '</tr>';
                                $count = $count+1;
                                
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    <!-- Row End -->
    <!-- Row Start -->
    <div class="row">
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">Pathology Sales Report</h3>
                <div class="table-responsive">
                    <table id="datatable_pathology" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>*</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $body = '';
                        $count = 1;
                        foreach ($result_content_pathology_treatment as $data) {
                            echo '<tr>';
                            echo '<td>'.$count.'</td>';
                            echo '<td>'.$data['patient_name'].'</td>';
                            echo '<td>'.$data['patient_phone'].'</td>';
                            echo '<td>'.$data['pathology_investigation_total_bill_after_discount'].'</td>';
                            echo '<td>'.$data['pathology_investigation_total_paid'].'</td>';
                            echo '<td>'.$data['pathology_investigation_total_due'].'</td>';
                            echo '<td>'.$data['pathology_investigation_creation_time'].'</td>';

                            echo '</tr>';
                            $count = $count+1;
                           
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <!-- Row Start -->
    <div class="row">
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">Pharmacy Sales Report</h3>
                <div class="table-responsive">
                    <table id="datatable_pharmacy" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>*</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $body = '';
                        $count = 1;
                        foreach ($result_content_pharmacy_bill as $data) {
                            echo '<tr>';
                            echo '<td>'.$count.'</td>';
                            echo '<td>'.$data['patient_name'].'</td>';
                            echo '<td>'.$data['patient_phone'].'</td>';
                            echo '<td>'.$data['pharmacy_sell_total_bill_after_discount'].'</td>';
                            echo '<td>'.$data['pharmacy_sell_total_paid'].'</td>';
                            echo '<td>'.$data['pharmacy_sell_total_due'].'</td>';
                            echo '<td>'.$data['pharmacy_sell_creation_time'].'</td>';

                            echo '</tr>';
                            $count = $count+1;
                            
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <!-- Row Start -->
    <div class="row">
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">OT Sales Report</h3>
                <div class="table-responsive">
                    <table id="datatable_ot" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>*</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        
                        $body = '';
                        $count = 1;
                        foreach ($result_content_ot_treatment as $data) {
                            echo '<tr>';
                            echo '<td>'.$count.'</td>';
                            echo '<td>'.$data['patient_name'].'</td>';
                            echo '<td>'.$data['patient_phone'].'</td>';
                            echo '<td>'.$data['ot_treatment_total_bill_after_discount'].'</td>';
                            echo '<td>'.$data['ot_treatment_total_paid'].'</td>';
                            echo '<td>'.$data['ot_treatment_total_due'].'</td>';
                            echo '<td>'.$data['ot_treatment_creation_time'].'</td>';

                            echo '</tr>';
                            $count = $count+1;
                            
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
<script>
    $('#datatable_outdoor').dataTable({
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
    }); //replace id with your first table's id
    $('#datatable_indoor').dataTable({
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
    }); //replace id with your first table's id
    $('#datatable_pathology').dataTable({
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
    }); //replace id with your first table's id
    $('#datatable_pharmacy').dataTable({
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
    }); //replace id with your first table's id
    $('#datatable_ot').dataTable({
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
    }); //replace id with your first table's id
</script>
<script>
    $("#time_frame").change( function (event) {
        var selectedVal = $("#time_frame option:selected").val();
        window.open("reports.php?t="+selectedVal,"_self");
    });

</script>
</div>


