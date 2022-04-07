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
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Add Medicine Leaf</h3>
            <form class="form-horizontal form-material mb-0" id="medicine_leaf_form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="content" value="medicine_leaf">

                    <div class="form-group col-md-6">
                        <label for="patient-name">Leaf Size<i class="text-danger"> * </i></label>
                        <input type="number" class="form-control" placeholder="Leaf name" id="medicine_leaf_name" name="medicine_leaf_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="patient-name">Total Per Box<i class="text-danger"> * </i></label>
                        <input type="number" class="form-control" placeholder="Total Leaf Per Box" id="medicine_leaf_total_per_box" name="medicine_leaf_total_per_box" required>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Leaf Description</label>
                        <textarea placeholder="Description" class="form-control" id="medicine_leaf_description" name="medicine_leaf_description" rows="3"></textarea>
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


        $('form#medicine_leaf_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_medicine_leaf.php',
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

</script>
</html>