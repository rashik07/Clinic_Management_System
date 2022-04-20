<?php
// need to enable on production
require_once('check_if_pathalogy_manager.php');
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

                    $get_content = "select * from pathology_test";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pathology_test = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Pathology Investigation</h3>
                            <form class="form-horizontal form-material mb-0" id="pathology_investigation_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="pathology_investigation">

                                    <div class="form-group col-md-6">
                                        <label for="indoor_treatment_admission_id">Admission ID.<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Admission ID" class="form-control" id="indoor_treatment_admission_id" name="indoor_treatment_admission_id" onchange="loadAdmission();">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="pathology_investigation_patient_phone">Patient Phone<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Patient Phone." class="form-control" id="pathology_investigation_patient_phone" name="pathology_investigation_patient_phone" required onchange="loadPatient();">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pathology_investigation_patient_id">Patient ID</label>
                                        <input type="text" placeholder="Patient ID." class="form-control" id="pathology_investigation_patient_id" name="pathology_investigation_patient_id" readonly required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pathology_investigation_patient_name">Patient Name</label>
                                        <input type="text" placeholder="Patient Name" class="form-control" id="pathology_investigation_patient_name" name="pathology_investigation_patient_name" required readonly>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="pathology_investigation_indoor_treatment_id">Indoor treatement id</label>
                                        <input type="text" placeholder="Indoor treatement id" class="form-control" id="pathology_investigation_indoor_treatment_id" name="pathology_investigation_indoor_treatment_id" readonly>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="pathology_investigation_date">Investigation Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Date" class="form-control" id="pathology_investigation_date" name="pathology_investigation_date" required>
                                    </div>

                                    <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name<i class="text-danger"> * </i></th>
                                                <th>Room No.</th>
                                                <th>Rate</th>
                                                <th>Quantity<i class="text-danger"> * </i></th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                                <th>Add</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable1_body">
                                            <tr>
                                                <td>
                                                    <select id="pathology_test_id" class="form-control pathology_test_id" name="pathology_test_id[]" placeholder="Pick a Test..." onchange="changeData(this);" required>
                                                        <option value="">Select a Test...</option>
                                                        <?php
                                                        foreach ($result_content_pathology_test as $data) {
                                                            echo '<option value="' . $data['pathology_test_id'] . '">' . $data['pathology_test_name'] . '</option>';
                                                        }
                                                        ?>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control pathology_test_room_no" placeholder="Room No" id="pathology_test_room_no" name="pathology_test_room_no[]" required readonly>

                                                </td>
                                                <td>
                                                    <input type="number" class="form-control pathology_investigation_test_price" placeholder="Price" id="pathology_investigation_test_price" name="pathology_investigation_test_price[]" readonly required>

                                                </td>
                                                <td>
                                                    <input type="number" class="form-control pathology_investigation_test_quantity" onchange="changeData(this);" placeholder="Quantity" id="pathology_investigation_test_quantity" name="pathology_investigation_test_quantity[]" required>

                                                </td>
                                                <td>
                                                    <input type="text" class="form-control pathology_investigation_test_dc" onchange="changeData(this);" placeholder="Discount" id="pathology_investigation_test_dc" name="pathology_investigation_test_dc[]">

                                                </td>

                                                <td>
                                                    <input type="number" class="form-control pathology_investigation_test_total_bill" placeholder="Total" id="pathology_investigation_test_total_bill" name="pathology_investigation_test_total_bill[]" readonly required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowTest();">Add Row</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="DeleteRowTest(this);">Delete Row</button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>

                                    <div class="form-group col-md-4">
                                        <label for="pathology_investigation_total_bill">Total Bill</label>
                                        <input type="number" placeholder="Total Bill" class="form-control" id="pathology_investigation_total_bill" name="pathology_investigation_total_bill" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pathology_investigation_discount_pc">Discount %</label>
                                        <input type="number" min="0" max="100" placeholder="Discount" class="form-control" id="pathology_investigation_discount_pc" name="pathology_investigation_discount_pc" onchange="update_total_bill();" value="0" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pathology_investigation_total_bill_after_discount">In Total Bill</label>
                                        <input type="number" placeholder="In Total Bill" class="form-control" id="pathology_investigation_total_bill_after_discount" name="pathology_investigation_total_bill_after_discount" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_total_paid">Paid<i class="text-danger"> * </i></label>
                                        <input type="number" placeholder="Total Paid" class="form-control" onchange="update_total_bill();" id="pathology_investigation_total_paid" name="pathology_investigation_total_paid" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_total_due">Due</label>
                                        <input type="number" placeholder="Total Due" class="form-control" id="pathology_investigation_total_due" name="pathology_investigation_total_due" value="0" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_payment_type">Payment Type<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="pathology_investigation_payment_type" name="pathology_investigation_payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            <option value="check">Check</option>
                                            <option value="card">Card</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_payment_type_no">Card/Check No</label>
                                        <input type="text" placeholder="Card/Check No" class="form-control" id="pathology_investigation_payment_type_no" name="pathology_investigation_payment_type_no">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pathology_investigation_note">Note</label>
                                        <input type="text" placeholder="Note" class="form-control" id="pathology_investigation_note" name="pathology_investigation_note">
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


        $('form#pathology_investigation_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_pathology_investigation.php',
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
                        window.open("pathology_investigation_list.php", "_self");

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
        let patient_phone = document.getElementById("pathology_investigation_patient_phone").value;
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
                    document.getElementById("pathology_investigation_patient_name").value = "";

                }

                var count = Object.keys(datas).length;
                if (count === 0) {
                    alert("No Patient Found");
                    document.getElementById("pathology_investigation_patient_name").value = "";
                } else {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            document.getElementById("pathology_investigation_patient_id").value = datas[key].patient_id;
                            document.getElementById("pathology_investigation_patient_name").value = datas[key].patient_name;
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
                            document.getElementById("pathology_investigation_patient_id").value = datas[key].patient_id;
                            document.getElementById("pathology_investigation_patient_name").value = datas[key].patient_name;
                            document.getElementById("pathology_investigation_patient_phone").value = datas[key].patient_phone;
                            document.getElementById("pathology_investigation_indoor_treatment_id").value = datas[key].indoor_treatment_id;
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
    var all_test = <?php echo json_encode($result_content_pathology_test); ?>;
    var total_bill = 0;

    function changeData(instance) {
        var row = $(instance).closest("tr");
        var pathology_test_id = parseFloat(row.find(".pathology_test_id").val());

        for (var i = 0; i < Object.keys(all_test).length; i++) {
            if (all_test[i]['pathology_test_id'] == pathology_test_id) {
                row.find(".pathology_test_room_no").val(all_test[i]['pathology_test_room_no']);
                row.find(".pathology_investigation_test_price").val(isNaN(parseInt(all_test[i]['pathology_test_price'])) ? 0 : all_test[i]['pathology_test_price']);

            }
        }
        var pathology_test_rate = parseFloat(row.find(".pathology_investigation_test_price").val());
        var pathology_test_quantity = parseFloat(row.find(".pathology_investigation_test_quantity").val());
        var pathology_investigation_test_dc = row.find(".pathology_investigation_test_dc").val();
        var total = parseInt(pathology_test_rate) * parseInt(pathology_test_quantity);
        if (pathology_investigation_test_dc != "") {
            if (pathology_investigation_test_dc.search("%") > 0) {
                var total_dc = (parseInt(pathology_investigation_test_dc) / 100) * parseInt(total);
                total = parseInt(pathology_test_rate) * parseInt(pathology_test_quantity) - total_dc;
            } else {
                total = parseInt(pathology_test_rate) * parseInt(pathology_test_quantity) - parseInt(pathology_investigation_test_dc);
            }
        }

        row.find(".pathology_investigation_test_total_bill").val(isNaN(total) ? 0 : total);

        update_total_bill();
    }

    function update_total_bill() {
        var in_total = 0;
        $("tr").each(function() {
            var total = $(this).find("input.pathology_investigation_test_total_bill").val();
            in_total = parseInt(in_total) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(in_total);
        document.getElementById("pathology_investigation_total_bill").value = parseInt(in_total);

        var discount = document.getElementById("pathology_investigation_discount_pc").value;
        discount = isNaN(parseInt(discount)) ? 0 : parseInt(discount);
        in_total = parseInt(in_total) - (parseInt(in_total) * (parseInt(discount) / 100));
        document.getElementById("pathology_investigation_total_bill_after_discount").value = in_total;

        var paid = document.getElementById("pathology_investigation_total_paid").value;
        document.getElementById("pathology_investigation_total_due").value = (in_total - paid);


    }

    function AddRowTest() {
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
        selectList.onchange = function() {
            changeData(this);
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
        text4.onchange = function() {
            changeData(this);
        }

        var text5 = document.createElement("INPUT");
        text5.setAttribute("type", "text");
        // text4.setAttribute("required", "required");
        text5.setAttribute("class", "form-control pathology_investigation_test_dc");
        text5.setAttribute("placeholder", "Discount");
        text5.setAttribute("name", "pathology_investigation_test_dc[]");
        text5.onchange = function() {
            changeData(this);
        }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "number");
        text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control pathology_investigation_test_total_bill");
        text6.setAttribute("placeholder", "Total");
        text6.setAttribute("name", "pathology_investigation_test_total_bill[]");
        text6.setAttribute("readonly", "readonly");


        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Add Row";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowTest(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.innerHTML = "Delete Row";
        buttonRemove.setAttribute("class", "btn btn-success pull-right");
        buttonRemove.onclick = function() {
            // ...
            DeleteRowTest(this);
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

    function DeleteRowTest(ctl) {
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