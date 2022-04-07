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

    $bed_category_id = $_GET['bed_category_id'];
    $get_content = "select * from indoor_bed_category where indoor_bed_category_id='$bed_category_id'";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_bed_category = $getJson->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Edit Bed Category</h3>
            <form class="form-horizontal form-material mb-0" id="edit_indoor_bed_category_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="indoor_bed_category_id" value="<?php echo $bed_category_id; ?>">
                    <input type="hidden" name="content" value="indoor_bed_category">

                    <div class="form-group col-md-6">
                        <label for="indoor_bed_category_name">Bed Category Name<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Bed Category Name" id="indoor_bed_category_name" name="indoor_bed_category_name" value="<?php echo $result_content_bed_category[0]['indoor_bed_category_name']; ?>" required>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="indoor_bed_category_description">Bed Category Description</label>
                        <textarea placeholder="Description" class="form-control" id="indoor_bed_category_description" name="indoor_bed_category_description" rows="3"><?php echo $result_content_bed_category[0]['indoor_bed_category_description']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Bed Category Status</label>
                        <select class="form-control" id="indoor_bed_category_status" name="indoor_bed_category_status" required>
                            <option value="">Select Status</option>
                            <option <?php if ($result_content_bed_category[0]['indoor_bed_category_status'] == "active") {
                                echo 'selected';
                            } ?> value="active">Active</option>
                            <option <?php if ($result_content_bed_category[0]['indoor_bed_category_status'] == "inactive") {
                                echo 'selected';
                            } ?> value="inactive">In-Active</option>

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
                url: '../apis/update_indoor_bed_category.php',
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
                        window.open("indoor_bed_category_list.php","_self");
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
        var data_id = <?php echo $bed_category_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_indoor_bed_category.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    indoor_bed_category_id: data_id,
                    content: "indoor_bed_category"
                },
                success: function (response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("indoor_bed_category_list.php","_self");
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