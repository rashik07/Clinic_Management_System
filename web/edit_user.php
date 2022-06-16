<?php
// need to enable on production
require_once('check_if_admin.php');
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

                    $user_id = $_GET['user_id'];
                    $get_content = "select * from user where user_id='$user_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Edit User</h3>
                            <form class="form-horizontal form-material mb-0" id="update_doctor_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="user">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <!-- <input type="hidden" name="doctor_status" value="active"> -->

                                    <div class="form-group col-md-12">
                                        <label for="user_Full_Name">Full Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Full Name" id="user_Full_Name" name="user_Full_Name" value="<?php echo $result_content_doctor[0]['user_Full_Name']  ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="<?php echo $result_content_doctor[0]['username']  ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="user_type_id">Role</label>
                                        <select class="form-control" id="user_type_id" name="user_type_id">
                                            <?php
                                            require_once("../apis/Connection.php");
                                            $connection = new Connection();

                                            $conn = $connection->getConnection();

                                            $get_content = "select * from user_type";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();

                                            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result_content as $data) {
                                                if ($data['user_type_id'] != 1) { ?>
                                                    <option <?php if ($result_content_doctor[0]['user_type_id'] == $data['user_type_id']) {
                                                                echo 'selected';
                                                            } ?> value="<?php echo  $data['user_type_id']; ?>"><?php echo  $data['user_type_Name']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>




                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="user_Email">Email<i class="text-danger"> * </i></label>
                                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" placeholder="Email" id="user_Email" name="user_Email" value="<?php echo $result_content_doctor[0]['user_Email']  ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="user_Password">New Password</label>
                                        <input type="text" class="form-control" placeholder="****" id="user_Password" name="user_Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="user_PhoneNo">Phone No.</label>
                                        <input type="text" placeholder="Phone No." class="form-control" id="user_PhoneNo" name="user_PhoneNo" value="<?php echo $result_content_doctor[0]['user_PhoneNo']  ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="user_Status">Status</label>
                                        <select class="form-control" id="user_Status" name="user_Status">
                                            <option value="">Select Status</option>
                                            <option <?php if ($result_content_doctor[0]['user_Status'] == "active") {
                                                        echo 'selected';
                                                    } ?> value="active">Active</option>
                                            <option <?php if ($result_content_doctor[0]['user_Status'] == "inactive") {
                                                        echo 'selected';
                                                    } ?> value="inactive">Inactive</option>
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

    $(document).ready(function() {
        $('form#update_doctor_form').on('submit', function(event) {
            // alert("working");
            event.preventDefault();
            // spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_user.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    // alert(data);
                    // spinner.hide();
                    var obj = JSON.parse(data);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        location.reload();

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