<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';

$connection = new Connection();

$conn = $connection->getConnection();

$get_content = "SELECT sum(pharmacy_purchase_grand_total),MONTHNAME(pharmacy_purchase_date)


FROM pharmacy_purchase GROUP BY EXTRACT(MONTH FROM pharmacy_purchase_date)";
$getJson = $conn->prepare($get_content);
$getJson->execute();

$result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);

      
