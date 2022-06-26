<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php include 'header.php';

// require_once __DIR__ . '/related_func.php';
?>
<?php
function numberTowords($num)
{

    $ones = array(
        0 => "Zero",
        1 => "One",
        2 => "Two",
        3 => "Three",
        4 => "Four",
        5 => "Five",
        6 => "Six",
        7 => "Seven",
        8 => "Eight",
        9 => "Nine",
        10 => "Ten",
        11 => "Eleven",
        12 => "Twelve",
        13 => "Thirteen",
        14 => "Fourteen",
        15 => "Fifteen",
        16 => "Sixteen",
        17 => "Seventeen",
        18 => "Eightteen",
        19 => "Nineteen",
        "014" => "Fourteen"
    );
    $tens = array(
        0 => "Zero",
        1 => "Ten",
        2 => "Twenty",
        3 => "Thirty",
        4 => "Forty",
        5 => "Fifty",
        6 => "Sixty",
        7 => "Seventy",
        8 => "Eighty",
        9 => "Ninety"
    );
    $hundreds = array(
        "Hundred",
        "Thousand",
        "Million",
        "Billion",
        "Trillion",
        "Quardilion",
    ); /*limit t quadrillion */
    $num = number_format($num, 2, ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr, 1);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {

        while (substr($i, 0, 1) == "0")
            $i = substr($i, 1, 5);
        if ($i < 20) {
            // echo "getting:" . $i;
            if ($i != "") {
                $rettxt .= $ones[$i];
            }
        } elseif ($i < 100) {
            if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
            if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
        } else {
            if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
            if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
            if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
        }
        if ($key > 0) {
            $rettxt .= " " . $hundreds[$key] . " ";
        }
    }
    if ($decnum > 0) {
        $rettxt .= " and ";
        if ($decnum < 20) {
            $rettxt .= $ones[$decnum];
        } elseif ($decnum < 100) {
            $rettxt .= $tens[substr($decnum, 0, 1)];
            $rettxt .= " " . $ones[substr($decnum, 1, 1)];
        }
    }
    return $rettxt . " Taka Only";
}
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
                                <div class="row mt-1">
                                    <div class="col-12 col-lg-10 offset-lg-1">
                                        <div class="row">
                                            <div class="col-12  justify-content-center">
                                                <div class="float-left">
                                                    <img class="center" src="../assets/images/logo.png" style="height: 60px; display: block; margin-left: auto; margin-right: auto;" alt="logo" class="logo-default">
                                                </div>

                                                <div class=" text-center ">
                                                    <p class="text-600" style="font-size: 18px; margin:0px; padding:0px;">MOMTAJ TRAUMA CENTER</p>
                                                    <p style="font-size: 14px; margin:0px; padding:0px;">House #56, Road #03, Dhaka Real State, Kaderabad housing,Mohammadpur, Dhaka-1207</p>
                                                    <p style="font-size: 14px; margin:0px; padding:0px;">For Serial: +88 01844080671 , +88 028101496, +88 01844 080 675, +88 01844 080 676</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- .row -->

                                        <!-- <hr class="row brc-default-l1 mx-n1 mb-1" /> -->
                                        <?php
                                        require_once("../apis/Connection.php");
                                        require_once("../apis/related_func.php");
                                        $connection = new Connection();
                                        $conn = $connection->getConnection();



                                        $indoor_treatment_payment_id  = $_GET['indoor_treatment_payment_id'];




                                        $get_content_receipt = "select * from indoor_treatment_payment left join indoor_treatment on indoor_treatment.indoor_treatment_id = indoor_treatment_payment.indoor_treatment_payment_treatment_id 
                                        left join patient p on p.patient_id = indoor_treatment.indoor_treatment_patient_id  left join indoor_treatment_doctor itd on itd.indoor_treatment_doctor_treatment_id=indoor_treatment.indoor_treatment_id 
                                        left join doctor d on d.doctor_id = itd.indoor_treatment_doctor_doctor_id
                                        where indoor_treatment_payment_id = '$indoor_treatment_payment_id'";
                                        // echo $get_content_receipt;
                                        $getJson = $conn->prepare($get_content_receipt);
                                        $getJson->execute();
                                        $result_get_content_receipt = $getJson->fetchAll(PDO::FETCH_ASSOC);

                                        $user_id = $result_get_content_receipt[0]['indoor_treatment_user_added_id'];
                                        $get_content_user = "select * from user where user_id = '$user_id'";
                                        //echo $get_content;
                                        $getJson = $conn->prepare($get_content_user);
                                        $getJson->execute();
                                        $result_content_user = $getJson->fetchAll(PDO::FETCH_ASSOC);


                                        ?>
                                        <div class="text-center" style=" margin: 20px;">

                                            <span class="text-600" style="float: left;">No: <?php echo  $result_get_content_receipt[0]['indoor_treatment_payment_id'] ?></span>
                                            <div class="text-center">
                                                <h4 style="border: 1px solid black;padding: 7px;display: inline;">MONEY RECEIPT</h4>
                                            </div>

                                        </div>
                                        <div class="money-receipt-font text-600" style=" margin: 20px 20px 0px 20px;">
                                            <p>Received with thanks from Mr/Mrs <span style="padding-left: 15px;padding-right: 40px; border-bottom: 1px dotted black"><?php echo $result_get_content_receipt[0]['patient_name']; ?></span><span class=" text-right" style="float: right;margin-right: -10px;">Date: <?php echo $result_get_content_receipt[0]['indoor_treatment_payment_creation_time']; ?></span>
                                            </p>
                                        </div>
                                        <table class="text-center money-receipt-font money_receipt-table" style="width: 100%;margin: 0px 20px 20px 20px;">
                                            <tr>
                                                <th colspan="2" style="height: 50px;">Details</td>
                                                <th>Amount</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="height: 150px;"><?php echo $result_get_content_receipt[0]['indoor_treatment_payment_details']; ?></td>
                                                <td><?php echo $result_get_content_receipt[0]['indoor_treatment_payment_amount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" style="border: 0px;width: 50%"></td>
                                                <th style="height: 50px;">Total</td>
                                                <th><?php echo $result_get_content_receipt[0]['indoor_treatment_payment_amount']; ?></th>
                                            </tr>
                                            <tr class="text-left">

                                                <td colspan="3">In Words : <?php echo numberTowords($result_get_content_receipt[0]['indoor_treatment_payment_amount']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p style="height: 50px;"></p>
                                                    <p>Payment By</p>
                                                </th>
                                                <th colspan="2">
                                                    <p style="height: 50px;"></p>
                                                    <p>Received By</p>
                                                </th>
                                            </tr>
                                        </table>

                                        <span class="text-right" style="float: right;">Prepared By: <?php echo $result_content_user[0]['username']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Widget Item -->
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