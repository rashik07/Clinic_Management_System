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
                            <h3 class="widget-title">Add Service</h3>
                            <form class="form-horizontal form-material mb-0" id="service_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="outdoor_service">

                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Service Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Service name" id="outdoor_service_name" name="outdoor_service_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="discharge-date">Service Category<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="outdoor_service_Category" name="outdoor_service_Category" required>
                                            <option value="">Select Service Category</option>
                                            <option value="Doctor Visit">Doctor Visit</option>
                                            <option value="Procedures">Procedures</option>
                                            <option value="Physiotherapy">Physiotherapy</option>
                                            <option value="OT">OT</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Service Rate<i class="text-danger"> * </i></label>
                                        <input type="number" class="form-control" placeholder="Service Rate" id="outdoor_service_rate" name="outdoor_service_rate" required>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Service Description</label>
                                        <textarea placeholder="Description" class="form-control" id="outdoor_service_description" name="outdoor_service_description" rows="3"></textarea>
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


        $('form#service_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_outdoor_service.php',
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
                        window.open("service_list.php", "_self");
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