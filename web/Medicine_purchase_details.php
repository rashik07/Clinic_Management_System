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
            <div class="container-fluid">

                <div class="row">
                    <!-- Widget Item -->
                    <?php
                    require_once("../apis/Connection.php");
                    $connection = new Connection();
                    $conn = $connection->getConnection();

                    $medicine_purchase_id = $_GET['medicine_purchase_id'];

                    $get_content = "select * from medicine_manufacturer";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine_manufacturer = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select *,
       (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id) as total_quantity  
from medicine
         
      
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
            left join pharmacy_medicine pm on medicine.medicine_id = pm.pharmacy_medicine_medicine_id";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select *, DATE (pharmacy_purchase_date) as pharmacy_purchase_date from pharmacy_purchase
                left join medicine_manufacturer mm on mm.medicine_manufacturer_id = pharmacy_purchase.pharmacy_purchase_manufacturer_id
                where pharmacy_purchase_id='$medicine_purchase_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_medicine_purchase = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    $get_content = "select *, DATE(pharmacy_medicine_exp_date) as pharmacy_medicine_exp_date,
       (SELECT  SUM(pharmacy_medicine.pharmacy_medicine_quantity) from pharmacy_medicine WHERE pharmacy_medicine.pharmacy_medicine_medicine_id=pm.pharmacy_medicine_medicine_id  and pharmacy_medicine.pharmacy_medicine_batch_id=pm.pharmacy_medicine_batch_id) as total_quantity  
from pharmacy_purchase_medicine
                left join pharmacy_medicine pm on pm.pharmacy_medicine_id = pharmacy_purchase_medicine.pharmacy_purchase_medicine_medicine_id
                left join medicine m on m.medicine_id = pm.pharmacy_medicine_medicine_id
                where pharmacy_purchase_medicine_purchase_id='$medicine_purchase_id'";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_pharmacy_medicine_purchase = $getJson->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="col-md-12">
                        <div class="widget-area-2 proclinic-box-shadow">
                            <h3 class="widget-title">Medicine Purchase</h3>
                            <form class="form-horizontal form-material mb-0" id="medicine_purchase_update_form" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <input type="hidden" name="request_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="medicine_purchase_id" value="<?php echo $medicine_purchase_id; ?>">
                                    <input type="hidden" name="content" value="pharmacy_medicine_purchase">

                                    <div class="form-group col-md-6">
                                        <label for="pharmacy_purchase_manufacturer_id">Manufacturer<i class="text-danger"> * </i></label>
                                        <select id="select-manufacturer" name="pharmacy_purchase_manufacturer_id" placeholder="Pick a Manufacturer..." onchange="changeManufacturer();" required >
                                            <option value="">Select a manufacturer...</option>
                                            <?php

                                            foreach ($result_content_medicine_manufacturer as $data) {
                                                if ($result_content_medicine_purchase[0]['medicine_manufacturer_id'] == $data['medicine_manufacturer_id']) {
                                                    echo '<option selected value="' . $data['medicine_manufacturer_id'] . '" readonly>' . $data['medicine_manufacturer_name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $data['medicine_manufacturer_id'] . '" readonly>' . $data['medicine_manufacturer_name'] . '</option>';
                                                }
                                            }


                                            ?>

                                        </select>
                                    </div>
                                    <!-- <datalist id="manufacturer_medicines"></datalist> -->

                                    <div class="form-group col-md-6">
                                        <label for="pharmacy_purchase_invoice_no">Invoice No<i class="text-danger"> * </i></label>
                                        <input type="text" placeholder="Invoice No." class="form-control" id="pharmacy_purchase_invoice_no" name="pharmacy_purchase_invoice_no" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_invoice_no']; ?>" required readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pharmacy_purchase_date">Purchase Date<i class="text-danger"> * </i></label>
                                        <input type="date" placeholder="Purchase Date" class="form-control" id="pharmacy_purchase_date" name="pharmacy_purchase_date" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_date']; ?>" required readonly>
                                    </div>
                                    <datalist id="manufacturer_medicines"></datalist>
                                    <table id="datatable1" class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Medicine<i class="text-danger"> * </i></th>
                                                <th>Batch ID<i class="text-danger"> * </i></th>
                                                <th>Exp. Date<i class="text-danger"> * </i></th>
                                                <th>Stock Qty</th>

                                                <th>Pieces</th>
                                                <th>Manufacture Price</th>
                                                <th>Box Mrp</th>
                                                <th>Total Purchase Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datatable1_body">

                                        </tbody>
                                        <tfoot id="datatable1_foot">
                                            <tr>
                                                <td class="text-right" colspan="7"><b>Sub Total:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="pharmacy_purchase_sub_total" class="text-right form-control" name="pharmacy_purchase_sub_total" placeholder="0.00" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_sub_total']; ?>" readonly="">
                                                </td>
                                             
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="7"><b>Vat:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="pharmacy_purchase_vat" onchange="total_calculation_update();" class="text-right form-control" name="pharmacy_purchase_vat" placeholder="0.00" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_vat']; ?>" tabindex="15" readonly="readonly">
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="7"><b>Discount:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="pharmacy_purchase_discount" onchange="total_calculation_update();" class="text-right form-control" name="pharmacy_purchase_discount" placeholder="0.00" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_discount']; ?>" tabindex="16" readonly="readonly">
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="7"><b>Grand Total:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="pharmacy_purchase_grand_total" class="text-right form-control" name="pharmacy_purchase_grand_total" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_grand_total']; ?>" readonly="readonly">
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="7"><b>Paid Amount<i class="text-danger"> * </i>:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="pharmacy_purchase_paid_amount" onchange="total_calculation_update();" class="text-right form-control" name="pharmacy_purchase_paid_amount" placeholder="0.00" required value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_paid_amount']; ?>" tabindex="18" readonly>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="7"><b>Due Amount:</b></td>
                                                <td class="text-right">
                                                    <input type="text" id="pharmacy_purchase_due_amount" class="text-right form-control" name="pharmacy_purchase_due_amount" placeholder="0.00" value="<?php echo $result_content_medicine_purchase[0]['pharmacy_purchase_due_amount']; ?>" readonly="readonly">
                                                </td>
                                                <td>
                                                </td>
                                            </tr>

                                        </tfoot>


                                    </table>

                                    <div class="form-group col-md-6 mb-3">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                    </div>
                            </form>
                            <div id="loader"></div>
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
    initRowTable();
    $(document).ready(function() {
        changeManufacturer();

        $('form#medicine_purchase_update_form').on('submit', function(event) {
            event.preventDefault();
            spinner.show();
            var formData = new FormData(this);

            $.ajax({
                url: '../apis/update_pharmacy_medicine_purchase.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    //alert(data);
                    console.log(data);
                    spinner.hide();
                    var obj = JSON.parse(data);
                    alert(obj.message);
                    //alert(obj.status);
                    if (obj.status) {
                        //location.reload();
                        // window.open("medicine_purchase_list.php","_self");

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
        // load_medicine();
    });


    var all_medicine = <?php echo json_encode($result_content_medicine); ?>;

    var total_bill = 0;

    function medicine_update(instance) {

        var row = $(instance).closest("tr");

        var val = row.find(".pharmacy_purchase_medicine_medicine_name").val();
        if (val === "") {
            row.find(".pharmacy_purchase_medicine_batch_id").val("");
            row.find(".pharmacy_purchase_medicine_exp_date").val("");
            row.find(".pharmacy_purchase_medicine_stock_qty").val("");

            row.find(".pharmacy_purchase_medicine_total_pieces").val("");

            row.find(".pharmacy_purchase_medicine_total_quantity").val("");
            row.find(".pharmacy_purchase_medicine_manufacture_price").val("");
            row.find(".pharmacy_purchase_medicine_box_mrp").val("");
            row.find(".pharmacy_purchase_medicine_total_purchase_price").val("");
            return;
        }
        // var name = $("#manufacturer_medicines option[value=" + val + "]").text();


        // //alert(val);
        // //alert(name);
        // var obj = $("#manufacturer_medicines").find("option[value='" + val + "']");

        const data_name = $("#manufacturer_medicines option[value=" + val + "]").text();
        const arr = data_name.split("~");
        var name = arr[0];
        var batch_id = arr[1];
        var medicine_id = arr[2];
        var pharmacy_medicine_id = val;
        var obj = $("#manufacturer_medicines").find("option[value='" + val + "']");

        if (obj != null && obj.length > 0) {
            //alert("valid");  // allow form submission
            //document.getElementById("is_new").value = "false";
            row.find(".pharmacy_purchase_medicine_medicine_name").val(name);
            row.find(".pharmacy_purchase_medicine_medicine_id").val(val);
            //alert(val);
            for (var i = 0; i < Object.keys(all_medicine).length; i++) {
                if (all_medicine[i]['medicine_name'] === name) {
                    //alert("matched");

                    row.find(".pharmacy_purchase_medicine_stock_qty").val(all_medicine[i]['total_quantity'] - all_medicine[i]['total_sell']);



                    row.find(".pharmacy_purchase_medicine_manufacture_price").val(all_medicine[i]['medicine_purchase_price']);
                    row.find(".pharmacy_purchase_medicine_box_mrp").val(all_medicine[i]['medicine_selling_price']);

                    row.find(".pharmacy_purchase_medicine_manufacture_price").val(all_medicine[i]['medicine_purchase_price']);
                    row.find(".pharmacy_purchase_medicine_box_mrp").val(all_medicine[i]['medicine_selling_price']);

                    var total_pieces = row.find(".pharmacy_purchase_medicine_total_pieces").val();

                    var total_purchase_price = parseFloat(row.find(".pharmacy_purchase_medicine_manufacture_price").val()) * parseFloat(total_pieces);

                    row.find(".pharmacy_purchase_medicine_total_purchase_price").val(total_purchase_price);

                }
            }
            row_update(instance);
        } else {
            alert("Medicine Not Available"); // don't allow form submission
            // document.getElementById("is_new").value = "true";
            row.find(".pharmacy_purchase_medicine_medicine_name").val("");
            row.find(".pharmacy_purchase_medicine_medicine_id").val("");
            row.find(".pharmacy_purchase_medicine_batch_id").val("");
            row.find(".pharmacy_purchase_medicine_exp_date").val("");
            row.find(".pharmacy_purchase_medicine_stock_qty").val("");
            row.find(".pharmacy_purchase_medicine_box_quantity").val("");
            row.find(".pharmacy_purchase_medicine_total_pieces").val("");

            row.find(".pharmacy_purchase_medicine_total_quantity").val("");
            row.find(".pharmacy_purchase_medicine_manufacture_price").val("");
            row.find(".pharmacy_purchase_medicine_box_mrp").val("");
            row.find(".pharmacy_purchase_medicine_total_purchase_price").val("");
            //row.find(".pharmacy_purchase_medicine_medicine_name").val(name);
            //row.find(".pharmacy_purchase_medicine_medicine_id").val(val);

        }
    }

    function row_update(instance) {

        var row = $(instance).closest("tr");
        let medicine_name = row.find(".pharmacy_purchase_medicine_medicine_name").val();
        //alert(medicine_name);
        for (var i = 0; i < Object.keys(all_medicine).length; i++) {
            if (all_medicine[i]['medicine_name'] === medicine_name) {
                //alert("matched");
                row.find(".pharmacy_purchase_medicine_stock_qty").val(all_medicine[i]['total_quantity'] - all_medicine[i]['total_sell']);


                row.find(".pharmacy_purchase_medicine_manufacture_price").val(all_medicine[i]['medicine_purchase_price']);
                row.find(".pharmacy_purchase_medicine_box_mrp").val(all_medicine[i]['medicine_selling_price']);

                var total_pieces = row.find(".pharmacy_purchase_medicine_total_pieces").val();

                var total_purchase_price = parseFloat(row.find(".pharmacy_purchase_medicine_manufacture_price").val()) * parseFloat(total_pieces);

                row.find(".pharmacy_purchase_medicine_total_purchase_price").val(total_purchase_price);

            }
        }
        total_calculation_update();

    }

    function total_calculation_update() {

        let sub_total = 0;
        $("tr").each(function() {
            var total = $(this).find("input.pharmacy_purchase_medicine_total_purchase_price").val();
            sub_total = parseInt(sub_total) + parseInt(isNaN(parseInt(total)) ? 0 : total);
        });
        //alert(sub_total);
        document.getElementById("pharmacy_purchase_sub_total").value = sub_total;
        let vat = document.getElementById("pharmacy_purchase_vat").value;
        let discount = document.getElementById("pharmacy_purchase_discount").value;
        let sub_total_with_vat = (sub_total + ((sub_total * vat) / 100))
        document.getElementById("pharmacy_purchase_grand_total").value = (sub_total_with_vat - ((sub_total * discount) / 100));
        let grand_total = document.getElementById("pharmacy_purchase_grand_total").value;
        let paid = document.getElementById("pharmacy_purchase_paid_amount").value;
        document.getElementById("pharmacy_purchase_due_amount").value = grand_total - paid;
        // row_update(this);
    }

    function changeManufacturer() {
        var manufacturer_id = $("#select-manufacturer :selected").val(); // The value of the selected option
        // alert(manufacturer_id);

        spinner.show();
        jQuery.ajax({
            type: 'POST',
            url: '../apis/get_medicine.php',
            cache: false,
            //dataType: "json", // and this
            data: {
                token: "<?php echo $_SESSION['token']; ?>",
                request_user_id: "<?php echo $_SESSION['user_id']; ?>",
                manufacturer_id: manufacturer_id,
                content: "manufacturer_medicine",
            },
            success: function(response) {
                //alert(response);
                spinner.hide();
                var obj = JSON.parse(response);
                var datas = obj.medicine;

                for (var key in datas) {
                    if (datas.hasOwnProperty(key)) {
                        $("#manufacturer_medicines").append('<option value="' + datas[key].medicine_id + '">' + datas[key].medicine_name + '</option>');
                    }
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                spinner.hide();
                alert("alert : " + errorThrown);
            }
        });


    }

    function load_medicine() {
        for (var i = 0; i < Object.keys(all_medicine).length; i++) {
            $("#manufacturer_medicines").append('<option value="' + all_medicine[i]['pharmacy_medicine_id'] + '">' + all_medicine[i]['medicine_name'] + '~' + all_medicine[i]['pharmacy_medicine_batch_id'] + '~' + all_medicine[i]['medicine_id'] + '</option>');
        }

    }

    function initRowTable() {
        var list = <?php echo json_encode($result_content_pharmacy_medicine_purchase); ?>;

        //alert(list);
        var table = document.getElementById('datatable1_body');
        var main_table = document.getElementById('datatable1');

        for (var i = 0; i < Object.keys(list).length; i++) {

            var tr = document.createElement('tr');

            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');
            var td4 = document.createElement('td');
            // var td5 = document.createElement('td');
            var td6 = document.createElement('td');
            var td7 = document.createElement('td');
            var td8 = document.createElement('td');
            var td9 = document.createElement('td');
            var td10 = document.createElement('td');


            var text1 = document.createElement("INPUT");
            text1.setAttribute("required", "required");
            text1.setAttribute("class", "form-control pharmacy_purchase_medicine_medicine_name");
            text1.setAttribute("type", "text");
            text1.setAttribute("list", "manufacturer_medicines");
            text1.setAttribute("id", "pharmacy_purchase_medicine_medicine_name");
            text1.setAttribute("name", "pharmacy_purchase_medicine_medicine_name[]");
            text1.setAttribute("placeholder", "Pick a Service...");
            text1.setAttribute("value", list[i]['medicine_name']);
            text1.setAttribute("readonly", "readonly");
            text1.onchange = function() {
                medicine_update(this);
            }
            var hiddenText = document.createElement("INPUT");
            hiddenText.setAttribute("required", "required");
            hiddenText.setAttribute("class", "form-control pharmacy_purchase_medicine_medicine_id");
            hiddenText.setAttribute("type", "hidden");
            hiddenText.setAttribute("id", "pharmacy_purchase_medicine_medicine_id");
            hiddenText.setAttribute("name", "pharmacy_purchase_medicine_medicine_id[]");
            hiddenText.setAttribute("value", list[i]['medicine_id']);

            var hiddenText2 = document.createElement("INPUT");
            hiddenText2.setAttribute("required", "required");
            hiddenText2.setAttribute("class", "form-control pharmacy_purchase_medicine_purchase_id");
            hiddenText2.setAttribute("type", "hidden");
            hiddenText2.setAttribute("id", "pharmacy_purchase_medicine_purchase_id");
            hiddenText2.setAttribute("name", "pharmacy_purchase_medicine_purchase_id");
            hiddenText2.setAttribute("value", list[i]['pharmacy_purchase_medicine_purchase_id']);

            //var cell = row.insertCell();
            //cell.appendChild(selectList);




            var text2 = document.createElement("INPUT");
            text2.setAttribute("required", "required");
            text2.setAttribute("class", "form-control pharmacy_purchase_medicine_batch_id");
            text2.setAttribute("type", "text");
            text2.setAttribute("placeholder", "Batch ID");
            text2.setAttribute("name", "pharmacy_purchase_medicine_batch_id[]");
            text2.setAttribute("value", list[i]['pharmacy_medicine_batch_id']);
            text2.setAttribute("readonly", "readonly");

            var text3 = document.createElement("INPUT");
            text3.setAttribute("type", "date");
            text3.setAttribute("required", "required");
            text3.setAttribute("class", "form-control pharmacy_purchase_medicine_exp_date");
            text3.setAttribute("placeholder", "Exp Date");
            text3.setAttribute("name", "pharmacy_purchase_medicine_exp_date[]");
            text3.setAttribute("value", list[i]['pharmacy_medicine_exp_date']);
            text3.setAttribute("readonly", "readonly");

            var text4 = document.createElement("INPUT");
            text4.setAttribute("type", "text");
            text4.setAttribute("required", "required");
            text4.setAttribute("class", "form-control pharmacy_purchase_medicine_stock_qty");
            text4.setAttribute("placeholder", "Stock Qty");
            text4.setAttribute("name", "pharmacy_purchase_medicine_stock_qty[]");
            text4.setAttribute("readonly", "readonly");
            text4.setAttribute("value", list[i]['total_quantity']);
            //alert(list[i]);

            // var text5 = document.createElement("INPUT");
            // text5.setAttribute("type", "text");
            // text5.setAttribute("required", "required");
            // text5.setAttribute("class", "form-control pharmacy_purchase_medicine_box_quantity");
            // text5.setAttribute("placeholder", "Box Qty");
            // text5.setAttribute("name", "pharmacy_purchase_medicine_box_quantity[]");
            // text5.setAttribute("value", list[i]['pharmacy_purchase_medicine_box_quantity']);

            // text5.onchange = function (){
            //     row_update(this);
            // }


            var text6 = document.createElement("INPUT");
            text6.setAttribute("type", "text");
            text6.setAttribute("required", "required");
            text6.setAttribute("class", "form-control pharmacy_purchase_medicine_total_pieces");
            text6.setAttribute("placeholder", "Total Pieces");
            text6.setAttribute("name", "pharmacy_purchase_medicine_total_pieces[]");
            text6.setAttribute("readonly", "readonly");
            text6.setAttribute("value", list[i]['pharmacy_purchase_medicine_total_pieces']);
            text6.onchange = function() {
                row_update(this);
            }


            var text7 = document.createElement("INPUT");
            text7.setAttribute("type", "text");
            text7.setAttribute("required", "required");
            text7.setAttribute("class", "form-control pharmacy_purchase_medicine_manufacture_price");
            text7.setAttribute("placeholder", "mPrice");
            text7.setAttribute("name", "pharmacy_purchase_medicine_manufacture_price[]");
            text7.setAttribute("value", list[i]['pharmacy_purchase_medicine_manufacture_price']);
            text7.setAttribute("readonly", "readonly");


            var text8 = document.createElement("INPUT");
            text8.setAttribute("type", "text");
            text8.setAttribute("required", "required");
            text8.setAttribute("class", "form-control pharmacy_purchase_medicine_box_mrp");
            text8.setAttribute("placeholder", "bPrice");
            text8.setAttribute("name", "pharmacy_purchase_medicine_box_mrp[]");
            text8.setAttribute("value", list[i]['pharmacy_purchase_medicine_box_mrp']);
            text8.setAttribute("readonly", "readonly");


            var text9 = document.createElement("INPUT");
            text9.setAttribute("type", "text");
            text9.setAttribute("required", "required");
            text9.setAttribute("class", "form-control pharmacy_purchase_medicine_total_purchase_price");
            text9.setAttribute("placeholder", "Total");
            text9.setAttribute("name", "pharmacy_purchase_medicine_total_purchase_price[]");
            text9.setAttribute("value", list[i]['pharmacy_purchase_medicine_total_purchase_price']);
            text9.setAttribute("readonly", "readonly");


            var buttonRemove = document.createElement('button');
            buttonRemove.setAttribute("type", "button");
            buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");

            buttonRemove.onclick = function() {
                // ...
                DeleteRow(this);

            };


            td1.appendChild(text1);
            td1.appendChild(hiddenText);
            td1.appendChild(hiddenText2);

            td2.appendChild(text2);
            td3.appendChild(text3);
            td4.appendChild(text4);
            // td5.appendChild(text5);
            td6.appendChild(text6);
            td7.appendChild(text7);
            td8.appendChild(text8);
            td9.appendChild(text9);
            td10.appendChild(buttonRemove);


            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            // tr.appendChild(td5);
            tr.appendChild(td6);
            tr.appendChild(td7);
            tr.appendChild(td8);
            tr.appendChild(td9);
            tr.appendChild(td10);



            table.appendChild(tr);

        }
        if (Object.keys(list).length == 0) {
            AddRowTable();
        }

        //document.body.appendChild(table);
    }

    function AddRowTable() {
        //alert("table q19");
        var table = document.getElementById('datatable1_body');
        var tr = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');
        // var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var td7 = document.createElement('td');
        var td8 = document.createElement('td');
        var td9 = document.createElement('td');
        var td10 = document.createElement('td');


        var text1 = document.createElement("INPUT");
        text1.setAttribute("required", "required");
        text1.setAttribute("class", "form-control pharmacy_purchase_medicine_medicine_name");
        text1.setAttribute("type", "text");
        text1.setAttribute("list", "manufacturer_medicines");
        text1.setAttribute("id", "pharmacy_purchase_medicine_medicine_name");
        text1.setAttribute("name", "pharmacy_purchase_medicine_medicine_name[]");
        text1.setAttribute("placeholder", "Pick a Service...");
        text1.onchange = function() {
            medicine_update(this);
        }
        var hiddenText = document.createElement("INPUT");
        hiddenText.setAttribute("required", "required");
        hiddenText.setAttribute("class", "form-control pharmacy_purchase_medicine_medicine_id");
        hiddenText.setAttribute("type", "hidden");
        hiddenText.setAttribute("id", "pharmacy_purchase_medicine_medicine_id");
        hiddenText.setAttribute("name", "pharmacy_purchase_medicine_medicine_id[]");

        //var cell = row.insertCell();
        //cell.appendChild(selectList);
        var hiddenText2 = document.createElement("INPUT");
            hiddenText2.setAttribute("required", "required");
            hiddenText2.setAttribute("class", "form-control pharmacy_purchase_medicine_purchase_id");
            hiddenText2.setAttribute("type", "hidden");
            hiddenText2.setAttribute("id", "pharmacy_purchase_medicine_purchase_id");
            hiddenText2.setAttribute("name", "pharmacy_purchase_medicine_purchase_id");
            hiddenText2.setAttribute("value", list[i]['pharmacy_purchase_medicine_purchase_id']);



        var text2 = document.createElement("INPUT");
        text2.setAttribute("required", "required");
        text2.setAttribute("class", "form-control pharmacy_purchase_medicine_batch_id");
        text2.setAttribute("type", "text");
        text2.setAttribute("placeholder", "Batch ID");
        text2.setAttribute("name", "pharmacy_purchase_medicine_batch_id[]");


        var text3 = document.createElement("INPUT");
        text3.setAttribute("type", "date");
        text3.setAttribute("required", "required");
        text3.setAttribute("class", "form-control pharmacy_purchase_medicine_exp_date");
        text3.setAttribute("placeholder", "Exp Date");
        text3.setAttribute("name", "pharmacy_purchase_medicine_exp_date[]");


        var text4 = document.createElement("INPUT");
        text4.setAttribute("type", "text");
        text4.setAttribute("required", "required");
        text4.setAttribute("class", "form-control pharmacy_purchase_medicine_stock_qty");
        text4.setAttribute("placeholder", "Stock Qty");
        text4.setAttribute("name", "pharmacy_purchase_medicine_stock_qty[]");
        text4.setAttribute("readonly", "readonly");


        // var text5 = document.createElement("INPUT");
        // text5.setAttribute("type", "text");
        // text5.setAttribute("required", "required");
        // text5.setAttribute("class", "form-control pharmacy_purchase_medicine_box_quantity");
        // text5.setAttribute("placeholder", "Box Qty");
        // text5.setAttribute("name", "pharmacy_purchase_medicine_box_quantity[]");
        // text5.onchange = function (){
        //     row_update(this);
        // }

        var text6 = document.createElement("INPUT");
        text6.setAttribute("type", "text");
        text6.setAttribute("required", "required");
        text6.setAttribute("class", "form-control pharmacy_purchase_medicine_total_pieces");
        text6.setAttribute("placeholder", "Total Pieces");
        text6.setAttribute("name", "pharmacy_purchase_medicine_total_pieces[]");
        // text6.setAttribute("readonly", "readonly");
        text6.onchange = function() {
            row_update(this);
        }


        var text7 = document.createElement("INPUT");
        text7.setAttribute("type", "text");
        text7.setAttribute("required", "required");
        text7.setAttribute("class", "form-control pharmacy_purchase_medicine_manufacture_price");
        text7.setAttribute("placeholder", "mPrice");
        text7.setAttribute("name", "pharmacy_purchase_medicine_manufacture_price[]");
        text7.setAttribute("readonly", "readonly");


        var text8 = document.createElement("INPUT");
        text8.setAttribute("type", "text");
        text8.setAttribute("required", "required");
        text8.setAttribute("class", "form-control pharmacy_purchase_medicine_box_mrp");
        text8.setAttribute("placeholder", "bPrice");
        text8.setAttribute("name", "pharmacy_purchase_medicine_box_mrp[]");
        text8.setAttribute("readonly", "readonly");


        var text9 = document.createElement("INPUT");
        text9.setAttribute("type", "text");
        text9.setAttribute("required", "required");
        text9.setAttribute("class", "form-control pharmacy_purchase_medicine_total_purchase_price");
        text9.setAttribute("placeholder", "Total");
        text9.setAttribute("name", "pharmacy_purchase_medicine_total_purchase_price[]");
        text9.setAttribute("readonly", "readonly");


        var buttonRemove = document.createElement('button');
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("class", "btn btn-danger-soft far fa-trash-alt");

        buttonRemove.onclick = function() {
            // ...
            DeleteRow(this);

        };


        td1.appendChild(text1);
        td1.appendChild(hiddenText);
        td1.appendChild(hiddenText2);

        td2.appendChild(text2);
        td3.appendChild(text3);
        td4.appendChild(text4);
        // td5.appendChild(text5);
        td6.appendChild(text6);
        td7.appendChild(text7);
        td8.appendChild(text8);
        td9.appendChild(text9);
        td10.appendChild(buttonRemove);


        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        // tr.appendChild(td5);
        tr.appendChild(td6);
        tr.appendChild(td7);
        tr.appendChild(td8);
        tr.appendChild(td9);
        tr.appendChild(td10);



        table.appendChild(tr);

    }

    function DeleteRow(ctl) {
        var table = document.getElementById('datatable1');

        //var tbodyRowCount = table.tBodies[0].rows.length; // 3
        var count = table.getElementsByTagName("tr").length;

        //alert(count-2);
        if (count - 1 > 1) {
            $(ctl).parents("tr").remove();
        } else {
            alert("At-least 1 Row is Required in service table");
        }
        document.getElementById("pharmacy_purchase_paid_amount").value = "";
        total_calculation_update();
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>


<script>
    $(document).ready(function() {
        $('#select-manufacturer').selectize({
            sortField: 'text'
        });

    });
</script>

</html>