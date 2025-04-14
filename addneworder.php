<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>

<?php
    $showAlert=false;
    $showError=false;

if (isset($_POST['add_new_order'])) {
    $requiredFields = ['client_name', 'cnic', 'phone', 'stitching_type', 'delivery_date', 'delivery_type', 'product', 'rate', 'quantity', 'sub_total', 'progress_suit'];
    $isValid = true;

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $isValid = false;
            break;
        }
    }

    // Allow `paid_amount` and `due_amount` to be optional or `0`
    $paid_amount = isset($_POST['paid_amount']) ? trim($_POST['paid_amount']) : '0';
    $due_amount = isset($_POST['due_amount']) ? trim($_POST['due_amount']) : '0';

    if ($isValid) {
        // Proceed with inserting data
        $client_name = $_POST['client_name'];
        $cnic = $_POST['cnic'];
        $phone = $_POST['phone'];
        $stitching_type = $_POST['stitching_type'];
        $delivery_date = $_POST['delivery_date'];
        $delivery_type = $_POST['delivery_type'];
        $product = $_POST['product'];
        $rate = $_POST['rate'];
        $quantity = $_POST['quantity'];
        $sub_total = $_POST['sub_total'];
        $progress_suit = $_POST['progress_suit'];

        $sql = "INSERT INTO `addneworder` (`client_name`, `cnic`, `phone`, `stitching_type`, `delivery_date`, `delivery_type`, `product`, `rate`, `quantity`, `sub_total`, `paid_amount`, `due_amount`, `progress_suit`) 
                VALUES ('$client_name', '$cnic', '$phone', '$stitching_type', '$delivery_date', '$delivery_type', '$product', '$rate', '$quantity', '$sub_total', '$paid_amount', '$due_amount', '$progress_suit')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $showAlert = "Client entered successfully";
        } else {
            $showError = "Record not Entered <br> " . mysqli_error($conn);
        }
    } else {
        $showError = "Please fill in all required fields.";
    }
}
?>



<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add New Order </h4>
                <h6>Add New Client's Information</h6>
            </div>


            <?php
             if ($showAlert) {
                    echo '
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Success!</strong> ' . $showAlert . '
                    </div>
                        
                    ';
                }
                if ($showError) {
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 1rem;width: 50%;">
                            <strong>Error!</strong> ' . $showError . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    ';
                }
            ?>

        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <form id="order_form" style="display: flex; flex-wrap: wrap;" method="POST"
                            onsubmit="return validation()">
                            <!-- //onsubmit="return validation()" -->
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">

                                    <label>Name</label>
                                    <input type="text" id="client_name" name="client_name">
                                    <span id="client_nameErr" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>CNIC</label>
                                    <input type="text" id="cnic" name="cnic" value="">
                                    <span id="cnicErr" style="color:red;"></span>

                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Whatsapp Number</label>
                                    <input type="text" id="phone" name="phone" value="">
                                    <span id="phoneErr" style="color:red;"></span>

                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Stitching Type</label>
                                    <select id="stitching_type" name="stitching_type">
                                        <option value="simple" selected>Simple</option>
                                        <option value="design">Design</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Delivery Date</label>
                                    <input type="date" id="delivery_date" name="delivery_date">
                                    <span id="delivery_dateErr" style="color:red;"></span>

                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Delivery Type</label>
                                    <select id="delivery_type" name="delivery_type">
                                        <option value="regular" selected>Regular</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Product</label>
                                    <select id="product" name="product">
                                        <option value="">Select Product</option>
                                        <!-- Options will be added dynamically -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Rate</label>
                                    <input type="text" id="rate" name="rate" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Quantity</label>
                                    <input type="text" id="quantity" name="quantity">
                                    <span id="quantityErr" style="color:red;"></span>

                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Sub Total</label>
                                    <input type="text" id="sub_total" name="sub_total">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Advance</label>
                                    <input type="text" id="paid_amount" name="paid_amount">
                                    <span id="paid_amountErr" style="color:red;"></span>

                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Due Amount</label>
                                    <input type="text" id="due_amount" name="due_amount">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group mx-2">
                                    <label>Status</label>
                                    <!-- <input type="text" id="pay_type" name="pay_type"> -->
                                    <select id="progress_suit" name="progress_suit">
                                        <option value="cutting_unit" selected>Cutting Unit</option>
                                        <option value="stitching_unit">Stitching Unit</option>
                                        <option value="ready_for_delivery">Ready For Delivery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <input class="btn btn-submit me-2" type="submit" id="add_new_order" name="add_new_order"
                                    value="Add Order">
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
document.getElementById("order_form").onsubmit = function(event) {
    let isValid = true;

    var client_name = document.getElementById("client_name").value;
    var cnic = document.getElementById("cnic").value;
    var phoneNumber = document.getElementById("phone").value;
    var deliveryDate = document.getElementById("delivery_date").value;
    var quantity = document.getElementById("quantity").value;

    // console.log(quantity);
    // var advance = document.getElementById("paid_amount").value;

    isValid = validate_client_name(client_name) && isValid;
    isValid = validateCNIC(cnic) && isValid;
    isValid = validatePhoneNumber(phoneNumber) && isValid;
    isValid = validateDeliveryDate(deliveryDate) && isValid;
    isValid = validatequantity(quantity) && isValid;

    // Validate Advance field
    if (!calculatePaidAmount()) {
        console.log("Validation failed");
        isValid = false;
        // event.preventDefault(); // Stop form submission if validation fails

    }

    if (!isValid) {
        // console.log("Validation failed");
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
//If delivery date is after 2 days from current day or one day or currrent day, the suit which has delivery data match to this condition will appear in the red area.
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
    const quantityErr = document.getElementById("quantityErr");
    quantityErr.innerHTML = ""; // Reset error first

    // Trim and check if the input is empty
    if (!quantity || quantity.trim() === "") {
        quantityErr.innerHTML = "Please enter a valid quantity";
        return false;
    }

    // Parse the quantity as a float
    const parsedQuantity = parseFloat(quantity);
    // console.log("parsedQuantity");
    // Check if the parsed value is a valid number
    if (isNaN(parsedQuantity)) {
        quantityErr.innerHTML = "Only numbers are allowed";
        return false;
    }

    // Check if the quantity is greater than 0
    if (parsedQuantity <= 0) {
        quantityErr.innerHTML = "Quantity must be greater than 0";
        return false;
    }

    // If all checks pass, return true
    return true;
}

function calculatePaidAmount() {
    let subtotal = parseFloat($("#sub_total").val()) || 0; // Get subtotal, default to 0 if empty
    let paidAmount = parseFloat($("#paid_amount").val()) || 0; // Get advance amount, default to 0 if empty
    let paidAmountInput = $("#paid_amount").val().trim(); // Get raw input value
    let paidAmountErr = $('#paid_amountErr'); // Error span for advance field

    // Reset errors
    paidAmountErr.text('');

    // Validate the Advance field
    // If the field is not empty, validate the input
    if (paidAmountInput !== '') {
        if (isNaN(paidAmount)) {
            paidAmountErr.text("Please enter a valid number");
            return false;
        }

        if (paidAmount < 0) {
            paidAmountErr.text("Advance cannot be negative");
            return false;
        }

        if (paidAmount > subtotal) {
            paidAmountErr.text("Advance cannot exceed subtotal");
            return false;
        }
    }

    // Calculate due amount
    let dueAmount = subtotal - paidAmount;
    console.log("Due Amount:", dueAmount);

    $("#due_amount").val(dueAmount.toFixed(2));
    return true;
}

// Attach the function to the input event of the Advance field
$("#paid_amount").on("input", function() {
    calculatePaidAmount();
});


$(document).ready(function() {

    $("#category_form").submit(function(event) {
        let isValid = true;

        let quantity = $("#quantity").val().trim();
        // let paid_amount = $("#paid_amount").val().trim();

        // Convert empty paid amount to 0 before validation
        //  if (paid_amount === "") {
        //     paidAmountInput.val("0");
        //     paid_amount = "0"; 
        // }

        isValid = validate_quantity(quantity) && isValid;
        // isValid = validate_paid_amount(paid_amount) && isValid;

        if (!isValid) {
            event.preventDefault(); // Stop form submission if validation fails
        }
    });
    // validate quantity
    function validate_quantity(quantity) {
        let quantityErr = $("#quantityErr");
        if (quantity === "") {
            quantityErr.html("Please enter a valid quantity");
            consol.log(quantity);
            return false;
        }
        if (!/^[0-9]+$/.test(quantity)) {
            quantityErr.html("Only numbers are allowed");
            return false;
        }
        quantityErr.html("");
        return true;
    }
});


$(document).ready(function() {


    // Set default value for Sub Total as 0.00
    $("#sub_total").val("0");
    // Function to calculate subtotal
    function calculateSubtotal() {
        let rate = parseFloat($("#rate").val()) || 0; // Get rate value
        let quantity = parseFloat($("#quantity").val()) || 0; // Get quantity value
        let subtotal = rate * quantity; // Multiply rate & quantity
        $("#sub_total").val(subtotal.toFixed(2)); // Display result in sub_total field
    }

    // Function to calculate due amount
    $("#due_amount").val("0");

    // Event listeners on rate, quantity, and advance amount fields
    $("#rate, #quantity").on("input", function() {
        calculateSubtotal(); // Update subtotal and due amount dynamically
    });

    // Fetch all products on page load
    $.ajax({
        url: "core.php",
        type: "GET",
        data: {
            action: "fetch_product_list"
        }, // Send action for fetching products
        dataType: "json",
        success: function(response) {
            if (response.success) {
                var productDropdown = $("#product");
                productDropdown.empty().append('<option value="">Select Product</option>');

                $.each(response.product_price, function(index, product) {
                    productDropdown.append('<option value="' + product.name + '">' + product
                        .name + '</option>');
                });
            } else {
                alert("No products found!");
            }
        }
    });

    // Fetch rate dynamically when a product is selected
    $("#product").change(function() {
        var selectedProduct = $(this).val();

        if (selectedProduct !== "") {
            $.ajax({
                url: "core.php",
                type: "POST",
                data: {
                    action: "fetch_product_rate",
                    product: selectedProduct
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#rate").val(response.price);
                    } else {
                        $("#rate").val("");
                        alert("Price not found for selected product.");
                    }
                }
            });
        } else {
            $("#rate").val("");
        }
    });


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