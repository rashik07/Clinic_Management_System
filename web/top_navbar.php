<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="navbar-brand arrow_style">
        <span class="icon ti-arrow-left"></span>
        <!--<span class="ti-arrow-right"></span>-->
    </a>
    <form class="form-inline">
        <a class="navbar-brand"><?php echo $_SESSION['user_Full_Name']; ?></a>
        <button type="button" class="btn btn-dark mx-2 my-sm-0" onclick="logout();">logout</button>
    </form>
</nav>

<!-- <div class="row no-margin-padding">
				<div class="col-md-6">
					<h3 class="block-title">Quick Statistics</h3>
				</div>
				<div class="col-md-6">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">
								<span class="ti-home"></span>
							</a>
						</li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>
	</div> -->
<?php include 'footer.php'
?>
<script>
    let hidden = false;
    $(".navbar-brand").click(function() {
        $(".proclinic-bg").toggleClass("main");
        if ($('.proclinic-bg').hasClass('main')) {
            $(".icon").toggleClass("ti-arrow-left");
            $(".icon").toggleClass("ti-arrow-right");
        } else {
            $(".icon").toggleClass("ti-arrow-left");
            $(".icon").toggleClass("ti-arrow-right");
        }
    });

    function logout() {
        jQuery.ajax({
            type: 'POST',
            url: '../scripts/clear_session.php',
            cache: false,
            //dataType: "json", // and this
            data: {},

            success: function(response) {
                window.open("login.php", "_self");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
                alert("alert : " + errorThrown);
            }
        });

    }
</script>