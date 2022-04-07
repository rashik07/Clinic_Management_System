<?php
// need to enable on production
require_once('check_if_pharmacy_manager.php');
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

    $medicine_leaf_id= $_GET['medicine_leaf_id'];
    $get_content = "select * from medicine_leaf where medicine_leaf_id='$medicine_leaf_id'";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_medicine_leaf = $getJson->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Edit Medicine Leaf</h3>
            <form class="form-horizontal form-material mb-0" id="edit_medicine_leaf_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="medicine_leaf_id" value="<?php echo $medicine_leaf_id; ?>">

                    <input type="hidden" name="content" value="medicine_leaf">

                    <div class="form-group col-md-6">
                        <label for="patient-name">Medicine Leaf Name<i class="text-danger"> * </i></label>
                        <input type="number" class="form-control" placeholder="Medicine Leaf name" id="medicine_leaf_name" name="medicine_leaf_name" value="<?php echo $result_content_medicine_leaf[0]['medicine_leaf_name']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="patient-name">Total Per Box<i class="text-danger"> * </i></label>
                        <input type="number" class="form-control" placeholder="Total Leaf Per Box" id="medicine_leaf_total_per_box" name="medicine_leaf_total_per_box" value="<?php echo $result_content_medicine_leaf[0]['medicine_leaf_total_per_box']; ?>"  required>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Medicine Leaf Description</label>
                        <textarea placeholder="Description" class="form-control" id="medicine_leaf_description" name="medicine_leaf_description" rows="3"><?php echo $result_content_medicine_leaf[0]['medicine_leaf_description']; ?></textarea>
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


        $('form#edit_medicine_leaf_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_medicine_leaf.php',
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
                        window.open("medicine_leaf_list.php","_self");
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
        var data_id = <?php echo $medicine_leaf_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_medicine_leaf.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    medicine_leaf_id: data_id,
                    content: "medicine_leaf"
                },
                success: function (response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("medicine_leaf_list.php","_self");
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