<?php
if (!isset($_SESSION)) {
    session_start();
}


$activePage = basename($_SERVER['PHP_SELF'], ".php");

?>
<?php include 'header.php'; ?>
<nav id="sidebar" class="proclinic-bg">
    <div class="sidebar-header">
        <a href="index.php"><img src="../assets/images/logo.png" class="logo" alt="logo"></a>
    </div>
    <ul class="list-unstyled components" id="sidebar-nav" onclick="myFunction(event)">
        <li class="">
            <a href="index.php">
                <span class="ti-home"></span> Dashboard
            </a>
        </li>
        <?php if ($_SESSION['user_type_access_level'] <= 2) { ?>
            <li>
                <a href="#nav-users" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <span class="ti-user"></span> Users
                </a>
                <ul class="list-unstyled collapse" id="nav-users">
                    <li>
                        <!-- <a href="add_user.php">Add user</a> -->
                    </li>
                    <li>
                        <a href="users.php">All Users</a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <?php if ($_SESSION['user_type_access_level'] <= 1 || $_SESSION['user_type_access_level'] == 3 || $_SESSION['user_type_access_level'] == 4) { ?>
            <li>
                <a href="#nav-patients" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <i class="fas fa-hospital-user"></i> Patients
                </a>
                <ul class="list-unstyled collapse" id="nav-patients">
                    <li>
                        <a href="add_patients.php">Add Patient</a>
                    </li>
                    <li>
                        <a class="<?php echo ($activePage == 'patients_list') ? 'active' : ''; ?>" href="patients_list.php">All Patients</a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if ($_SESSION['user_type_access_level'] <= 2 || $_SESSION['user_type_access_level'] == 3) { ?>
            <li>
                <a href="#nav-doctors" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <span class="ti-user"></span> Doctors
                </a>
                <ul class="list-unstyled collapse" id="nav-doctors">
                    <li>
                        <a href="add_doctor.php">Add Doctor</a>
                    </li>
                    <li>
                        <a href="doctors_list.php">All Doctors</a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if ($_SESSION['user_type_access_level'] <= 1 || $_SESSION['user_type_access_level'] == 3) { ?>
            <li>
                <a href="#nav-services" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <span class="ti-server"></span> Services
                </a>
                <ul class="list-unstyled collapse" id="nav-services">
                    <li>
                        <a href="add_service.php">Add Service</a>
                    </li>
                    <li>
                        <a href="service_list.php">All Service</a>
                    </li>


                </ul>
            </li>
            </li>


        <?php } ?>

        <?php if ($_SESSION['user_type_access_level'] <= 1 || $_SESSION['user_type_access_level'] == 3 || $_SESSION['user_type_access_level'] == 4) { ?>
            <li>
                <a href="#nav-bills" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <span class="ti-money"></span> Billing
                </a>
                <ul class="list-unstyled collapse" id="nav-bills">

                    <li>
                        <a href="Service_doctor_visit.php">Doctor Visit</a>
                    </li>
                    <li>
                        <a href="Service_procedures.php">Procedures</a>
                    </li>
                    <li>
                        <a href="Service_physiotherapy.php">Physiotherapy</a>
                    </li>
                    <li>
                        <a href="Service_ot.php">OT</a>
                    </li>
                    <li>
                        <a href="Service_test.php">Investigation</a>
                    </li>
                    <li>
                        <a href="patient_treatment_list.php">Outdoor Invoices</a>
                    </li>
                    <li>
                        <a href="patient_treatment_list_indoor.php">Indoor Invoices</a>
                    </li>
                    <li>
                        <a href="indoor_bill_list.php">Indoor Biils</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="#nav-patient-treatment" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <span class="ti-wheelchair"></span> Admission
                </a>
                <ul class="list-unstyled collapse" id="nav-patient-treatment">

                    <li>
                        <a href="add_indoor_treatment.php">Indoor Allotment</a>
                    </li>
                    <li>
                        <a href="indoor_treatment_list.php">All Allotments</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#nav-bed" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <i class="fas fa-bed"></i> Bed Management
                </a>
                <ul class="list-unstyled collapse" id="nav-bed">
                    <li>
                        <a href="add_indoor_bed_category.php">Add Bed Category</a>
                    </li>
                    <li>
                        <a href="indoor_bed_category_list.php">All Bed Category</a>
                    </li>
                    <li>
                        <a href="add_indoor_bed.php">Add Bed</a>
                    </li>
                    <li>
                        <a href="indoor_bed_list.php">All Bed</a>
                    </li>

                </ul>
            </li>

        <?php } ?>

        <?php if ($_SESSION['user_type_access_level'] <= 1 || $_SESSION['user_type_access_level'] == 6) { ?>
            <li><a href="#nav-Medicine" data-toggle="collapse" aria-expanded="false" class="collapsed">
                    <span class="ti-write"></span> Pharmacy Data Entry
                </a>
                <ul class="list-unstyled collapse" id="nav-Medicine">
                    <li>
                        <a href="add_medicine_unit.php">Unit Entry</a>
                    </li>
                    <li>
                        <a href="medicine_unit_list.php">Unit List</a>
                    </li>
                    <!-- <li>
                        <a href="add_medicine_type.php">Type Entry</a>
                    </li>
                    <li>
                        <a href="medicine_type_list.php">Type List</a>
                    </li> -->
                    <!-- <li>
                        <a href="add_medicine_leaf.php">Leaf Entry</a>
                    </li>
                    <li>
                        <a href="medicine_leaf_list.php">Leaf List</a>
                    </li> -->
                    <li>
                        <a href="add_manufacturer.php">Supplier Entry</a>
                    </li>
                    <li>
                        <a href="manufacturer_list.php">Supplier List</a>
                    </li>

                    <li>
                        <a href="add_medicine.php">Medicine Entry</a>
                    </li>
                    <li>
                        <a href="medicine_list.php">Medicine List</a>
                    </li>


                </ul>
            </li>

            <li>
                <a href="#nav-maps" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-capsules"></i>Pharmacy
                </a>
                <ul class="collapse list-unstyled" id="nav-maps">
                    <!-- <li>
                        <a href="add_medicine_category.php">Category Entry</a>
                    </li>
                    <li>
                        <a href="medicine_category_list.php">Category List</a>
                    </li> -->
                    <li>
                        <a href="stock.php"> Stock</a>
                    </li>
                    <li>
                        <a href="stock_alert.php">Stock Alert</a>
                    </li>
                    <li>
                        <a href="stock_experied.php">Expired Medicine</a>
                    </li>

                    <li>
                        <a href="add_medicine_purchase.php"> Purchase Entry</a>
                    </li>
                    <li>
                        <a href="medicine_purchase_list.php"> Purchase List</a>
                    </li>
                    <li>
                        <a href="add_medicine_sell.php"> Sell Entry</a>
                    </li>
                    <li>
                        <a href="medicine_sell_list.php"> Sell List</a>
                    </li>
                    <li>
                        <a href="sell_return_list.php"> Return List</a>
                    </li>

                    <?php if ($_SESSION['user_type_access_level'] <= 2 || $_SESSION['user_type_access_level'] == 6) { ?>
                        <li>
                            <a href="report_pharmacy_sell.php"> Sell Report</a>
                        </li>
                        <li>
                            <a href="report_pharmacy_purchase.php"> Purchase Report</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($_SESSION['user_type_access_level'] <= 2 || $_SESSION['user_type_access_level'] == 3 || $_SESSION['user_type_access_level'] == 4) { ?>
            <li>
                <a href="#nav-icons" data-toggle="collapse" aria-expanded="false">
                    <span class="ti-bar-chart"></span> Reports
                </a>

                <ul class="collapse list-unstyled" id="nav-icons">

                    <li>
                        <a href="reports.php">Outdoor Reports</a>
                    </li>
                    <li>
                        <a href="reports_indoor.php">Indoor Reports</a>
                    </li>


                </ul>
            </li>
        <?php } ?>

    </ul>
    <div class="nav-help animated fadeIn">
        <h5><span class="ti-comments"></span> Need Help</h5>
        <h6>
            <span class="ti-mobile"></span> +880-1708-591899
        </h6>
        <h6>
            <span class="ti-email"></span> info@theicthub.com
        </h6>
        <p class="copyright-text">Copy rights ?? 2021</p>
    </div>
</nav>
<script>
    function myFunction(e) {
        var elems = document.querySelectorAll(".active");
        [].forEach.call(elems, function(el) {
            el.classList.remove("active");
        });
        e.target.class = "active";
    }
</script>

<!-- <script>
    jQuery(function($) {
        $('.menu ul li a').filter(function() {
            var locationUrl = window.location.href;
            var currentItemUrl = $(this).prop('href');

            return currentItemUrl === locationUrl;
        }).parent('li').addClass('active');
    });
</script> -->