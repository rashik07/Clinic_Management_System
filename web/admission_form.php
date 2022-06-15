<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php include 'header.php';

// require_once __DIR__ . '/related_func.php';
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

            <div id="print_bill">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Widget Item -->
                        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
                        <link href="../assets/css/invoice.css" rel="stylesheet">

                        <div class="page-content container">

                            <div class="container px-0">
                                <div class="row mt-1" style="margin:-24px">
                                    <div class="col-12 col-lg-10 offset-lg-1">
                                        <div class="row">
                                            <div class="col-12  justify-content-center">
                                                <div class="float-left">
                                                    <img class="center" src="../assets/images/logo.png" style="height: 60px; display: block; margin-left: auto; margin-right: auto;" alt="logo" class="logo-default">
                                                </div>

                                                <div class=" text-center text-600">
                                                    <p style="font-size: 18px; margin:0px; padding:0px;">MOMTAJ TRAUMA CENTER</p>
                                                    <p style="font-size: 14px; margin:0px; padding:0px;">House #56, Road #03, Dhaka Real State, Kaderabad housing,Mohammadpur, Dhaka-1207</p>
                                                    <p style="font-size: 14px; margin:0px; padding:0px;">For Serial: +88 01844080671 , +88 028101496, +88 01844 080 675, +88 01844 080 676</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="row brc-default-l1 mx-n1 mb-1 m-4" />
                                        <!-- .row -->




                                        <?php
                                        require_once("../apis/Connection.php");
                                        require_once("../apis/related_func.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();



                                        $treatment_id  = $_GET['indoor_treatment_id'];




                                        $get_content_user = "select * from indoor_treatment  left join patient p on p.patient_id = indoor_treatment.indoor_treatment_patient_id  left join indoor_treatment_doctor itd on itd.indoor_treatment_doctor_treatment_id=indoor_treatment.indoor_treatment_id 
                                        where indoor_treatment_id = '$treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_outdoor_treatment = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                        // var_dump( $result_content_outdoor_treatment);
                                        $indoor_treatment_consultant = $result_content_outdoor_treatment[0]['indoor_treatment_doctor_doctor_id'];
                                        // $indoor_patient_bed_bed_id = $result_content_outdoor_treatment[0]['indoor_treatment_bed_id'];

                                        $get_content_user = "select * from indoor_treatment  left join patient p on p.patient_id = indoor_treatment.indoor_treatment_patient_id left join indoor_treatment_bed itb on itb.indoor_treatment_bed_treatment_id = indoor_treatment.indoor_treatment_id left join indoor_bed on indoor_bed.indoor_bed_id = itb.indoor_treatment_bed_bed_id
                                        where indoor_treatment_id = '$treatment_id'";
                                        // echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_outdoor_treatment_bed = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $invoice_no = if_empty(
                                            $result_content_outdoor_treatment[0]['indoor_treatment_id']
                                        );
                                        $patient_id = $result_content_outdoor_treatment[0]['patient_id'];
                                        $patient_name = $result_content_outdoor_treatment[0]['patient_name'];


                                        $get_content = "select * from doctor where doctor_id = '$indoor_treatment_consultant'";
                                        $getJson = $conn->prepare($get_content);
                                        $getJson->execute();
                                        $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $doctor_name = if_empty($result_content[0]['doctor_name']);
                                        $doctor_experience = if_empty($result_content[0]['doctor_experience']);
                                        $user_id = $result_content_outdoor_treatment[0]['indoor_treatment_user_added_id'];
                                        $get_content_user = "select * from user where user_id = '$user_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_user = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        ?>

                                        <div class="text-center m-4" style="margin-top: 20px;">
                                            <div class="text-center">
                                                <h4 style="border: 1px solid black;border-radius: 10px;padding: 7px;display: inline;">Admission Form</h4>
                                            </div>
                                        </div>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="highlight" style="width: 10%;">ID NO:</td>
                                                <td class="gray"><?php echo  $result_content_outdoor_treatment[0]["indoor_treatment_admission_id"] ?></td>
                                            </tr>
                                        </table>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="" style="width: 20%;">Cabin/Ward No:</td>
                                                <td class="gray" style="width: 20%;"><?php echo  $result_content_outdoor_treatment_bed[0]['indoor_treatment_bed_category_name'] ?> ( <?php echo  $result_content_outdoor_treatment_bed[0]['indoor_bed_name'] ?> )</td>
                                                <td style="width: 20%;">Admission Date:</td>
                                                <td class="gray" style="width: 40%;"> <?php echo  $result_content_outdoor_treatment[0]["indoor_treatment_creation_time"] ?></td>
                                            </tr>
                                        </table>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="" style="width: 20%;">Consultant Name :</td>
                                                <td class="gray"><?php echo $doctor_name ?> (
                                                    <span class="text-300 text-110  align-middle"><?php echo $doctor_experience ?></span>)
                                                </td>
                                            </tr>
                                        </table>


                                        <div class="text-center m-4">
                                            <div class="text-center">
                                                <h4 style="border: 1px solid black;border-radius: 10px;padding: 7px;display: inline;">Patient Details</h4>
                                            </div>
                                        </div>

                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="" style="width: 20%;">Patient Name :</td>
                                                <td class="" style="width: 65%;"><?php echo $patient_name ?>
                                                </td>
                                                <td class="gray" style="width: 8%;">Age :</td>
                                                <td class="gray" style="width: 7%;"><?php echo $result_content_outdoor_treatment[0]['patient_age'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" style="width: 20%;">Father/Mother Name :</td>
                                                <td class="" style="width: 65%;"><?php echo $result_content_outdoor_treatment[0]['patient_name'] ?>
                                                </td>
                                                <td class="" style="width: 8%;">Sex :</td>
                                                <td class="" style="width: 7%;"><?php echo $result_content_outdoor_treatment[0]['patient_gender'] ?>
                                                </td>
                                            </tr>

                                        </table>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="" style="width: 20%;">Eamil :</td>
                                                <td class="" style="width: 30%;"><?php echo $result_content_outdoor_treatment[0]['patient_email'] ?>
                                                </td>
                                                <td class="gray" style="width: 20%;">National ID :</td>
                                                <td class="" style="width: 30%;"><?php echo $result_content_outdoor_treatment[0]['patient_national_ID'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" style="width: 20%;">Contact No :</td>
                                                <td class="" style="width: 30%;"><?php echo $result_content_outdoor_treatment[0]['patient_phone'] ?>
                                                </td>
                                                <td class="" style="width: 20%;">Blood Group :</td>
                                                <td class="" style="width: 30%;"><?php echo $result_content_outdoor_treatment[0]['patient_blood_group'] ?>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="" style="width: 20%;">Symtomps :</td>
                                                <td class="" style="width: 80%;"><?php echo $result_content_outdoor_treatment[0]['patient_description'] ?>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="" style="width: 20%;">Present Address :</td>
                                                <td class="" style="width: 80%;"><?php echo $result_content_outdoor_treatment[0]['patient_address'] ?>
                                                </td>

                                            </tr>
                                        </table>

                                        <div class="text-center m-4">
                                            <div class="text-center">
                                                <h4 style="border: 1px solid black;border-radius: 10px;padding: 7px;display: inline;">Emergency Contact Person</h4>
                                            </div>
                                        </div>

                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="gray" style="width: 20%;">Name :</td>
                                                <td class="gray" style="width: 80%;"><?php echo $result_content_outdoor_treatment[0]['patient_emergency_name'] ?>
                                                </td>

                                            </tr>
                                        </table>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="gray" style="width: 20%;">Relation With Patient :</td>
                                                <td class="gray" style="width: 30%;"><?php echo $result_content_outdoor_treatment[0]['patient_emergency_relation'] ?>
                                                </td>
                                                <td class="gray" style="width: 20%;">Contact No :</td>
                                                <td class="gray" style="width: 30%;"><?php echo $result_content_outdoor_treatment[0]['patient_emergency_contact'] ?>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="admission-table admission-font mb-2">
                                            <tr>
                                                <td class="gray" style="width: 20%;"> Address :</td>
                                                <td class="gray" style="width: 80%;"><?php echo $result_content_outdoor_treatment[0]['patient_emergency_address'] ?>
                                                </td>

                                            </tr>
                                        </table>








                                        <!-- <hr /> -->

                                        <div class="d-flex justify-content-between">


                                            <div>
                                                <span class="text-600 text-black-m2 align-middle">Prepared By: <?php echo $result_content_user[0]['username']; ?></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- /Widget Item -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-header  text-blue-d2">
                <div class="page-tools">
                    <div class="action-buttons">
                        <button class="btn btn-primary mx-1px text-95" onclick="print_div();">
                            <i class="mr-1 fa fa-print text-white-m1 text-120 w-2"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>




            <?php include 'footer.php'
            ?>
</body>
<script>
    function print_div() {

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head>');
        mywindow.document.write("<link href=\"../assets/css/invoice.css\" rel=\"stylesheet\">");
        mywindow.document.write("<link href=\"../assets/css/custom.css\" rel=\"stylesheet\">");
        mywindow.document.write("<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">");
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('print_bill').innerHTML);
        mywindow.document.write('</body></html>');
        console.log(mywindow.document);
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 1000)
        return true;
    }
</script>

</html>