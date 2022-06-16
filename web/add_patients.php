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
                            <h3 class="widget-title">Add Patient</h3>
                            <form class="form-horizontal form-material mb-0" id="patient_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="patient">
                                    <input type="hidden" name="patient_status" value="active">

                                    <div class="form-group col-md-4">
                                        <label for="patient-name">Patient Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Patient name" id="patient_name" name="patient_name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="patient_gender" name="patient_gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="age">Age<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Age" class="form-control" id="patient_age" name="patient_age" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" style="padding: 20px;">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" placeholder="Phone" onchange="phoneOnChange(this.value)" class="form-control" id="patient_phone" name="patient_phone">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email</label>
                                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email" class="form-control" id="patient_email" name="patient_email">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dob">Date Of Birth</label>
                                                    <input type="date" placeholder="Date of Birth" class="form-control" id="patient_dob" name="patient_dob">
                                                </div>



                                                <div class="form-group col-md-6">
                                                    <label for="gender">Blood Group</label>
                                                    <select class="form-control" id="patient_blood_group" name="patient_blood_group">
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
                                                    <label for="patient_national_ID">National ID</label>
                                                    <input type="text" placeholder="National ID" class="form-control" id="patient_national_ID" name="patient_national_ID">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="patient_marital_status">Marital Status</label>
                                                    <select class="form-control" id="patient_marital_status" name="patient_marital_status">
                                                        <option value="">Select Marital Status</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Unmarried">Unmarried</option>
                                                        <option value="Others">Others</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_guardian">Father/Mother Name</label>
                                                    <input type="text" placeholder="Father/Mother Name" class="form-control" id="patient_guardian" name="patient_guardian">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="patient_refered_by">Refered By</label>
                                                    <input type="text" placeholder="National ID" class="form-control" id="patient_refered_by" name="patient_refered_by">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleFormControlTextarea1">Symtomps</label>
                                                    <textarea placeholder="Symtomps" class="form-control" id="patient_description" name="patient_description" rows="3"></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleFormControlTextarea1">Address</label>
                                                    <textarea placeholder="Address" class="form-control" id="patient_address" name="patient_address" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f9f5f5;padding: 20px;border-radius: 10px;">
                                            <div class="row">
                                                <h3>Emergency Contact Person</h3>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_emergency_name">Name</label>
                                                    <input type="text" placeholder="Name" class="form-control" id="patient_emergency_name" name="patient_emergency_name">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_emergency_relation">Relation with patient</label>
                                                    <input type="text" placeholder="Relation" class="form-control" id="patient_emergency_relation" name="patient_emergency_relation">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="patient_emergency_contact">Contact number</label>
                                                    <input type="text" placeholder="Contact number" class="form-control" id="patient_emergency_contact" name="patient_emergency_contact">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleFormControlTextarea1">Address</label>
                                                    <textarea placeholder="Address" class="form-control" id="patient_emergency_address" name="patient_emergency_address" rows="3"></textarea>
                                                </div>
                                            </div>

                                        </div>
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
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="options" aria-labelledby="options" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div id="modal_content"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div>

            </div>
            <?php include 'footer.php'
            ?>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                    // document.getElementById("patient_form").reset();

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


        $('form#patient_form').on('submit', function(event) {
            event.preventDefault();
            // spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_patient.php',
                type: 'POST',
                data: formData,
                success: function(data) {

                    // spinner.hide();
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        let htmlcontent = '<div class="row" style="margin: 20px;padding: 10px;"><a class="col-md-4" href="Service_doctor_visit.php?patient_id=' + obj.patient_id + '"><div class="card"><div class="card-body"><p class="card-text">Doctor Visit</p></div></div></a><a class="col-md-4" href="Service_physiotherapy.php?patient_id=' + obj.patient_id + '"><div class="card"><div class="card-body"><p class="card-text">Physiotherapy</p></div></div></a><a class="col-md-4" href="add_indoor_treatment.php?patient_id=' + obj.patient_id + '"><div class="card"><div class="card-body"><p class="card-text">Admission</p></div></div></a><a class="col-md-4" href="Service_ot.php?patient_id=' + obj.patient_id + '"><div class="card"><div class="card-body"><p class="card-text">OT</p></div></div></a><a class="col-md-4" href="Service_procedures.php?patient_id=' + obj.patient_id + '"><div class="card"><div class="card-body"><p class="card-text">Procedures</p></div></div></a><a class="col-md-4" href="Service_test.php?patient_id=' + obj.patient_id + '"><div class="card"><div class="card-body"><p class="card-text">Investigation/Test</p></div></div></a></div>';
                        // document.getElementById("modal_content").innerHTML("");
                        document.getElementById("modal_content").insertAdjacentHTML("afterend", htmlcontent);
                        $('#options').modal('show');
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