
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
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Edit Room Allotment</h3>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="room-number">Room Number</label>
                        <input value="10" type="text" class="form-control" placeholder="Room Number" id="room-number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="room-type">Room Type</label>
                        <select class="form-control" id="room-type">
                            <option>ICU</option>
                            <option selected="">General</option>
                            <option>AC Room</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="patient-name">Patient Name</label>
                        <input value="Damodar Reddy" type="text" placeholder="Patient Name" class="form-control" id="patient-name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="allot-date">Allotment Date</label>
                        <input value="2018-10-10" type="date" placeholder="Allotment Date" class="form-control" id="allot-date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discharge-date">Discharge Date</label>
                        <input value="2018-10-16" type="date" placeholder="Discharge Date" class="form-control" id="discharge-date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doctor-name">Doctor Name</label>
                        <input value="Dr Manoj Kumar" type="text" placeholder="Doctor Name" class="form-control" id="doctor-name">
                    </div>																	
                    
                    <div class="form-group col-md-6 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">Updated</button>
                    </div>
                </div>
            </form>
            <!-- Alerts-->
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Updated Successfully!</strong> Please check in Allotment list
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- /Alerts-->
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

</html>