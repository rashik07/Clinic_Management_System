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
        <div class="body-content px-3 py-3">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0">Add Supplier</h6>
                                </div>
                                <div class="text-right">
                                    <a href="manufacturer_list.php" class="btn btn-success btn-sm mr-1"><i
                                                class="fas fa-align-justify mr-1"></i>Supplier List</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal form-material mb-0" id="medicine_manufacturer_form" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="content" value="medicine_manufacturer">

                                <div class="form-group row">
                                    <label for="manufacturer_name" class="col-md-2 text-right col-form-label">Supplier
                                        Name <i class="text-danger"> * </i>:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <input type="text" name="medicine_manufacturer_name" class="form-control"
                                                   id="medicine_manufacturer_name" placeholder="Supplier Name" required>
                                        </div>
                                    </div>
                                    <label for="manufacturer_mobile" class="col-md-2 text-right col-form-label">Mobile
                                        No:<i class="text-danger"> * </i></label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <input type="text" name="medicine_manufacturer_mobile"
                                                   class="form-control input-mask-trigger text-left valid_number"
                                                   id="medicine_manufacturer_mobile" placeholder="Mobile No" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="manufacturer_email" class="col-md-2 text-right col-form-label">Email
                                        Address:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <input type="email" class="form-control input-mask-trigger"
                                                   name="medicine_manufacturer_email" id="medicine_manufacturer_email"
                                                   placeholder="Email">
                                        </div>
                                    </div>
                                    <label for="address1" class="col-md-2 text-right col-form-label">Address:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <textarea name="medicine_manufacturer_address" id="medicine_manufacturer_address" class="form-control"
                                                      placeholder="Address " ></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="city" class="col-md-2 text-right col-form-label">City:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <input type="text" name="medicine_manufacturer_city" class="form-control" id="medicine_manufacturer_city"
                                                   placeholder="City" >
                                        </div>
                                    </div>
                                    <label for="state" class="col-md-2 text-right col-form-label">State:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <input type="text" name="medicine_manufacturer_state" class="form-control" id="medicine_manufacturer_state"
                                                   placeholder="State">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">


                                </div>
                                <div class="form-group row">

                                    <label for="address1" class="col-md-2 text-right col-form-label">Supplier
                                        Details:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <textarea name="medicine_manufacturer_description" id="medicine_manufacturer_description" class="form-control"
                                                      placeholder="Supplier  Details "></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 text-right">
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="">
                                            <button type="submit" class="btn btn-success">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <div id="loader"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'
?>
</body>
<script>
    var spinner = $('#loader');
    $(document).ready(function() {


        $('form#medicine_manufacturer_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_medicine_manufacturer.php',
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
                        window.open("manufacturer_list.php","_self");
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