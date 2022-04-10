<?php
// need to enable on production
require_once('check_if_ot_manager.php');
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

                    $get_content = "select *,
       (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
       (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
 LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
 WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell
from medicine
            left join medicine_category mc on mc.medicine_category_id = medicine.medicine_category
            left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf
            left join medicine_type mt on mt.medicine_type_id = medicine.medicine_type
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
            left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    // echo $result_content_medicine;
                    $get_content = "select * from doctor";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Allotment</h3>
                            <form class="form-horizontal form-material mb-0" id="patient_allotment_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="ot_allotment">
                                    <div class="form-group col-md-6">
                                        <label for="indoor_treatment_admission_id">Admission ID.<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Admission ID" class="form-control" id="indoor_treatment_admission_id" name="indoor_treatment_admission_id" onchange="loadAdmission();">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ot_treatment_patient_phone">Patient Phone<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Patient Phone." class="form-control" id="ot_treatment_patient_phone" name="ot_treatment_patient_phone" required onchange="loadPatient();">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ot_treatment_patient_id">Patient ID</label>
                                        <input type="text" placeholder="Patient ID." class="form-control" id="ot_treatment_patient_id" name="ot_treatment_patient_id" readonly required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ot_treatment_patient_name">Patient Name</label>
                                        <input type="text" placeholder="Patient Name" class="form-control" id="ot_treatment_patient_name" name="ot_treatment_patient_name" required readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ot_treatment_indoor_treatment_id">Indoor treatement id</label>
                                        <input type="text" placeholder="Indoor treatement id" class="form-control" id="ot_treatment_indoor_treatment_id" name="ot_treatment_indoor_treatment_id" required readonly>
                                    </div>


                                    <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Doctor Name<i class="text-danger"> * </i></th>
                                                <th>Fee<i class="text-danger"> * </i></th>
                                                <th>Note</th>
                                                <th>Assign New</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable1_body">
                                            <tr>
                                                <td>
                                                    <select id="ot_treatment_doctor_doctor_id" class="form-control ot_treatment_doctor_doctor_id" name="ot_treatment_doctor_doctor_id[]" placeholder="Pick a Service..." required>
                                                        <option value="">Select a Doctor...</option>
                                                        <?php
                                                        foreach ($result_content_doctor as $data) {
                                                            echo '<option value="' . $data['doctor_id'] . '">' . $data['doctor_name'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control ot_treatment_doctor_bill" placeholder="Fee" id="ot_treatment_doctor_bill" name="ot_treatment_doctor_bill[]" onchange="update_total_bill();" required>

                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_doctor_note" placeholder="Note" id="ot_treatment_doctor_note" name="ot_treatment_doctor_note[]">

                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowDoctor();">Assign New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger-soft far fa-trash-alt" onclick="DeleteRowDoctor(this);"></button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>
                                    <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Guest Doctor Name</th>
                                                <th>Fee</th>
                                                <th>Note</th>
                                                <th>Allot New</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable2_body">
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_guest_doctor_doctor_name" placeholder="Doctor Name" id="ot_treatment_guest_doctor_doctor_name" name="ot_treatment_guest_doctor_doctor_name[]">

                                                </td>

                                                <td>
                                                    <input type="number" class="form-control ot_treatment_guest_doctor_bill" placeholder="Fee" id="ot_treatment_guest_doctor_bill" name="ot_treatment_guest_doctor_bill[]" onchange="update_total_bill();">

                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_guest_doctor_note" placeholder="Note" id="ot_treatment_guest_doctor_note" name="ot_treatment_guest_doctor_note[]">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowGuestDoctor();">Allot New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger-soft far fa-trash-alt" onclick="DeleteRowGuestDoctor(this);"></button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>
                                    <datalist id="medicine_list"></datalist>

                                    <table id="datatable3" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Pharmacy Item<i class="text-danger"> * </i></th>
                                                <th>Batch ID</th>
                                                <th>Stock Qty</th>
                                                <th>Per Peice Price</th>
                                                <th>Total Item<i class="text-danger"> * </i></th>
                                                <th>Total Bill</th>
                                                <th>Note</th>
                                                <th>Assign New</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable3_body">
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_pharmacy_item_medicine_name" id="ot_treatment_pharmacy_item_medicine_name" name="ot_treatment_pharmacy_item_medicine_name[]" list="medicine_list" onchange="medicine_update(this);" autocomplete="off">
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
                                                    <input type="text" class="form-control ot_treatment_pharmacy_item_quantity" placeholder="Qty" id="ot_treatment_pharmacy_item_quantity" name="ot_treatment_pharmacy_item_quantity[]" onchange="row_update(this);">

                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_pharmacy_item_bill" placeholder="Bill" id="ot_treatment_pharmacy_item_bill" name="ot_treatment_pharmacy_item_bill[]" readonly>

                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_pharmacy_item_note" placeholder="Note" id="ot_treatment_pharmacy_item_note" name="ot_treatment_pharmacy_item_note[]">

                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowMedicine();">Assign New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger-soft far fa-trash-alt" onclick="DeleteRowMedicine(this);"></button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>
                                    <table id="datatable4" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>OT Item Name</th>
                                                <th>Item Price</th>
                                                <th>Item Note</th>
                                                <th>Allot New</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable4_body">
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_item_name" placeholder="Item Name" id="ot_treatment_item_name" name="ot_treatment_item_name[]">

                                                </td>

                                                <td>
                                                    <input type="number" class="form-control ot_treatment_item_price" placeholder="Price" id="ot_treatment_item_price" name="ot_treatment_item_price[]" onchange="update_total_bill();">

                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ot_treatment_item_note" placeholder="Note" id="ot_treatment_item_note" name="ot_treatment_item_note[]">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowItem();">Allot New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger-soft far fa-trash-alt" onclick="DeleteRowItem(this);"></button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>
                                    <div class="form-group col-md-4">
                                        <label for="ot_treatment_total_bill">Total Bill</label>
                                        <input type="number" placeholder="Total Bill" class="form-control" id="ot_treatment_total_bill" name="ot_treatment_total_bill" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ot_treatment_discount_pc">Discount %</label>
                                        <input type="number" min="0" max="100" placeholder="Discount" class="form-control" id="ot_treatment_discount_pc" name="ot_treatment_discount_pc" onchange="update_total_bill();" value="0" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ot_treatment_total_bill_after_discount">In Total Bill</label>
                                        <input type="number" placeholder="In Total Bill" class="form-control" id="ot_treatment_total_bill_after_discount" name="ot_treatment_total_bill_after_discount" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ot_treatment_total_paid">Paid<i class="text-danger"> * </i></label>
                                        <input type="number" placeholder="Total Paid" class="form-control" onchange="update_total_bill();" id="ot_treatment_total_paid" name="ot_treatment_total_paid" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ot_treatment_total_due">Due</label>
                                        <input type="number" placeholder="Total Due" class="form-control" id="ot_treatment_total_due" name="ot_treatment_total_due" value="0" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ot_treatment_payment_type">Payment Type<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="ot_treatment_payment_type" name="ot_treatment_payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            <option value="check">Check</option>
                                            <option value="card">Card</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ot_treatment_payment_type_no">Card/Check No</label>
                                        <input type="text" placeholder="Card/Check No" class="form-control" id="ot_treatment_payment_type_no" name="ot_treatment_payment_type_no">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="ot_treatment_note">Note</label>
                                        <input type="text" placeholder="Note" class="form-control" id="ot_treatment_note" name="ot_treatment_note">
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


            if (!check_data_validation()) {
                return false;
            } else {
                spinner.show();
                var formData = new FormData(this);

                $.ajax({
                    url: '../apis/create_ot_treatment.php',
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
                            window.open("ot_treatment_list.php", "_self");

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

            }


        });
    });

    function loadPatient() {
        let patient_phone = document.getElementById("ot_treatment_patient_phone").value;
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
                if (datas === null) {
                    alert("No Patient Found");
                    document.getElementById("ot_treatment_patient_name").value = "";

                }

                var count = Object.keys(datas).length;
                if (count === 0) {
                    alert("No Patient Found");
                    document.getElementById("ot_treatment_patient_name").value = "";
                } else {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            document.getElementById("ot_treatment_patient_id").value = datas[key].patient_id;
                            document.getElementById("ot_treatment_patient_name").value = datas[key].patient_name;
                        }
                    }
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                spinner.hide();
                alert("alert : " + errorThrown);
            }
        });
    }

    function loadAdmission() {
        // let patient_phone = document.getElementById("outdoor_patient_phone").value;
        let indoor_treatment_admission_id = document.getElementById("indoor_treatment_admission_id").value;
        spinner.show();
        jQuery.ajax({
            type: 'POST',
            url: '../apis/get_patient.php',
            cache: false,
            //dataType: "json", // and this
            data: {
                token: "<?php echo $_SESSION['token']; ?>",
                request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                indoor_treatment_admission_id: indoor_treatment_admission_id,
                content: "patient_indoor_treatment_admission_id",
            },
            success: function(response) {
                //alert(response);
                spinner.hide();
                var obj = JSON.parse(response);
                var datas = obj.patient;
                if (datas === null) {
                    alert("No Patient Found");
                    document.getElementById("outdoor_patient_name").value = "";

                }

                var count = Object.keys(datas).length;
                if (count === 0) {
                    alert("No Patient Found");
                    document.getElementById("outdoor_patient_name").value = "";
                } else {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            document.getElementById("ot_treatment_patient_id").value = datas[key].patient_id;
                            document.getElementById("ot_treatment_patient_name").value = datas[key].patient_name;
                            document.getElementById("ot_treatment_patient_phone").value = datas[key].patient_phone;
                            document.getElementById("ot_treatment_indoor_treatment_id").value = datas[key].indoor_treatment_id;
                        }
                    }
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                spinner.hide();
                alert("alert : " + errorThrown);
            }
        });
    }
    var all_doctor = <?php echo json_encode($result_content_doctor); ?>;
    var all_medicine = <?php echo json_encode($result_content_medicine); ?>;

    function medicine_update(instance) {

        var row = $(instance).closest("tr");

        var val = row.find(".ot_treatment_pharmacy_item_medicine_name").val();
        if (val === "") {
            row.find(".ot_treatment_pharmacy_item_medicine_id").val("");
            row.find(".ot_treatment_pharmacy_item_batch_id").val("");
            row.find(".ot_treatment_pharmacy_item_stock_qty").val("");
            row.find(".ot_treatment_pharmacy_item_per_piece_price").val("");
            row.find(".ot_treatment_pharmacy_item_quantity").val("");
            row.find(".ot_treatment_pharmacy_item_bill").val("");
            row.find(".ot_treatment_pharmacy_item_note").val("");

            return;
        }
        const data_name = $("#medicine_list option[value=" + val + "]").text();
        const arr = data_name.split("~");
        var name = arr[0];
        var batch_id = arr[1];
        var medicine_id = arr[2];
        var pharmacy_medicine_id = val;
        var obj = $("#medicine_list").find("option[value='" + val + "']");

        if (obj != null && obj.length > 0) {
            row.find(".ot_treatment_pharmacy_item_medicine_name").val(name);
            row.find(".ot_treatment_pharmacy_item_medicine_id").val(val);
            //    alert(val);
            //    alert(name);
            for (var i = 0; i < Object.keys(all_medicine).length; i++) {
                if (all_medicine[i]['medicine_name'] === name && all_medicine[i]['pharmacy_medicine_batch_id'] === batch_id) {
                    //alert("matched");
                    row.find(".ot_treatment_pharmacy_item_batch_id").val(all_medicine[i]['pharmacy_medicine_batch_id']);

                    row.find(".ot_treatment_pharmacy_item_stock_qty").val(all_medicine[i]['total_quantity'] - all_medicine[i]['total_sell']);
                    //alert(all_medicine[i]['total_quantity']);
                    var per_pc_price = (parseFloat(all_medicine[i]['medicine_selling_price']) / (parseInt(all_medicine[i]['medicine_leaf_name']) * parseInt(all_medicine[i]['medicine_leaf_total_per_box'])));
                    //alert(per_pc_price);
                    row.find(".ot_treatment_pharmacy_item_per_piece_price").val(per_pc_price);

                    var selling_pieces = row.find(".ot_treatment_pharmacy_item_quantity").val();
                    var total_selling_price = parseFloat(selling_pieces) * per_pc_price;

                    row.find(".ot_treatment_pharmacy_item_bill").val(total_selling_price);

                }
            }
            row_update(instance);
        } else {
            alert("Medicine Not Available"); // don't allow form submission
            row.find(".ot_treatment_pharmacy_item_medicine_id").val("");
            row.find(".ot_treatment_pharmacy_item_batch_id").val("");
            row.find(".ot_treatment_pharmacy_item_stock_qty").val("");
            row.find(".ot_treatment_pharmacy_item_per_piece_price").val("");
            row.find(".ot_treatment_pharmacy_item_quantity").val("");
            row.find(".ot_treatment_pharmacy_item_bill").val("");
            row.find(".ot_treatment_pharmacy_item_note").val("");

        }
    }

    function row_update(instance) {

        var row = $(instance).closest("tr");
        let medicine_name = row.find(".ot_treatment_pharmacy_item_medicine_name").val();
        //alert(medicine_name);
        for (var i = 0; i < Object.keys(all_medicine).length; i++) {
            if (all_medicine[i]['medicine_name'] === medicine_name) {
                //alert("matched");
                row.find(".ot_treatment_pharmacy_item_batch_id").val(all_medicine[i]['pharmacy_medicine_batch_id']);

                row.find(".ot_treatment_pharmacy_item_stock_qty").val(all_medicine[i]['total_quantity'] - all_medicine[i]['total_sell']);
                //alert(all_medicine[i]['total_quantity']);
                var per_pc_price = (parseFloat(all_medicine[i]['medicine_selling_price']) / (parseInt(all_medicine[i]['medicine_leaf_name']) * parseInt(all_medicine[i]['medicine_leaf_total_per_box'])));
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

    function load_medicine() {
        for (var i = 0; i < Object.keys(all_medicine).length; i++) {
            $("#medicine_list").append('<option value="' + all_medicine[i]['pharmacy_medicine_id'] + '">' + all_medicine[i]['medicine_name'] + '~' + all_medicine[i]['pharmacy_medicine_batch_id'] + '~' + all_medicine[i]['medicine_id'] + '</option>');
        }

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

    function check_data_validation() {
        let is_valid = true;
        $("#datatable2_body tr").each(function() {
            var name = $(this).find("input.ot_treatment_guest_doctor_doctor_name").val();
            var bill = $(this).find("input.ot_treatment_guest_doctor_bill").val();
            // alert(
            //     "guest doctor: "+name + " " + bill
            // );

            if ((name != "" && bill == "") || (name == "" && bill != "")) {
                alert("Please Fill All Fields of Guest Doctor");
                is_valid = false;
                return false;
            }
        });
        $("#datatable3_body tr").each(function() {
            var id = $(this).find("input.ot_treatment_pharmacy_item_medicine_id").val();
            var quantity = $(this).find("input.ot_treatment_pharmacy_item_quantity").val();
            // alert(
            //     "pharmacy item: "+id + " " + quantity
            // );
            if ((id != "" && quantity == "") || (id == "" && quantity != "")) {
                alert("Please Fill All Fields of Pharmacy Item");
                is_valid = false;
                return false;
            }
        });
        $("#datatable4_body tr").each(function() {
            var name = $(this).find("input.ot_treatment_item_name").val();
            var bill = $(this).find("input.ot_treatment_item_price").val();
            // alert(
            //     "ot item: "+ name + " " + bill
            // );
            if ((name != "" && bill == "") || (name == "" && bill != "")) {
                alert("Please Fill All Fields of OT Item");
                is_valid = false;
                return false;
            }

        });
        return is_valid;
    }

    function update_total_bill() {
        var doctortotal = 0;
        $("#datatable1 tr").each(function() {
            var total = $(this).find("input.ot_treatment_doctor_bill").val();
            doctortotal = parseInt(doctortotal) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(doctortotal);
        var guestdoctortotal = 0;
        $("#datatable2 tr").each(function() {
            var total = $(this).find("input.ot_treatment_guest_doctor_bill").val();
            guestdoctortotal = parseInt(guestdoctortotal) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(guestdoctortotal);
        var pharmacytotal = 0;
        $("#datatable3 tr").each(function() {
            var total = $(this).find("input.ot_treatment_pharmacy_item_bill").val();
            pharmacytotal = parseFloat(pharmacytotal) + parseFloat(isNaN(parseFloat(total)) ? 0 : total);
        });
        //alert(pharmacytotal);
        var ot_itemtotal = 0;
        $("#datatable4 tr").each(function() {
            var total = $(this).find("input.ot_treatment_item_price").val();
            ot_itemtotal = parseInt(ot_itemtotal) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(ot_itemtotal);
        let in_total = doctortotal + guestdoctortotal + pharmacytotal + ot_itemtotal;
        document.getElementById("ot_treatment_total_bill").value = parseFloat(in_total);
        var discount = document.getElementById("ot_treatment_discount_pc").value;
        discount = isNaN(parseFloat(discount)) ? 0 : parseFloat(discount);
        in_total = parseInt(in_total) - (parseInt(in_total) * (parseInt(discount) / 100));
        document.getElementById("ot_treatment_total_bill_after_discount").value = in_total;
        var paid = document.getElementById("ot_treatment_total_paid").value;
        document.getElementById("ot_treatment_total_due").value = parseInt(in_total - paid);


    }

    function AddRowDoctor() {
        //alert("table q19");
        var table = document.getElementById('datatable1_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');



        var selectList = document.createElement("select");
        selectList.setAttribute("id", "ot_treatment_doctor_doctor_id");
        selectList.setAttribute("required", "required");
        selectList.setAttribute("name", "ot_treatment_doctor_doctor_id[]");
        selectList.setAttribute("class", "form-control ot_treatment_doctor_doctor_id");

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


        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control ot_treatment_doctor_bill");
        text2.setAttribute("type", "number");
        text2.setAttribute("placeholder", "Fee");
        text2.setAttribute("name", "ot_treatment_doctor_bill[]");
        text2.onchange = function() {
            update_total_bill(this);
        }

        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "text");
        text3.setAttribute("class", "form-control ot_treatment_doctor_note");
        text3.setAttribute("placeholder", "note");
        text3.setAttribute("name", "ot_treatment_doctor_note[]");



        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Assign New";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowDoctor(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowDoctor(this);
        };


        td1.appendChild(selectList);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(buttonAdd);
        td5.appendChild(buttonRemove);

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);



        table.appendChild(tr);

    }

    function AddRowGuestDoctor() {
        //alert("table q19");
        var table = document.getElementById('datatable2_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');

        var text1 = document.createElement("INPUT");
        text1.setAttribute("class", "form-control ot_treatment_guest_doctor_doctor_name");
        text1.setAttribute("type", "text");
        text1.setAttribute("placeholder", "Name");
        text1.setAttribute("name", "ot_treatment_guest_doctor_doctor_name[]");

        var text2 = document.createElement("INPUT");
        text2.setAttribute("type", "number");
        text2.setAttribute("class", "form-control ot_treatment_guest_doctor_bill");
        text2.setAttribute("placeholder", "Fee");
        text2.setAttribute("name", "ot_treatment_guest_doctor_bill[]");
        text2.onchange = function() {
            update_total_bill(this);
        }

        var text3 = document.createElement("INPUT");
        text3.setAttribute("class", "form-control ot_treatment_guest_doctor_note");
        text3.setAttribute("type", "text");
        text3.setAttribute("placeholder", "Note");
        text3.setAttribute("name", "ot_treatment_guest_doctor_note[]");

        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Allot New";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowGuestDoctor(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowGuestDoctor(this);
        };


        td1.appendChild(text1);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(buttonAdd);
        td5.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);

        table.appendChild(tr);

    }

    function AddRowMedicine() {
        //alert("table q19");
        var table = document.getElementById('datatable3_body');
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
        text1.onchange = function() {
            medicine_update(this);
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
        text5.onchange = function() {
            row_update(this);
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
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Assign New";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowMedicine(this);
        };


        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");

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
        var table = document.getElementById('datatable4_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        var td5 = document.createElement('td');

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
        text2.onchange = function() {
            update_total_bill(this);
        }

        var text3 = document.createElement("INPUT");
        text3.setAttribute("class", "form-control ot_treatment_item_note");
        text3.setAttribute("type", "text");
        text3.setAttribute("placeholder", "Note");
        text3.setAttribute("name", "ot_treatment_item_note[]");

        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Allot New";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowItem(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowItem(this);
        };


        td1.appendChild(text1);
        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(buttonAdd);
        td5.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);

        table.appendChild(tr);

    }

    function DeleteRowDoctor(ctl) {
        var table = document.getElementById('datatable1');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if (count - 1 > 1) {
            $(ctl).parents("tr").remove();
        } else {
            alert("At-least 1 Row is Required in service table");
        }
    }

    function DeleteRowGuestDoctor(ctl) {
        var table = document.getElementById('datatable2');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if (count - 1 > 1) {
            $(ctl).parents("tr").remove();
        } else {
            alert("At-least 1 Row is Required in service table");
        }
    }

    function DeleteRowMedicine(ctl) {
        var table = document.getElementById('datatable3');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if (count - 1 > 1) {
            $(ctl).parents("tr").remove();
        } else {
            alert("At-least 1 Row is Required in service table");
        }
        document.getElementById("pharmacy_purchase_paid_amount").value = "";
        //total_calculation_update();
    }

    function DeleteRowItem(ctl) {
        var table = document.getElementById('datatable4');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if (count - 1 > 1) {
            $(ctl).parents("tr").remove();
        } else {
            alert("At-least 1 Row is Required in service table");
        }
    }
</script>
<script>
    $('#datatable1').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable2').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable3').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
    $('#datatable4').dataTable({
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
    $(document).ready(function() {
        $('#select-patient').selectize({
            sortField: 'text'
        });
    });
</script>

</html>