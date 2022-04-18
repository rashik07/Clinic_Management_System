<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
?>
<?php include 'header.php';
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

                    $get_content = "select * from outdoor_service";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_outdoor_service = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select * from doctor";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Treatment</h3>
                            <form class="form-horizontal form-material mb-0" id="patient_service_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="patient_treatment">
                                    <div class="form-group col-md-6">
                                        <label for="indoor_treatment_admission_id">Admission ID.</label>
                                        <input type="text" placeholder="Admission ID" class="form-control" id="indoor_treatment_admission_id" name="indoor_treatment_admission_id" onchange="loadAdmission();">
                                    </div>
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
                                        <label for="outdoor_treatment_indoor_treatment_id">Indoor treatement id</label>
                                        <input type="text" placeholder="Indoor treatement id" class="form-control" id="outdoor_treatment_indoor_treatment_id" name="outdoor_treatment_indoor_treatment_id" required readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="outdoor_treatment_consultant">Consultant Name</label>
                                        <select id="outdoor_treatment_consultant" class="form-control outdoor_treatment_consultant" name="outdoor_treatment_consultant" placeholder="Pick a Service..." >
                                            <option value="">Select Doctor...</option>
                                            <?php
                                            foreach ($result_content_doctor as $data) {
                                                echo '<option value="' . $data['doctor_id'] . '">' . $data['doctor_name'] . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="outdoor_treatment_reference">Reference Name</label>
                                        <input type="text" placeholder="Reference Name" class="form-control" id="outdoor_treatment_reference" name="outdoor_treatment_reference">
                                    </div>

                                    <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name<i class="text-danger"> * </i></th>
                                                <th>Quantity<i class="text-danger"> * </i></th>
                                                <th>Rate</th>
                                                <th>Total</th>
                                                <th>Add</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable1_body">
                                            <tr>
                                                <td>
                                                    <select id="outdoor_service_id" class="form-control outdoor_service_id" name="outdoor_service_id[]" placeholder="Pick a Service..." onchange="changeData(this);" required>
                                                        <option value="">Select a Service...</option>
                                                        <?php
                                                        foreach ($result_content_outdoor_service as $data) {
                                                            echo '<option value="' . $data['outdoor_service_id'] . '">' . $data['outdoor_service_name'] . '</option>';
                                                        }
                                                        ?>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control outdoor_service_quantity" onchange="calculate(this);" placeholder="Service Quantity" id="outdoor_service_quantity" name="outdoor_service_quantity[]" required>

                                                </td>
                                                <td>
                                                    <input type="number" class="form-control outdoor_service_rate" placeholder="Service Rate" id="outdoor_service_rate" name="outdoor_service_rate[]" readonly required>

                                                </td>
                                                <td>
                                                    <input type="number" class="form-control outdoor_service_total" placeholder="Service Total" id="outdoor_service_total" name="outdoor_service_total[]" readonly required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowQ19();">Add Row</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="DeleteRow(this);">Delete Row</button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>

                                    <div class="form-group col-md-4">
                                        <label for="discharge-date">Total Bill</label>
                                        <input type="number" placeholder="Total Bill" class="form-control" id="outdoor_treatment_total_bill" name="outdoor_treatment_total_bill" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="discharge-date">Discount %</label>
                                        <input type="number" min="0" max="100" placeholder="Discount" class="form-control" id="outdoor_treatment_discount_pc" name="outdoor_treatment_discount_pc" onchange="update_total_bill();" value="0" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="discharge-date">In Total Bill</label>
                                        <input type="number" placeholder="In Total Bill" class="form-control" id="outdoor_treatment_total_bill_after_discount" name="outdoor_treatment_total_bill_after_discount" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="discharge-date">Paid<i class="text-danger"> * </i></label>
                                        <input type="number" placeholder="Total Paid" class="form-control" onchange="update_payment();" id="outdoor_treatment_total_paid" name="outdoor_treatment_total_paid" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="discharge-date">Due</label>
                                        <input type="number" placeholder="Total Due" class="form-control" id="outdoor_treatment_total_due" name="outdoor_treatment_total_due" value="0" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="discharge-date">Payment Type<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="outdoor_treatment_payment_type" name="outdoor_treatment_payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            <option value="check">Check</option>
                                            <option value="card">Card</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="card-check">Card/Check No</label>
                                        <input type="text" placeholder="Card/Check No" class="form-control" id="outdoor_treatment_payment_type_no" name="outdoor_treatment_payment_type_no">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="card-check">Note</label>
                                        <input type="text" placeholder="Note" class="form-control" id="outdoor_treatment_note" name="outdoor_treatment_note">
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


        $('form#patient_service_form').on('submit', function(event) {
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
            formData.append('outdoor_treatment_invoice_id', datetime);

            $.ajax({
                url: '../apis/create_outdoor_treatment.php',
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
                        window.open("patient_treatment_list.php", "_self");

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

    function loadPatient() {
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
                            document.getElementById("outdoor_patient_id").value = datas[key].patient_id;
                            document.getElementById("outdoor_patient_name").value = datas[key].patient_name;
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
                            document.getElementById("outdoor_patient_id").value = datas[key].patient_id;
                            document.getElementById("outdoor_patient_name").value = datas[key].patient_name;
                            document.getElementById("outdoor_patient_phone").value = datas[key].patient_phone;
                            document.getElementById("outdoor_treatment_indoor_treatment_id").value = datas[key].indoor_treatment_id;
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

    var all_service = <?php echo json_encode($result_content_outdoor_service); ?>;
    var total_bill = 0;

    function changeData(instance) {
        var row = $(instance).closest("tr");
        var outdoor_service_id = parseFloat(row.find(".outdoor_service_id").val());

        for (var i = 0; i < Object.keys(all_service).length; i++) {
            if (all_service[i]['outdoor_service_id'] == outdoor_service_id) {
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

    function calculate(instance) {
        var row = $(instance).closest("tr");
        var outdoor_service_id = parseFloat(row.find(".outdoor_service_id").val());
        var outdoor_service_rate = parseFloat(row.find(".outdoor_service_rate").val());
        var outdoor_service_quantity = parseFloat(row.find(".outdoor_service_quantity").val());
        //alert(outdoor_service_id);
        var total = outdoor_service_rate * outdoor_service_quantity
        row.find(".outdoor_service_total").val(isNaN(parseInt(total)) ? 0 : total);

        update_total_bill();
    }

    function update_payment() {
        var total_paid = document.getElementById("outdoor_treatment_total_paid").value;
        total_paid = isNaN(parseInt(total_paid)) ? 0 : total_paid;

        var total_bill = document.getElementById("outdoor_treatment_total_bill_after_discount").value;
        total_bill = isNaN(parseInt(total_bill)) ? 0 : total_bill;

        var total_due = parseInt(total_bill) - parseInt(total_paid);
        document.getElementById("outdoor_treatment_total_due").value = total_due;
    }

    function update_total_bill() {
        var in_total = 0;
        $("tr").each(function() {
            var total = $(this).find("input.outdoor_service_total").val();
            in_total = parseInt(in_total) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(in_total);
        document.getElementById("outdoor_treatment_total_bill").value = parseInt(in_total);
        var discount = document.getElementById("outdoor_treatment_discount_pc").value;
        discount = isNaN(parseInt(discount)) ? 0 : parseInt(discount);
        in_total = parseInt(in_total) - (parseInt(in_total) * (parseInt(discount) / 100));
        document.getElementById("outdoor_treatment_total_bill_after_discount").value = in_total;
        update_payment();

    }

    function AddRowQ19() {
        //alert("table q19");
        var table = document.getElementById('datatable1_body');
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
        selectList.onchange = function() {
            changeData(this);
        }

        //var cell = row.insertCell();
        //cell.appendChild(selectList);




        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control outdoor_service_quantity");
        text2.setAttribute("type", "number");
        text2.setAttribute("placeholder", "Service Quantity");
        text2.setAttribute("name", "outdoor_service_quantity[]");
        text2.onchange = function() {
            calculate(this);
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
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Add Row";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowQ19(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.innerHTML = "Delete Row";
        buttonRemove.setAttribute("class", "btn btn-success pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRow(this);
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
        update_total_bill();
        update_payment();
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
        $('#select-patient').selectize({
            sortField: 'text'
        });
    });
</script>

</html>