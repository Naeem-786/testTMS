<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>
<?php include('./message.php'); ?>
<?php
$showAlert=false;
$showError=false;
    // it is used to fetch record from database and show in form
    $id=$_GET['id'];
    $query = "SELECT * FROM addneworder WHERE id= '$id' ";  //is this query first id after where clause is the db column name and second $id is variable name 
    $db_table_data= mysqli_query($conn, $query);
    
    $result = mysqli_fetch_assoc($db_table_data);

    // echo var_dump($result);
    // exit();
    if ($result> 0) {
        $stitching_type = $result['stitching_type'];
        $delivery_type = $result['delivery_type'];
        $product = $result['product'];
        $progress_suit = $result['progress_suit'];
        // echo var_dump($progress_suit);
        // exit();
        
    } else {
        echo $showError; // Default value if no record is found
    }

    // $conn->close(); // Close the database connection

    // php code for suit no searching
    if(isset($_POST['find_suit'])){
        if((isset($_POST['suit_no']) )
        && trim($_POST['suit_no']) !=='' ){
            $suit_no = $_POST['suit_no'];
            
            $find_suit = mysqli_query($conn, "SELECT * FROM addneworder WHERE suit_no ='$suit_no' LIMIT 1 ")
                or die(mysqli_error($conn));
        }
    } 
    
   

if(isset($_POST['final_bill'])){
    if(isset($_POST['suit_no'], $_POST['progress_suit'], $_POST['discount'],
        $_POST['paid_amount'], $_POST['grand_total']))
        {
            
        $suit_no = trim($_POST['suit_no']);
        $discount = $_POST['discount'];
        $advance = $_POST['paid_amount'];
        $grand_total = $_POST['grand_total'];
        $status = trim($_POST['progress_suit']);
        var_dump($status);

        // Rest of your processing code...
        $sql_payment = "INSERT INTO `payment_tbl` (`suit_id`,`discount`,`advance`,`grand_total`,`status`) VALUES ('$suit_no','$discount','$advance','$grand_total','$status')";
        $insert_payment = mysqli_query($conn, $sql_payment);

        if ($insert_payment) {
            $update_status = "UPDATE `addneworder` SET `progress_suit` = ? WHERE `id` = ?";
            $stmt2 = mysqli_prepare($conn, $update_status);
            mysqli_stmt_bind_param($stmt2, "si", $status, $suit_no);
            mysqli_stmt_execute($stmt2);
            mysqli_commit($conn);
            
            $_SESSION['success'] = "Order #$suit_no : Bill paid successfully!";
            // header("Location: ready_for_delivery.php");
            echo "<meta http-equiv='refresh' content='0; url=http://localhost/SM-IMS/ready_for_delivery.php' />";
            exit();
        } else {
            echo "<script>alert('Error: Bill not paid. " . mysqli_error($conn) . "');</script>";
            echo "<meta http-equiv='refresh' content='0; url=http://localhost/SM-IMS/ready_for_delivery.php' />";
            exit();
        }
    }else{
        $showError = "some fields are missing to put data" . mysqli_error($conn);
    }
}
?>


<div class="page-wrapper">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <div class="col-lg-6">
                        <div class="page-title">
                            <h4>Edit Invoice </h4>
                            <h6>Finalize Client Payment</h6>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- <div class="form-group" style="margin: 0;"> -->

                        <form method="POST">
                            <div class="page-title d-flex" style="justify-content: end; align-items: center;}">
                                <!-- style="margin-top: 0.7rem; padding: 8px 10px;" -->
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
            
                <?php
                if ($showAlert) {
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="padding: 1rem;">
                            <strong>Success!</strong> ' . htmlspecialchars($showAlert, ENT_QUOTES, 'UTF-8') . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    ';
                }
                if ($showError) {
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ' . htmlspecialchars($showError, ENT_QUOTES, 'UTF-8') . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    ';
                }
                ?>
                <div class="row">
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
                    <form id="category_form" style="display: flex; flex-wrap: wrap;" method="POST"
                        onsubmit="return validation()">
                        
                        <!-- suit no -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Suit No.</label>
                                <input type="text" id="suit_no" name="suit_no" value="<?php echo $result['id'] ; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="client_name" name="client_name"
                                    value="<?php echo $result['client_name'] ; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>CNIC</label>
                                <input type="text" id="cnic" name="cnic" value="<?php echo $result['cnic'] ; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Phone</label>
                                <input type="text" id="phone" name="phone" value="<?php echo $result['phone'] ; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Stitching Type</label>
                                <select id="stitching_type" name="stitching_type">
                                    <option value="simple" selected
                                        <?php echo ($stitching_type == 'simple') ? 'selected' : ''; ?>>Simple
                                    </option>
                                    <option value="design"
                                        <?php echo ($stitching_type == 'design') ? 'selected' : ''; ?>>Design
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Delivery Date</label>
                                <input type="date" id="delivery_date" name="delivery_date"
                                    value="<?php echo $result['delivery_date'] ; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Delivery Type</label>
                                <select id="delivery_type" name="delivery_type">
                                    <option value="regular" selected
                                        <?php echo ($delivery_type == 'regular') ? 'selected' : ''; ?>>Regular
                                    </option>
                                    <option value="urgent"
                                        <?php echo ($delivery_type == 'urgent') ? 'selected' : ''; ?>>Urgent
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Product</label>
                                <select id="product" name="product" readonly>
                                    <option value="full_suit" selected
                                        <?php echo ($product == 'full_suit') ? 'selected' : ''; ?>>Full Suit
                                    </option>
                                    <option value="only_qameez"
                                        <?php echo ($product == 'only_qameez') ? 'selected' : ''; ?>>Only Qameez
                                    </option>
                                    <option value="only_shalwar"
                                        <?php echo ($product == 'only_shalwar') ? 'selected' : ''; ?>>Only Shalwar
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Rate</label>
                                <input type="text" id="rate" name="rate" value="<?php echo $result['rate'] ; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Quantity</label>
                                <input type="text" id="quantity" name="quantity"
                                    value="<?php echo $result['quantity'] ; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Sub Total</label>
                                <input type="text" id="sub_total" name="sub_total"
                                    value="<?php echo $result['sub_total'] ; ?>" readonly>
                            </div>
                        </div>
                        <!-- advacne -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Advance</label>
                                <input type="text" id="paid_amount" name="paid_amount"
                                    value="<?php echo $result['paid_amount'] ; ?>" readonly>
                            </div>
                        </div>
                        <!-- deu amount -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Due Amount</label>
                                <input type="text" id="due_amount" name="due_amount"
                                    value="<?php echo $result['due_amount'] ; ?>" readonly>
                            </div>
                        </div>
                        <!-- discount -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Discount</label>
                                <input type="text" id="discount" name="discount">
                                <span id="discountErr" style="color:red;"></span>
                            </div>
                        </div>
                        <!-- grand total -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Grand Total</label>
                                <input type="text" id="grand_total" name="grand_total" readonly>

                            </div>
                        </div>
                        <!-- cash -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Cash</label>
                                <input type="text" id="enter_amount" name="enter_amount">
                                <span id="cashErr" style="color:red;"></span>
                            </div>
                        </div>
                        <!-- balance -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Balance</label>
                                <input type="text" id="balance" name="balance">

                            </div>
                        </div>
                        <!-- suit progress status -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Status</label>
                                <select id="progress_suit" name="progress_suit">
                                    <option value="cut_unit" selected
                                        <?php echo ($progress_suit == 'cut_unit') ? 'selected' : ''; ?>>Cutting Unit
                                    </option>
                                    <option value="stitching_unit"
                                        <?php echo ($progress_suit == 'stitching_unit') ? 'selected' : ''; ?>>
                                        Stitching Unit</option>
                                    <option value="ready_for_delivery"
                                        <?php echo ($progress_suit == 'ready_for_delivery') ? 'selected' : ''; ?>>
                                        Ready For Delivery</option>

                                    <option value="delivered"
                                        <?php echo ($progress_suit == 'delivered') ? 'selected' : ''; ?>>Delivered
                                    </option>
                                    <option value="not_delivered"
                                        <?php echo ($progress_suit == 'not_delivered') ? 'selected' : ''; ?>>Not
                                        Delivered</option>
                                </select>
                            </div>
                        </div>
                        <!-- final bill payment btn -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <input class="btn btn-submit me-2" type="submit" id="final_bill" name="final_bill"
                                value="Pay Bill">
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

<script>
// {/* // <!-- ajax call to validate discount and cash payment amount --> */}
document.getElementById("category_form").onsubmit = function(event) {
    let isValid = true;
    // $("#discount").val("0");
    // var discount = document.getElementById("discount").value;

    // console.log(discount)
    var enter_amount = document.getElementById("enter_amount").value;

    // isValid = validate_discount(discount) && isValid;
    isValid = validate_enter_amount(enter_amount) && isValid;

    if (!isValid) {
        event.preventDefault(); // Stop form submission if validation fails
    }
}

function validate_enter_amount(enter_amount) {
    var cashErr = document.getElementById("cashErr");
    if (enter_amount.trim() === "") {
        cashErr.innerHTML = "Please enter valid amount";
        return false;
    }
    if (!/^[0-9 ]+$/.test(enter_amount)) {
        cashErr.innerHTML = "Only numbers are allowed";
        return false;
    }
    cashErr.innerHTML = "";
    return true;
}



// Bill payment delivery status 
document.addEventListener("DOMContentLoaded", function() {
    var finalBillButton = document.getElementById("final_bill");
    var progressSuit = document.getElementById("progress_suit");
    var errorMessage = document.getElementById("error_message");

    var cash_amount = document.getElementById("enter_amount");
    var grand_total = document.getElementById("grand_total");
    console.log(cash_amount);

    // Check if the status is already "delivered" when fetching the record
    if (progressSuit.value === "delivered") {
        finalBillButton.disabled = true; // Disable the Pay Bill button
    }

    finalBillButton.addEventListener("click", function(event) {
        var status = progressSuit.value;
        var cash_amount_payment_status = parseFloat(cash_amount.value); // assuming this is an input field
        var grandTotal = parseFloat(grand_total.value); // you need to define this
        
        let error = "";
        
        if (status !== "delivered") {
            error = "❌ Error: Status must be 'Delivered' to proceed!";
        } 
        else if (cash_amount_payment_status < grandTotal) {
            error = "❌ Error: Cash amount must be greater than or equal to Grand Total to pay Bill!";
        }
        
        if (error) {
            event.preventDefault();
            errorMessage.innerHTML = error;
            $(errorMessage).slideDown();
        } else {
            errorMessage.innerHTML = "";
            $(errorMessage).slideUp();
        }
    });

    // readonly or disabled or prevent to change the dropdown value against these fields
    document.querySelectorAll("#stitching_type, #delivery_type, #product").forEach(function(element) {
        element.addEventListener("mousedown", function(event) {
            event.preventDefault(); // Prevent selection change
        });
    });

});

$(document).ready(function() {
    // Initialize with due amount as grand total
    const dueAmount = parseFloat($('#due_amount').val()) || 0;
    $('#grand_total').val(dueAmount.toFixed(2));
    $('#balance').val('0.00');

    // Calculate both grand total and balance
    function calculateAll() {
        const dueAmount = parseFloat($('#due_amount').val()) || 0;
        const discountInput = $('#discount').val().trim();
        const cashInput = $('#enter_amount').val().trim();
        
        // Reset errors
        $('#discountErr').text('');
        $('#cashErr').text('');

        // 1. Handle discount (optional field)
        let grandTotal = dueAmount;
        if (discountInput !== '') {
            const discount = parseFloat(discountInput);

            if (isNaN(discount)) {
                $('#discountErr').text("Please enter a valid number");
                return false;
            } else if (discount < 0) {
                $('#discountErr').text("Discount cannot be negative");
                return false;
            } else if (discount > dueAmount) {
                $('#discountErr').text("Discount cannot exceed due amount");
                return false;
            } else {
                grandTotal = dueAmount - discount;
            }
        }
        $('#grand_total').val(grandTotal.toFixed(2));

        // 2. Handle payment (required if grandTotal > 0)
        let paymentValid = true;
        if (cashInput !== '') {
            const cash = parseFloat(cashInput);
            
            if (isNaN(cash)) {
                $('#cashErr').text("Please enter a valid number");
                paymentValid = false;
            } else if (cash < 0) {
                $('#cashErr').text("Payment cannot be negative");
                paymentValid = false;
            } else if (cash < grandTotal) {
                $('#cashErr').text("❌ Payment insufficient (must cover grand total)");
                paymentValid = false;
            }
            
            const balance = cash - grandTotal;
            $('#balance').val(balance.toFixed(2));
        } else {
            // If no payment entered but amount is due
            if (grandTotal > 0) {
                $('#cashErr').text("❌ Payment required");
                paymentValid = false;
            }
            $('#balance').val('0.00');
        }
        // } else {
        //     // If no payment entered but amount is due
        //     if (grandTotal > 0) {
        //         $('#cashErr').text("❌ Payment required");
        //         paymentValid = false;
        //     }
        //     $('#balance').val('0.00');
        // }

        return paymentValid;
    }

    // Real-time calculation
    $('#discount, #enter_amount').on('input', calculateAll);

    // Form submission
    $('#billForm').on('submit', function(e) {
        if (!calculateAll()) {
            e.preventDefault();
        }
    });
});

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