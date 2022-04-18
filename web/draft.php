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
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="indoor_Allotment multiCollapseExample2">Close all</button>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-6">
                                        <label for="pharmacy_sell_date">Start Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Selling Date" class="form-control" id="min" name="min">
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group col-md-6">
                                        <label for="pharmacy_sell_date">End Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Selling Date" class="form-control" id="max" name="max">
                                    </div>
                                </div>
                            </div>
                            <!-- <table class="Report_table" style="width: 100%;">
                                <thead>
                                    <tr>

                                        <td style="width: 40%;">Details</td>
                                        <td>QTY</td>
                                        <td>Per Unit</td>
                                        <td>Issue Date</td>
                                        <td>Bill</td>
                                        <td>Discount</td>
                                        <td>Payment</td>
                                        <td>Due</td>
                                        <td>Total</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    // $indoor_treatment_id = $_GET['indoor_treatment_id'];
                                    $get_content = "select * from pharmacy_sell";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $pharmacy_sells = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    // print_r($pharmacy_sells);
                                    if (count($pharmacy_sells) > 0) {
                                        foreach ($pharmacy_sells as $pharmacy_sell) {
                                            // $last_bed_name = $bed['indoor_bed_name'];
                                            if ($pharmacy_sell['pharmacy_sell_discount'] == "") {
                                                $pharmacy_sell['pharmacy_sell_discount'] = 0;
                                            }
                                            echo '
                                    <tr class="main_row">
                                        <td> 
                                        <a class="" data-toggle="collapse" href="#pharmacy_sell" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Medicine</a>
                                        <div class="collapse multi-collapse" id="pharmacy_sell">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_creation_time'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_sub_total'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_discount'] . '%</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_paid_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_due_amount'] . '</td>
                                        <td>' . $pharmacy_sell['pharmacy_sell_grand_total'] . '</td>
                                        <td><a href="edit_medicine_sell.php?medicine_sell_id=' . $pharmacy_sell['pharmacy_sell_id'] . '">Update</a></td>
                                    </tr>';
                                        }
                                    } ?>
                                </tbody>
                            </table> -->

                            <table id="datatable1" class="table nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <td style="width: 40%;">Details</td>
                                        <td>QTY</td>
                                        <td>Per Unit</td>
                                        <td>Issue Date</td>
                                        <td>Bill</td>
                                        <td>Discount</td>
                                        <td>Payment</td>
                                        <td>Due</td>
                                        <td>Total</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once("../apis/Connection.php");
                                    $connection = new Connection();
                                    $conn = $connection->getConnection();
                                    $get_content = "select * from pharmacy_sell";
                                    $getJson = $conn->prepare($get_content);
                                    $getJson->execute();
                                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                                    $body = '';
                                    $count = 1;
                                    foreach ($result_content as $data) {

                                        // $relaseDate = $data['release_date'] ? date_format(date_create($data['release_date']), "d/m/Y") : '<span class="text-danger">Not Released</span>';
                                        $sell_Date = date("m-d-Y", strtotime($data['pharmacy_sell_creation_time']));

                                        echo '<tr>';
                                        echo '<td> 
                                        <a class="" data-toggle="collapse" href="#pharmacy_sell" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Medicine</a>
                                        <div class="collapse multi-collapse" id="pharmacy_sell">
                                            <div class="card card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                            </div>
                                        </div>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>' . $sell_Date . '</td>
                                        <td>' . $data['pharmacy_sell_sub_total'] . '</td>
                                        <td>' . $data['pharmacy_sell_discount'] . '%</td>
                                        <td>' . $data['pharmacy_sell_paid_amount'] . '</td>
                                        <td>' . $data['pharmacy_sell_due_amount'] . '</td>
                                        <td>' . $data['pharmacy_sell_grand_total'] . '</td>
                                        <td><a href="edit_medicine_sell.php?medicine_sell_id=' . $data['pharmacy_sell_id'] . '">Update</a></td>';
                                        echo '</tr>';
                                        $count = $count + 1;
                                    }
                                    ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
            <div>





            </div>
            <?php include 'footer.php'
            ?>
</body>


</html>


<script>
    var minDate, maxDate;
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = new Date(minDate.val()).toLocaleDateString('en-CA');;
            var max = new Date(maxDate.val()).toLocaleDateString('en-CA');;
            var date = new Date(data[3]).toLocaleDateString('en-CA'); // use data for the admission_date column
            console.log(min);
            console.log(max);
            console.log(date);
            if (
                (!isValidDate(min) && !isValidDate(max)) ||
                (!isValidDate(min) && date <= max) ||
                (min <= date && !isValidDate(max)) ||

                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||

                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );
    $(document).ready(function() {
        // // // Create date inputs
        // minDate = new DateTime($('#min'), {
        //     format: 'MMMM Do YYYY'
        // });
        // maxDate = new DateTime($('#max'), {
        //     format: 'MMMM Do YYYY'
        // });

        minDate = $('#min');
        maxDate = $('#max');
        // DataTables initialisation
        var table = $('#datatable1').dataTable({
            "aaSorting": []
        });
        // Refilter the table
        $('#min, #max').on('change', function() {
            console.log("redraw");
            table.fnDraw();
        });
    });

    function isValidDate(dateObject) {
        return new Date(dateObject).toString() !== 'Invalid Date';
    }
</script>