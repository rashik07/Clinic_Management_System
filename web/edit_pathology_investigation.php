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

                    $pathology_investigation_id = $_GET['pathology_investigation_id'];


                    $get_content = "select * from patient";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select *,DATE(pathology_investigation_date) as pathology_investigation_date from pathology_investigation
                left join patient p on p.patient_id = pathology_investigation.pathology_investigation_patient_id
                left join indoor_treatment on indoor_treatment.indoor_treatment_id =  pathology_investigation.pathology_investigation_indoor_treatment_id
                where pathology_investigation_id='$pathology_investigation_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pathology_investigation = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select * from pathology_investigation_test where pathology_investigation_test_investigation_id='$pathology_investigation_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pathology_investigation_test = $getJson->fetchAll(PDO::FETCH_ASSOC);


                    $get_content = "select * from pathology_test";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pathology_test = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Pathology Investigation</h3>
                            <form class="form-horizontal form-material mb-0" id="update_pathology_investigation_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="pathology_investigation_id" value="<?php echo $pathology_investigation_id; ?>">
                                    <input type="hidden" name="content" value="pathology_investigation">
                                    <div class="form-group col-md-6">
                                        <label for="indoor_treatment_admission_id">Admission ID.</label>
                                        <input type="text" placeholder="Admission ID" class="form-control" id="indoor_treatment_admission_id" name="indoor_treatment_admission_id" value="<?php echo $result_content_pathology_investigation[0]['indoor_treatment_admission_id'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pathology_investigation_patient_phone">Patient Phone<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Patient Phone." class="form-control" id="pathology_investigation_patient_phone" name="pathology_investigation_patient_phone" required value="<?php echo $result_content_pathology_investigation[0]['patient_phone'] ?>" onchange="loadPatient();">
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
                                        <label for="pathology_investigation_date">Investigation Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Date" class="form-control" id="pathology_investigation_date" name="pathology_investigation_date" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_date'] ?>" required>
                                    </div>

                                    <table id="datatable1" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name<i class="text-danger"> * </i></th>
                                                <th>Room No.</th>
                                                <th>Rate</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Add</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable1_body">

                                        </tbody>

                                    </table>

                                    <div class="form-group col-md-4">
                                        <label for="pathology_investigation_total_bill">Total Bill</label>
                                        <input type="number" placeholder="Total Bill" class="form-control" id="pathology_investigation_total_bill" name="pathology_investigation_total_bill" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_total_bill'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pathology_investigation_discount_pc">Discount %</label>
                                        <input type="number" min="0" max="100" placeholder="Discount" class="form-control" id="pathology_investigation_discount_pc" name="pathology_investigation_discount_pc" onchange="update_total_bill();" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_discount_pc'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pathology_investigation_total_bill_after_discount">In Total Bill</label>
                                        <input type="number" placeholder="In Total Bill" class="form-control" id="pathology_investigation_total_bill_after_discount" name="pathology_investigation_total_bill_after_discount" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_total_bill_after_discount'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_total_paid">Paid<i class="text-danger"> * </i></label>
                                        <input type="number" placeholder="Total Paid" class="form-control" onchange="update_total_bill();" id="pathology_investigation_total_paid" name="pathology_investigation_total_paid" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_total_paid'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_total_due">Due</label>
                                        <input type="number" placeholder="Total Due" class="form-control" id="pathology_investigation_total_due" name="pathology_investigation_total_due" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_total_due'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_payment_type">Payment Type<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="pathology_investigation_payment_type" name="pathology_investigation_payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            <option <?php if ($result_content_pathology_investigation[0]['pathology_investigation_payment_type'] == "check") {
                                                        echo 'selected';
                                                    } ?> value="check">Check</option>
                                            <option <?php if ($result_content_pathology_investigation[0]['pathology_investigation_payment_type'] == "card") {
                                                        echo 'selected';
                                                    } ?> value="card">Card</option>
                                            <option <?php if ($result_content_pathology_investigation[0]['pathology_investigation_payment_type'] == "cash") {
                                                        echo 'selected';
                                                    } ?> value="cash">Cash</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pathology_investigation_payment_type_no">Card/Check No</label>
                                        <input type="text" placeholder="Card/Check No" class="form-control" id="pathology_investigation_payment_type_no" name="pathology_investigation_payment_type_no" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_payment_type_no'] ?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pathology_investigation_note">Note</label>
                                        <input type="text" placeholder="Note" class="form-control" id="pathology_investigation_note" name="pathology_investigation_note" value="<?php echo $result_content_pathology_investigation[0]['pathology_investigation_note'] ?>">
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
    var all_test = <?php echo json_encode($result_content_pathology_test); ?>;
    var spinner = $('#loader');
    loadPatient();
    InitRowTest();
    $(document).ready(function() {


        $('form#update_pathology_investigation_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_pathology_investigation.php',
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

    function invoice() {
        form = document.getElementById('update_pathology_investigation_form');
        form.target = '_blank';
        form.action = 'invoice.php';
        form.submit();
        form.action = 'invoice.php';
        form.target = '';
    }

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
        //alert(outdoor_service_id);
        var total = parseInt(pathology_test_rate) * parseInt(pathology_test_quantity);
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

    function InitRowTest() {
        //alert("table q19");
        var list = <?php echo json_encode($result_content_pathology_investigation_test); ?>;

        var table = document.getElementById('datatable1_body');
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
                if (option.value == list[i]['pathology_investigation_test_pathology_test_id'])
                    option.selected = true;
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
            text4.setAttribute("value", list[i]['pathology_investigation_test_quantity']);

            text4.onchange = function() {
                changeData(this);
            }
            var text5 = document.createElement("INPUT");
            text5.setAttribute("type", "number");
            text5.setAttribute("required", "required");
            text5.setAttribute("class", "form-control pathology_investigation_test_total_bill");
            text5.setAttribute("placeholder", "Total");
            text5.setAttribute("name", "pathology_investigation_test_total_bill[]");
            text5.setAttribute("readonly", "readonly");
            text5.setAttribute("value", list[i]['pathology_investigation_test_total_bill']);


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
        text5.setAttribute("type", "number");
        text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control pathology_investigation_test_total_bill");
        text5.setAttribute("placeholder", "Total");
        text5.setAttribute("name", "pathology_investigation_test_total_bill[]");
        text5.setAttribute("readonly", "readonly");


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