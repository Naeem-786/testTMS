<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>


<div class="page-wrapper">
    <div class="content">
        <div class="container">


            <div class="row">
                <div class="page-header">
                    <div class="col-lg-6">
                        <div class="page-title">
                            <h4>Find Your Order </h4>
                            <h6>Finalize Client Order</h6>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form method="POST">
                            <div class="page-title d-flex" style="justify-content: end; align-items: center;}">
                                <h4>Suit No: </h4>
                                <div class="form-group m-0">
                                    <input type="text" id="suit_no" name="suit_no">

                                </div>
                                <div class="form-grouph">
                                    <input class="btn btn-submit" type="submit" id="find_suit" name="find_suit"
                                        value="Find Suit" style="margin-left: 0.7rem; padding: 8px 10px;">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    $showError = false;
                    $showAlert = false;
                        if ($showError) {
                            echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> ' . $showError . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive" id="raw_category">
                        <h2 class="text-center font-weight-bold h2_heading">Your Searched Result</h2>

                        <table id="myTable" class="table  datanew">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Order Dated</th>
                                    <th>Suit No.</th>
                                    <th>Name</th>
                                    <th>Whatsapp Number</th>
                                    <th>Delivery Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $suit_no = '';
                                        $client_name = '';

                                        if(isset($_POST['find_suit'])) {
                                            // Get and sanitize inputs
                                            $suit_no = isset($_POST['suit_no']) ? mysqli_real_escape_string($conn, trim($_POST['suit_no'])) : '';
                                            $client_name = isset($_POST['client_name']) ? mysqli_real_escape_string($conn, trim($_POST['client_name'])) : '';
                                            
                                            // Proceed if either field has value
                                            // if($suit_no !== '' || $client_name !== '') {
                                                // $sql = "SELECT * FROM addneworder WHERE `id` = '$suit_no' LIMIT 1 OR `client_name` LIKE '%$client_name%'";
                                                
                                                if (is_numeric($suit_no)) {
                                                    // Search by suit_no (only one record)
                                                    $sql = "SELECT * FROM addneworder WHERE `id` = '$suit_no' LIMIT 1";
                                                } else  {
                                                    // Search by client_name (all matching records)
                                                    $sql = "SELECT * FROM addneworder WHERE `client_name` LIKE '%$suit_no%'";
                                                } 
                                                $result = mysqli_query($conn, $sql);
                                                
                                                if ($result === false) {
                                                    // die("SQL Error: " . mysqli_error($conn));
                                                    // die($_SESSION['error'] = "SQL Error: " . mysqli_error($conn));
                                                    $showError = "SQL Error: " . mysqli_error($conn);
                                                    die($showError);
                                                }
        
                                                $total_rows = mysqli_num_rows($result);
                                                // var_dump($total_rows);
                                                // exit;
                                                
                                                                                                                           
                                                if($total_rows > 0) {
                                                    $number = 1;
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        // $order_date = date("d-m-Y", strtotime($result['date']));
                                                        // $delivery_date = date("d-m-Y", strtotime($result['delivery_date']));
                                                        echo "
                                                        <tr>
                                                            <td class='td_style'>".htmlspecialchars($number)."</td>
                                                            <td class='td_style'>".htmlspecialchars($row['date'])."</td>
                                                            <td class='td_style'>".htmlspecialchars($row['id'])."</td>
                                                            <td class='td_style'>".htmlspecialchars($row['client_name'])."</td>
                                                            <td class='td_style'>".htmlspecialchars($row['phone'])."</td>
                                                            <td class='td_style'>".htmlspecialchars($row['delivery_date'])."</td>
                                                            <td class='td_style'>".htmlspecialchars($row['progress_suit'])."</td>
                                                            <td>
                                                                <a class='me-3 edit_btn' href='/SM-IMS/testTMS/pay_invoice.php?id=".urlencode($row['id'])."'><img src='assets/img/icons/dash2.svg' alt='img'></a>
                                                                <button type='button' class='btn btn-danger delete_btn' style='background:transparent; border:none;' value='".htmlspecialchars($row['id'])."'>
                                                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                                                </button>
                                                            </td>
                                                        </tr>";
                                                        $number++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='8' class='text-center' style='color:red;'>No Suit Booked against this Number</td></tr>";
                                                }
                                            // }
                                        }   
                                ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div id="success_message"></div>
            <div id="error_message"></div>
        </div>
    </div>
</div>
</div>

<script>
// <!-- ajax call to add new category -->

$(document).ready(function() {

    // delete new category code through sweetalert ajax
    $('.table-responsive').on('click', '.delete_btn', function(e) {
        e.preventDefault();
        var id = $(this).val();
        // console.log(id);

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        method: "POST",
                        url: "core.php",
                        data: {
                            action: "delete_order",
                            stitch_btn: id,
                        },
                        success: function(response) {
                            if (response == 200) {
                                swal("Success", "Record Deleted Successfully!",
                                    "success");
                                // Destroy the DataTable instance
                                // $('#myTable').DataTable().destroy();
                                // Reload the content and reinitialize DataTable
                                $("#new_category_code").load(location.href +
                                    " #new_category_code",
                                    function() {
                                        $('#myTable').DataTable();
                                    });
                            } else if (response == 500) {
                                swal("Error!", "Record Not Deleted!", "error");
                            }
                        }
                    });
                }
            });
    });

    // Data Table load through .load funtion, if Previous & Next button for paginaiton doesn't appear use this load method and if shows warning that can't reintialize datatable, use it.   

    $("#new_category_code").load(location.href + " #new_category_code", function() {
        $('#myTable').DataTable();
    });



});
</script>

<?php include('assets/includes/footer.php'); ?>