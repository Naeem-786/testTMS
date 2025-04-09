
<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php');?>
<?php

      // ******   PHP CODE FOR TMS  ********
    // <--- TO GET TOTAL ORDERS WHICH ARE BEING DELIVERED AFTER 2 DAYS 1 DAYS AND CURRENT DAY --->
    $count_query = "SELECT COUNT(*) AS total_orders FROM addneworder WHERE delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND progress_suit IN ('cutting_unit', 'stitching_unit')";
    $count_result = mysqli_query($conn, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_orders = $count_row['total_orders']; // Get the total count

     // Query to get total orders ready for delivery
     $ready_for_delivery = "SELECT COUNT(*) AS total_orders FROM addneworder WHERE progress_suit IN ('ready_for_delivery')";
     $delivery_result = mysqli_query($conn, $ready_for_delivery);
     $delivery_row = mysqli_fetch_assoc($delivery_result);
     $total_delivery = $delivery_row['total_orders']; // Get the total count

      // Query to count total orders in cutting unit
      $cutting_unit = "SELECT COUNT(*) AS total_orders FROM addneworder WHERE progress_suit IN ('cutting_unit')";
      $cutting_result = mysqli_query($conn, $cutting_unit);
      $cutting_row = mysqli_fetch_assoc($cutting_result);
      $total_cutting_orders = $cutting_row['total_orders']; // Get the total count

      // Query to count total orders in stitching unit
      $stitching_unit = "SELECT COUNT(*) AS total_orders FROM addneworder WHERE progress_suit IN ('stitching_unit')";
      $stitching_result = mysqli_query($conn, $stitching_unit);
      $stitching_row = mysqli_fetch_assoc($stitching_result);
      $total_stitching_orders = $stitching_row['total_orders']; // Get the total count

    //   FIND OUT TOTAL REVRNU
      // If either column might contain NULL values that you want to treat as 0, you could use COALESCE()
      // Today total Revenue
    $today_revenue = "SELECT SUM(COALESCE(advance, 0) + COALESCE(grand_total, 0)) AS Total_revenue 
    FROM payment_tbl 
    WHERE DATE(Date) = CURRENT_DATE";
    $sql_query_revenue = mysqli_query($conn, $today_revenue);
    $result = mysqli_fetch_assoc($sql_query_revenue);
    $total_of_today = $result['Total_revenue'];

     // monthwise total Revenue
    $monthly_revenue = "SELECT SUM(COALESCE(advance, 0) + COALESCE(grand_total, 0)) AS Total_revenue FROM payment_tbl WHERE EXTRACT(MONTH FROM Date) = EXTRACT(MONTH FROM CURRENT_DATE) AND EXTRACT(YEAR FROM Date) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $sql_query_revenue = mysqli_query($conn, $monthly_revenue);
    $result = mysqli_fetch_assoc($sql_query_revenue);
    $total_monthwise = $result['Total_revenue'];

    // To find total revenue of current year 
    $yearwise_total = "SELECT SUM(COALESCE(advance, 0) + COALESCE(grand_total, 0)) AS yearly_revenue 
    FROM payment_tbl 
    WHERE EXTRACT(YEAR FROM Date) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $sql_query = mysqli_query($conn, $yearwise_total);
    $result = mysqli_fetch_assoc($sql_query);
    $total_yearwise = $result['yearly_revenue'];

    $today = date('l');
    $month = date('M');
    $year = date('Y');


    
    ?>
<!-- Then initialize DataTables -->
<script>
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        columnDefs: [{
                orderable: false,
                targets: [7]
            } // Make action column (8th) non-orderable
        ]
    });
});
</script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <!-- Total Revenue of Today -->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- <a href="http://localhost/sm-ims/pending_packing.php"> -->
                    <div class="dash-widget" style="padding: 20px 15px 20px;">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters"><?=$total_of_today ? $total_of_today : 0?> Rupee</span></h5>
                            <h6 class="fw-bold">Today <?=$today?> Revenue</h6>
                        </div>
                    </div>
                </a>

            </div>
            <!-- Total revenue of Current Month-->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- <a href="http://localhost/sm-ims/monthly_packing.php"> -->
                    <div class="dash-widget dash1">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters"><?=$total_monthwise ? $total_monthwise : 0?> Rupee</span></h5>
                            <h6 class="fw-bold">Total Revenue in <?=$month;?></h6>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Total Revenue of CUrrent year -->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- <a href="http://localhost/sm-ims/pending_packing.php"> -->
                    <div class="dash-widget" style="padding: 20px 15px 20px;">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters"><?=$total_yearwise ? $total_yearwise : 0?> Rupee</span></h5>
                            <h6 class="fw-bold">Today Revenue in <?= $year ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- gatePass generation, modal trigger button -->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- <button style="background:transparent; border:none;" type="button" data-bs-toggle="modal"
                    data-bs-target="#gatePassModal"> -->

                    <div class="dash-widget dash2">
                        <div class="dash-widgetimg">
                            <span><img src="assets/img/icons/pdf.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            In Comming Commands
                        </div>
                    </div>
                </button>
                <!-- gatepass modal body start -->
                <div class="modal fade" id="gatePassModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <div class="modal-title page-header">
                                    <div class="page-title">
                                        <h4>Generate Gate Pass for Products out</h4>
                                        <h6>Select date & vendor name to whom products are being sent.</h6>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <form id="gatePass" style="display: flex; flex-wrap: wrap;" method="post">

                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Date</label>
                                                            <input type="date" id="pass_date" name="pass_date"
                                                                placeholder="Select Date">
                                                            <span id="pro_qtyErr" style="color:red;"></span>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group" style="margin-bottom:0;">
                                                            <label>Vendor Name</label>
                                                            <input type="text" id="gatePass_vendor"
                                                                name="gatePass_vendor" placeholder="Vendor Name">
                                                            <span id="pro_qtyErr" style="color:red;"></span>

                                                        </div>
                                                        <div class="emp_name list-group" id="gatePass_list"></div>

                                                    </div>

                                                    <div class="col-lg-6 col-sm-6 col-12" style="margin:1.4rem;">
                                                        <input class="btn btn-submit me-2" type="submit"
                                                            name="generate_gate_pass" id="generate_gate_pass"
                                                            value="Generate Gate Pass(Out)">

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="success_message"></div>
                                    <div id="error_message"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- gatepass modal body end -->
            </div>


            <!-- order near to delivery data -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <a href="near_to_deliver.php">
                    <div class="dash-count das3">
                        <div class="dash-counts">
                            <h4><?php echo $total_orders?> Order Near to Deliver</h4>
                            <!-- <h5>Ready in <?=$month?></h5> -->
                            <!-- <h4><?=$total_product_yard ?$total_product_yard:0 ?> Products</h4> -->
                        </div>
                        <div class="dash-imgs">
                            <!-- <i data-feather="file"></i> -->
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Total orders ready for delivery -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <a href="ready_for_delivery.php">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4><?php echo $total_delivery?> Order Ready for Delivery</h4>
                        </div>
                        <div class="dash-imgs">
                            <!-- <i data-feather="user"></i> -->
                            <i class="fa-brands fa-product-hunt"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Total orders in Cutting Unit -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <a href="cutting_unit.php">
                    <div class="dash-count das1">
                        <div class="dash-counts">
                            <h4><?php echo $total_cutting_orders?> Order in Cutting Unit</h4>
                        </div>
                        <div class="dash-imgs">
                            <!-- <i data-feather="user-check"></i> -->
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Total orders in Stitching Unit -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <a href="stitching_unit.php">
                    <div class="dash-count das2">
                        <div class="dash-counts">
                            <h4><?php echo $total_stitching_orders?> Order in Stitching Unit</h4>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="file-text"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- chart row section -->

        <!-- last row to show record Ready for Delivery datatable section -->
        <div class="card mb-0">
            <div class="card-body">
                <h4 class="card-title h2_heading text-white p-2">Suits Ready for Delivery</h4>
                <div class="table-responsive dataview">
                    <table class="table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Order Dated</th>
                                <th>Suit No.</th>
                                <th>Name</th>
                                <th>Whatsapp Number</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                               
                    $query = "SELECT * FROM addneworder WHERE progress_suit IN ('ready_for_delivery') ORDER BY date DESC";                              
                    
                    $db_table_data = mysqli_query($conn, $query);
                    $total_rows = mysqli_num_rows($db_table_data);

                    if($total_rows > 0){
                        $number = 1;
                        
                        while($result = mysqli_fetch_assoc($db_table_data)){
                            $order_date = date("d-m-Y", strtotime($result['date']));
                            $delivery_date = date("d-m-Y", strtotime($result['delivery_date']));
                            echo "
                                <tr>
                                    <td class='td_style'>".$number."</td>
                                    <td class='td_style'>".$order_date."</td>
                                    <td class='td_style'>".($result['id'])."</td>
                                    <td class='td_style'>".($result['client_name'])."</td>
                                    <td class='td_style'>".($result['phone'])."</td>
                                    <td class='td_style'>".$delivery_date."</td>
                                    <td class='td_style'>".($result['progress_suit'])."</td>                                                
                                    <td class='td_style'>
                                        <a class='me-3 edit_btn' href='/SM-IMS/testTMS/edit_invoice.php?id=$result[id]'>
                                            <img src='assets/img/icons/dash2.svg' alt='img'>
                                        </a>
                                        <button type='button' class='btn btn-danger delete_btn' style='background:transparent; border:none;' value='".$result['id']."'>
                                            <img src='assets/img/icons/delete.svg' alt='img'>
                                        </button>
                                    </td>
                                </tr>
                            ";                                               
                            $number++;
                        }
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fetch vendor Name for Gatepass generation (final code to fetch vendor name in gatepass modal form but action "fetch_vendor_name" is as used in above ajax of "#vendor_nmae"
$(document).on('keyup', '#gatePass_vendor', function(e) {
    e.preventDefault();
    var gatePass_vendor = $(this).val().trim();

    if (gatePass_vendor != "") {
        $.ajax({
            url: "core.php",
            method: "POST",
            data: {
                action: "gatePass_vendor_name",
                search_gatePass_vendor_name: gatePass_vendor
            },
            success: function(data) {
                // console.log("Raw data received:", data); // Log the raw data
                data = JSON.parse(data); // Parse JSON response
                console.log("Parsed data:", data); // Log the parsed data


                if (data.error) {
                    $("#error_message").html(data.error).slideDown();
                } else {
                    let vendor_List = '';
                    $.each(data, function(index, emp) {
                        vendor_List +=
                            `<a class="list-group-item list-group-item-action" data-id="${emp.id}">${emp.gate_vendor_name}</a>`; ///vendor_name is the property which is defined in core.php in JSON returning data
                    });
                    $("#gatePass_list").html(vendor_List);
                    $("#error_message").html("").slideUp();
                    // console.log(emp.id);
                }
            },
        })
    } else {
        $("#gatePass_list").html("");
    }
});

// Get vendor name for gatepass (pending)
// $(document).on("click", "a.list-group-item", function() {
//     var name = $(this).html();
//     // var id = $(this).data('id');
//     // console.log(id);

//     $("#gatePass_vendor").val(name);
//     // $("#emp_id").val(id);
//     $("#gatePass_list").html("");
//     $("#error_message").html("").slideUp();
// });



// gatepass generation pdf file ajax
$('#generate_gate_pass').click(function(e) {
    e.preventDefault();

    // Serialize form data
    var formData = new FormData($('#gatePass')[0]);
    formData.set('action', 'gatePass_pdf_file_by_ajax');

    $.ajax({
        type: 'POST',
        url: 'core.php',
        data: formData,
        catch: false,
        processData: false,
        contentType: false,

        success: function(response) {
            console.log("Response received:", response); // Log the response for debugging

            if (response.trim() !== '') {
                // it'll remove all backslashes from the generated pdf file link like this {"success":true,"pdfUrl":".\/uploads\/certificate_362.pdf"}
                var trimdata = response.replace(/\\/g, '');
                //now backslashes removed and parse the JSON
                var resp = JSON.parse(trimdata); // Parse the JSON response

                console.log("Trimed response received:", resp); // Log the response for debugging
                // Check if the response indicates success
                if (resp.success) {
                    var pdfUrl = resp.pdfUrl;

                    $("#success_message").html(
                        "From data Uploaded Successfully & Generate PDF file").slideDown();

                    $("#error_message").slideUp();

                    // Create blob link to download
                    const link = document.createElement('a');
                    link.href = pdfUrl;
                    link.setAttribute('download', pdfUrl);

                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    $("#error_message").html("All fields are required").slideDown();
                    $("#success_message").slideUp();

                    // console.error("Error in response:", resp); // Log response details for debugging
                    // Handle error response
                    // alert("An error occurred while generating the PDF. Please try again later.");
                }
            } else {
                $("#error_message").html("Empty response received").slideDown();
                $("#success_message").slideUp();
                // console.error("Empty response received"); // Log empty response error for debugging
                // Handle empty response
                alert(
                    "An unexpected empty response was received from the server. Please try again later."
                    );
            }
            // THIS'll empty form after submission form data into db
            $('#gatePass')[0].reset();
        }

    });

});
</script>
<!-- Then initialize DataTables -->
<!-- <script>
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        columnDefs: [
            { orderable: false, targets: [7] } // Make action column (8th) non-orderable
        ]
    });
});
</script> -->

<script>
$(document).ready(function() {
    // Check if DataTable is already initialized
    if (!$.fn.DataTable.isDataTable('.datatable')) {
        $('.datatable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            columnDefs: [{
                    orderable: false,
                    targets: [7]
                } // Make action column non-orderable
            ]
        });
    }
});
</script>

<?php include('assets/includes/footer.php'); ?>