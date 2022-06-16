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
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Add User</h3>
                            <form class="form-horizontal form-material mb-0" id="doctor_form" method="post" enctype="multipart/form-data">

                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="user">
                                    <!-- <input type="hidden" name="doctor_status" value="active"> -->

                                    <div class="form-group col-md-12">
                                        <label for="user_Full_Name">Full Name<i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="Full Name" id="user_Full_Name" name="user_Full_Name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" placeholder="Username" id="username" name="username">
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
                                                if ($data['user_type_id'] != 1) {
                                                    echo '<option value="' . $data['user_type_id'] . '">' . $data['user_type_Name'] . '</option>';
                                                }
                                            }
                                            ?>




                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="user_Email">Email<i class="text-danger"> * </i></label>
                                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" placeholder="Email" id="user_Email" name="user_Email" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="user_Password">Password <i class="text-danger"> * </i></label>
                                        <input type="text" class="form-control" placeholder="****" id="user_Password" name="user_Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="user_PhoneNo">Phone No.</label>
                                        <input type="text" placeholder="Phone No." class="form-control" id="user_PhoneNo" name="user_PhoneNo">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="user_Status">Status</label>
                                        <select class="form-control" id="user_Status" name="user_Status">
                                            <option value="">Select Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
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
                url: '../apis/create_user.php',
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
                        window.open("users.php", "_self");

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