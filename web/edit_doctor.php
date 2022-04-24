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

    $doctor_id = $_GET['doctor_id'];
    $get_content = "select * from doctor where doctor_id='$doctor_id'";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Edit Doctor</h3>
            <form class="form-horizontal form-material mb-0" id="update_doctor_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="content" value="doctor">
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                    <div class="form-group col-md-6">
                        <input type="file" class="dropify" name="photo_url" data-default-file="../<?php echo $result_content_doctor[0]['photo_url']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="file" class="dropify" name="document_url" data-default-file="../<?php echo $result_content_doctor[0]['document_url']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_name">Doctor Name<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Patient name" id="doctor_name" name="doctor_name" value="<?php echo $result_content_doctor[0]['doctor_name']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_dob">Date Of Birth</label>
                        <input type="date" placeholder="Date of Birth" class="form-control" id="doctor_dob" name="doctor_dob" value="<?php echo $result_content_doctor[0]['doctor_dob']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_specialization">Doctor Specialization</label>
                        <input type="text" class="form-control" placeholder="Doctor Specialization" id="doctor_specialization" name="doctor_specialization" value="<?php echo $result_content_doctor[0]['doctor_specialization']; ?>"  >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_experience">Doctor Experience</label>
                        <input type="text" class="form-control" placeholder="Doctor Experience" id="doctor_experience" name="doctor_experience" value="<?php echo $result_content_doctor[0]['doctor_experience']; ?>"  >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_age">Age</label>
                        <input type="text" placeholder="Age" class="form-control" id="doctor_age" name="doctor_age" value="<?php echo $result_content_doctor[0]['doctor_age']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_phone">Phone</label>
                        <input type="text" placeholder="Phone" class="form-control" id="doctor_phone" name="doctor_phone" value="<?php echo $result_content_doctor[0]['doctor_phone']; ?>" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_emergency_phone">Emergency Phone</label>
                        <input type="text" placeholder="Emergency Phone" class="form-control" id="doctor_emergency_phone" name="doctor_emergency_phone" value="<?php echo $result_content_doctor[0]['doctor_emergency_phone']; ?>" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_email">Email</label>
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email" class="form-control" id="doctor_email" name="doctor_email" value="<?php echo $result_content_doctor[0]['doctor_email']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_gender">Gender</label>
                        <select class="form-control" id="doctor_gender" name="doctor_gender" >
                            <option value="">Select Gender</option>
                            <option <?php if ($result_content_doctor[0]['doctor_gender'] == "male") {
                                echo 'selected';
                            } ?> value="male">Male</option>
                            <option <?php if ($result_content_doctor[0]['doctor_gender'] == "female") {
                                echo 'selected';
                            } ?> value="female">Female</option>
                            <option <?php if ($result_content_doctor[0]['doctor_gender'] == "other") {
                                echo 'selected';
                            } ?> value="other">Other</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_blood_group">Blood Group</label>
                        <select class="form-control" id="doctor_blood_group" name="doctor_blood_group" >
                            <option value="">Select Blood Group</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "A+") {
                                echo 'selected';
                            } ?> value="A+">A+</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "B+") {
                                echo 'selected';
                            } ?> value="B+">B+</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "O+") {
                                echo 'selected';
                            } ?> value="O+">O+</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "AB+") {
                                echo 'selected';
                            } ?> value="AB+">AB+</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "A-") {
                                echo 'selected';
                            } ?> value="A-">A-</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "B-") {
                                echo 'selected';
                            } ?> value="B-">B-</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "O-") {
                                echo 'selected';
                            } ?> value="O-">O-</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "AB-") {
                                echo 'selected';
                            } ?> value="AB-">AB-</option>
                            <option <?php if ($result_content_doctor[0]['doctor_blood_group'] == "not tested") {
                                echo 'selected';
                            } ?> value="not tested">Not Tested</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor_visit_fee">Visit Fee<i class="text-danger"> * </i></label>
                        <input type="number" placeholder="Visit Fee" class="form-control" id="doctor_visit_fee" name="doctor_visit_fee"
                               value="<?php echo $result_content_doctor[0]['doctor_visit_fee']; ?>" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea placeholder="Description" class="form-control" id="doctor_description" name="doctor_description" rows="3" ><?php echo $result_content_doctor[0]['doctor_description']; ?></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Address</label>
                        <textarea placeholder="Address" class="form-control" id="doctor_address" name="doctor_address" rows="3" ><?php echo $result_content_doctor[0]['doctor_address']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Doctor Status</label>
                        <select class="form-control" id="doctor_status" name="doctor_status" >
                            <option value="">Select Status</option>
                            <option <?php if ($result_content_doctor[0]['doctor_status'] == "active") {
                                echo 'selected';
                            } ?> value="active">Active</option>
                            <option <?php if ($result_content_doctor[0]['doctor_status'] == "inactive") {
                                echo 'selected';
                            } ?> value="inactive">In-Active</option>

                        </select>
                    </div>

                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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
    $(document).ready(function() {


        $('form#update_doctor_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_doctor.php',
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
                        window.open("doctor_details.php?doctor_id=<?php echo $result_content_doctor[0]['doctor_id']; ?>","_self");
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
<script>
    $('.dropify').dropify();
</script>
</html>