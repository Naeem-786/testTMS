<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>
<?php
    $showAlert=false;
    $showError=false;
    // session_start();
    // Get order ID from URL
    $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Fetch client data from addneworder table and display in edit_incoive.php form to edit the details
    $query = "SELECT * FROM addneworder WHERE id = $order_id";
    $db_table_data = mysqli_query($conn, $query);

    if(!$db_table_data) {
        die("Query failed: " . mysqli_error($conn));
    }

    $result = mysqli_fetch_assoc($db_table_data);
    // Assign values if record exists
    if ($result) {
        $client_name = $result['client_name'];
        $cnic = $result['cnic'];
        $stitching_type = $result['stitching_type'];
        $delivery_type = $result['delivery_type'];
        $product = $result['product'];
        $progress_suit = $result['progress_suit'];
        // Add other fields as needed
    }
    // END SELECT QUERY, Fetch client data from addneworder table and display in edit_incoive.php form to edit the details

    // fetch the updated value from the Form and store data into addneworder table using UPDATE QUERY
    if(isset($_POST['final_bill'])) {
        if(($_POST['progress_suit']) && trim($_POST['progress_suit'])!=='')
        {
      
            // Sanitize all inputs
            $order_id = (int)$_POST['order_id'];
            var_dump($order_id);
            $progress_suit = mysqli_real_escape_string($conn, $_POST['progress_suit']); 

            $sql = "UPDATE `addneworder` SET
                    `progress_suit` = '$progress_suit'
                    
                    WHERE id = $order_id";
            if(mysqli_query($conn, $sql)) {
                // $_SESSION['success'] = "Record updated successfully!";
                // Set success message in session
                $_SESSION['success'] = "Order #$order_id updated successfully!";
                // $showAlert = "Order # $order_id is updated Successfully ";               
                ?>
                    <meta http-equiv="refresh" content="0; url=http://localhost/SM-IMS/manage_order.php" />
                    <!-- this meta tag will refresh page after 0 sec, CONTENT declare time of refresh,  -->
                <?php
            }
        } 
        else {
            echo "<script>alert('Something went wrong, Product Status is not updated')</script>" .mysqli_error($conn);
            ?>
                <meta http-equiv="refresh" content="0; url=http://localhost/SM-IMS/manage_order.php" />
            <?php 
        }
    } 
    // else {
    //         echo "<script>alert('Something went wrong, Product is not updated')</script>" .mysqli_error($conn);
    
    //         <meta http-equiv="refresh" content="0; url=http://localhost/SM-IMS/manage_order.php" /> -->
          
    // }
    
    //END UPDATE QUERY, fetch the updated value from the Form and store data into addneworder table using UPDATE QUERY
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

                    <form id="update_order_form" style="display: flex; flex-wrap: wrap;" method="POST"
                        onsubmit="return validation()">
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                        <?php endif; ?>
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <!-- suit no, -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Suit No.</label>
                                <input type="text" id="suit_no" name="suit_no" value="<?php echo $result['id'] ; ?>"
                                    readonly>
                            </div>
                        </div>
                        <!-- client name -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="client_name" name="client_name"
                                    value="<?php echo $result['client_name'] ; ?>" readonly>
                                <span id="client_nameErr" style="color:red;"></span>

                            </div>
                        </div>
                            <!-- cnic -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>CNIC</label>
                                <input type="text" id="cnic" name="cnic" value="<?php echo $result['cnic'] ; ?>"readonly>
                                <span id="cnicErr" style="color:red;"></span>

                            </div>
                        </div>
                            <!-- phone -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Phone</label>
                                <input type="text" id="phone" name="phone" value="<?php echo $result['phone'] ; ?>" readonly>
                                <span id="phoneErr" style="color:red;"></span>

                            </div>
                        </div>
                            <!-- stitching type -->
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
                            <!-- delivery date -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Delivery Date</label>
                                <input type="date" id="delivery_date" name="delivery_date"
                                    value="<?php echo $result['delivery_date'] ; ?>" readonly>
                                <span id="delivery_dateErr" style="color:red;"></span>

                            </div>
                        </div>
                            <!-- delivery type -->
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
                            <!-- product -->
                        <!-- <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Product</label>

                                <select id="product" name="product">
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
                        </div>                        -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Product</label>
                                <input type="text" id="product" name="product" class="form-control" 
                                    value="<?php echo $result['product']; ?>" >

                                <!-- <select id="product" name="product">
                                    <option value="full_suit" selected
                                        <?php echo ($product == 'full_suit') ? 'selected' : ''; ?>>Full Suit
                                    </option>
                                    <option value="only_qameez"
                                        <?php echo ($product == 'only_qameez') ? 'selected' : ''; ?>>Only Qameez
                                    </option>
                                    <option value="only_shalwar"
                                        <?php echo ($product == 'only_shalwar') ? 'selected' : ''; ?>>Only Shalwar
                                    </option>

                                </select> -->
                            </div>
                        </div>                       
                        <!-- Rate Field -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Rate</label>
                                <input type="text" id="rate" name="rate" class="form-control" 
                                    value="<?php echo $result['rate']; ?>" readonly>
                            </div>
                        </div>                        
                        <!-- quantity -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Quantity</label>
                                <input type="text" id="quantity" name="quantity"
                                    value="<?php echo $result['quantity'] ; ?>" readonly>
                                <span id="quantityErr" style="color:red;"></span>

                            </div>
                        </div>
                        <!-- sub total -->
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
                                <span id="paid_amountErr" style="color:red;"></span>

                            </div>
                        </div>
                        <!-- due amount -->
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group mx-2">
                                <label>Due Amount</label>
                                <input type="text" id="due_amount" name="due_amount"
                                    value="<?php echo $result['due_amount'] ; ?>" readonly>
                            </div>
                        </div>
                            <!-- status -->
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

                                    <!-- <option value="delivered"
                                        <?php echo ($progress_suit == 'delivered') ? 'selected' : ''; ?>>Delivered
                                    </option>
                                    <option value="not_delivered"
                                        <?php echo ($progress_suit == 'not_delivered') ? 'selected' : ''; ?>>Not
                                        Delivered</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <input class="btn btn-submit me-2" type="submit" id="final_bill" name="final_bill"
                                value="Update Status" style="margin-top: 1.7rem;padding: 10px;width: 100%;">
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
document.getElementById("update_order_form").onsubmit = function(event) {
    let isValid = true;

    var client_name = document.getElementById("client_name").value;
    var cnic = document.getElementById("cnic").value;
    var phoneNumber = document.getElementById("phone").value;
    var deliveryDate = document.getElementById("delivery_date").value;
    var quantity = document.getElementById("quantity").value;
    var advance = document.getElementById("paid_amount").value;

    isValid = validate_client_name(client_name) && isValid;
    isValid = validateCNIC(cnic) && isValid;
    isValid = validatePhoneNumber(phoneNumber) && isValid;
    isValid = validateDeliveryDate(deliveryDate) && isValid;
    isValid = validatequantity(quantity) && isValid;
    isValid = validatePaid_amount(advance) && isValid;

    if (!isValid) {
        event.preventDefault(); // Stop form submission if validation fails
    }
};

function validate_client_name(client_name) {
    var client_nameErr = document.getElementById("client_nameErr");
    if (client_name.trim() === "") {
        client_nameErr.innerHTML = "Please enter the Client Name";
        return false;
    }
    if (!/^[a-zA-Z0-9 ]+$/.test(client_name)) {
        client_nameErr.innerHTML = "Only letters & numbers are allowed";
        return false;
    }
    client_nameErr.innerHTML = "";
    return true;
}

function validateCNIC(cnic) {
    const cnicErr = document.getElementById("cnicErr");

    // Remove any non-digit characters if accidentally entered
    const cleanCNIC = cnic.replace(/\D/g, '');

    // Validate exactly 13 digits and only numbers
    if (/^\d{13}$/.test(cleanCNIC)) {
        cnicErr.innerHTML = "";
        return true;
    } else {
        cnicErr.innerHTML = "CNIC must be exactly 13 digits (numbers only)";
        return false;
    }
}

function validatePhoneNumber(phoneNumber) {
    const phoneRegex = /^0\d{10}$/;
    const phoneErr = document.getElementById("phoneErr");

    if (phoneRegex.test(phoneNumber)) {
        phoneErr.innerHTML = "";
        return true;
    } else {
        phoneErr.innerHTML = "Invalid phone number. Must start with 0 and be exactly 10 digits.";
        return false;
    }
}
// delivery date must be less than order date
function validateDeliveryDate() {
    const deliveryDateInput = document.getElementById("delivery_date");
    const deliveryDateErr = document.getElementById("delivery_dateErr") || deliveryDateInput.nextElementSibling;

    // Create error span if it doesn't exist
    if (!deliveryDateErr || !deliveryDateErr.matches('.error')) {
        deliveryDateInput.insertAdjacentHTML('afterend', '<span class="error" style="color:red;"></span>');
    }

    const errorSpan = deliveryDateInput.nextElementSibling;
    const selectedDate = new Date(deliveryDateInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time to compare dates only

    if (!deliveryDateInput.value) {
        errorSpan.textContent = "Delivery date is required";
        return false;
    } else if (selectedDate <= today) {
        errorSpan.textContent = "Delivery date must be after today";
        return false;
    }

    errorSpan.textContent = "";
    return true;
}

function validatequantity(quantity) {
    const quantityRegex = /^\d+$/;
    const quantityErr = document.getElementById("quantityErr");

    if (quantityRegex.test(quantity)) {
        quantityErr.innerHTML = "";
        return true;
    } else {
        quantityErr.innerHTML = "Only numbers are allowed";
        return false;
    }
}

function validatePaid_amount(advance) {
    const paid_amountRegex = /^\d+$/;
    const paid_amountErr = document.getElementById("paid_amountErr");

    if (paid_amountRegex.test(advance)) {
        paid_amountErr.innerHTML = "";
        return true;
    } else {
        paid_amountErr.innerHTML = "Only numbers are allowed";
        return false;
    }
}


$(document).ready(function() {
    
    function calculateBill() {
        var quantity = parseFloat($("#quantity").val()) || 0;
        var rate = parseFloat($("#rate").val()) || 0;
        var paidAmount = parseFloat($("#paid_amount").val()) || 0;

        var subTotal = quantity * rate; // Calculate Sub Total
        var dueAmount = subTotal - paidAmount; // Calculate Due Amount

        $("#sub_total").val(subTotal.toFixed(2)); // Update Sub Total Field
        $("#due_amount").val(dueAmount.toFixed(2)); // Update Due Amount Field
    }

    // Input Validations
    $("#quantity, #paid_amount").on("blur", function () {
        var value = parseFloat($(this).val());

        if ($(this).attr("id") == "paid_amount" && value === 0) {
            $(this).next("span").text(""); // No error if Paid Amount = 0
        } else if (isNaN(value) || value < 0) {
            $(this).next("span").text("Invalid input");
        } else {
            $(this).next("span").text("");
        }
    });

    // Auto Calculation on Input Change
    $("#quantity, #rate, #paid_amount").on("input", function () {
        calculateBill();
    });

    // Form Submission Condition
    $("#myForm").on("submit", function (e) {
        var paidAmount = parseFloat($("#paid_amount").val()) || 0;
        var quantity = parseFloat($("#quantity").val()) || 0;

        if ((isNaN(quantity) || quantity <= 0) || (isNaN(paidAmount) || paidAmount < 0)) {
            alert("Please enter valid values before submitting!");
            e.preventDefault();
        } else {
            return true; // Allow form submission
        }
    });

    // Initialize Calculation on Page Load (For Editing Mode)
    calculateBill();
    // readonly or disabled or prevent to change the dropdown value against these fields
    document.querySelectorAll("#stitching_type, #delivery_type, #product").forEach(function(element) {
        element.addEventListener("mousedown", function(event) {
            event.preventDefault(); // Prevent selection change
        });
    });

    // Call Calculation on Page Load (if editing an order)
    calculateBill();


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