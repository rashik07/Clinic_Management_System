
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
            <h3 class="widget-title">Payments List</h3>
            <div class="table-responsive mb-3">
                <div id="tableId_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="tableId_length"><label>Show <select name="tableId_length" aria-controls="tableId" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="tableId_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="tableId"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="tableId" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="tableId_info">
                    <thead>
                        <tr role="row"><th class="no-sort sorting_disabled" rowspan="1" colspan="1" aria-label="
                                
                                    
                                    
                                
                            " style="width: 20px;">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="select-all">
                                    <label class="custom-control-label" for="select-all"></label>
                                </div>
                            </th><th class="sorting" tabindex="0" aria-controls="tableId" rowspan="1" colspan="1" aria-label="Patient Name: activate to sort column ascending" style="width: 142.078px;">Patient Name</th><th class="sorting" tabindex="0" aria-controls="tableId" rowspan="1" colspan="1" aria-label="Doctor Name: activate to sort column ascending" style="width: 137.031px;">Doctor Name</th><th class="sorting" tabindex="0" aria-controls="tableId" rowspan="1" colspan="1" aria-label="Service Name: activate to sort column ascending" style="width: 140.641px;">Service Name</th><th class="sorting" tabindex="0" aria-controls="tableId" rowspan="1" colspan="1" aria-label="Charges: activate to sort column ascending" style="width: 88.3125px;">Charges</th><th class="sorting" tabindex="0" aria-controls="tableId" rowspan="1" colspan="1" aria-label="Discount (%): activate to sort column ascending" style="width: 121.938px;">Discount <small>(%)</small></th><th class="sorting" tabindex="0" aria-controls="tableId" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 87px;">Status</th></tr>
                    </thead>
                    <tbody>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    <tr role="row" class="odd">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="1">
                                    <label class="custom-control-label" for="1"></label>
                                </div>
                            </td>
                            <td>Manoj Kumar</td>
                            <td>Daniel Smith</td>
                            <td>X-ray</td>
                            <td>$500</td>
                            <td>5</td>
                            <td>
                                <span class="badge badge-success">completed</span>
                            </td>
                        </tr><tr role="row" class="even">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="2">
                                    <label class="custom-control-label" for="2"></label>
                                </div>
                            </td>
                            <td>Riya</td>
                            <td>Daniel Smith</td>
                            <td>ECG</td>
                            <td>$120</td>
                            <td>10</td>
                            <td>
                                <span class="badge badge-success">completed</span>
                            </td>
                        </tr><tr role="row" class="odd">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="3">
                                    <label class="custom-control-label" for="3"></label>
                                </div>
                            </td>
                            <td>Susan</td>
                            <td>Daniel Smith</td>
                            <td>Dental</td>
                            <td>$190</td>
                            <td>8</td>
                            <td>
                                <span class="badge badge-warning">Pending</span>
                            </td>
                        </tr><tr role="row" class="even">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="4">
                                    <label class="custom-control-label" for="4"></label>
                                </div>
                            </td>
                            <td>Manoj Kumar</td>
                            <td>Daniel Smith</td>
                            <td>X-ray</td>
                            <td>$500</td>
                            <td>5</td>
                            <td>
                                <span class="badge badge-danger">cancelled</span>
                            </td>
                        </tr><tr role="row" class="odd">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="5">
                                    <label class="custom-control-label" for="5"></label>
                                </div>
                            </td>
                            <td>Riya</td>
                            <td>Daniel Smith</td>
                            <td>ECG</td>
                            <td>$120</td>
                            <td>10</td>
                            <td>
                                <span class="badge badge-success">completed</span>
                            </td>
                        </tr><tr role="row" class="even">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="6">
                                    <label class="custom-control-label" for="6"></label>
                                </div>
                            </td>
                            <td>Susan</td>
                            <td>Daniel Smith</td>
                            <td>Dental</td>
                            <td>$190</td>
                            <td>8</td>
                            <td>
                                <span class="badge badge-warning">Pending</span>
                            </td>
                        </tr><tr role="row" class="odd">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="7">
                                    <label class="custom-control-label" for="7"></label>
                                </div>
                            </td>
                            <td>Manoj Kumar</td>
                            <td>Daniel Smith</td>
                            <td>X-ray</td>
                            <td>$500</td>
                            <td>5</td>
                            <td>
                                <span class="badge badge-success">completed</span>
                            </td>
                        </tr><tr role="row" class="even">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="8">
                                    <label class="custom-control-label" for="8"></label>
                                </div>
                            </td>
                            <td>Riya</td>
                            <td>Daniel Smith</td>
                            <td>ECG</td>
                            <td>$120</td>
                            <td>10</td>
                            <td>
                                <span class="badge badge-success">completed</span>
                            </td>
                        </tr><tr role="row" class="odd">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="9">
                                    <label class="custom-control-label" for="9"></label>
                                </div>
                            </td>
                            <td>Susan</td>
                            <td>Daniel Smith</td>
                            <td>Dental</td>
                            <td>$190</td>
                            <td>8</td>
                            <td>
                                <span class="badge badge-warning">Pending</span>
                            </td>
                        </tr><tr role="row" class="even">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="10">
                                    <label class="custom-control-label" for="10"></label>
                                </div>
                            </td>
                            <td>Manoj Kumar</td>
                            <td>Daniel Smith</td>
                            <td>X-ray</td>
                            <td>$500</td>
                            <td>5</td>
                            <td>
                                <span class="badge badge-danger">cancelled</span>
                            </td>
                        </tr></tbody>
                </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="tableId_info" role="status" aria-live="polite">Showing 1 to 10 of 12 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="tableId_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="tableId_previous"><a href="#" aria-controls="tableId" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="tableId" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="tableId" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="tableId_next"><a href="#" aria-controls="tableId" data-dt-idx="3" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                
                <!--Export links-->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center export-pagination">
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-download"></span> csv</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-printer"></span>  print</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-file"></span> PDF</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><span class="ti-align-justify"></span> Excel</a>
                        </li>
                    </ul>
                </nav>
                <!-- /Export links-->
                <button type="button" class="btn btn-danger mt-3 mb-0"><span class="ti-trash"></span> DELETE</button>
                <button type="button" class="btn btn-primary mt-3 mb-0"><span class="ti-pencil-alt"></span> EDIT</button>
            </div>
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