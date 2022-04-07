<?php
// need to enable on production
require_once('check_if_indoor_manager.php');
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
                <?php
                require_once("../apis/Connection.php");
                $connection = new Connection();
                $conn = $connection->getConnection();

                $get_content = "select * from patient";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from indoor_bed 
                left join indoor_bed_category ibc on ibc.indoor_bed_category_id = indoor_bed.indoor_bed_category_id
                where indoor_bed.indoor_bed_status='available'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_bed = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from doctor";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from outdoor_service";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_outdoor_service = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from pathology_test";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_pathology_test = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select *,
       (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
       (SELECT  SUM(psm.indoor_pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
 LEFT JOIN indoor_pharmacy_sell_medicine psm ON psm.indoor_pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
 WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell
from medicine
            left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
            left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_medicine = $getJson->fetchAll(PDO::FETCH_ASSOC);

                ?>
                <div class="col-md-12">
                    <div class="widget-area-2 proclinic-box-shadow">
                        <h3 class="widget-title">Patient Allotment</h3>
                        <form class="form-horizontal form-material mb-0" id="patient_allotment_form" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-row">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="content" value="indoor_allotment">

                                <div class="form-group col-md-6">
                                    <label for="outdoor_patient_phone">Patient Phone<i class="text-danger"> * </i></label>
                                    <input type="text" placeholder="Patient Phone." class="form-control" id="outdoor_patient_phone" name="outdoor_patient_phone" required onchange="loadPatient();">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="outdoor_patient_id">Patient ID</label>
                                    <input type="text" placeholder="Patient ID." class="form-control" id="outdoor_patient_id" name="outdoor_patient_id" readonly required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="outdoor_patient_name">Patient Name</label>
                                    <input type="text" placeholder="Patient Name" class="form-control" id="outdoor_patient_name" name="outdoor_patient_name" required readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="indoor_treatment_admission_date">Admission Date<i class="text-danger"> * </i></label>
                                    <input type="date" placeholder="Admission Date" class="form-control" id="indoor_treatment_admission_date" name="indoor_treatment_admission_date" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="indoor_treatment_referer_doctor_id">Referer Doctor<i class="text-danger"> * </i></label>
                                    <select id="indoor_treatment_referer_doctor_id" class="form-control indoor_treatment_referer_doctor_id" name="indoor_treatment_referer_doctor_id">
                                        <option value="">Select a Doctor...</option>
                                        <?php
                                            foreach($result_content_doctor as $data)
                                            {
                                                echo '<option value="'.$data['doctor_id'].'">'.$data['doctor_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Room No<i class="text-danger"> * </i></th>
                                        <th>Room Type</th>
                                        <th>Room Price</th>
                                        <th>Total Bill</th>
                                        <th>Entry Time<i class="text-danger"> * </i></th>
                                        <th>Discharge Time<i class="text-danger"> * </i></th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datatable1_body">
                                    <tr>
                                        <td>
                                            <select id="indoor_patient_bed_bed_id" class="form-control indoor_patient_bed_bed_id" name="indoor_patient_bed_bed_id[]" placeholder="Pick a Service..." onchange="changeDataBed(this);" required>
                                                <option value="">Select a Bed...</option>
                                                <?php
                                                foreach($result_content_indoor_bed as $data)
                                                {
                                                    echo '<option value="'.$data['indoor_bed_id'].'">'.$data['indoor_bed_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control indoor_bed_category_name" placeholder="Bed Category" id="indoor_bed_category_name" name="indoor_bed_category_name[]" required readonly>

                                        </td>

                                        <td>
                                            <input type="number" class="form-control indoor_bed_price" placeholder="Price" id="indoor_bed_price" name="indoor_bed_price[]" readonly required>

                                        </td>
                                        <td>
                                            <input type="number" class="form-control bed_total_bill" placeholder="Total Bill" id="bed_total_bill" name="bed_total_bill[]" readonly required>

                                        </td>
                                        <td>
                                            <input type="date" class="form-control indoor_patient_bed_entry_time" placeholder="Entry time" id="indoor_patient_bed_entry_time" name="indoor_patient_bed_entry_time[]" onchange="changeDataBed(this);" required>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control indoor_patient_bed_discharge_time" placeholder="Discharge time" id="indoor_patient_bed_discharge_time" name="indoor_patient_bed_discharge_time[]" onchange="changeDataBed(this);">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success pull-right" onclick="AddRowBed();"><i class="fa fa-plus"></i></button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger pull-right" onclick="DeleteRowBed(this);"><i class="fa fa-minus"></i></button>
                                        </td>
                                    </tr>


                                    </tbody>

                                </table>
                                <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Doctor Name<i class="text-danger"> * </i></th>
                                        <th>Specialization</th>
                                        <th>Visit Fee</th>
                                        <th>Total Bill</th>
                                        <th>Entry Time<i class="text-danger"> * </i></th>
                                        <th>Discharge Time<i class="text-danger"> * </i></th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datatable2_body">
                                    <tr>
                                        <td>
                                            <select id="indoor_patient_doctor_doctor_id" class="form-control indoor_patient_doctor_doctor_id" name="indoor_patient_doctor_doctor_id[]" placeholder="Pick a Service..." onchange="changeDataDoctor(this);" required>
                                                <option value="">Select a Doctor...</option>
                                                <?php
                                                foreach($result_content_doctor as $data)
                                                {
                                                    echo '<option value="'.$data['doctor_id'].'">'.$data['doctor_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control doctor_specialization" placeholder="Doctor Specialization" id="doctor_specialization" name="doctor_specialization[]" required readonly>

                                        </td>
                                        <td>
                                            <input type="number" class="form-control doctor_visit_fee" placeholder="Fee" id="doctor_visit_fee" name="doctor_visit_fee[]" readonly required>

                                        </td>
                                        <td>
                                            <input type="number" class="form-control doctor_total_bill" placeholder="Bill" id="doctor_total_bill" name="doctor_total_bill[]" readonly required>

                                        </td>
                                        <td>
                                            <input type="date" class="form-control indoor_patient_doctor_entry_time" placeholder="Entry time" id="indoor_patient_doctor_entry_time" name="indoor_patient_doctor_entry_time[]" onchange="changeDataDoctor(this);" required>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control indoor_patient_doctor_discharge_time" placeholder="Discharge time" id="indoor_patient_doctor_discharge_time" name="indoor_patient_doctor_discharge_time[]" onchange="changeDataDoctor(this);">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success pull-right" onclick="AddRowDoctor();"><i class="fa fa-plus"></i></button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger pull-right" onclick="DeleteRowDoctor(this);"><i class="fa fa-minus"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table id="datatable3" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Service Name<i class="text-danger"> * </i></th>
                                        <th>Quantity<i class="text-danger"> * </i></th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datatable3_body">
                                        <tr>
                                            <td>
                                                <select id="outdoor_service_id" class="form-control outdoor_service_id" name="outdoor_service_id[]" placeholder="Pick a Service..." onchange="changeDataService(this);">
                                                    <option value="">Select a Service...</option>
                                                    <?php
                                                    foreach($result_content_outdoor_service as $data)
                                                    {
                                                        echo '<option value="'.$data['outdoor_service_id'].'">'.$data['outdoor_service_name'].'</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control outdoor_service_quantity" onchange="changeDataService(this);" placeholder="Service Quantity" id="outdoor_service_quantity" name="outdoor_service_quantity[]">

                                            </td>
                                            <td>
                                                <input type="number" class="form-control outdoor_service_rate" placeholder="Service Rate" id="outdoor_service_rate" name="outdoor_service_rate[]" readonly>

                                            </td>
                                            <td>
                                                <input type="number" class="form-control outdoor_service_total" placeholder="Service Total" id="outdoor_service_total" name="outdoor_service_total[]" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success pull-right" onclick="AddRowService();"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger pull-right" onclick="DeleteRowService(this);"><i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="datatable4" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Test Name<i class="text-danger"> * </i></th>
                                        <th>Room No.</th>
                                        <th>Rate</th>
                                        <th>Quantity<i class="text-danger"> * </i></th>
                                        <th>Total</th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datatable4_body">
                                        <tr>
                                            <td>
                                                <select id="pathology_test_id" class="form-control pathology_test_id" name="pathology_test_id[]" placeholder="Pick a Test..." onchange="changeDataTest(this);">
                                                    <option value="">Select a Test...</option>
                                                    <?php
                                                    foreach($result_content_pathology_test as $data)
                                                    {
                                                        echo '<option value="'.$data['pathology_test_id'].'">'.$data['pathology_test_name'].'</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control pathology_test_room_no" placeholder="Room No" id="pathology_test_room_no" name="pathology_test_room_no[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control pathology_investigation_test_price" placeholder="Price" id="pathology_investigation_test_price" name="pathology_investigation_test_price[]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control pathology_investigation_test_quantity" onchange="changeDataTest(this);" placeholder="Quantity" id="pathology_investigation_test_quantity" name="pathology_investigation_test_quantity[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control pathology_investigation_test_total_bill" placeholder="Total" id="pathology_investigation_test_total_bill" name="pathology_investigation_test_total_bill[]" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success pull-right" onclick="AddRowTest();"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger pull-right" onclick="DeleteRowTest(this);"><i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <datalist id="medicine_list"></datalist>
                                <table id="datatable5" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Pharmacy Item<i class="text-danger"> * </i></th>
                                        <th>Batch ID</th>
                                        <th>Stock Qty</th>
                                        <th>Per Peice Price</th>
                                        <th>Total Item<i class="text-danger"> * </i></th>
                                        <th>Total Bill</th>
                                        <th>Note</th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datatable5_body">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_medicine_name" id="ot_treatment_pharmacy_item_medicine_name" name="ot_treatment_pharmacy_item_medicine_name[]" list="medicine_list" onchange="changeDataMedicine(this);" autocomplete="off">
                                            <input class="form-control ot_treatment_pharmacy_item_medicine_id" type="hidden" id="ot_treatment_pharmacy_item_medicine_id" name="ot_treatment_pharmacy_item_medicine_id[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_batch_id" placeholder="batch" id="ot_treatment_pharmacy_item_batch_id" name="ot_treatment_pharmacy_item_batch_id[]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_stock_qty" placeholder="Qty" id="ot_treatment_pharmacy_item_stock_qty" name="ot_treatment_pharmacy_item_stock_qty[]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_per_piece_price" placeholder="Price" id="ot_treatment_pharmacy_item_per_piece_price" name="ot_treatment_pharmacy_item_per_piece_price[]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_quantity" placeholder="Qty" id="ot_treatment_pharmacy_item_quantity" name="ot_treatment_pharmacy_item_quantity[]" onchange="medicine_row_update(this);">

                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_bill" placeholder="Bill" id="ot_treatment_pharmacy_item_bill" name="ot_treatment_pharmacy_item_bill[]" readonly>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_pharmacy_item_note" placeholder="Note" id="ot_treatment_pharmacy_item_note" name="ot_treatment_pharmacy_item_note[]">

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success pull-right" onclick="AddRowMedicine();"><i class="fa fa-plus"></i></button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="DeleteRowMedicine(this);"><i class="fa fa-minus"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table id="datatable6" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Item Price</th>
                                        <th>Item Qty</th>
                                        <th>Item Total</th>
                                        <th>Item Note</th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datatable6_body">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_item_name" placeholder="Item Name" id="ot_treatment_item_name" name="ot_treatment_item_name[]">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control ot_treatment_item_price" placeholder="Price" id="ot_treatment_item_price" name="ot_treatment_item_price[]" onchange="changeDataItem(this);">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control ot_treatment_item_qty" placeholder="Qty" id="ot_treatment_item_qty" name="ot_treatment_item_qty[]" onchange="changeDataItem(this);">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control ot_treatment_item_total" placeholder="Total" id="ot_treatment_item_total" name="ot_treatment_item_total[]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control ot_treatment_item_note" placeholder="Note" id="ot_treatment_item_note" name="ot_treatment_item_note[]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success pull-right" onclick="AddRowItem();"><i class="fa fa-plus"></i></button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger pull-right" onclick="DeleteRowItem(this);"><i class="fa fa-minus"></i></button>
                                        </td>
                                    </tr>
                                   

                                    </tbody>

                                </table>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_total_bill">Total Bill</label>
                                    <input type="number" placeholder="Total Bill" class="form-control" id="indoor_treatment_total_bill" name="indoor_treatment_total_bill" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_discount_pc">Discount %</label>
                                    <input type="number" min="0" max="100" placeholder="Discount" class="form-control" id="indoor_treatment_discount_pc" name="indoor_treatment_discount_pc" onchange="update_total_bill();" value="0" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_service_charge">Service Charge(10%)</label>
                                    <input type="number" placeholder="Service Charge" class="form-control" id="indoor_treatment_service_charge" name="indoor_treatment_service_charge" value="0" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_total_bill_after_discount">In Total Bill</label>
                                    <input type="number" placeholder="In Total Bill" class="form-control" id="indoor_treatment_total_bill_after_discount" name="indoor_treatment_total_bill_after_discount" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_total_paid">Paid<i class="text-danger"> * </i></label>
                                    <input type="number" placeholder="Total Paid" class="form-control" onchange="update_total_bill();" id="indoor_treatment_total_paid" name="indoor_treatment_total_paid" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_total_due">Due</label>
                                    <input type="number" placeholder="Total Due" class="form-control" id="indoor_treatment_total_due" name="indoor_treatment_total_due" value="0" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_payment_type">Payment Type<i class="text-danger"> * </i></label>
                                    <select class="form-control" id="indoor_treatment_payment_type" name="indoor_treatment_payment_type" required>
                                        <option value="">Select Payment Type</option>
                                        <option value="check">Check</option>
                                        <option value="card">Card</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_payment_type_no">Card/Check No</label>
                                    <input type="text" placeholder="Card/Check No" class="form-control" id="indoor_treatment_payment_type_no" name="indoor_treatment_payment_type_no">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="indoor_treatment_note">Note</label>
                                    <input type="text" placeholder="Note" class="form-control" id="indoor_treatment_note" name="indoor_treatment_note">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                </div>
                            </div>
                        </form>
                        <div id="loader"></div>
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
    var spinner = $('#loader');
    $(document).ready(function() {
        load_medicine();
        $('form#patient_allotment_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_indoor_patient_allotment.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    //alert(data);
                    console.log(data);
                    spinner.hide();
                    var obj = JSON.parse(data);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("indoor_treatment_list.php","_self");

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("alert : " + errorThrown);
                    spinner.hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });


        });
    });
    function load_medicine()
    {
        for (var i = 0; i < Object.keys(all_medicine).length; i++){
            $("#medicine_list").append('<option value="' + all_medicine[i]['pharmacy_medicine_id']+ '">' +  all_medicine[i]['medicine_name']+'~'+all_medicine[i]['pharmacy_medicine_batch_id']+'~'+all_medicine[i]['medicine_id']+ '</option>');
        }
    }
    function loadPatient()
    {
        let patient_phone = document.getElementById("outdoor_patient_phone").value;
        spinner.show();
        jQuery.ajax({
            type: 'POST',
            url: '../apis/get_patient.php',
            cache: false,
            //dataType: "json", // and this
            data: {
                token: "<?php echo $_SESSION['token']; ?>",
                request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                patient_phone: patient_phone,
                content: "patient_single_phone",
            },
            success: function(response) {
                //alert(response);
                spinner.hide();
                var obj = JSON.parse(response);
                var datas = obj.patient;
                if(datas === null)
                {
                    alert("No Patient Found");
                    document.getElementById("outdoor_patient_name").value = "";

                }

                var count = Object.keys(datas).length;
                if(count === 0)
                {
                    alert("No Patient Found");
                    document.getElementById("outdoor_patient_name").value = "";
                }
                else
                {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            document.getElementById("outdoor_patient_id").value = datas[key].patient_id;
                            document.getElementById("outdoor_patient_name").value = datas[key].patient_name;
                        }
                    }
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                spinner.hide();
                alert("alert : "+errorThrown);
            }
        });
    }
    var all_bed = <?php echo json_encode($result_content_indoor_bed); ?>;
    var all_doctor = <?php echo json_encode($result_content_doctor); ?>;
    var all_service = <?php echo json_encode($result_content_outdoor_service); ?>;
    var all_test = <?php echo json_encode($result_content_pathology_test); ?>;
    var all_medicine = <?php echo json_encode($result_content_medicine); ?>;

    function changeDataBed(instance)
    {
        var row = $(instance).closest("tr");
        var indoor_bed_id = parseFloat(row.find(".indoor_patient_bed_bed_id").val());

        for (var i = 0; i < Object.keys(all_bed).length; i++){
            //alert(all_bed[i]['indoor_bed_id']);
            //alert(indoor_bed_id);
            //alert(all_bed[i]['indoor_bed_id'] == indoor_bed_id);
            if(all_bed[i]['indoor_bed_id'] == indoor_bed_id)
            {
                //alert("matched");
                let per_day_price =isNaN(parseInt(all_bed[i]['indoor_bed_price'])) ? 0 : all_bed[i]['indoor_bed_price'];
                row.find(".indoor_bed_category_name").val(all_bed[i]['indoor_bed_category_name']);
                row.find(".indoor_bed_price").val(per_day_price);
                let entry_date = row.find(".indoor_patient_bed_entry_time").val();
                let discharge_date = row.find(".indoor_patient_bed_discharge_time").val();

                let total_dates = DateDiff(entry_date, discharge_date);
                row.find(".bed_total_bill").val(per_day_price * total_dates);

            }
        }
        update_total_bill();
    }
    function changeDataDoctor(instance)
    {
        var row = $(instance).closest("tr");
        var doctor_id = parseFloat(row.find(".indoor_patient_doctor_doctor_id").val());

        for (var i = 0; i < Object.keys(all_doctor).length; i++){
            //alert(all_bed[i]['indoor_bed_id']);
            //alert(indoor_bed_id);
            //alert(all_bed[i]['indoor_bed_id'] == indoor_bed_id);
            if(all_doctor[i]['doctor_id'] == doctor_id)
            {
                //alert("matched");
                let per_day_price =isNaN(parseInt(all_doctor[i]['doctor_visit_fee'])) ? 0 : all_doctor[i]['doctor_visit_fee'];
                row.find(".doctor_specialization").val(all_doctor[i]['doctor_specialization']);
                row.find(".doctor_visit_fee").val(per_day_price);

                let entry_date = row.find(".indoor_patient_doctor_entry_time").val();
                let discharge_date = row.find(".indoor_patient_doctor_discharge_time").val();

                let total_dates = DateDiff(entry_date, discharge_date);
                row.find(".doctor_total_bill").val(per_day_price * total_dates);
            }
        }
        update_total_bill();
    }
    function changeDataService(instance)
    {
        var row = $(instance).closest("tr");
        var outdoor_service_id = parseFloat(row.find(".outdoor_service_id").val());

        for (var i = 0; i < Object.keys(all_service).length; i++){
            if(all_service[i]['outdoor_service_id'] == outdoor_service_id)
            {
                row.find(".outdoor_service_rate").val(isNaN(parseInt(all_service[i]['outdoor_service_rate'])) ? 0 : all_service[i]['outdoor_service_rate']);
            }
        }
        var outdoor_service_rate = parseFloat(row.find(".outdoor_service_rate").val());
        var outdoor_service_quantity = parseFloat(row.find(".outdoor_service_quantity").val());
        //alert(outdoor_service_id);
        var total = parseInt(outdoor_service_rate) * parseInt(outdoor_service_quantity);
        row.find(".outdoor_service_total").val(isNaN(total) ? 0 : total);

        update_total_bill();
    }
    function changeDataTest(instance)
    {
        var row = $(instance).closest("tr");
        var pathology_test_id = parseFloat(row.find(".pathology_test_id").val());

        for (var i = 0; i < Object.keys(all_test).length; i++){
            if(all_test[i]['pathology_test_id'] == pathology_test_id)
            {
                row.find(".pathology_test_room_no").val(all_test[i]['pathology_test_room_no']);
                row.find(".pathology_investigation_test_price").val(isNaN(parseInt(all_test[i]['pathology_test_price'])) ? 0 : all_test[i]['pathology_test_price']);

            }
        }
        var pathology_test_rate = parseFloat(row.find(".pathology_investigation_test_price").val());
        var pathology_test_quantity = parseFloat(row.find(".pathology_investigation_test_quantity").val());
        //alert(outdoor_service_id);
        var total = parseInt(pathology_test_rate) * parseInt(pathology_test_quantity);
        row.find(".pathology_investigation_test_total_bill").val(isNaN(total) ? 0 : total);

        update_total_bill();
    }
    function changeDataMedicine(instance)
    {

        var row = $(instance).closest("tr");

        var val = row.find(".ot_treatment_pharmacy_item_medicine_name").val();
        if(val === "")
        {
            row.find(".ot_treatment_pharmacy_item_medicine_id").val("");
            row.find(".ot_treatment_pharmacy_item_batch_id").val("");
            row.find(".ot_treatment_pharmacy_item_stock_qty").val("");
            row.find(".ot_treatment_pharmacy_item_per_piece_price").val("");
            row.find(".ot_treatment_pharmacy_item_quantity").val("");
            row.find(".ot_treatment_pharmacy_item_bill").val("");
            row.find(".ot_treatment_pharmacy_item_note").val("");
            return;
        }
        const  data_name = $("#medicine_list option[value=" + val + "]").text();
        const arr = data_name.split("~");
        var name = arr[0];
        var batch_id = arr[1];
        var medicine_id = arr[2];
        var pharmacy_medicine_id = val;
        var obj = $("#medicine_list").find("option[value='" + val + "']");

        if(obj != null && obj.length > 0)
        {
            row.find(".ot_treatment_pharmacy_item_medicine_name").val(name);
            row.find(".ot_treatment_pharmacy_item_medicine_id").val(val);
            for (var i = 0; i < Object.keys(all_medicine).length; i++){
                if(all_medicine[i]['medicine_name'] === name && all_medicine[i]['pharmacy_medicine_batch_id'] === batch_id )
                {
                    //alert("matched");
                    row.find(".ot_treatment_pharmacy_item_batch_id").val(all_medicine[i]['pharmacy_medicine_batch_id']);

                    row.find(".ot_treatment_pharmacy_item_stock_qty").val(all_medicine[i]['total_quantity']-all_medicine[i]['total_sell']);
                    //alert(all_medicine[i]['total_quantity']);
                    var per_pc_price = (parseFloat(all_medicine[i]['medicine_selling_price'])/(parseInt(all_medicine[i]['medicine_leaf_name']) * parseInt(all_medicine[i]['medicine_leaf_total_per_box']))) ;
                    //alert(per_pc_price);
                    row.find(".ot_treatment_pharmacy_item_per_piece_price").val(per_pc_price);

                    var selling_pieces = row.find(".ot_treatment_pharmacy_item_quantity").val();
                    var total_selling_price = parseFloat(selling_pieces) * per_pc_price;

                    row.find(".ot_treatment_pharmacy_item_bill").val(total_selling_price);
                }
            }
            medicine_row_update();
        }
        else
        {
            alert("Medicine Not Available"); // don't allow form submission
            row.find(".ot_treatment_pharmacy_item_medicine_name").val("");
            row.find(".ot_treatment_pharmacy_item_medicine_id").val("");
            row.find(".ot_treatment_pharmacy_item_batch_id").val("");
            row.find(".ot_treatment_pharmacy_item_stock_qty").val("");
            row.find(".ot_treatment_pharmacy_item_per_piece_price").val("");
            row.find(".ot_treatment_pharmacy_item_quantity").val("");
            row.find(".ot_treatment_pharmacy_item_bill").val("");
            row.find(".ot_treatment_pharmacy_item_note").val("");
        }
    }
    function medicine_row_update(instance)
    {

        var row = $(instance).closest("tr");
        let medicine_name = row.find(".ot_treatment_pharmacy_item_medicine_name").val();
        //alert(medicine_name);
        for (var i = 0; i < Object.keys(all_medicine).length; i++){
            if(all_medicine[i]['medicine_name'] === medicine_name)
            {
                //alert("matched");
                row.find(".ot_treatment_pharmacy_item_batch_id").val(all_medicine[i]['pharmacy_medicine_batch_id']);

                    row.find(".ot_treatment_pharmacy_item_stock_qty").val(all_medicine[i]['total_quantity']-all_medicine[i]['total_sell']);
                    //alert(all_medicine[i]['total_quantity']);
                    var per_pc_price = (parseFloat(all_medicine[i]['medicine_selling_price'])/(parseInt(all_medicine[i]['medicine_leaf_name']) * parseInt(all_medicine[i]['medicine_leaf_total_per_box']))) ;
                    //alert(per_pc_price);
                    row.find(".ot_treatment_pharmacy_item_per_piece_price").val(per_pc_price);

                    var selling_pieces = row.find(".ot_treatment_pharmacy_item_quantity").val();
                    var total_selling_price = parseFloat(selling_pieces) * per_pc_price;

                    row.find(".ot_treatment_pharmacy_item_bill").val(total_selling_price);
            }
        }
        //total_calculation_update();
        update_total_bill();

    }
    function changeDataItem(instance)
    {
        var row = $(instance).closest("tr");
        console.log(row);
        var ot_treatment_item_price = row.find(".ot_treatment_item_price").val();
        var ot_treatment_item_qty = row.find(".ot_treatment_item_qty").val();
        var total = parseInt(ot_treatment_item_price) * parseInt(ot_treatment_item_qty);
        row.find(".ot_treatment_item_total").val(isNaN(total) ? 0 : total);
        update_total_bill();
    }
    function DateDiff(date1, date2) {
        date1 = new Date(date1);
        date2 = new Date(date2);
        date1.setHours(0);
        date1.setMinutes(0, 0, 0);
        date2.setHours(0);
        date2.setMinutes(0, 0, 0);
        var datediff = Math.abs(date1.getTime() - date2.getTime()); // difference
        return parseInt(datediff / (24 * 60 * 60 * 1000), 10); //Convert values days and return value
    }
    function update_total_bill()
    {
        var bedtotal = 0;
        $("#datatable1 tr").each(function() {
            var total = $(this).find("input.bed_total_bill").val();
            bedtotal = parseInt(bedtotal)  + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var doctortotal = 0;
        $("#datatable2 tr").each(function() {
            var total = $(this).find("input.doctor_total_bill").val();
            doctortotal = parseInt(doctortotal)  + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var servicetotal = 0;
        $("#datatable3 tr").each(function() {
            var total = $(this).find("input.outdoor_service_total").val();
            servicetotal = parseInt(servicetotal)  + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var testtotal = 0;
        $("#datatable4 tr").each(function() {
            var total = $(this).find("input.pathology_investigation_test_total_bill").val();
            testtotal = parseInt(testtotal)  + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var medicinetotal = 0;
        $("#datatable5 tr").each(function() {
            var total = $(this).find("input.ot_treatment_pharmacy_item_bill").val();
            medicinetotal = parseInt(medicinetotal)  + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var ottotal = 0;
        $("#datatable6 tr").each(function() {
            var total = $(this).find("input.ot_treatment_item_total").val();
            ottotal = parseInt(ottotal)  + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        let in_total = bedtotal+doctortotal+servicetotal+testtotal+medicinetotal+ottotal;
        let service_charge = (parseInt(in_total) * (parseInt(10)/100));;
        document.getElementById("indoor_treatment_service_charge").value = service_charge;
        document.getElementById("indoor_treatment_total_bill").value = parseInt(in_total);
        var discount = document.getElementById("indoor_treatment_discount_pc").value;
        discount = isNaN(parseInt(discount)) ? 0 : parseInt(discount) ;
        in_total = (parseInt(in_total) - (parseInt(in_total) * (parseInt(discount)/100))) + service_charge;
        document.getElementById("indoor_treatment_total_bill_after_discount").value = in_total;
        var paid = document.getElementById("indoor_treatment_total_paid").value;
        document.getElementById("indoor_treatment_total_due").value = parseInt(in_total - paid);


    }
    function AddRowBed() {
        //alert("table q19");
        var table = document.getElementById('datatable1_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var td7 = document.createElement('td');
        var td8 = document.createElement('td');

        var selectList = document.createElement("select");
        selectList.setAttribute("id", "indoor_patient_bed_bed_id");
        selectList.setAttribute("required", "required");
        selectList.setAttribute("name", "indoor_patient_bed_bed_id[]");
        selectList.setAttribute("class", "form-control indoor_patient_bed_bed_id");

        var option = document.createElement("option");
        option.setAttribute("value", "");
        option.text = "Select a Bed...";
        selectList.appendChild(option);

        for (var j = 0; j < Object.keys(all_bed).length; j++) {
            var option = document.createElement("option");
            option.setAttribute("value", all_bed[j]['indoor_bed_id']);
            option.text = all_bed[j]['indoor_bed_name'];
            selectList.appendChild(option);
        }
        selectList.onchange = function () {
            changeDataBed(this);
        }

        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control indoor_bed_category_name");
        text2.setAttribute("type", "text");
        text2.setAttribute("placeholder", "Category");
        text2.setAttribute("name", "indoor_bed_category_name[]");
        text2.setAttribute("readonly", "readonly");

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control indoor_bed_price");
        text3.setAttribute("placeholder", "Price");
        text3.setAttribute("name", "indoor_bed_price[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control bed_total_bill");
        text4.setAttribute("placeholder", "Bill");
        text4.setAttribute("name", "bed_total_bill[]");
        text4.setAttribute("readonly", "readonly");

        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "datetime-local");
        text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control indoor_patient_bed_entry_time");
        text5.setAttribute("placeholder", "Entry");
        text5.setAttribute("name", "indoor_patient_bed_entry_time[]");
        text5.onchange = function () {
            changeDataBed(this);
        }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "datetime-local");
        // text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control indoor_patient_bed_discharge_time");
        text6.setAttribute("placeholder", "Discharge");
        text6.setAttribute("name", "indoor_patient_bed_discharge_time[]");
        text6.onchange = function () {
            changeDataBed(this);
        }
        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type","button");
        buttonAdd.innerHTML='<i class="fa fa-plus"></i>';
        buttonAdd.setAttribute("class","btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowBed(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type","button");
        buttonRemove.innerHTML='<i class="fa fa-minus"></i>';
        buttonRemove.setAttribute("class","btn btn-danger pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowBed(this);
        };


        td1.appendChild(selectList);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        td5.appendChild(text5);
        td6.appendChild(text6);
        td7.appendChild(buttonAdd);
        td8.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);
        tr.appendChild(td7);
        tr.appendChild(td8);


        table.appendChild(tr);

    }
    function AddRowDoctor() {
        //alert("table q19");
        var table = document.getElementById('datatable2_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var td7 = document.createElement('td');
        var td8 = document.createElement('td');



        var selectList = document.createElement("select");
        selectList.setAttribute("id", "indoor_patient_doctor_doctor_id");
        selectList.setAttribute("required", "required");
        selectList.setAttribute("name", "indoor_patient_doctor_doctor_id[]");
        selectList.setAttribute("class", "form-control indoor_patient_doctor_doctor_id");

        var option = document.createElement("option");
        option.setAttribute("value", "");
        option.text = "Select a Doctor...";
        selectList.appendChild(option);

        for (var j = 0; j < Object.keys(all_doctor).length; j++) {
            var option = document.createElement("option");
            option.setAttribute("value", all_doctor[j]['doctor_id']);
            option.text = all_doctor[j]['doctor_name'];
            selectList.appendChild(option);
        }
        selectList.onchange = function () {
            changeDataDoctor(this);
        }

        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control doctor_specialization");
        text2.setAttribute("type", "text");
        text2.setAttribute("placeholder", "Specialization");
        text2.setAttribute("name", "doctor_specialization[]");
        text2.setAttribute("readonly", "readonly");

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control doctor_visit_fee");
        text3.setAttribute("placeholder", "Fee");
        text3.setAttribute("name", "doctor_visit_fee[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control doctor_total_bill");
        text4.setAttribute("placeholder", "Bill");
        text4.setAttribute("name", "doctor_total_bill[]");
        text4.setAttribute("readonly", "readonly");

        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "datetime-local");
        text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control indoor_patient_doctor_entry_time");
        text5.setAttribute("placeholder", "Entry");
        text5.setAttribute("name", "indoor_patient_doctor_entry_time[]");
        text5.onchange = function () {
            changeDataDoctor(this);
        }
        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "datetime-local");
        // text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control indoor_patient_doctor_discharge_time");
        text6.setAttribute("placeholder", "Discharge");
        text6.setAttribute("name", "indoor_patient_doctor_discharge_time[]");
        text6.onchange = function () {
            changeDataDoctor(this);
        }
        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type","button");
        buttonAdd.innerHTML='<i class="fa fa-plus"></i>';
        buttonAdd.setAttribute("class","btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowDoctor(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type","button");
        buttonRemove.innerHTML='<i class="fa fa-minus"></i>';
        buttonRemove.setAttribute("class","btn btn-danger pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowDoctor(this);
        };


        td1.appendChild(selectList);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        td5.appendChild(text5);
        td6.appendChild(text6);
        td7.appendChild(buttonAdd);
        td8.appendChild(buttonRemove);

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);
        tr.appendChild(td7);
        tr.appendChild(td8);


        table.appendChild(tr);

    }
    function AddRowService() {
        //alert("table q19");
        var table = document.getElementById('datatable3_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');

        /*var text1 = document.createElement("INPUT");
        text1.setAttribute("required", "required");
        text1.setAttribute("class", "form-control outdoor_service_id");
        text1.setAttribute("type", "text");
        text1.setAttribute("list", "service");
        text1.setAttribute("name", "outdoor_service_id[]");
        text1.setAttribute("placeholder", "Pick a Service...");
        text1.onchange = function () {
            changeData(this);
        }*/

        var selectList = document.createElement("select");
        selectList.setAttribute("id", "outdoor_service_id");
        selectList.setAttribute("required", "required");
        selectList.setAttribute("name", "outdoor_service_id[]");
        selectList.setAttribute("class", "form-control outdoor_service_id");

        var option = document.createElement("option");
        option.setAttribute("value", "");
        option.text = "Select a Service...";
        selectList.appendChild(option);

        for (var j = 0; j < Object.keys(all_service).length; j++) {
            var option = document.createElement("option");
            option.setAttribute("value", all_service[j]['outdoor_service_id']);
            option.text = all_service[j]['outdoor_service_name'];
            selectList.appendChild(option);
        }
        selectList.onchange = function () {
            changeDataService(this);
        }

        //var cell = row.insertCell();
        //cell.appendChild(selectList);




        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control outdoor_service_quantity");
        text2.setAttribute("type", "number");
        text2.setAttribute("placeholder", "Service Quantity");
        text2.setAttribute("name", "outdoor_service_quantity[]");
        text2.onchange = function () {
            changeDataService(this);
        }

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control outdoor_service_rate");
        text3.setAttribute("placeholder", "Service Rate");
        text3.setAttribute("name", "outdoor_service_rate[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control outdoor_service_total");
        text4.setAttribute("placeholder", "Service Total");

        text4.setAttribute("name", "outdoor_service_total[]");
        text4.setAttribute("readonly", "readonly");

        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type","button");
        buttonAdd.innerHTML='<i class="fa fa-plus"></i>';
        buttonAdd.setAttribute("class","btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowService(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type","button");
        buttonRemove.innerHTML='<i class="fa fa-minus"></i>';
        buttonRemove.setAttribute("class","btn btn-danger pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowService(this);
        };


        td1.appendChild(selectList);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);

        td5.appendChild(buttonAdd);
        td6.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);


        table.appendChild(tr);

    }
    function AddRowTest() {
        //alert("table q19");
        var table = document.getElementById('datatable4_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var td7 = document.createElement('td');

        var selectList = document.createElement("select");
        selectList.setAttribute("id", "pathology_test_id");
        selectList.setAttribute("required", "required");
        selectList.setAttribute("name", "pathology_test_id[]");
        selectList.setAttribute("class", "form-control pathology_test_id");

        var option = document.createElement("option");
        option.setAttribute("value", "");
        option.text = "Select a Test...";
        selectList.appendChild(option);

        for (var j = 0; j < Object.keys(all_test).length; j++) {
            var option = document.createElement("option");
            option.setAttribute("value", all_test[j]['pathology_test_id']);
            option.text = all_test[j]['pathology_test_name'];
            selectList.appendChild(option);
        }
        selectList.onchange = function () {
            changeDataTest(this);
        }

        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control pathology_test_room_no");
        text2.setAttribute("type", "number");
        text2.setAttribute("placeholder", "Room No");
        text2.setAttribute("name", "pathology_test_room_no[]");
        text2.setAttribute("readonly", "readonly");


        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control pathology_investigation_test_price");
        text3.setAttribute("placeholder", "Price");
        text3.setAttribute("name", "pathology_investigation_test_price[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control pathology_investigation_test_quantity");
        text4.setAttribute("placeholder", "Quantity");
        text4.setAttribute("name", "pathology_investigation_test_quantity[]");
        text4.onchange = function () {
            changeDataTest(this);
        }
        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "number");
        text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control pathology_investigation_test_total_bill");
        text5.setAttribute("placeholder", "Total");
        text5.setAttribute("name", "pathology_investigation_test_total_bill[]");
        text5.setAttribute("readonly", "readonly");


        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type","button");
        buttonAdd.innerHTML='<i class="fa fa-plus"></i>';
        buttonAdd.setAttribute("class","btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowTest(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type","button");
        buttonRemove.innerHTML='<i class="fa fa-minus"></i>';
        buttonRemove.setAttribute("class","btn btn-danger pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowTest(this);
        };


        td1.appendChild(selectList);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        td5.appendChild(text5);
        td6.appendChild(buttonAdd);
        td7.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);
        tr.appendChild(td7);

        table.appendChild(tr);

    }
    function AddRowMedicine() {
        //alert("table q19");
        var table = document.getElementById('datatable5_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var td7 = document.createElement('td');
        var td8 = document.createElement('td');
        var td9 = document.createElement('td');
        var td10 = document.createElement('td');


        var text1 = document.createElement("INPUT");
        text1.setAttribute("class", "form-control ot_treatment_pharmacy_item_medicine_name");
        text1.setAttribute("type", "text");
        text1.setAttribute("list", "medicine_list");
        text1.setAttribute("id", "ot_treatment_pharmacy_item_medicine_name");
        text1.setAttribute("name", "ot_treatment_pharmacy_item_medicine_name[]");
        text1.setAttribute("placeholder", "Pick a Service...");
        text1.onchange = function () {
            changeDataMedicine(this);
        }
        var hiddenText = document.createElement("INPUT");
        hiddenText.setAttribute("class", "form-control ot_treatment_pharmacy_item_medicine_id");
        hiddenText.setAttribute("type", "hidden");
        hiddenText.setAttribute("id", "ot_treatment_pharmacy_item_medicine_id");
        hiddenText.setAttribute("name", "ot_treatment_pharmacy_item_medicine_id[]");

        //var cell = row.insertCell();
        //cell.appendChild(selectList);




        var text2 = document.createElement("INPUT");
        text2.setAttribute("class", "form-control ot_treatment_pharmacy_item_batch_id");
        text2.setAttribute("type", "text");
        text2.setAttribute("placeholder", "Batch ID");
        text2.setAttribute("name", "ot_treatment_pharmacy_item_batch_id[]");
        text2.setAttribute("readonly", "readonly");

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "text");
        text3.setAttribute("class", "form-control ot_treatment_pharmacy_item_stock_qty");
        text3.setAttribute("placeholder", "Qty");
        text3.setAttribute("name", "ot_treatment_pharmacy_item_stock_qty[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "text");
        text4.setAttribute("class", "form-control ot_treatment_pharmacy_item_per_piece_price");
        text4.setAttribute("placeholder", "Item Price");
        text4.setAttribute("name", "ot_treatment_pharmacy_item_per_piece_price[]");
        text4.setAttribute("readonly", "readonly");


        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "text");
        text5.setAttribute("class", "form-control ot_treatment_pharmacy_item_quantity");
        text5.setAttribute("placeholder", "Qty");
        text5.setAttribute("name", "ot_treatment_pharmacy_item_quantity[]");
        text5.onchange = function (){
            medicine_row_update(this);
        }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "text");
        text6.setAttribute("class", "form-control ot_treatment_pharmacy_item_bill");
        text6.setAttribute("placeholder", "Bill");
        text6.setAttribute("name", "ot_treatment_pharmacy_item_bill[]");
        text6.setAttribute("readonly", "readonly");



        var text7 = document.createElement("INPUT");
        text7.setAttribute("type", "text");
        text7.setAttribute("class", "form-control ot_treatment_pharmacy_item_note");
        text7.setAttribute("placeholder", "Note");
        text7.setAttribute("name", "ot_treatment_pharmacy_item_note[]");


        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type","button");
        buttonAdd.innerHTML='<i class="fa fa-plus"></i>';
        buttonAdd.setAttribute("class","btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowMedicine(this);
        };
       

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type","button");
        buttonRemove.innerHTML='<i class="fa fa-minus"></i>';
        buttonRemove.setAttribute("class","btn btn-danger pull-right");

        buttonRemove.onclick = function() {
            // ...
            DeleteRowMedicine(this);

        };
        td1.appendChild(text1);
        td1.appendChild(hiddenText);

        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        td5.appendChild(text5);
        td6.appendChild(text6);
        td7.appendChild(text7);
        td8.appendChild(buttonAdd);
        td9.appendChild(buttonRemove);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);
        tr.appendChild(td7);
        tr.appendChild(td8);
        tr.appendChild(td9);
        table.appendChild(tr);

    }
    function AddRowItem() {
        //alert("table q19");
        var table = document.getElementById('datatable6_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var td7 = document.createElement('td');
       
        var text1 = document.createElement("INPUT");
        text1.setAttribute("class", "form-control ot_treatment_item_name");
        text1.setAttribute("type", "text");
        text1.setAttribute("placeholder", "Name");
        text1.setAttribute("name", "ot_treatment_item_name[]");
        
        var text2 = document.createElement("INPUT");
        text2.setAttribute("type", "number");
        text2.setAttribute("class", "form-control ot_treatment_item_price");
        text2.setAttribute("placeholder", "Price");
        text2.setAttribute("name", "ot_treatment_item_price[]");
        text2.onchange = function () {
            changeDataItem(this);
        }

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        text3.setAttribute("class", "form-control ot_treatment_item_qty");
        text3.setAttribute("placeholder", "Qty");
        text3.setAttribute("name", "ot_treatment_item_qty[]");
        text3.onchange = function () {
            changeDataItem(this);
        }

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        text4.setAttribute("class", "form-control ot_treatment_item_total");
        text4.setAttribute("placeholder", "Total");
        text4.setAttribute("name", "ot_treatment_item_total[]");
        text4.setAttribute("readonly", "readonly");
        
        var text5 = document.createElement("INPUT");
        text5.setAttribute("class", "form-control ot_treatment_item_note");
        text5.setAttribute("type", "text");
        text5.setAttribute("placeholder", "Note");
        text5.setAttribute("name", "ot_treatment_item_note[]");

        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type","button");
        buttonAdd.innerHTML='<i class="fa fa-plus"></i>';
        buttonAdd.setAttribute("class","btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowItem(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type","button");
        buttonRemove.innerHTML='<i class="fa fa-minus"></i>';
        buttonRemove.setAttribute("class","btn btn-danger pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowItem(this);
        };


        td1.appendChild(text1);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        td5.appendChild(text5);
        td6.appendChild(buttonAdd);
        td7.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);
        tr.appendChild(td7);

        table.appendChild(tr);

    }
    function DeleteRowTest(ctl) {
        var table = document.getElementById('datatable4');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if(count-1 > 1)
        {
            $(ctl).parents("tr").remove();
        }
        else
        {
            alert("At-least 1 Row is Required in service table");
        }
        update_total_bill();
    }

    function DeleteRowService(ctl) {
        var table = document.getElementById('datatable3');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if(count-1 > 1)
        {
            $(ctl).parents("tr").remove();
        }
        else
        {
            alert("At-least 1 Row is Required in service table");
        }
        update_total_bill();
    }
    function DeleteRowBed(ctl) {
        var table = document.getElementById('datatable1');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if(count-1 > 1)
        {
            $(ctl).parents("tr").remove();
        }
        else
        {
            alert("At-least 1 Row is Required in service table");
        }
        update_total_bill();
    }
    function DeleteRowDoctor(ctl) {
        var table = document.getElementById('datatable2');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if(count-1 > 1)
        {
            $(ctl).parents("tr").remove();
        }
        else
        {
            alert("At-least 1 Row is Required in service table");
        }
        update_total_bill();
    }
    function DeleteRowMedicine(ctl) {
        var table = document.getElementById('datatable5');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if(count-1 > 1)
        {
            $(ctl).parents("tr").remove();
        }
        else
        {
            alert("At-least 1 Row is Required in service table");
        }
        update_total_bill();
    }
    function DeleteRowItem(ctl) {
        var table = document.getElementById('datatable6');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if(count-1 > 1)
        {
            $(ctl).parents("tr").remove();
        }
        else
        {
            alert("At-least 1 Row is Required in service table");
        }
        update_total_bill();
    }


</script>
<script>
    $('#datatable1').dataTable({
    "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging                
    "bPaginate": false,//Dont want paging
    searching: false,    
    }); //replace id with your first table's id
    $('#datatable2').dataTable({
    "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging                
    "bPaginate": false,//Dont want paging
    searching: false,    
    }); //replace id with your first table's id
    $('#datatable3').dataTable({
    "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging                
    "bPaginate": false,//Dont want paging 
    searching: false,   
    }); //replace id with your first table's id
    $('#datatable4').dataTable({
    "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging                
    "bPaginate": false,//Dont want paging 
    searching: false,   
    }); //replace id with your first table's id
    $('#datatable5').dataTable({
    "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging                
    "bPaginate": false,//Dont want paging 
    searching: false,   
    }); //replace id with your first table's id
    $('#datatable6').dataTable({
    "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging                
    "bPaginate": false,//Dont want paging 
    searching: false,   
    }); //replace id with your first table's id

</script>

<script>
    $(document).ready(function () {
        $('#select-patient').selectize({
            sortField: 'text'
        });
    });
</script>

</html>