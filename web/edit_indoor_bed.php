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

    $bed_id = $_GET['bed_id'];
    $get_content = "select * from indoor_bed where indoor_bed_id='$bed_id'";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_bed = $getJson->fetchAll(PDO::FETCH_ASSOC);

    $get_content = "select * from indoor_bed_category";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_bed_category= $getJson->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Edit Bed</h3>
            <form class="form-horizontal form-material mb-0" id="edit_indoor_bed_category_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="indoor_bed_id" value="<?php echo $bed_id; ?>">
                    <input type="hidden" name="content" value="indoor_bed">

                    <div class="form-group col-md-6">
                        <label for="indoor_bed_name">Bed Name<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Bed name" id="indoor_bed_name" name="indoor_bed_name" value="<?php echo $result_content_bed[0]['indoor_bed_name']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="indoor_bed_name">Bed Name<i class="text-danger"> * </i></label>
                        <select name="indoor_bed_category_id" id="indoor_bed_category_id"
                                class="form-control select2 select2-hidden-accessible" required>
                            <option value="">Select Category</option>
                            <?php
                            foreach($result_content_bed_category as $data)
                            {
                                if ($result_content_bed[0]['indoor_bed_category_id'] == $data['indoor_bed_category_id'])
                                {
                                    echo '<option selected value="'.$data['indoor_bed_category_id'].'">'.$data['indoor_bed_category_name'].'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$data['indoor_bed_category_id'].'">'.$data['indoor_bed_category_name'].'</option>';

                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="indoor_bed_room_no">Room No<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Room No" id="indoor_bed_room_no" name="indoor_bed_room_no" value="<?php echo $result_content_bed[0]['indoor_bed_room_no']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="indoor_bed_price">Price<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Price" id="indoor_bed_price" name="indoor_bed_price" value="<?php echo $result_content_bed[0]['indoor_bed_price']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Bed Status<i class="text-danger"> * </i></label>
                        <select class="form-control" id="indoor_bed_status" name="indoor_bed_status" required>
                            <option value="">Select Status</option>
                            <option <?php if ($result_content_bed[0]['indoor_bed_status'] == "available") {
                                echo 'selected';
                            } ?> value="available">Available</option>
                            <option <?php if ($result_content_bed[0]['indoor_bed_status'] == "booked") {
                                echo 'selected';
                            } ?> value="booked">Booked</option>

                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <button type="button" class="btn btn-danger btn-lg" onclick="delete_data();">Delete</button>
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


        $('form#edit_indoor_bed_category_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_indoor_bed.php',
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
                        window.open("indoor_bed_list.php","_self");
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
    function delete_data()
    {
        var data_id = <?php echo $bed_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_indoor_bed.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    indoor_bed_id: data_id,
                    content: "indoor_bed"
                },
                success: function (response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("indoor_bed_list.php","_self");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
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