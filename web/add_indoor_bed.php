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
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Add Bed Category</h3>
            <?php
            require_once("../apis/Connection.php");
            $connection = new Connection();
            $conn = $connection->getConnection();

            $get_content = "select * from indoor_bed_category";
            //echo $get_content;
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content_bed_category= $getJson->fetchAll(PDO::FETCH_ASSOC);

            ?>
            <form class="form-horizontal form-material mb-0" id="indoor_bed_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="content" value="indoor_bed">
                    <input type="hidden" name="indoor_bed_status" value="available">

                        <div class="form-group col-md-6">
                            <label for="indoor_bed_name">Bed Name<i class="text-danger"> * </i></label>
                            <input type="text" class="form-control" placeholder="Bed name" id="indoor_bed_name" name="indoor_bed_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="indoor_bed_category_id">Bed Category<i class="text-danger"> * </i></label>
                            <select name="indoor_bed_category_id" id="indoor_bed_category_id"
                                    class="form-control select2 select2-hidden-accessible" required>
                                <option value="">Select Category</option>
                                <?php
                                foreach($result_content_bed_category as $data)
                                {
                                    echo '<option value="'.$data['indoor_bed_category_id'].'">'.$data['indoor_bed_category_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    <div class="form-group col-md-6">
                        <label for="indoor_bed_room_no">Room No<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Room No" id="indoor_bed_room_no" name="indoor_bed_room_no" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="indoor_bed_price">Price<i class="text-danger"> * </i></label>
                        <input type="text" class="form-control" placeholder="Price" id="indoor_bed_price" name="indoor_bed_price" required>
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


        $('form#indoor_bed_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_indoor_bed.php',
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

</script>
</html>