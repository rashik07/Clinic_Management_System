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
                    <!-- Widget Item -->
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Patient Treatment List</h3>
                            <div class="table-responsive mb-3">
                                <table id="datatable1" class="table  " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <!-- <th>#</th> -->
                                            <th>Invoice No</th>
                                            <th>Patient Name</th>
                                            <th>Services</th>
                                            <th>Total Bill</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <?php if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo "<th>Edit</th>";
                                            }

                                            ?>
                                            <th>Collection</th>
                                            <th>Invoice</th>
                                            <?php if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo "<th>Delete</th>";
                                            }

                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../apis/Connection.php");
                                        $connection = new Connection();

                                        $conn = $connection->getConnection();

                                        $get_content = "select * from  outdoor_treatment
                                        inner join patient on outdoor_treatment.outdoor_treatment_patient_id = patient.patient_id where outdoor_treatment_indoor_treatment_id IS  NULL ORDER BY outdoor_treatment_id DESC";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();

                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        $body = '';
                                        $count = 1;
                                        foreach ($result_content as $data) {
                                            echo '<tr>';
                                            // echo '<td>' . $count . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_id'] . '</td>';
                                            echo '<td>' . $data['patient_name'] . '</td>';

                                            $treatment_id = $data['outdoor_treatment_id'];

                                            $get_content = "select * from outdoor_treatment_service 
                                    left join outdoor_service os on os.outdoor_service_id = outdoor_treatment_service.outdoor_treatment_service_service_id 
                                    where outdoor_treatment_service_treatment_id = '$treatment_id'";
                                            $getJson = $conn->prepare($get_content);
                                            $getJson->execute();
                                            $result_content_services = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                            $service_list = array();

                                            foreach ($result_content_services as $services) {
                                                array_push($service_list, $services['outdoor_service_name']);
                                            }
                                            $services_names = implode(', ', $service_list);

                                            echo '<td>' . $services_names . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_bill_after_discount'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_paid'] . '</td>';
                                            echo '<td>' . $data['outdoor_treatment_total_due'] . '</td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<td><a href="edit_patient_treatment.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '"><i class="ti ti-settings" style="font-size:24px"></i></a></td>';
                                            }
                                            if ($data['outdoor_treatment_total_due'] > 0) {
                                                echo '<td><a href="edit_patient_treatment_due.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '">Collection</a></td>';
                                            } else {
                                                echo '<td> - </td>';
                                            }

                                            echo '<td><a href="doctor_visit_invoice.php?outdoor_treatment_id=' . $data['outdoor_treatment_id'] . '"><i class="ti ti-save" style="font-size:24px"></i></a></td>';
                                            if ($_SESSION['user_type_access_level'] <= 2) {
                                                echo '<td> <button type="button" class="btn btn-danger mb-3" onclick="delete_data(' . $treatment_id . ');">Delete</button></td>';
                                            }

                                            $count = $count + 1;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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

    function delete_data(treatment_id) {
        // var data_id = <?php echo $treatment_id; ?>;

        if (confirm('Are you sure you want to Delete This Content?')) {
            // yes
            spinner.show();
            $.ajax({
                type: 'POST',
                url: '../apis/delete_treatment_list.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                    token: "<?php echo $_SESSION['token']; ?>",
                    treatment_id: treatment_id,
                    content: "outdoor_treatment"
                },
                success: function(response) {
                    //alert(response);
                    spinner.hide();
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        window.open("patient_treatment_list.php", "_self");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    spinner.hide();
                    alert("alert : " + errorThrown);
                }
            });
        } else {
            // Do nothing!
            console.log('Said No');
        }
    }

    $('#datatable1').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); //replace id with your first table's id
</script>

</html>