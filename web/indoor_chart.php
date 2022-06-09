<?php
require_once("../apis/Connection.php");
$connection = new Connection();

$conn = $connection->getConnection();

$get_content = "SELECT sum(outdoor_treatment_total_bill_after_discount) as total_bill_after_discount,sum(outdoor_treatment_total_paid) as outdoor_treatment_total_paid ,sum(outdoor_treatment_total_due) as outdoor_treatment_total_due FROM `outdoor_treatment` WHERE outdoor_treatment_indoor_treatment_id is null";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);

$outdoor_bill_chart = array();


array_push($outdoor_bill_chart, $result_content[0]['total_bill_after_discount'], $result_content[0]['outdoor_treatment_total_paid'], $result_content[0]['outdoor_treatment_total_due']);

// print_r($grand_total);



$get_content = "SELECT sum(pharmacy_sell_grand_total)as sell_grand_total, DAY(pharmacy_sell_date) as sell_monthName,sum(pharmacy_sell_due_amount) as sell_due_amount


FROM pharmacy_sell GROUP BY DAY(pharmacy_sell_date)";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content_sell = $getJson->fetchAll(PDO::FETCH_ASSOC);

$sell_grand_total = array();
$sell_monthName = array();
$sell_due_amount = array();
for ($i = 0; $i < count($result_content_sell); $i++) {
    array_push($sell_grand_total, $result_content_sell[$i]['sell_grand_total']);
    array_push($sell_monthName, $result_content_sell[$i]['sell_monthName']);
    array_push($sell_due_amount, $result_content_sell[$i]['sell_due_amount']);
    // print_r($grand_total);

}



?>

<div class="row mt-5">
    <div class="col-md-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Outdoor Billing Chart</h3>
            <canvas id="myChart2"></canvas>
        </div>

    </div>
    <div class="col-md-6">
        <!-- <div class="widget-area-2 proclinic-box-shadow">
      <h3 class="widget-title">Medicine Sell by Day</h3>
      <canvas id="myChart3"></canvas>
    </div> -->

    </div>
</div>


<script>
    var outdoor_bill_chart = <?php echo json_encode($outdoor_bill_chart) ?>;



    const data2 = {
        labels: ['Total Bill', 'Total Paid', 'Total Due'],
        datasets: [{
                label: 'Grand Total',
                backgroundColor: [
                    'blue',
                    '#3CB371',
                    'rgb(255, 99, 132)'
                ],
                borderColor: [
                    'blue',
                    '#3CB371',
                    'rgb(255, 99, 132)'
                ],
                data: outdoor_bill_chart,
            },

        ]

    };

    const config2 = {
        type: 'doughnut',
        data: data2,
        options: {}
    };
    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );


    var sell_grand_total = <?php
                            echo json_encode($sell_grand_total)
                            ?>;
    var sell_monthName = <?php
                            echo json_encode($sell_monthName)
                            ?>;
    var sell_due_amount = <?php
                            echo json_encode($sell_due_amount)
                            ?>;

    const data3 = {
        labels: sell_monthName.slice(Math.max(sell_monthName.length - 20, 0)),
        datasets: [{
                label: 'Grand Total',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: sell_grand_total,
            },
            {
                label: 'Total Due',
                backgroundColor: 'blue',
                borderColor: 'blue',
                data: sell_due_amount,
            }
        ]

    };

    const config3 = {
        type: 'line',
        data: data3,
        options: {}
    };
    const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );
</script>