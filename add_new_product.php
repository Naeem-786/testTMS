<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>

<?php
     if(isset($_POST['add_new_product'])){
        if((isset($_POST['name']) && ($_POST['price']))  && trim($_POST['name']) !=='' && trim($_POST['price']) !=='' ){
            $product_name = $_POST['name'];
            $product_price = $_POST['price'];
            var_dump('product:'.$product_name);
            $exist_code = mysqli_query($conn, "SELECT * FROM product_price WHERE p_name ='$product_name' LIMIT 1 ")
            or die(mysqli_error($conn));
            // if($exist_code) to check wether product already exist or not
            if($row_code = mysqli_fetch_assoc($exist_code)) {
                // echo 0;
                $_SESSION['error'] = "Product Already exist!";

            }else{
                $sql = "INSERT INTO `product_price` (`p_name`, `p_price`) VALUES ('$product_name','$product_price')";
                
                $result = mysqli_query($conn, $sql);
                if($result){ 

                    $_SESSION['success'] = "Product is entered successfully";
                }else{
                    $_SESSION['error'] = "Product is Not entered!";

                }
            }            
        }
    }
?>


<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4> Products Page </h4>
                <h6>List of all Products</h6>
            </div>

            <div class="page-btn">
                <!-- modal initializing button -->
                <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#myModal"> <img
                        src="assets/img/icons/plus.svg" class="me-1" alt="img">
                    Add New Product
                </button>
            </div>
        </div>

        <!-- modal start -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <div class="modal-title page-header">
                            <div class="page-title">
                                <h4>Add New Product</h4>
                                <h6>Please don't duplicate Product Name</h6>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                
                             <!-- //onsubmit="return validation()" -->
                                <div class="row"> 
                                    <form id="product_form" style="display: flex; flex-wrap: wrap;" method="POST">
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="form-group mx-2">
                                                <label>Product Name</label>
                                                <input type="text" id="name" name="name" required-field>
                                                <small id="name-error" class="text-danger d-none">Product name is required</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Product Price</label>
                                                <input type="text" id="price" name="price" required-field>
                                                <small id="price-error" class="text-danger d-none">Product price is required</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <input class="btn btn-submit me-2" type="submit" id="add_new_product"
                                                name="add_new_product" value="Submit">
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
        <!-- modal end -->

        <!-- fetching all vendor detail-->
        <div class="card">
            <div class="card-body">
            <?php
                     // Display success message if product is entered successfully, this session message is fetched from above insert code
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success alert-dismissible">' . $_SESSION['success'] . 
                             '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                             </div>';
                        unset($_SESSION['success']);
                    }
                    // Display error message if product not enetered
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">'.$_SESSION['error'].
                             '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>                        
                        </div>';
                        unset($_SESSION['error']);
                    }
                ?>
                <div class="table-responsive" id="product_price">
                    <!-- <table id="myTable" class="table  datanew"> -->
                    <table id="myTables" class="table">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                 $sql = "SELECT * FROM product_price";
                                 $query_run = mysqli_query($conn, $sql);
                                 $total_rows = mysqli_num_rows($query_run);

                                 if($total_rows != 0){
                                    $number = 1;
                                    while($result = mysqli_fetch_assoc($query_run)){
                                        echo "
                                                <tr>
                                                    <td class='td_style'>".$number."</td>
                                                    <td class='td_style'>".$result['id']."</td>
                                                    <td class='td_style'>".$result['p_name']."</td>
                                                    <td class='td_style'>".$result['p_price']."</td>
                                                    <td>
                                                        <button type='button' class='btn btn-danger delete_btn' style='background:transparent; border:none;' value=".($result['id'])." ><img src='assets/img/icons/delete.svg' alt='img'></button>
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

$(document).ready(function() {
    
    // Validate fields on keyup
    $('.required-field').keyup(function() {
        validateFields();
    });

    // Form submission handler
    $('form').submit(function(e) {
        if (!validateFields()) {
            e.preventDefault(); // Prevent form submission
        }
    });

    function validateFields() {
        let isValid = true;
        
        // Check name field
        if ($('#name').val().trim() === '') {
            $('#name-error').removeClass('d-none');
            isValid = false;
        } else {
            $('#name-error').addClass('d-none');
        }

        // Check price field
        // Validate price field
        const price = $('#price').val().trim();
        if (price === '') {
            $('#price-error').text('Product price is required').removeClass('d-none');
            isValid = false;
        } else if (!$.isNumeric(price)) {
            $('#price-error').text('Only numbers are allowed').removeClass('d-none');
            isValid = false;
        } else if (parseFloat(price) <= 0) {
            $('#price-error').text('Price must be greater than 0').removeClass('d-none');
            isValid = false;
        } else {
            $('#price-error').addClass('d-none');
        }

        return isValid;
    }


    // delete products from product price table through sweetalert ajax
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
                            action: "delete_product_price",
                            product_del_btn: id,
                        },
                        success: function(response) {
                            if (response == 200) {
                                swal("Success", "Record Deleted Successfully!", "success");
                                // Destroy the DataTable instance
                                // $('#myTable').DataTable().destroy();
                                // Reload the content and reinitialize DataTable
                                $("#product_price").load(location.href + " #product_price", function () {
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

    $("#product_price").load(location.href + " #product_price", function () {
        $('#myTable').DataTable();
    });
   
});
</script>

<?php include('assets/includes/footer.php'); ?>