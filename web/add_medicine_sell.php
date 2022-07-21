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
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();
                    $conn = $connection->getConnection();

                    $get_content = "select * from medicine_manufacturer";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine_manufacturer = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select * from patient";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select *,(SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity,
                    (SELECT  SUM(psm.pharmacy_sell_medicine_selling_piece) from pharmacy_medicine
                    LEFT JOIN pharmacy_sell_medicine psm ON psm.pharmacy_sell_medicine_medicine_id = pharmacy_medicine.pharmacy_medicine_id
                    WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_sell,

                    (SELECT SUM(pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_piece) from pharmacy_medicine
                    LEFT JOIN pharmacy_sell_medicine_return on pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_medicine_id=pharmacy_medicine.pharmacy_medicine_id
                    WHERE pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_medicine_id=pm.pharmacy_medicine_id and pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_medicine_batch_id=pm.pharmacy_medicine_batch_id
                    ) as total_return 
                    from medicine
     
                         left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
                         left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
                         left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id;";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select * from medicine_leaf";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine_leaf = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Medicine Sell</h3>
                            <form class="form-horizontal form-material mb-0" id="medicine_sell_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="Search">Patient Search</label>
                                                <div class="row">
                                                    <div class="col-md-9"><input type="text" placeholder="Patient Phone / Name / ID" class="form-control" id="Search" name="Search" onchange="loadPatient();"></div>
                                                    <div class="col-md-3"><a href="add_patients.php" class="btn btn-success ">Add Patient</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <!-- <label for="patient_name">Patient Name</label> -->
                                                <input type="text" placeholder="Patient Name" class="form-control" id="patient_name" name="patient_name">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <!-- <label for="patient_age">Patient Age</label> -->
                                                <input type="text" placeholder="Patient Age" class="form-control" id="patient_age" name="patient_age">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <!-- <label for="patient_gender">Patient Gender</label> -->
                                                <select id="patient_gender" class="form-control " name="patient_gender" placeholder="Pick a Gender...">
                                                    <option value="">Select Gender...</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <!-- <label for="patient_phone">Patient Phone</label> -->
                                                <input type="text" placeholder="Patient Phone" class="form-control" id="patient_phone" name="patient_phone" readonly>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <!-- <label for="patient_phone">Patient Phone</label> -->
                                                <input type="text" placeholder="Patient ID" class="form-control" id="pharmacy_sell_patient_id" name="pharmacy_sell_patient_id" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                        <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                        <input type="hidden" name="outdoor_treatment_outdoor_service_Category" value="Doctor Visit">
                                        <input type="hidden" name="content" value="pharmacy_medicine_sell">
                                        <input type="hidden" name="get_patient_id" id="get_patient_id" value="<?php echo $patient_id ?>">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="indoor_treatment_admission_id">Admission ID.</label>
                                                <input type="text" placeholder="Admission ID" class="form-control" id="indoor_treatment_admission_id" name="indoor_treatment_admission_id" onchange="loadAdmission();">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="outdoor_treatment_indoor_treatment_id">Indoor treatement id</label>
                                                <input type="text" placeholder="Indoor treatement id" class="form-control" id="pharmacy_sell_indoor_treatment_id" name="pharmacy_sell_indoor_treatment_id" required readonly>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pharmacy_sell_date">Selling Date<i class="text-danger"> * </i></label>
                                                <input type="date" placeholder="Selling Date" class="form-control" id="pharmacy_sell_date" name="pharmacy_sell_date" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <datalist id="medicine_list"></datalist>

                                <table id="datatable1" class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Medicine<i class="text-danger"> * </i></th>
                                            <th>Batch ID</th>
                                            <th>Exp. Date</th>
                                            <th>Stock Qty</th>
                                            <th>Per Piece Price</th>
                                            <th>selling Quantity<i class="text-danger"> * </i></th>
                                            <th>Total Selling Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datatable1_body">
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control pharmacy_selling_medicine_medicine_name" id="pharmacy_selling_medicine_medicine_name" name="pharmacy_selling_medicine_medicine_name[]" list="medicine_list" onchange="medicine_update(this);" autocomplete="off">
                                                <input required="required" class="form-control pharmacy_selling_medicine_medicine_id" type="hidden" id="pharmacy_selling_medicine_medicine_id" name="pharmacy_selling_medicine_medicine_id[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control pharmacy_selling_medicine_batch_id" placeholder="Batch ID" id="pharmacy_selling_medicine_batch_id" name="pharmacy_selling_medicine_batch_id[]" required readonly>

                                            </td>
                                            <td>
                                                <input type="date" class="form-control pharmacy_selling_medicine_exp_date" placeholder="Exp. Date" id="pharmacy_selling_medicine_exp_date" name="pharmacy_selling_medicine_exp_date[]" required readonly>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control pharmacy_selling_medicine_stock_qty" placeholder="Stock Qty" id="pharmacy_selling_medicine_stock_qty" name="pharmacy_selling_medicine_stock_qty[]" readonly required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control pharmacy_selling_medicine_per_pc_price" placeholder="Per Pc Price" id="pharmacy_selling_medicine_per_pc_price" name="pharmacy_selling_medicine_per_pc_price[]" required readonly>
                                            </td>

                                            <td>
                                                <input type="number" min=1 max="<?php echo $result_content_medicine[0]['pharmacy_medicine_quantity']; ?>" class="form-control pharmacy_selling_medicine_selling_pieces" placeholder="Selling Pieces" id="pharmacy_selling_medicine_selling_pieces" name="pharmacy_selling_medicine_selling_pieces[]" required onchange="row_update(this);">
                                            </td>

                                            <td>
                                                <input type="text" class="form-control pharmacy_purchase_medicine_total_selling_price" placeholder="total" id="pharmacy_purchase_medicine_total_selling_price" name="pharmacy_purchase_medicine_total_selling_price[]" readonly required>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-danger-soft far fa-trash-alt" onclick="DeleteRow(this);"></i></button>
                                            </td>
                                        </tr>


                                    </tbody>
                                    <tfoot id="datatable1_foot">
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Sub Total:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_sub_total" class="text-right form-control" name="pharmacy_selling_sub_total" placeholder="0.00" readonly="">
                                            </td>
                                            <td>
                                                <button onclick="AddRowTable();" id="add_invoice_item" type="button" class="btn btn-info-soft" name="add-invoice-item"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Vat:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_vat" onchange="total_calculation_update();" class="text-right form-control valid_number" name="pharmacy_selling_vat" placeholder="0.00" tabindex="15">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Discount:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_discount" onchange="total_calculation_update();" class="text-right form-control valid_number" name="pharmacy_selling_discount" placeholder="0.00" tabindex="16">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Exemption:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_exemption" onchange="total_calculation_update();" class="text-right form-control valid_number" name="pharmacy_selling_exemption" placeholder="0.00" tabindex="16">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Grand Total:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_grand_total" class="text-right form-control" name="pharmacy_selling_grand_total" value="0.00" readonly="readonly">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Paid Amount<i class="text-danger"> * </i>:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_paid_amount" onchange="total_calculation_update();" class="text-right form-control valid_number" name="pharmacy_selling_paid_amount" placeholder="0.00" tabindex="18">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6"><b>Due Amount:</b></td>
                                            <td class="text-right">
                                                <input type="text" id="pharmacy_selling_due_amount" class="text-right form-control" name="pharmacy_selling_due_amount" placeholder="0.00" readonly="readonly">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>

                                    </tfoot>


                                </table>

                                <div class="form-group col-md-6 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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


        $('form#medicine_sell_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);
            var currentdate = new Date();
            
            var datetime = currentdate.getDate().toString() +
                (currentdate.getMonth() + 1).toString() +
                currentdate.getFullYear().toString() +
                currentdate.getHours().toString() +
                currentdate.getMinutes().toString() +
                currentdate.getSeconds().toString();
            console.log(datetime);
            formData.append('pharmacy_sell_invoice_id', datetime);

            $.ajax({
                url: '../apis/create_pharmacy_medicine_sell.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    //alert(data);
                    console.log(data);
                    spinner.hide();
                    var obj = JSON.parse(data);
                    alert(obj.message);
                    //alert(obj.status);
                    console.log(obj);
                    if (obj.status) {
                        //location.reload();
                        // window.open("medicine_sell_list.php", "_self");
                        window.open("medicine_sell_invoice.php?medicine_sell_id=" + obj.pharmacy_sell_id, "_self");

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
        load_medicine();
    });

    var all_medicine = <?php echo json_encode($result_content_medicine); ?>;
    var all_pattern = <?php echo json_encode($result_content_medicine_leaf); ?>;

    var total_bill = 0;

    function medicine_update(instance) {

        var row = $(instance).closest("tr");

        var val = row.find(".pharmacy_selling_medicine_medicine_name").val();
        if (val === "") {
            row.find(".pharmacy_selling_medicine_batch_id").val("");
            row.find(".pharmacy_selling_medicine_exp_date").val("");
            row.find(".pharmacy_selling_medicine_stock_qty").val("");
            row.find(".pharmacy_selling_medicine_per_pc_price").val("");
            row.find(".pharmacy_selling_medicine_selling_pieces").val("");
            row.find(".pharmacy_purchase_medicine_total_selling_price").val("");

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
            //alert("valid");  // allow form submission
            //document.getElementById("is_new").value = "false";
            row.find(".pharmacy_selling_medicine_medicine_name").val(name);
            row.find(".pharmacy_selling_medicine_medicine_id").val(val);
            // alert(val);
            // alert(name);
            for (var i = 0; i < Object.keys(all_medicine).length; i++) {
                if (all_medicine[i]['medicine_name'] === name && all_medicine[i]['pharmacy_medicine_batch_id'] === batch_id) {
                    //alert("matched");
                    row.find(".pharmacy_selling_medicine_batch_id").val(all_medicine[i]['pharmacy_medicine_batch_id']);
                    row.find(".pharmacy_selling_medicine_exp_date").val(formatDate(all_medicine[i]['pharmacy_medicine_exp_date']));
                    row.find(".pharmacy_selling_medicine_stock_qty").val(all_medicine[i]['total_quantity'] - all_medicine[i]['total_sell'] + all_medicine[i]['total_return']);
                    //alert(all_medicine[i]['total_quantity']);
                    var per_pc_price = (parseFloat(all_medicine[i]['medicine_selling_price']));
                    // alert(per_pc_price);
                    row.find(".pharmacy_selling_medicine_per_pc_price").val(per_pc_price);

                    var selling_pieces = row.find(".pharmacy_selling_medicine_selling_pieces").val();
                    var total_selling_price = parseFloat(selling_pieces) * per_pc_price;

                    row.find(".pharmacy_purchase_medicine_total_selling_price").val(total_selling_price);

                }
            }
            row_update(instance);

        } else {
            alert("Medicine Not Available"); // don't allow form submission
            // document.getElementById("is_new").value = "true";
            row.find(".pharmacy_selling_medicine_batch_id").val("");
            row.find(".pharmacy_selling_medicine_exp_date").val("");
            row.find(".pharmacy_selling_medicine_stock_qty").val("");
            row.find(".pharmacy_selling_medicine_per_pc_price").val("");
            row.find(".pharmacy_selling_medicine_selling_pieces").val("");
            row.find(".pharmacy_purchase_medicine_total_selling_price").val("");
            //row.find(".pharmacy_purchase_medicine_medicine_name").val(name);
            //row.find(".pharmacy_purchase_medicine_medicine_id").val(val);

        }
    }

    function row_update(instance) {

        var row = $(instance).closest("tr");
        let medicine_name = row.find(".pharmacy_selling_medicine_medicine_name").val();
        let batch_id = row.find(".pharmacy_selling_medicine_batch_id").val();

        //alert(medicine_name);
        for (var i = 0; i < Object.keys(all_medicine).length; i++) {
            if (all_medicine[i]['medicine_name'] === medicine_name && all_medicine[i]['pharmacy_medicine_batch_id'] === batch_id) {
                //alert("matched");
                row.find(".pharmacy_selling_medicine_batch_id").val(all_medicine[i]['pharmacy_medicine_batch_id']);
                row.find(".pharmacy_selling_medicine_exp_date").val(formatDate(all_medicine[i]['pharmacy_medicine_exp_date']));
                row.find(".pharmacy_selling_medicine_stock_qty").val(all_medicine[i]['total_quantity'] - all_medicine[i]['total_sell'] + all_medicine[i]['total_return']);
                var per_pc_price = (parseFloat(all_medicine[i]['medicine_selling_price']));
                row.find(".pharmacy_selling_medicine_per_pc_price").val(per_pc_price);

                var selling_pieces = row.find(".pharmacy_selling_medicine_selling_pieces").val();
                var total_selling_price = parseFloat(selling_pieces) * per_pc_price;

                row.find(".pharmacy_purchase_medicine_total_selling_price").val(total_selling_price.toFixed(2));

            }
        }
        total_calculation_update();

    }

    function total_calculation_update() {

        let sub_total = 0;
        $("tr").each(function() {
            var total = $(this).find("input.pharmacy_purchase_medicine_total_selling_price").val();
            sub_total = parseInt(sub_total) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(sub_total);
        document.getElementById("pharmacy_selling_sub_total").value = sub_total;
        let vat = document.getElementById("pharmacy_selling_vat").value;
        let discount = document.getElementById("pharmacy_selling_discount").value;
        let exemption = document.getElementById("pharmacy_selling_exemption").value;
        let sub_total_with_vat = (sub_total + ((sub_total * vat) / 100))
        if (discount != "") {
            if (discount.search("%") > 0) {
                var total_dc = (parseInt(discount) / 100) * parseInt(sub_total_with_vat);
                sub_total_with_vat = parseInt(sub_total_with_vat) - total_dc;
            } else {
                sub_total_with_vat = parseInt(sub_total_with_vat) - parseInt(discount);
            }
        }
        if (exemption > 0) {
            sub_total_with_vat = parseInt(sub_total_with_vat) - parseInt(exemption);
        }
        document.getElementById("pharmacy_selling_grand_total").value = sub_total_with_vat;
        let grand_total = document.getElementById("pharmacy_selling_grand_total").value;
        let paid = document.getElementById("pharmacy_selling_paid_amount").value;
        document.getElementById("pharmacy_selling_due_amount").value = grand_total - paid;

    }

    // function loadPatient() {
    //     let patient_phone = document.getElementById("pharmacy_sell_patient_phone").value;
    //     spinner.show();
    //     jQuery.ajax({
    //         type: 'POST',
    //         url: '../apis/get_patient.php',
    //         cache: false,
    //         //dataType: "json", // and this
    //         data: {
    //             token: "<?php echo $_SESSION['token']; ?>",
    //             request_user_id: "<?php echo $_SESSION['user_id']; ?>",
    //             patient_phone: patient_phone,
    //             content: "patient_single_phone",
    //         },
    //         success: function(response) {
    //             //alert(response);
    //             spinner.hide();
    //             var obj = JSON.parse(response);
    //             var datas = obj.patient;
    //             var count = Object.keys(datas).length;
    //             if (count == 0) {
    //                 alert("No Patient Found");
    //             } else {
    //                 for (var key in datas) {
    //                     if (datas.hasOwnProperty(key)) {
    //                         document.getElementById("pharmacy_sell_patient_id").value = datas[key].patient_id;
    //                         document.getElementById("pharmacy_sell_patient_name").value = datas[key].patient_name;
    //                     }
    //                 }
    //             }


    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             //console.log(textStatus, errorThrown);
    //             spinner.hide();
    //             alert("alert : " + errorThrown);
    //         }
    //     });
    // }
    function loadPatient() {

        let Search = document.getElementById("Search").value;
        spinner.show();
        jQuery.ajax({
            type: 'POST',
            url: '../apis/get_patient.php',
            cache: false,
            //dataType: "json", // and this
            data: {
                token: "<?php echo $_SESSION['token']; ?>",
                request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                Search: Search,
                content: "patient_Search",
            },
            success: function(response) {
                spinner.hide();
                var obj = JSON.parse(response);
                var datas = obj.patient;

                if (datas === null) {
                    alert("No Patient Found");
                    document.getElementById("patient_name").value = "";
                    document.getElementById("patient_age").value = "";
                    document.getElementById("patient_gender").value = "";
                    document.getElementById("patient_phone").value = "";
                    document.getElementById("pharmacy_sell_patient_id").value = "";

                }

                var count = Object.keys(datas).length;
                if (count === 0) {
                    alert("No Patient Found");
                    document.getElementById("patient_name").value = "";
                    document.getElementById("patient_age").value = "";
                    document.getElementById("patient_gender").value = "";
                    document.getElementById("patient_phone").value = "";
                    document.getElementById("pharmacy_sell_patient_id").value = "";
                } else {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            // alert(datas[key])
                            // console.log(datas[key])
                            document.getElementById("pharmacy_sell_patient_id").value = datas[key].patient_id;
                            document.getElementById("patient_name").value = datas[key].patient_name;
                            document.getElementById("patient_age").value = datas[key].patient_age;
                            document.getElementById("patient_gender").value = datas[key].patient_gender;
                            document.getElementById("patient_phone").value = datas[key].patient_phone;
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
                            document.getElementById("pharmacy_sell_patient_id").value = datas[key].patient_id;
                            document.getElementById("patient_name").value = datas[key].patient_name;
                            document.getElementById("patient_phone").value = datas[key].patient_phone;
                            document.getElementById("pharmacy_sell_indoor_treatment_id").value = datas[key].indoor_treatment_id;
                            document.getElementById("patient_age").value = datas[key].patient_age;
                            document.getElementById("patient_gender").value = datas[key].patient_gender;
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

    function load_medicine() {
        for (var i = 0; i < Object.keys(all_medicine).length; i++) {
            if (all_medicine[i]['pharmacy_medicine_id'] && (all_medicine[i]['total_quantity']-all_medicine[i]['total_sell']+all_medicine[i]['total_return']!=0)) {
                $("#medicine_list").append('<option value="' + all_medicine[i]['pharmacy_medicine_id'] + '">' + all_medicine[i]['medicine_name'] + '~' + all_medicine[i]['pharmacy_medicine_batch_id'] + '</option>');
            }

        }

    }


    function AddRowTable() {
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

        var text1 = document.createElement("INPUT");
        text1.setAttribute("required", "required");
        text1.setAttribute("class", "form-control pharmacy_selling_medicine_medicine_name");
        text1.setAttribute("type", "text");
        text1.setAttribute("list", "medicine_list");
        text1.setAttribute("id", "pharmacy_selling_medicine_medicine_name");
        text1.setAttribute("name", "pharmacy_selling_medicine_medicine_name[]");
        text1.onchange = function() {
            medicine_update(this);
        }
        var hiddenText = document.createElement("INPUT");
        hiddenText.setAttribute("required", "required");
        hiddenText.setAttribute("class", "form-control pharmacy_selling_medicine_medicine_id");
        hiddenText.setAttribute("type", "hidden");
        hiddenText.setAttribute("id", "pharmacy_selling_medicine_medicine_id");
        hiddenText.setAttribute("name", "pharmacy_selling_medicine_medicine_id[]");

        //var cell = row.insertCell();
        //cell.appendChild(selectList);




        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("readonly", "readonly");
        text2.setAttribute("class", "form-control pharmacy_selling_medicine_batch_id");
        text2.setAttribute("type", "text");
        text2.setAttribute("placeholder", "Batch ID");
        text2.setAttribute("name", "pharmacy_selling_medicine_batch_id[]");
        text2.setAttribute("id", "pharmacy_selling_medicine_batch_id");


        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "date");
        text3.setAttribute("required", "required");
        text3.setAttribute("readonly", "readonly");
        text3.setAttribute("class", "form-control pharmacy_selling_medicine_exp_date");
        text3.setAttribute("placeholder", "Exp Date");
        text3.setAttribute("name", "pharmacy_selling_medicine_exp_date[]");
        text3.setAttribute("id", "pharmacy_selling_medicine_exp_date");


        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "text");
        text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control pharmacy_selling_medicine_stock_qty");
        text4.setAttribute("placeholder", "Stock Qty");
        text4.setAttribute("name", "pharmacy_selling_medicine_stock_qty[]");
        text4.setAttribute("id", "pharmacy_selling_medicine_stock_qty");
        text4.setAttribute("readonly", "readonly");


        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "text");
        text5.setAttribute("required", "required");
        text5.setAttribute("readonly", "readonly");
        text5.setAttribute("class", "form-control pharmacy_selling_medicine_per_pc_price");
        text5.setAttribute("placeholder", "Per PC Price");
        text5.setAttribute("name", "pharmacy_selling_medicine_per_pc_price[]");
        text5.setAttribute("id", "pharmacy_selling_medicine_per_pc_price");



        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "text");
        text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control pharmacy_selling_medicine_selling_pieces");
        text6.setAttribute("placeholder", "Selling Pieces");
        text6.setAttribute("name", "pharmacy_selling_medicine_selling_pieces[]");
        text6.setAttribute("id", "pharmacy_selling_medicine_selling_pieces");

        text6.onchange = function() {
            row_update(this);
        }

        var text7 = document.createElement("INPUT");
        text7.setAttribute("type", "text");
        text7.setAttribute("required", "required");
        text7.setAttribute("class", "form-control pharmacy_purchase_medicine_total_selling_price");
        text7.setAttribute("placeholder", "total");
        text7.setAttribute("name", "pharmacy_purchase_medicine_total_selling_price[]");
        text7.setAttribute("id", "pharmacy_purchase_medicine_total_selling_price");

        text7.setAttribute("readonly", "readonly");


        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");

        buttonRemove.onclick = function() {
            // ...
            DeleteRow(this);

        };


        td1.appendChild(text1);
        td1.appendChild(hiddenText);

        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        td5.appendChild(text5);
        td6.appendChild(text6);
        td7.appendChild(text7);
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

    function DeleteRow(ctl) {
        var table = document.getElementById('datatable1');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if (count - 1 > 1) {
            $(ctl).parents("tr").remove();
        } else {
            alert("At-least 1 Row is Required in service table");
        }
        document.getElementById("pharmacy_purchase_paid_amount").value = "";
        total_calculation_update();
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
        $('#select-manufacturer').selectize({
            sortField: 'text'
        });

    });
</script>

</html>