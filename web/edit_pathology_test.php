<?php
// need to enable on production
require_once('check_if_pathalogy_manager.php');
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

    $pathology_test_id = $_GET['pathology_test_id'];
    $get_content = "select * from pathology_test where pathology_test_id='$pathology_test_id'";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_pathology_test = $getJson->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Edit Pathology Test</h3>
            <form class="form-horizontal form-material mb-0" id="edit_pathology_test_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="pathology_test_id" value="<?php echo $pathology_test_id; ?>">

                    <input type="hidden" name="content" value="pathology_test">

                    <div class="form-group col-md-6">
                        <label for="pathology_test_name">Test Name<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Test name" id="pathology_test_name" name="pathology_test_name" value="<?php echo $result_content_pathology_test[0]['pathology_test_name']; ?>" required>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="pathology_test_description">Test Description</label>
                        <textarea placeholder="Description" class="form-control" id="pathology_test_description" name="pathology_test_description" rows="3"><?php echo $result_content_pathology_test[0]['pathology_test_description']; ?></textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pathology_test_room_no">Room No.</label>
                        <input type="text" class="form-control" placeholder="Room No" id="pathology_test_room_no" name="pathology_test_room_no" value="<?php echo $result_content_pathology_test[0]['pathology_test_room_no']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pathology_test_price">Test Price<i class="text-danger"> * </i></label>
                        <input type="number" class="form-control" placeholder="Test Price" id="pathology_test_price" name="pathology_test_price" value="<?php echo $result_content_pathology_test[0]['pathology_test_price']; ?>"  required>
                    </div>

                    <div class="form-group col-md-6 mb-3">
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


        $('form#edit_pathology_test_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_pathology_test.php',
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
                        window.open("pathology_test_list.php","_self");
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
        var data_id = <?php echo $pathology_test_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_pathology_test.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    pathology_test_id: data_id,
                    content: "pathology_test"
                },
                success: function (response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("pathology_test_list.php","_self");
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