<?php
// need to enable on production
require_once('check_if_indoor_manager.php');
?>
<?php include 'header.php';
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];
} else {
    $patient_id = "";
}
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

                    $get_content = "select * from outdoor_service where outdoor_service_Category='Admission'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_Admission = $getJson->fetchAll(PDO::FETCH_ASSOC);


                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Allotment</h3>
                            <form class="form-horizontal form-material mb-0" id="patient_allotment_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="indoor_allotment">
                                    <input type="hidden" name="get_patient_id" id="get_patient_id" value="<?php echo $patient_id ?>">
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
                                                <input type="text" placeholder="Patient Age" class="form-control" id="patient_age" name="patient_age" required>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <!-- <label for="patient_gender">Patient Gender</label> -->
                                                <select id="patient_gender" class="form-control " name="patient_gender" placeholder="Pick a Gender..." disabled>
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
                                                <input type="text" placeholder="Patient ID" class="form-control" id="outdoor_treatment_patient_id" name="outdoor_treatment_patient_id" readonly>
                                            </div>
                                        </div>
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
                                                <th>Allot New</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable1_body">
                                            <tr>
                                                <td>
                                                    <select id="indoor_patient_bed_bed_id" class="form-control indoor_patient_bed_bed_id" name="indoor_patient_bed_bed_id[]" placeholder="Pick a Service..." onchange="changeDataBed(this);" required>
                                                        <option value="">Select a Bed...</option>
                                                        <?php
                                                        foreach ($result_content_indoor_bed as $data) {
                                                            echo '<option value="' . $data['indoor_bed_id'] . '">' . $data['indoor_bed_name'] . '</option>';
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
                                                    <input type="datetime-local" class="form-control indoor_patient_bed_entry_time" placeholder="Entry time" id="indoor_patient_bed_entry_time" name="indoor_patient_bed_entry_time[]" onchange="changeDataBed(this);" required>
                                                </td>
                                                <td>
                                                    <input type="datetime-local" class="form-control indoor_patient_bed_discharge_time" placeholder="Discharge time" id="indoor_patient_bed_discharge_time" name="indoor_patient_bed_discharge_time[]" onchange="changeDataBed(this);" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowBed();">Allot New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="DeleteRowBed(this);">Delete Row</button>
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
                                                <th>Assign New</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable2_body">
                                            <tr>
                                                <td>
                                                    <select id="indoor_patient_doctor_doctor_id" class="form-control indoor_patient_doctor_doctor_id" name="indoor_patient_doctor_doctor_id[]" placeholder="Pick a Service..." onchange="changeDataDoctor(this);" required>
                                                        <option value="">Select a Doctor...</option>
                                                        <?php
                                                        foreach ($result_content_doctor as $data) {
                                                            echo '<option value="' . $data['doctor_id'] . '">' . $data['doctor_name'] . '</option>';
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
                                                    <input type="datetime-local" class="form-control indoor_patient_doctor_entry_time" placeholder="Entry time" id="indoor_patient_doctor_entry_time" name="indoor_patient_doctor_entry_time[]" onchange="changeDataDoctor(this);" required>
                                                </td>
                                                <td>
                                                    <input type="datetime-local" class="form-control indoor_patient_doctor_discharge_time" placeholder="Discharge time" id="indoor_patient_doctor_discharge_time" name="indoor_patient_doctor_discharge_time[]" onchange="changeDataDoctor(this);" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowDoctor();">Assign New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="DeleteRowDoctor(this);">Delete Row</button>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>

                                    <table id="datatable3" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Admission Charge<i class="text-danger"> * </i></th>
                                                <th>Amount</th>


                                                <!-- <th>Assign New</th>
                                                <th>Delete</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="datatable3_body">
                                            <tr>
                                                <td>
                                                    <select id="outdoor_service_id" class="form-control outdoor_service_id" name="outdoor_service_id[]" placeholder="Pick a Service..." onchange="changeDataService(this);" required>
                                                        <option value="">Select a service...</option>
                                                        <?php
                                                        foreach ($result_content_Admission as $data) {
                                                            echo '<option value="' . $data['outdoor_service_id'] . '">' . $data['outdoor_service_name'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </td>


                                                <td>
                                                    <input type="number" class="form-control outdoor_service_rate" placeholder="Fee" id="outdoor_service_rate" name="outdoor_service_rate[]" readonly required>

                                                </td>


                                                <!-- <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="AddRowDoctor();">Assign New</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success pull-right" onclick="DeleteRowDoctor(this);">Delete Row</button>
                                                </td> -->
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
        loadPatientonbegining();


        $('form#patient_allotment_form').on('submit', function(event) {
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
            formData.append('indoor_treatment_admission_id', datetime);
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
                        window.open("indoor_treatment_list.php", "_self");
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


    function loadPatientonbegining() {

        let Search = document.getElementById("get_patient_id").value;
        if (Search > 0) {
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
                        document.getElementById("outdoor_treatment_patient_id").value = "";

                    }

                    var count = Object.keys(datas).length;
                    if (count === 0) {
                        alert("No Patient Found");
                        document.getElementById("patient_name").value = "";
                        document.getElementById("patient_age").value = "";
                        document.getElementById("patient_gender").value = "";
                        document.getElementById("patient_phone").value = "";
                        document.getElementById("outdoor_treatment_patient_id").value = "";
                    } else {
                        for (var key in datas) {
                            if (datas.hasOwnProperty(key)) {
                                // alert(datas[key])
                                // console.log(datas[key])
                                document.getElementById("outdoor_treatment_patient_id").value = datas[key].patient_id;
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
    }

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
                    document.getElementById("outdoor_treatment_patient_id").value = "";

                }

                var count = Object.keys(datas).length;
                if (count === 0) {
                    alert("No Patient Found");
                    document.getElementById("patient_name").value = "";
                    document.getElementById("patient_age").value = "";
                    document.getElementById("patient_gender").value = "";
                    document.getElementById("patient_phone").value = "";
                    document.getElementById("outdoor_treatment_patient_id").value = "";
                } else {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            // alert(datas[key])
                            // console.log(datas[key])
                            document.getElementById("outdoor_treatment_patient_id").value = datas[key].patient_id;
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
    var all_bed = <?php echo json_encode($result_content_indoor_bed); ?>;
    var all_doctor = <?php echo json_encode($result_content_doctor); ?>;
    var all_admission = <?php echo json_encode($result_content_Admission); ?>;

    function changeDataBed(instance) {
        var row = $(instance).closest("tr");
        var indoor_bed_id = parseFloat(row.find(".indoor_patient_bed_bed_id").val());

        for (var i = 0; i < Object.keys(all_bed).length; i++) {
            //alert(all_bed[i]['indoor_bed_id']);
            //alert(indoor_bed_id);
            //alert(all_bed[i]['indoor_bed_id'] == indoor_bed_id);
            if (all_bed[i]['indoor_bed_id'] == indoor_bed_id) {
                //alert("matched");
                let per_day_price = isNaN(parseInt(all_bed[i]['indoor_bed_price'])) ? 0 : all_bed[i]['indoor_bed_price'];
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

    function changeDataDoctor(instance) {
        var row = $(instance).closest("tr");
        var doctor_id = parseFloat(row.find(".indoor_patient_doctor_doctor_id").val());

        for (var i = 0; i < Object.keys(all_doctor).length; i++) {
            //alert(all_bed[i]['indoor_bed_id']);
            //alert(indoor_bed_id);
            //alert(all_bed[i]['indoor_bed_id'] == indoor_bed_id);
            if (all_doctor[i]['doctor_id'] == doctor_id) {
                //alert("matched");
                let per_day_price = isNaN(parseInt(all_doctor[i]['doctor_visit_fee'])) ? 0 : all_doctor[i]['doctor_visit_fee'];
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

    function changeDataService(instance) {
        var row = $(instance).closest("tr");
        var outdoor_service_id = parseFloat(row.find(".outdoor_service_id").val());

        for (var i = 0; i < Object.keys(all_admission).length; i++) {
            //alert(all_bed[i]['indoor_bed_id']);
            //alert(indoor_bed_id);
            //alert(all_bed[i]['indoor_bed_id'] == indoor_bed_id);
            if (all_admission[i]['outdoor_service_id'] == outdoor_service_id) {
                //alert("matched");
                let per_day_price = isNaN(parseInt(all_admission[i]['outdoor_service_rate'])) ? 0 : all_admission[i]['outdoor_service_rate'];
                row.find(".outdoor_service_rate").val(per_day_price);
            }
        }
        update_total_bill();
    }

    function DateDiff(date1, date2) {
        date1 = new Date(date1);
        date2 = new Date(date2);
        // date2.setDate(date2.getDate() + 1)
        date1.setHours(0);
        date1.setMinutes(0, 0, 0);
        date2.setHours(0);
        date2.setMinutes(0, 0, 0);
        var datediff = Math.abs(date1.getTime() - date2.getTime()); // difference
        return parseInt(datediff / (24 * 60 * 60 * 1000), 10); //Convert values days and return value
    }

    function update_total_bill() {
        var bedtotal = 0;
        $("#datatable1 tr").each(function() {
            var total = $(this).find("input.bed_total_bill").val();
            bedtotal = parseInt(bedtotal) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var doctortotal = 0;
        $("#datatable2 tr").each(function() {
            var total = $(this).find("input.doctor_total_bill").val();
            doctortotal = parseInt(doctortotal) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        var admissionfee = 0;
        $("#datatable3 tr").each(function() {
            var total = $(this).find("input.outdoor_service_rate").val();
            admissionfee = parseInt(admissionfee) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });

        let in_total = bedtotal + doctortotal + admissionfee;
        document.getElementById("indoor_treatment_total_bill").value = parseInt(in_total);
        var discount = document.getElementById("indoor_treatment_discount_pc").value;
        discount = isNaN(parseInt(discount)) ? 0 : parseInt(discount);
        in_total = parseInt(in_total) - (parseInt(in_total) * (parseInt(discount) / 100));
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
        selectList.onchange = function() {
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
        text5.setAttribute("type", "date");
        text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control indoor_patient_bed_entry_time");
        text5.setAttribute("placeholder", "Entry");
        text5.setAttribute("name", "indoor_patient_bed_entry_time[]");
        text5.onchange = function() {
            changeDataBed(this);
        }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "date");
        text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control indoor_patient_bed_discharge_time");
        text6.setAttribute("placeholder", "Discharge");
        text6.setAttribute("name", "indoor_patient_bed_discharge_time[]");
        text6.onchange = function() {
            changeDataBed(this);
        }
        var buttonAdd = document.createElement('button');
        buttonAdd.setAttribute("type", "button");
        buttonAdd.innerHTML = "Allot New";
        buttonAdd.setAttribute("class", "btn btn-success pull-right");
        buttonAdd.onclick = function() {
            // ...
            AddRowBed(this);
        };

        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.innerHTML = "Delete Row";
        buttonRemove.setAttribute("class", "btn btn-success pull-right");
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
        selectList.onchange = function() {
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
        text5.setAttribute("type", "date");
        text5.setAttribute("required", "required");
        text5.setAttribute("class", "form-control indoor_patient_doctor_entry_time");
        text5.setAttribute("placeholder", "Entry");
        text5.setAttribute("name", "indoor_patient_doctor_entry_time[]");
        text5.onchange = function() {
            changeDataDoctor(this);
        }
        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "date");
        text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control indoor_patient_doctor_discharge_time");
        text6.setAttribute("placeholder", "Discharge");
        text6.setAttribute("name", "indoor_patient_doctor_discharge_time[]");
        text6.onchange = function() {
            changeDataDoctor(this);
        }
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
        buttonRemove.innerHTML = "Delete Row";
        buttonRemove.setAttribute("class", "btn btn-success pull-right");
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

    function DeleteRowBed(ctl) {
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

    function DeleteRowDoctor(ctl) {
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
</script>
<script>
    // $('#datatable1').dataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //         'copyHtml5',
    //         'excelHtml5',
    //         'csvHtml5',
    //         'pdfHtml5'
    //     ]
    // }); //replace id with your first table's id
    // $('#datatable2').dataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //         'copyHtml5',
    //         'excelHtml5',
    //         'csvHtml5',
    //         'pdfHtml5'
    //     ]
    // }); //replace id with your first table's id
</script>

<script>
    $(document).ready(function() {
        $('#select-patient').selectize({
            sortField: 'text'
        });
    });
</script>

</html>