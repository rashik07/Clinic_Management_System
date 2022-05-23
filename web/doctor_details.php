<?php
// need to enable on production
require_once('check_if_outdoor_manager.php');
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
    <?php
    require_once("../apis/Connection.php");
    $connection = new Connection();
    $conn = $connection->getConnection();

    $doctor_id = $_GET['doctor_id'];
    $get_content = "select * from doctor where doctor_id='$doctor_id'";
    //echo $get_content;
    $getJson = $conn->prepare($get_content);
    $getJson->execute();
    $result_content_doctor = $getJson->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!-- Widget Item -->
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Doctor Details</h3>
            <div class="row no-mp">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="../<?php echo $result_content_doctor[0]['photo_url']; ?>" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $result_content_doctor[0]['doctor_name']; ?></h4>
                            <p class="card-text"><?php echo $result_content_doctor[0]['doctor_description']; ?></p>

                            <?php if ($_SESSION['user_type_access_level'] <= 2 ) { ?>
                            <a type="button" class="btn btn-success mb-3" href="edit_doctor.php?doctor_id=<?php echo $result_content_doctor[0]['doctor_id']; ?>"><span class="ti-pencil-alt"></span> Edit Doctor</a>
                            <?php } ?>
                            <a type="button" class="btn btn-success mb-3" href="../<?php echo $result_content_doctor[0]['document_url']; ?>"><span class="ti-pencil-alt"></span> View Document</a>
                            <?php if ($_SESSION['user_type_access_level'] <= 2 ) { ?>
                            <button type="button" class="btn btn-danger btn-lg" onclick="delete_data();">Delete</button>
                            <?php } ?>

                            <!--<a type="button" class="btn btn-danger mb-3"><span class="ti-trash"></span> Delete Patient</a>-->

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>Specialization</strong></td>
                                    <td><?php echo $result_content_doctor[0]['doctor_specialization']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Visit Fee</strong></td>
                                    <td><?php echo $result_content_doctor[0]['doctor_visit_fee']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Experience</strong></td>
                                    <td><?php echo $result_content_doctor[0]['doctor_experience']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Gender</strong></td>
                                    <td><?php echo $result_content_doctor[0]['doctor_gender']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td><?php echo $result_content_doctor[0]['doctor_address']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong> </td>
                                    <td><?php echo $result_content_doctor[0]['doctor_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Date Of Birth</strong> </td>
                                    <td><?php echo $result_content_doctor[0]['doctor_dob']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td><?php echo $result_content_doctor[0]['doctor_email']; ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <!-- <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Doctor Activity</h3>
            <div class="table-responsive"> -->
                <!-- <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Injury/Condition</th>
                            <th>Visit Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Viral fever</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                        <tr>
                            <td>Riya </td>
                            <td>Hand Fracture</td>
                            <td>12-10-2018</td>
                            <td>Small Operation</td>
                        </tr>
                        <tr>
                            <td>Paul</td>
                            <td>Dengue</td>
                            <td>15-10-2018</td>
                            <td>Admintted in Generalward</td>
                        </tr>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Malayria</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Viral fever</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                        <tr>
                            <td>Riya </td>
                            <td>Hand Fracture</td>
                            <td>12-10-2018</td>
                            <td>Small Operation</td>
                        </tr>
                        <tr>
                            <td>Paul</td>
                            <td>Dengue</td>
                            <td>15-10-2018</td>
                            <td>Admintted in Generalward</td>
                        </tr>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Malayria</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                    </tbody>
                </table> -->

                <!--Export links-->
                <!-- <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center export-pagination">
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-download"></span> csv</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-printer"></span> print</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-file"></span> PDF</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-align-justify"></span> Excel</a>
                        </li>
                    </ul>
                </nav> -->
                <!-- /Export links-->
            <!-- </div>
        </div>
    </div> -->
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
    function delete_data()
    {
        var data_id = <?php echo $doctor_id; ?>;
        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_doctor.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    doctor_id: data_id,
                    content: "doctor"
                },
                success: function (response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("doctors_list.php","_self");
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