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
                                        <h6 class="fs-17 font-weight-600 mb-0">Add Medicine</h6>
                                    </div>
                                    <div class="text-right">
                                        <a href="medicine_list.php" class="btn btn-success btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Medicine List</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            require_once("../apis/Connection.php");
                            $connection = new Connection();
                            $conn = $connection->getConnection();

                            $get_content = "select * from medicine_leaf";
                            //echo $get_content;
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $result_content_medicine_leaf = $getJson->fetchAll(PDO::FETCH_ASSOC);


                            $get_content = "select * from medicine_category";
                            //echo $get_content;
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $result_content_medicine_category = $getJson->fetchAll(PDO::FETCH_ASSOC);

                            $get_content = "select * from medicine_unit";
                            //echo $get_content;
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $result_content_medicine_unit = $getJson->fetchAll(PDO::FETCH_ASSOC);

                            $get_content = "select * from medicine_type";
                            //echo $get_content;
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $result_content_medicine_type = $getJson->fetchAll(PDO::FETCH_ASSOC);

                            $get_content = "select * from medicine_manufacturer";
                            //echo $get_content;
                            $getJson = $conn->prepare($get_content);
                            $getJson->execute();
                            $result_content_medicine_manufacturer = $getJson->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="card-body">
                                <form class="form-horizontal form-material mb-0" id="medicine_form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="content" value="medicine">

                                    <div class="form-group row">

                                        <label for="medicine_name" class="col-md-2 text-right col-form-label">Medicine Name
                                            <i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <input type="text" name="medicine_name" class="form-control" id="medicine_name" placeholder="Medicine Name" required>
                                            </div>
                                        </div>
                                        <label for="medicine_generic_name" class="col-md-2 text-right col-form-label">Generic
                                            Name:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <input type="text" class="form-control" name="medicine_generic_name" id="medicine_generic_name" placeholder="Generic Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="medicine_leaf" class="col-md-2 text-right col-form-label">Box Size <i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <select name="medicine_leaf" class="form-control select2 required select2-hidden-accessible" id="medicine_leaf" required>
                                                    <option value="">Select Leaf Pattern</option>
                                                    <?php
                                                    foreach ($result_content_medicine_leaf as $data) {
                                                        echo '<option value="' . $data['medicine_leaf_id'] . '">' . $data['medicine_leaf_name'] . '*' . $data['medicine_leaf_total_per_box'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <label for="medicine_unit" class="col-md-2 text-right col-form-label">Unit <i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <select name="medicine_unit" id="medicine_unit" class="form-control select2 select2-hidden-accessible" required>
                                                    <option value="">Select Unit</option>
                                                    <?php
                                                    foreach ($result_content_medicine_unit as $data) {
                                                        echo '<option value="' . $data['medicine_unit_id'] . '">' . $data['medicine_unit_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="medicine_description" class="col-md-2 text-right col-form-label">Medicine
                                            Details:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <input type="text" name="medicine_description" class="form-control" id="medicine_description" placeholder="Medicine Details" value="">
                                            </div>
                                        </div>
                                        <!-- <label for="medicine_category" class="col-md-2 text-right col-form-label">Category<i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <select name="medicine_category" id="medicine_category" class="form-control select2 select2-hidden-accessible" required>
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    foreach ($result_content_medicine_category as $data) {
                                                        echo '<option value="' . $data['medicine_category_id'] . '">' . $data['medicine_category_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>

                                    <div class="form-group row">
                                        <!-- <label for="medicine_type" class="col-md-2 text-right col-form-label">Medicine
                                        Type<i class="text-danger"> * </i>:</label>
                                    <div class="col-md-4">
                                        <div class="">
                                            <select name="medicine_type"
                                                    class="form-control select2 select2-hidden-accessible" required>
                                                <option value="">Select Type</option>
                                                <?php
                                                foreach ($result_content_medicine_type as $data) {
                                                    echo '<option value="' . $data['medicine_type_id'] . '">' . $data['medicine_type_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div> -->
                                        <label for="medicine_manufacturer" class="col-md-2 text-right col-form-label">Manufacturer
                                            <i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <select name="medicine_manufacturer" id="medicine_manufacturer" class="form-control select2 select2-hidden-accessible" required>
                                                    <option value="">Select Manufacturer</option>
                                                    <?php
                                                    foreach ($result_content_medicine_manufacturer as $data) {
                                                        echo '<option value="' . $data['medicine_manufacturer_id'] . '">' . $data['medicine_manufacturer_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="form-group row">

                                        <label for="medicine_purchase_price" class="col-md-2 text-right col-form-label">Manufacturer
                                            Price(TP) <i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <input type="text" name="medicine_purchase_price" class="form-control valid_number" id="medicine_purchase_price" placeholder="Manufacturer Price" required>
                                            </div>
                                        </div>
                                        <label for="medicine_selling_price" class="col-md-2 text-right col-form-label">Selling Price(MRP)<i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <input class="form-control valid_number" id="medicine_selling_price" type="text" name="medicine_selling_price" placeholder="Price" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">

                                        <label for="medicine_status" class="col-md-2 text-right col-form-label">Status <i class="text-danger"> * </i>:</label>
                                        <div class="col-md-4">
                                            <div class="">
                                                <select name="medicine_status" id="medicine_status" class="form-control select2 select2-hidden-accessible" required>
                                                    <option value="">Select Status</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">In-Active</option>
                                                </select>
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
    </div>

    <div>

    </div>
    <?php include 'footer.php'
    ?>
</body>
<script>
    var spinner = $('#loader');
    $(document).ready(function() {


        $('form#medicine_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/create_medicine.php',
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
                        window.open("medicine_list.php", "_self");
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