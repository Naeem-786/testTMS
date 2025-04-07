<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>

<!-- insert cloth record through modal -->
<?php
    $showError = false;
    $showAlert = false;

?>
<div class="page-wrapper">
    <div class="content">
        <?php
             if ($showError) {
                echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ' . $showError . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
            }
        ?>
        <div class="page-header">
            <div class="page-title">
                <h4>Client Detail</h4>
            </div>

            <div class="page-btn">
                <!-- modal initializing button -->
                <button type="button" class="btn btn-added"> <img
                        src="assets/img/icons/plus.svg" class="me-1" alt="img">
                    <a href="addneworder.php">Add Invoice</a>
                </button>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <?php
                     // Display success message if exists, this session message is fetched from edit_invoice.php page
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                        unset($_SESSION['success']);
                    }

                    // Display error message if exists
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                        unset($_SESSION['error']);
                    }
                ?>
                <div class="table-responsive" id="raw_category">
                    

                    <table id="myTable" class="table  datanew">
                        <thead>
                            <?php
                                // Query to count total orders
                                $count_query = "SELECT COUNT(*) AS total_orders FROM addneworder WHERE progress_suit IN ('cut_unit', 'cutting_unit', 'stitching_unit')";
                                $count_result = mysqli_query($conn, $count_query);
                                $count_row = mysqli_fetch_assoc($count_result);
                                $total_orders = $count_row['total_orders']; // Get the total count
                            ?>
                            <h2 class="text-center h2_heading"><?php echo $total_orders?>:Orders in Process</h2>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Order Dated</th>
                                <th>Suit No.</th>
                                <th>Name</th>
                                <th>Whatsapp Number</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <!-- <th>Paymenst</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                               
                                $query = "SELECT * FROM addneworder WHERE progress_suit IN ('cut_unit', 'cutting_unit', 'stitching_unit') ORDER BY date DESC";                              
                                
                                $db_table_data = mysqli_query($conn, $query);
                                $total_rows = mysqli_num_rows($db_table_data);

                                if($total_rows >0){
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
                                                    <td>
                                                    <a class='me-3 edit_btn' href='/SM-IMS/edit_invoice.php?id=$result[id]' ><img src='assets/img/icons/edit.svg' alt='img'></a>
                                                    <a class='me-3 edit_btn' href='/SM-IMS/pay_invoice.php?id=$result[id]' ><img src='assets/img/icons/dash2.svg' alt='img'></a>
                                                    <button type='button' class='btn btn-danger delete_btn' style='background:transparent; border:none;' value=".($result['id'])." ><img src='assets/img/icons/delete.svg' alt='img'></button>
                                                    </td>
                                                    
                                                    </tr>
                                                    ";
                                                    // <td class='td_style'>".($result['pay_status'])."</td>                                                
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

$(document).ready(function() {

    // delete Raw category code through sweetalert ajax
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
                            action: "manage_order_delete",
                            stitch_btn: id,
                        },
                        success: function(response) {
                            if (response == 200) {
                                swal("Success", "Record Deleted Successfully!", "success");
                                // Destroy the DataTable instance
                                // $('#myTable').DataTable().destroy();
                                // Reload the content and reinitialize DataTable
                                $("#raw_category").load(location.href + " #raw_category", function () {
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

    $("#raw_category").load(location.href + " #raw_category", function () {
        $('#myTable').DataTable();
    });

});
</script>
<?php include('assets/includes/footer.php'); ?>