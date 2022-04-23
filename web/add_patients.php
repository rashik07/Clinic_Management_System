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

                    <div class="form-group col-md-6">
                        <label for="patient-name">Patient Name<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Patient name" id="patient_name" name="patient_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dob">Date Of Birth</label>
                        <input type="date" placeholder="Date of Birth" class="form-control" id="patient_dob" name="patient_dob">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="age">Age<i class="text-danger"> * </i></label>
                        <input type="text" placeholder="Age" class="form-control" id="patient_age" name="patient_age" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone<i class="text-danger"> * </i></label>
                        <input type="text" placeholder="Phone" onchange="phoneOnChange(this.value)" class="form-control" id="patient_phone" name="patient_phone" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email" class="form-control" id="patient_email" name="patient_email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender<i class="text-danger"> * </i></label>
                        <select class="form-control" id="patient_gender" name="patient_gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
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
                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea placeholder="Description" class="form-control" id="patient_description" name="patient_description" rows="3"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Address</label>
                        <textarea placeholder="Address" class="form-control" id="patient_address" name="patient_address" rows="3"></textarea>
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
    function phoneOnChange(val)
    {
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
                if(datas === null)
                {
                    //alert("No Patient Found");
                    
                }
                else
                {
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            alert("A patient named: "+ datas[key].patient_name + " Already Registered with the phone No: "+ val)
                        }
                    }
                    //document.getElementById("patient_phone").value = "";
                    document.getElementById("patient_form").reset();

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                spinner.hide();
                alert("alert : "+errorThrown);
            }
        });
    }
    
    $(document).ready(function() {


        $('form#patient_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_patient.php',
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
                        window.open("patients_list.php","_self");
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