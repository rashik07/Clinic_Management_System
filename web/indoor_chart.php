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



$get_content = "SELECT sum(outdoor_treatment_total_bill_after_discount) as total_bill_after_discount,sum(outdoor_treatment_total_paid) as outdoor_treatment_total_paid ,sum(outdoor_treatment_total_due) as outdoor_treatment_total_due FROM `outdoor_treatment` WHERE outdoor_treatment_indoor_treatment_id is not null";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content_sell = $getJson->fetchAll(PDO::FETCH_ASSOC);

$get_content = "SELECT sum(indoor_treatment_total_bill_after_discount) as total_bill_after_discount,sum(indoor_treatment_total_paid) as indoor_treatment_total_paid ,sum(indoor_treatment_total_due) as indoor_treatment_total_due FROM `indoor_treatment` ";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content_indoor = $getJson->fetchAll(PDO::FETCH_ASSOC);

$indoor_bill_chart = array();


array_push($indoor_bill_chart, $result_content_sell[0]['total_bill_after_discount'] + $result_content_indoor[0]['total_bill_after_discount'], $result_content_sell[0]['outdoor_treatment_total_paid'] + $result_content_indoor[0]['indoor_treatment_total_paid'], $result_content_sell[0]['outdoor_treatment_total_due'] + $result_content_indoor[0]['indoor_treatment_total_due']);


?>

<div class="row mt-5">
    <div class="col-md-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Outdoor Billing Chart</h3>
            <canvas id="myChart2"  height="400"></canvas>
        </div>

    </div>
    <div class="col-md-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Indoor Billing Chart</h3>
            <canvas id="myChart3"></canvas>
        </div>

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
       
        options: {
            radius: "100%",
            
    
        
        }
    };
    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );


    var indoor_bill_chart = <?php
                            echo json_encode($indoor_bill_chart)
                            ?>;


    const data3 = {
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
                data: indoor_bill_chart,
            },

        ]

    };

    const config3 = {
        type: 'doughnut',
        data: data3,
        options: {}
    };
    const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );
</script>