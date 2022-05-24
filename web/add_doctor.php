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
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Add Doctor</h3>
                            <form class="form-horizontal form-material mb-0" id="doctor_form" method="post" enctype="multipart/form-data">

                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="doctor">
                                    <input type="hidden" name="doctor_status" value="active">
                                    <div class="form-group col-md-6">
                                        <input type="file" class="dropify" name="photo_url" data-default-file="../assets/images/doctor.png">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="file" class="dropify" name="document_url">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Doctor Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Doctor name" id="doctor_name" name="doctor_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dob">Date Of Birth</label>
                                        <input type="date" placeholder="Date of Birth" class="form-control" id="doctor_dob" name="doctor_dob">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Doctor Specialization</label>
                                        <input type="text" class="form-control" placeholder="Doctor Specialization" id="doctor_specialization" name="doctor_specialization">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Doctor Degree</label>
                                        <input type="text" class="form-control" placeholder="Doctor Degree" id="doctor_experience" name="doctor_experience">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="age">Age</label>
                                        <input type="text" placeholder="Age" class="form-control" id="doctor_age" name="doctor_age">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" placeholder="Phone" class="form-control" id="doctor_phone" name="doctor_phone">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="doctor_emergency_phone">Emergency Phone</label>
                                        <input type="text" placeholder="Emergency Phone" class="form-control" id="doctor_emergency_phone" name="doctor_emergency_phone">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email" class="form-control" id="doctor_email" name="doctor_email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" id="doctor_gender" name="doctor_gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">Blood Group</label>
                                        <select class="form-control" id="doctor_blood_group" name="doctor_blood_group">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+">A+</option>
                                            <option value="B+">B+</option>
                                            <option value="O+">O+</option>
                                            <option value="AB+">AB+</option>
                                            <option value="A-">A-</option>
                                            <option value="B-">B-</option>
                                            <option value="O-">O-</option>
                                            <option value="AB-">AB-</option>
                                            <option value="not tested">Not Tested</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="doctor_visit_fee">Visit Fee<i class="text-danger"> * </i></label>
                                        <input type="number" placeholder="Visit Fee" class="form-control" id="doctor_visit_fee" name="doctor_visit_fee" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Description</label>
                                        <textarea placeholder="Description" class="form-control" id="doctor_description" name="doctor_description" rows="3"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Address</label>
                                        <textarea placeholder="Address" class="form-control" id="doctor_address" name="doctor_address" rows="3"></textarea>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
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
    $(document).ready(function() {


        $('form#doctor_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_doctor.php',
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
                        window.open("doctors_list.php", "_self");

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