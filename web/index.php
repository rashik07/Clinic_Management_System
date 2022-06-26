<?php
if (!isset($_SESSION)) {
    session_start();
}
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
            echo '<div class="container-fluid home">';
            include "top_section.php";
            if ($_SESSION['user_type_access_level'] <= 2||$_SESSION['user_type_access_level'] == 6) {
            include 'medicine_chat.php';
            }
            if ($_SESSION['user_type_access_level'] <= 4) {
            include 'indoor_chart.php';
            }
            echo '</div>';
            
            // if ($_SESSION['user_type_access_level'] <= 2 || $_SESSION['user_type_access_level'] == 6) {
            //     include 'home.php';
            // }

            ?>

            <div>

            </div>
            <?php include 'footer.php'
            ?>
</body>

</html>