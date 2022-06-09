<?php
require_once("../apis/Connection.php");
$connection = new Connection();

$conn = $connection->getConnection();

$get_content = "SELECT sum(pharmacy_purchase_grand_total) as grand_total,sum(pharmacy_purchase_due_amount)as due_amount, MONTHNAME(pharmacy_purchase_date) as monthName

FROM pharmacy_purchase GROUP BY EXTRACT(MONTH FROM pharmacy_purchase_date)";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);

$grand_total = array();
$monthName = array();
$due_amount = array();
for ($i = 0; $i < count($result_content); $i++) {
  array_push($grand_total, $result_content[$i]['grand_total']);
  array_push($monthName, $result_content[$i]['monthName']);
  array_push($due_amount, $result_content[$i]['due_amount']);
  // print_r($grand_total);

}

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
      <h3 class="widget-title">Medicine Purchase By Month</h3>
      <canvas id="myChart"></canvas>
    </div>

  </div>
  <div class="col-md-6">
    <div class="widget-area-2 proclinic-box-shadow">
      <h3 class="widget-title">Medicine Sell by Day</h3>
      <canvas id="myChart1"></canvas>
    </div>

  </div>
</div>


<script>
  var grand_total = <?php
                    echo json_encode($grand_total)
                    ?>;
  var monthName = <?php
                  echo json_encode($monthName)
                  ?>;
  var due_amount = <?php
                    echo json_encode($due_amount)
                    ?>;


  const data = {
    labels: monthName.slice(Math.max(monthName.length - 12, 0)),
    datasets: [{
        label: 'Grand Total',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: grand_total,
      },
      {
        label: 'Total Due',
        backgroundColor: 'blue',
        borderColor: 'blue',
        data: due_amount,
      }
    ]

  };

  const config = {
    type: 'bar',
    data: data,
    options: {}
  };
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
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

  const data1 = {
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

  const config1 = {
    type: 'line',
    data: data1,
    options: {}
  };
  const myChart1 = new Chart(
    document.getElementById('myChart1'),
    config1
  );
</script>