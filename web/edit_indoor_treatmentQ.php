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
                $indoor_treatment_id = $_GET['indoor_treatment_id'];

                $get_content = "select * from patient";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from indoor_bed 
                left join indoor_bed_category ibc on ibc.indoor_bed_category_id = indoor_bed.indoor_bed_category_id
                left join indoor_treatment_bed itb on indoor_bed.indoor_bed_id = itb.indoor_treatment_bed_bed_id
                where indoor_bed.indoor_bed_status='available' OR indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
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

                $get_content = "select * from indoor_bed 
                left join indoor_bed_category ibc on ibc.indoor_bed_category_id = indoor_bed.indoor_bed_category_id
                left join indoor_treatment_bed itb on indoor_bed.indoor_bed_id = itb.indoor_treatment_bed_bed_id
                where indoor_bed.indoor_bed_status='available' OR indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_bed_available = $getJson->fetchAll(PDO::FETCH_ASSOC);


                $get_content = "select * from doctor";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);


                $get_content = "select * from indoor_treatment
                left join patient p on p.patient_id = indoor_treatment.indoor_treatment_patient_id
                where indoor_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);


                $get_content = "select * from indoor_treatment_bed
                where indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_treatment_bed = $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from indoor_treatment_doctor
                where indoor_treatment_doctor_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_treatment_doctor= $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from indoor_treatment_service
                where indoor_treatment_service_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_treatment_service= $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select * from indoor_pathology_investigation_test
                where pathology_investigation_test_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_treatment_investigation= $getJson->fetchAll(PDO::FETCH_ASSOC);

                $get_content = "select *,
                (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
                (SELECT  SUM(psm.indoor_pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
 LEFT JOIN indoor_pharmacy_sell_medicine psm ON psm.indoor_pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
 WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell
          from indoor_pharmacy_sell_medicine AS ipsm
                left join pharmacy_medicine pm ON ipsm.indoor_pharmacy_sell_medicine_medicine_id=pm.pharmacy_medicine_id
                left join medicine m on pm.pharmacy_medicine_medicine_id = m.medicine_id
                left join medicine_leaf ml on ml.medicine_leaf_id = m.medicine_leaf
                where indoor_pharmacy_sell_medicine_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_indoor_treatment_pharmacy_item = $getJson->fetchAll(PDO::FETCH_ASSOC);


                $get_content = "select * from ot_treatment_item 
                where ot_treatment_item_treatment_id='$indoor_treatment_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content_ot_item = $getJson->fetchAll(PDO::FETCH_ASSOC);


                ?>
                <div class="col-md-12">
                    <div class="widget-area-2 proclinic-box-shadow">
                        <h3 class="widget-title">Patient Allotment</h3>
                        <form class="form-horizontal form-material mb-0" id="patient_allotment_form" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-row">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="indoor_treatment_id" value="<?php echo $indoor_treatment_id; ?>">
                                <input type="hidden" name="content" value="indoor_allotment">

                                <div class="form-group col-md-6">
                                    <label for="outdoor_patient_phone">Patient Phone<i class="text-danger"> * </i></label>
                                    <input type="text" placeholder="Patient Phone." class="form-control" id="outdoor_patient_phone" name="outdoor_patient_phone" value="<?php echo $result_content_indoor_treatment[0]['patient_phone']?>" required onchange="loadPatient();">
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
                                    </tbody>

                                </table>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_total_bill">Total Bill</label>
                                    <input type="number" placeholder="Total Bill" class="form-control" id="indoor_treatment_total_bill" name="indoor_treatment_total_bill" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_total_bill']?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_discount_pc">Discount %</label>
                                    <input type="number" min="0" max="100" placeholder="Discount" class="form-control" id="indoor_treatment_discount_pc" name="indoor_treatment_discount_pc" onchange="update_total_bill();" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_discount_pc']?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_service_charge">Service Charge(10%)</label>
                                    <input type="number" placeholder="Service Charge" class="form-control" id="indoor_treatment_service_charge" name="indoor_treatment_service_charge" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_service_charge']?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indoor_treatment_total_bill_after_discount">In Total Bill</label>
                                    <input type="number" placeholder="In Total Bill" class="form-control" id="indoor_treatment_total_bill_after_discount" name="indoor_treatment_total_bill_after_discount" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_total_bill_after_discount']?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_total_paid">Paid<i class="text-danger"> * </i></label>
                                    <input type="number" placeholder="Total Paid" class="form-control" onchange="update_total_bill();" id="indoor_treatment_total_paid" name="indoor_treatment_total_paid" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_total_paid']?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_total_due">Due</label>
                                    <input type="number" placeholder="Total Due" class="form-control" id="indoor_treatment_total_due" name="indoor_treatment_total_due" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_total_due']?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_payment_type">Payment Type<i class="text-danger"> * </i></label>
                                    <select class="form-control" id="indoor_treatment_payment_type" name="indoor_treatment_payment_type"  required>
                                        <option value="">Select Payment Type</option>
                                        <option <?php if ($result_content_indoor_treatment[0]['indoor_treatment_payment_type'] == "check") {
                                            echo 'selected';
                                        } ?> value="check">Check</option>
                                        <option <?php if ($result_content_indoor_treatment[0]['indoor_treatment_payment_type'] == "card") {
                                            echo 'selected';
                                        } ?> value="card">Card</option>
                                        <option <?php if ($result_content_indoor_treatment[0]['indoor_treatment_payment_type'] == "cash") {
                                            echo 'selected';
                                        } ?> value="cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="indoor_treatment_payment_type_no">Card/Check No</label>
                                    <input type="text" placeholder="Card/Check No" class="form-control" id="indoor_treatment_payment_type_no" name="indoor_treatment_payment_type_no" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_payment_type_no']?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="indoor_treatment_note">Note</label>
                                    <input type="text" placeholder="Note" class="form-control" id="indoor_treatment_note" name="indoor_treatment_note" value="<?php echo $result_content_indoor_treatment[0]['indoor_treatment_note']?>">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                    <button class="btn btn-primary btn-lg" onclick="invoice();">invoice</button>

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
    var all_bed = <?php echo json_encode($result_content_indoor_bed); ?>;
    var all_doctor = <?php echo json_encode($result_content_doctor); ?>;
    var all_service = <?php echo json_encode($result_content_outdoor_service); ?>;
    var all_test = <?php echo json_encode($result_content_pathology_test); ?>;
    var all_medicine = <?php echo json_encode($result_content_medicine); ?>;
    let admission_date = "<?php echo $result_content_indoor_treatment[0]['indoor_treatment_admission_date']; ?>";
    let date = new Date(admission_date);
    document.getElementById("indoor_treatment_admission_date").value = date.toLocaleDateString('en-CA');
    let referer_doctor = "<?php echo $result_content_indoor_treatment[0]['indoor_treatment_referer_doctor_id']; ?>";
    $('select[name="indoor_treatment_referer_doctor_id"]').find('option[value="' + referer_doctor + '"]').attr("selected", true);

    loadPatient();
    InitRowDoctor();
    InitRowBed();
    InitRowService();
    InitRowInvestigation();
    InitRowMedicine();
    InitRowItem();
    $(document).ready(function() {
        load_medicine();
        $('form#patient_allotment_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_indoor_patient_allotment.php',
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
    function invoice()
    {
        let treatment_id = "<?php echo $indoor_treatment_id; ?>";
        window.open("indoor_invoice.php?treatment_id="+treatment_id,"_blank");
        // form=document.getElementById('patient_allotment_form');
        // form.target='_blank';
        // form.action='indoor_invoice.php';
        // form.submit();
        // form.action='indoor_invoice.php';
        // form.target='';
    }
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
    function AddRowBed(required=true) {
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
        if (required)
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
        text2.setAttribute("class", "form-control indoor_bed_category_name");
        text2.setAttribute("type", "text");
        if (required)
            text2.setAttribute("required", "required");
        text2.setAttribute("placeholder", "Category");
        text2.setAttribute("name", "indoor_bed_category_name[]");
        text2.setAttribute("readonly", "readonly");

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        if (required)
            text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control indoor_bed_price");
        text3.setAttribute("placeholder", "Price");
        text3.setAttribute("name", "indoor_bed_price[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        if (required)
            text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control bed_total_bill");
        text4.setAttribute("placeholder", "Bill");
        text4.setAttribute("name", "bed_total_bill[]");
        text4.setAttribute("readonly", "readonly");

        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "datetime-local");
        if (required)
            text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control indoor_patient_bed_entry_time");
        text5.setAttribute("placeholder", "Entry");
        text5.setAttribute("name", "indoor_patient_bed_entry_time[]");
        text5.onchange = function () {
            changeDataBed(this);
        }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "datetime-local");
        if (required)
            text6.setAttribute("required", "required");
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
    function AddRowDoctor(required=true) {
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
        if (required)
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
        text2.setAttribute("class", "form-control doctor_specialization");
        if (required)
            text2.setAttribute("required", "required");
        text2.setAttribute("type", "text");
        text2.setAttribute("placeholder", "Specialization");
        text2.setAttribute("name", "doctor_specialization[]");
        text2.setAttribute("readonly", "readonly");

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        if (required)
            text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control doctor_visit_fee");
        text3.setAttribute("placeholder", "Fee");
        text3.setAttribute("name", "doctor_visit_fee[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        if (required)
            text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control doctor_total_bill");
        text4.setAttribute("placeholder", "Bill");
        text4.setAttribute("name", "doctor_total_bill[]");
        text4.setAttribute("readonly", "readonly");

        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "datetime-local");
        if (required)
            text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control indoor_patient_doctor_entry_time");
        text5.setAttribute("placeholder", "Entry");
        text5.setAttribute("name", "indoor_patient_doctor_entry_time[]");
        text5.onchange = function () {
            changeDataDoctor(this);
        }
        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "datetime-local");
        if (required)
            text6.setAttribute("required", "required");
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
    function AddRowService(required=true) {
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
        if (required)
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
        if (required)
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
        if (required)
            text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control outdoor_service_rate");
        text3.setAttribute("placeholder", "Service Rate");
        text3.setAttribute("name", "outdoor_service_rate[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        if (required)
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
    function AddRowTest(required=true) {
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
        if (required)
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
        text2.setAttribute("class", "form-control pathology_test_room_no");
        text2.setAttribute("type", "number");
        if (required)
            text2.setAttribute("required", "required");
        text2.setAttribute("placeholder", "Room No");
        text2.setAttribute("name", "pathology_test_room_no[]");
        text2.setAttribute("readonly", "readonly");


        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        if (required)
            text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control pathology_investigation_test_price");
        text3.setAttribute("placeholder", "Price");
        text3.setAttribute("name", "pathology_investigation_test_price[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        if (required)
            text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control pathology_investigation_test_quantity");
        text4.setAttribute("placeholder", "Quantity");
        text4.setAttribute("name", "pathology_investigation_test_quantity[]");
        text4.onchange = function () {
            changeDataTest(this);
        }
        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "number");
        if (required)
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
    function AddRowMedicine(required=true) {
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
        if (required)
            text1.setAttribute("required", "required");
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
        if (required)
            text2.setAttribute("required", "required");
        text2.setAttribute("placeholder", "Batch ID");
        text2.setAttribute("name", "ot_treatment_pharmacy_item_batch_id[]");
        text2.setAttribute("readonly", "readonly");

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "text");
        if (required)
            text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control ot_treatment_pharmacy_item_stock_qty");
        text3.setAttribute("placeholder", "Qty");
        text3.setAttribute("name", "ot_treatment_pharmacy_item_stock_qty[]");
        text3.setAttribute("readonly", "readonly");

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "text");
        if (required)
            text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control ot_treatment_pharmacy_item_per_piece_price");
        text4.setAttribute("placeholder", "Item Price");
        text4.setAttribute("name", "ot_treatment_pharmacy_item_per_piece_price[]");
        text4.setAttribute("readonly", "readonly");


        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "number");
        if (required)
            text5.setAttribute("required", "required");
        text5.setAttribute("type", "text");
        text5.setAttribute("class", "form-control ot_treatment_pharmacy_item_quantity");
        text5.setAttribute("placeholder", "Qty");
        text5.setAttribute("name", "ot_treatment_pharmacy_item_quantity[]");
        text5.onchange = function (){
            medicine_row_update(this);
        }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "text");
        if (required)
            text6.setAttribute("required", "required");
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
    function AddRowItem(required=true) {
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
        if (required)
            text1.setAttribute("required", "required");
        text1.setAttribute("placeholder", "Name");
        text1.setAttribute("name", "ot_treatment_item_name[]");
        
        var text2 = document.createElement("INPUT");
        text2.setAttribute("type", "number");
        if (required)
            text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control ot_treatment_item_price");
        text2.setAttribute("placeholder", "Price");
        text2.setAttribute("name", "ot_treatment_item_price[]");
        text2.onchange = function () {
            changeDataItem(this);
        }

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "number");
        if (required)
            text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control ot_treatment_item_qty");
        text3.setAttribute("placeholder", "Qty");
        text3.setAttribute("name", "ot_treatment_item_qty[]");
        text3.onchange = function () {
            changeDataItem(this);
        }

        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "number");
        if (required)
            text4.setAttribute("required", "required");
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
        $(ctl).parents("tr").remove();
        //alert(count-2);
        // if(count-1 > 1)
        // {
        //     $(ctl).parents("tr").remove();
        // }
        // else
        // {
        //     alert("At-least 1 Row is Required in service table");
        // }
        update_total_bill();
    }

    function DeleteRowService(ctl) {
        var table = document.getElementById('datatable3');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;
        $(ctl).parents("tr").remove();
        //alert(count-2);
        // if(count-1 > 1)
        // {
        //     $(ctl).parents("tr").remove();
        // }
        // else
        // {
        //     alert("At-least 1 Row is Required in service table");
        // }
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
        $(ctl).parents("tr").remove();
        //alert(count-2);
        // if(count-1 > 1)
        // {
        //     $(ctl).parents("tr").remove();
        // }
        // else
        // {
        //     alert("At-least 1 Row is Required in service table");
        // }
        update_total_bill();
    }
    function DeleteRowItem(ctl) {
        var table = document.getElementById('datatable6');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;
        $(ctl).parents("tr").remove();
        //alert(count-2);
        // if(count-1 > 1)
        // {
        //     $(ctl).parents("tr").remove();
        // }
        // else
        // {
        //     alert("At-least 1 Row is Required in service table");
        // }
        update_total_bill();
    }
    function InitRowBed() {
        //alert("table q19");
        var list = <?php echo json_encode($result_content_indoor_treatment_bed); ?>;
        // console.log(list);
        var table = document.getElementById('datatable1_body');
        if(Object.keys(list).length == 0)
        {
            AddRowBed();
        }
        for (var i = 0; i < Object.keys(list).length; i++){
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
                if(option.value == list[i]['indoor_treatment_bed_bed_id'])
                    option.selected = true;
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
            text2.setAttribute("value", list[i]['indoor_treatment_bed_category_name']);

            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "number");
            text3.setAttribute("required", "required");
            text3.setAttribute("class", "form-control indoor_bed_price");
            text3.setAttribute("placeholder", "Price");
            text3.setAttribute("name", "indoor_bed_price[]");
            text3.setAttribute("readonly", "readonly");
            text3.setAttribute("value", list[i]['indoor_treatment_bed_price']);

            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "number");
            text4.setAttribute("required", "required");
            text4.setAttribute("class", "form-control bed_total_bill");
            text4.setAttribute("placeholder", "Bill");
            text4.setAttribute("name", "bed_total_bill[]");
            text4.setAttribute("readonly", "readonly");
            text4.setAttribute("value", list[i]['indoor_treatment_bed_total_bill']);

            var text5 = document.createElement("INPUT");
            text5.setAttribute("type", "date");
            text5.setAttribute("required", "required");
            text5.setAttribute("class", "form-control indoor_patient_bed_entry_time");
            text5.setAttribute("placeholder", "Entry");
            text5.setAttribute("name", "indoor_patient_bed_entry_time[]");
            text5.setAttribute("value", formatDate(list[i]['indoor_treatment_bed_entry_time']));

            text5.onchange = function () {
                changeDataBed(this);
            }

            var text6 = document.createElement("INPUT");
            text6.setAttribute("type", "date");
            text6.setAttribute("class", "form-control indoor_patient_bed_discharge_time");
            text6.setAttribute("placeholder", "Discharge");
            text6.setAttribute("name", "indoor_patient_bed_discharge_time[]");
            if(list[i]['indoor_treatment_bed_discharge_time'] == null || list[i]['indoor_treatment_bed_discharge_time'] == "")
                text6.setAttribute("value", "");
            else
                text6.setAttribute("value", formatDate(list[i]['indoor_treatment_bed_discharge_time']));

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


    }
    function InitRowDoctor() {
        //alert("table q19");
        var list = <?php echo json_encode($result_content_indoor_treatment_doctor); ?>;

        var table = document.getElementById('datatable2_body');
        if(Object.keys(list).length == 0)
        {
            AddRowDoctor();
        }
        for (var i = 0; i < Object.keys(list).length; i++) {
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
                if(option.value == list[i]['indoor_treatment_doctor_doctor_id'])
                    option.selected = true;
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
            text2.setAttribute("value", list[i]['indoor_treatment_doctor_specialization']);

            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "number");
            text3.setAttribute("required", "required");
            text3.setAttribute("class", "form-control doctor_visit_fee");
            text3.setAttribute("placeholder", "Fee");
            text3.setAttribute("name", "doctor_visit_fee[]");
            text3.setAttribute("readonly", "readonly");
            text3.setAttribute("value", list[i]['indoor_treatment_doctor_visit_fee']);

            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "number");
            text4.setAttribute("required", "required");
            text4.setAttribute("class", "form-control doctor_total_bill");
            text4.setAttribute("placeholder", "Bill");
            text4.setAttribute("name", "doctor_total_bill[]");
            text4.setAttribute("readonly", "readonly");
            text4.setAttribute("value", list[i]['indoor_treatment_doctor_total_bill']);

            var text5 = document.createElement("INPUT");
            text5.setAttribute("type", "date");
            text5.setAttribute("required", "required");
            text5.setAttribute("class", "form-control indoor_patient_doctor_entry_time");
            text5.setAttribute("placeholder", "Entry");
            text5.setAttribute("name", "indoor_patient_doctor_entry_time[]");
            text5.setAttribute("value", formatDate(list[i]['indoor_treatment_doctor_entry_time']));

            text5.onchange = function () {
                changeDataDoctor(this);
            }
            var text6 = document.createElement("INPUT");
            text6.setAttribute("type", "date");
            text6.setAttribute("class", "form-control indoor_patient_doctor_discharge_time");
            text6.setAttribute("placeholder", "Discharge");
            text6.setAttribute("name", "indoor_patient_doctor_discharge_time[]");
            if(list[i]['indoor_treatment_doctor_discharge_time'] == null || list[i]['indoor_treatment_doctor_discharge_time'] == "")
                text6.setAttribute("value", "");
            else
                text6.setAttribute("value", formatDate(list[i]['indoor_treatment_doctor_discharge_time']));

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

    }
    function InitRowService() {
        //alert("table q19");
        var list = <?php echo json_encode($result_content_indoor_treatment_service); ?>;

        var table = document.getElementById('datatable3_body');
        if(Object.keys(list).length == 0)
        {
            AddRowService(false);
        }
        for (var i = 0; i < Object.keys(list).length; i++) {
            var tr = document.createElement('tr');

            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');
            var td4 = document.createElement('td');
            var td5 = document.createElement('td');
            var td6 = document.createElement('td');



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
                if(option.value == list[i]['indoor_treatment_service_service_id'])
                    option.selected = true;
                selectList.appendChild(option);
            }
            selectList.onchange = function () {
                changeDataDoctor(this);
            }

            var text2 = document.createElement("INPUT");
            text2.setAttribute("required", "required");
            text2.setAttribute("class", "form-control outdoor_service_quantity");
            text2.setAttribute("type", "number");
            text2.setAttribute("placeholder", "Service Quantity");
            text2.setAttribute("name", "outdoor_service_quantity[]");
            text2.onchange = function () {
                changeDataService(this);
            }
            text2.setAttribute("value", list[i]['indoor_treatment_service_service_quantity']);

            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "number");
            text3.setAttribute("required", "required");
            text3.setAttribute("class", "form-control outdoor_service_rate");
            text3.setAttribute("placeholder", "Service Rate");
            text3.setAttribute("name", "outdoor_service_rate[]");
            text3.setAttribute("readonly", "readonly");
            text3.setAttribute("value", list[i]['indoor_treatment_service_service_rate']);


            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "number");
            text4.setAttribute("required", "required");
            text4.setAttribute("class", "form-control outdoor_service_total");
            text4.setAttribute("placeholder", "Service Total");
            text4.setAttribute("name", "outdoor_service_total[]");
            text4.setAttribute("readonly", "readonly");
            text4.setAttribute("value", list[i]['indoor_treatment_service_service_total']);

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

    }
    function InitRowInvestigation() {
        //alert("table q19");
        var list = <?php echo json_encode($result_content_indoor_treatment_investigation); ?>;

        var table = document.getElementById('datatable4_body');
        if(Object.keys(list).length == 0)
        {
            AddRowTest(false);
        }
        for (var i = 0; i < Object.keys(list).length; i++) {
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
                if(option.value == list[i]['pathology_investigation_test_pathology_test_id'])
                    option.selected = true;
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
            text2.setAttribute("value", list[i]['pathology_investigation_test_room_no']);

            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "number");
            text3.setAttribute("required", "required");
            text3.setAttribute("class", "form-control pathology_investigation_test_price");
            text3.setAttribute("placeholder", "Price");
            text3.setAttribute("name", "pathology_investigation_test_price[]");
            text3.setAttribute("readonly", "readonly");
            text3.setAttribute("value", list[i]['pathology_investigation_test_price']);


            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "number");
            text4.setAttribute("required", "required");
            text4.setAttribute("class", "form-control pathology_investigation_test_quantity");
            text4.setAttribute("placeholder", "Quantity");
            text4.setAttribute("name", "pathology_investigation_test_quantity[]");
            text4.onchange = function () {
                changeDataTest(this);
            }
            text4.setAttribute("value", list[i]['pathology_investigation_test_quantity']);

            var text5 = document.createElement("INPUT");
            text5.setAttribute("type", "number");
            text5.setAttribute("required", "required");
            text5.setAttribute("class", "form-control pathology_investigation_test_total_bill");
            text5.setAttribute("placeholder", "Total");
            text5.setAttribute("name", "pathology_investigation_test_total_bill[]");
            text5.setAttribute("readonly", "readonly");
            text5.setAttribute("value", list[i]['pathology_investigation_test_total_bill']);

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

    }
    function InitRowMedicine() {
        //alert("table q19");
        let list = <?php echo json_encode($result_content_indoor_treatment_pharmacy_item); ?>;
        console.log(list);
        var table = document.getElementById('datatable5_body');
        if(Object.keys(list).length == 0)
        {
            AddRowMedicine(false);
        }
        for (var i = 0; i < Object.keys(list).length; i++)
        {

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
            text1.setAttribute("value", list[i]['medicine_name']);
            text1.onchange = function () {
                changeDataMedicine(this);
            }
            var hiddenText = document.createElement("INPUT");
            hiddenText.setAttribute("class", "form-control ot_treatment_pharmacy_item_medicine_id");
            hiddenText.setAttribute("type", "hidden");
            hiddenText.setAttribute("id", "ot_treatment_pharmacy_item_medicine_id");
            hiddenText.setAttribute("name", "ot_treatment_pharmacy_item_medicine_id[]");
            hiddenText.setAttribute("value", list[i]['pharmacy_medicine_id']);

            //var cell = row.insertCell();
            //cell.appendChild(selectList);




            var text2 = document.createElement("INPUT");
            text2.setAttribute("class", "form-control ot_treatment_pharmacy_item_batch_id");
            text2.setAttribute("type", "text");
            text2.setAttribute("placeholder", "Batch ID");
            text2.setAttribute("name", "ot_treatment_pharmacy_item_batch_id[]");
            text2.setAttribute("readonly", "readonly");
            text2.setAttribute("value", list[i]['indoor_pharmacy_sell_medicine_batch_id']);

            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "text");
            text3.setAttribute("class", "form-control ot_treatment_pharmacy_item_stock_qty");
            text3.setAttribute("placeholder", "Qty");
            text3.setAttribute("name", "ot_treatment_pharmacy_item_stock_qty[]");
            text3.setAttribute("readonly", "readonly");
            text3.setAttribute("value", parseInt(list[i]['total_quantity'])-parseInt(list[i]['total_sell']));

            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "text");
            text4.setAttribute("class", "form-control ot_treatment_pharmacy_item_per_piece_price");
            text4.setAttribute("placeholder", "Item Price");
            text4.setAttribute("name", "ot_treatment_pharmacy_item_per_piece_price[]");
            text4.setAttribute("readonly", "readonly");
            text4.setAttribute("value", list[i]['indoor_pharmacy_sell_medicine_per_piece_price']);


            var text5 = document.createElement("INPUT");
            text5.setAttribute("type", "text");
            text5.setAttribute("class", "form-control ot_treatment_pharmacy_item_quantity");
            text5.setAttribute("placeholder", "Qty");
            text5.setAttribute("name", "ot_treatment_pharmacy_item_quantity[]");
            text5.setAttribute("value", list[i]['indoor_pharmacy_sell_medicine_selling_piece']);

            text5.onchange = function (){
                medicine_row_update(this);
            }

            var text6 = document.createElement("INPUT");
            text6.setAttribute("type", "text");
            text6.setAttribute("class", "form-control ot_treatment_pharmacy_item_bill");
            text6.setAttribute("placeholder", "Bill");
            text6.setAttribute("name", "ot_treatment_pharmacy_item_bill[]");
            text6.setAttribute("readonly", "readonly");
            text6.setAttribute("value", list[i]['indoor_pharmacy_sell_medicine_total_selling_price']);



            var text7 = document.createElement("INPUT");
            text7.setAttribute("type", "text");
            text7.setAttribute("class", "form-control ot_treatment_pharmacy_item_note");
            text7.setAttribute("placeholder", "Note");
            text7.setAttribute("name", "ot_treatment_pharmacy_item_note[]");
            text7.setAttribute("value", list[i]['indoor_pharmacy_sell_medicine_note']);


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

    }
    function InitRowItem() {
        //alert("table q19");
        let list = <?php echo json_encode($result_content_ot_item); ?>;
        var table = document.getElementById('datatable6_body');
        if(Object.keys(list).length == 0)
        {
            AddRowItem(false);
        }
        for (var i = 0; i < Object.keys(list).length; i++)
        {

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
            text1.setAttribute("value", list[i]['ot_treatment_item_name']);

            var text2 = document.createElement("INPUT");
            text2.setAttribute("type", "number");
            text2.setAttribute("class", "form-control ot_treatment_item_price");
            text2.setAttribute("placeholder", "Price");
            text2.setAttribute("name", "ot_treatment_item_price[]");
            text2.onchange = function () {
                changeDataItem(this);
            }
            text2.setAttribute("value", list[i]['ot_treatment_item_price']);

            
            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "number");
            text3.setAttribute("class", "form-control ot_treatment_item_qty");
            text3.setAttribute("placeholder", "Qty");
            text3.setAttribute("name", "ot_treatment_item_qty[]");
            text3.onchange = function () {
                changeDataItem(this);
            }
            text3.setAttribute("value", list[i]['ot_treatment_item_qty']);

            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "number");
            text4.setAttribute("class", "form-control ot_treatment_item_total");
            text4.setAttribute("placeholder", "Total");
            text4.setAttribute("name", "ot_treatment_item_total[]");
            text4.setAttribute("readonly", "readonly");
            text4.setAttribute("value", list[i]['ot_treatment_item_total']);

            
            var text5 = document.createElement("INPUT");
            text5.setAttribute("class", "form-control ot_treatment_item_note");
            text5.setAttribute("type", "text");
            text5.setAttribute("placeholder", "Note");
            text5.setAttribute("name", "ot_treatment_item_note[]");
            text5.setAttribute("value", list[i]['ot_treatment_item_note']);

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

    }
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
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