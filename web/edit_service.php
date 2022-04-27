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

                    $outdoor_service_id = $_GET['outdoor_service_id'];
                    $get_content = "select * from outdoor_service where outdoor_service_id='$outdoor_service_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_outdoor_service = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Edit Patient</h3>
                            <form class="form-horizontal form-material mb-0" id="edit_service_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="outdoor_service_id" value="<?php echo $outdoor_service_id; ?>">

                                    <input type="hidden" name="content" value="outdoor_service">

                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Service Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Service name" id="outdoor_service_name" name="outdoor_service_name" value="<?php echo $result_content_outdoor_service[0]['outdoor_service_name']; ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="discharge-date">Service Category<i class="text-danger"> * </i></label>
                                        <select class="form-control" id="outdoor_service_Category" name="outdoor_service_Category" required>
                                            <option value="">Select Service Category</option>
                                            <!-- <option value="doctor_visit">Doctor Visit</option>
                                            <option value="procedures">Procedures</option>
                                            <option value="physiotherapy">Physiotherapy</option>
                                            <option value="ot">OT</option> -->
                                            <option <?php if ($result_content_outdoor_service[0]['outdoor_service_Category'] == "Doctor Visit") {
                                                        echo 'selected';
                                                    } ?> value="doctor_visit">Doctor Visit</option>
                                            <option <?php if ($result_content_outdoor_service[0]['outdoor_service_Category'] == "Procedures") {
                                                        echo 'selected';
                                                    } ?> value="procedures">Procedures</option>
                                            <option <?php if ($result_content_outdoor_service[0]['outdoor_service_Category'] == "Physiotherapy") {
                                                        echo 'selected';
                                                    } ?> value="physiotherapy">Physiotherapy</option>
                                            <option <?php if ($result_content_outdoor_service[0]['outdoor_service_Category'] == "OT") {
                                                        echo 'selected';
                                                    } ?> value="ot">OT</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="patient-name">Service Rate<i class="text-danger"> * </i></label>
                                        <input type="number" class="form-control" placeholder="Service Rate" id="outdoor_service_rate" name="outdoor_service_rate" value="<?php echo $result_content_outdoor_service[0]['outdoor_service_rate']; ?>" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Service Description</label>
                                        <textarea placeholder="Description" class="form-control" id="outdoor_service_description" name="outdoor_service_description" rows="3"><?php echo $result_content_outdoor_service[0]['outdoor_service_description']; ?></textarea>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                        <button type="button" class="btn btn-danger btn-lg" onclick="delete_data();">Delete</button>
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


        $('form#edit_service_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_outdoor_service.php',
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

    function delete_data() {
        var data_id = <?php echo $outdoor_service_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_outdoor_service.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    outdoor_service_id: data_id,
                    content: "outdoor_service"
                },
                success: function(response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("service_list.php", "_self");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    spinner.hide();
                    alert("alert : " + errorThrown);
                }
            });
        } else {
            // Do nothing!
            console.log('Said No');
        }
    }
</script>

</html>