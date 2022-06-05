<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
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

                    $patient_id = $_GET['patient_id'];
                    $get_content = "select * from patient where patient_id='$patient_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_patient = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Edit Patient</h3>
                            <form class="form-horizontal form-material mb-0" id="update_patient_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="patient">
                                    <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">

                                    <div class="form-group col-md-4">
                                        <label for="patient-name">Patient Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Patient name" id="patient_name" name="patient_name" value="<?php echo $result_content_patient[0]['patient_name']; ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="patient_gender" name="patient_gender" required>
                                            <option value="">Select Gender</option>
                                            <option <?php if ($result_content_patient[0]['patient_gender'] == "male") {
                                                        echo 'selected';
                                                    } ?> value="male">Male</option>
                                            <option <?php if ($result_content_patient[0]['patient_gender'] == "female") {
                                                        echo 'selected';
                                                    } ?> value="female">Female</option>
                                            <option <?php if ($result_content_patient[0]['patient_gender'] == "other") {
                                                        echo 'selected';
                                                    } ?> value="other">Other</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="age">Age</label>
                                        <input type="text" placeholder="Age" class="form-control" id="patient_age" name="patient_age" value="<?php echo $result_content_patient[0]['patient_age']; ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" placeholder="Phone" onchange="phoneOnChange(this.value)" class="form-control" id="patient_phone" name="patient_phone" value="<?php echo $result_content_patient[0]['patient_phone']; ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email</label>
                                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email" class="form-control" id="patient_email" name="patient_email" value="<?php echo $result_content_patient[0]['patient_email']; ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dob">Date Of Birth</label>
                                                    <input type="date" placeholder="Date of Birth" class="form-control" id="patient_dob" name="patient_dob" value="<?php echo $result_content_patient[0]['patient_dob']; ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="gender">Blood Group</label>
                                                    <select class="form-control" id="patient_blood_group" name="patient_blood_group">
                                                        <option value="">Select Blood Group</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "A+") {
                                                                    echo 'selected';
                                                                } ?> value="A+">A+</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "B+") {
                                                                    echo 'selected';
                                                                } ?> value="B+">B+</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "O+") {
                                                                    echo 'selected';
                                                                } ?> value="O+">O+</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "AB+") {
                                                                    echo 'selected';
                                                                } ?> value="AB+">AB+</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "A-") {
                                                                    echo 'selected';
                                                                } ?> value="A-">A-</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "B-") {
                                                                    echo 'selected';
                                                                } ?> value="B-">B-</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "O-") {
                                                                    echo 'selected';
                                                                } ?> value="O-">O-</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "AB-") {
                                                                    echo 'selected';
                                                                } ?> value="AB-">AB-</option>
                                                        <option <?php if ($result_content_patient[0]['patient_blood_group'] == "not tested") {
                                                                    echo 'selected';
                                                                } ?> value="not tested">Not Tested</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_national_ID">National ID</label>
                                                    <input type="text" placeholder="National ID" class="form-control" id="patient_national_ID" name="patient_national_ID" value="<?php echo $result_content_patient[0]['patient_national_ID']; ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleFormControlTextarea1">Description</label>
                                                    <textarea placeholder="Description" class="form-control" id="patient_description" name="patient_description" rows="3"><?php echo $result_content_patient[0]['patient_description']; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleFormControlTextarea1">Address</label>
                                                    <textarea placeholder="Address" class="form-control" id="patient_address" name="patient_address" rows="3"><?php echo $result_content_patient[0]['patient_address']; ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6" style="background-color: #f9f5f5;padding: 20px;border-radius: 10px;">
                                            <div class="row">
                                                <h3>Emergency Contact Person</h3>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_emergency_name">Name</label>
                                                    <input type="text" placeholder="Name" class="form-control" id="patient_emergency_name" name="patient_emergency_name" value="<?php echo $result_content_patient[0]['patient_emergency_name']; ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_emergency_relation">Relation with patient</label>
                                                    <input type="text" placeholder="Relation" class="form-control" id="patient_emergency_relation" name="patient_emergency_relation" value="<?php echo $result_content_patient[0]['patient_emergency_relation']; ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_emergency_contact">Contact number</label>
                                                    <input type="text" placeholder="Contact number" class="form-control" id="patient_emergency_contact" name="patient_emergency_contact" value="<?php echo $result_content_patient[0]['patient_emergency_contact']; ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleFormControlTextarea1">Address</label>
                                                    <textarea placeholder="Address" class="form-control" id="patient_emergency_address" name="patient_emergency_address" rows="3"><?php echo $result_content_patient[0]['patient_emergency_address']; ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="gender">Patient Status <i class="text-danger"> * </i></label>
                                    <select class="form-control" id="patient_status" name="patient_status" required>
                                        <option value="">Select Status</option>
                                        <option <?php if ($result_content_patient[0]['patient_status'] == "active") {
                                                    echo 'selected';
                                                } ?> value="active">Active</option>
                                        <option <?php if ($result_content_patient[0]['patient_status'] == "inactive") {
                                                    echo 'selected';
                                                } ?> value="inactive">In-Active</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                </div>

                        </div>

                        </form>
                        <div id="loader"></div>
                        <!-- /Alerts-->
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

    function phoneOnChange(val) {
        //alert(val);
        spinner.show();
        jQuery.ajax({
            type: 'POST',
            url: '../apis/get_patient.php',
            cache: false,
            //dataType: "json", // and this
            data: {
                token: "<?php echo $_SESSION['token']; ?>",
                request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                patient_phone: val,
                content: "patient_single_phone",
            },
            success: function(response) {
                //alert(response);
                spinner.hide();
                var obj = JSON.parse(response);
                var datas = obj.patient;
                if (datas === null) {
                    //alert("No Patient Found");

                } else {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            alert("A patient named: " + datas[key].patient_name + " Already Registered with the phone No: " + val)
                        }
                    }
                    //document.getElementById("patient_phone").value = "";
                    document.getElementById("update_patient_form").reset();

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                spinner.hide();
                alert("alert : " + errorThrown);
            }
        });
    }
    $(document).ready(function() {


        $('form#update_patient_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_patient.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    //alert(data);
                    spinner.hide();
                    var obj = JSON.parse(data);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("patient_details.php?patient_id=<?php echo $result_content_patient[0]['patient_id']; ?>", "_self");
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
</script>

</html>