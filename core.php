<?php
include('./connect.php');
// to generate pdf file include autoload.php
require_once __DIR__ . '/vendor/autoload.php';

// THIS AJAX CODE IS FOR TMS SYSTEM NO SYSTEM CODE EXIST HERE
// employee delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_dept'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM signup WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}

// Delete order from delivered_order.php page table delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'manage_order_delete'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM addneworder WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}
// Delete product from product price table in db through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_product_price'){
    $id = $_POST['product_del_btn'];

    $sql = " DELETE FROM product_price WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}

// FETCH product name already exist in product table to avoid duplicacy
if(isset($_POST['action']) && $_POST['action']=== 'fetch_product_name'){
    if(isset($_POST['search_product'])){
        $product_name = $_POST['search_code'];
            
            $exist_product = "SELECT * FROM product_price WHERE p_name='$product_name' LIMIT 1 ";
            $exist_product_query = mysqli_query($conn, $exist_product);

            // $sql = "SELECT * FROM category where cat_code = $search_code";
            // $sql_query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($exist_product_query) == 1){
                echo '1';
            }else{
                echo '0';
            }
    }
    exit;
}
    // Fetch all products on page load
    // / Check if this is a product fetch request
if (isset($_GET['action']) && $_GET['action'] == "fetch_product_list") {
    $query = "SELECT p_name, p_price FROM product_price";
    $result = $conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = ["name" => $row['p_name'], "price" => $row['p_price']];
    }

    echo json_encode(["success" => true, "product_price" => $products]);
    exit;
}

// Fetch rate when a product is selected
if (isset($_POST['action']) && $_POST['action'] == "fetch_product_rate" && isset($_POST['product'])) {
    $product = $_POST['product'];

    $stmt = $conn->prepare("SELECT p_price FROM product_price WHERE p_name = ?");
    $stmt->bind_param("s", $product);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "price" => $row['p_price']]);
    } else {
        echo json_encode(["success" => false]);
    }
    exit;
}  

// Include your connection file


    if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Fetch the saved product from DB
    if ($action == 'fetch_saved_product') {
        $query = "SELECT id, `p_name`, `p_price` FROM `product_price`"; // Modify for your DB structure
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $options = '<option value="' . $row['id'] . '">' . $row['p_name'] . '</option>';
            echo json_encode(['status' => 'success', 'options' => $options, 'rate' => $row['p_price']]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // Fetch all products when clicking the dropdown
    elseif ($action == 'fetch_products') {
        $query = "SELECT id, p_name FROM product_price";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $options = '<option value="">Select Product</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $options .= '<option value="' . $row['id'] . '">' . $row['p_name'] . '</option>';
            }
            echo json_encode(['status' => 'success', 'options' => $options]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // Fetch rate when product is selected
    elseif ($action == 'fetch_product_rate' && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $query = "SELECT p_price FROM product_price WHERE id = '$product_id'";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode(['status' => 'success', 'rate' => $row['p_price']]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
    
// ******pdf generation and form processing logic in one place*******


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process_payment_and_invoice') {
    // 1. VALIDATE REQUIRED FIELDS
    $required = ['suit_no', 'progress_suit', 'discount', 'paid_amount', 'grand_total', 'client_name'];
    $missing = array_diff($required, array_keys($_POST));
    
    if (!empty($missing)) {
        echo json_encode(['success' => false, 'message' => "Missing fields: " . implode(", ", $missing)]);
        exit;
    }
    $current_date = date('F j, Y');
    // 2. PROCESS PAYMENT
    mysqli_begin_transaction($conn);
    try {
        // Insert payment record
        $sql_payment = "INSERT INTO payment_tbl (suit_id, discount, advance, grand_total, status) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_payment);
        mysqli_stmt_bind_param($stmt, "sddsd", 
            $_POST['suit_no'], 
            $_POST['discount'], 
            $_POST['paid_amount'], 
            $_POST['grand_total'], 
            $_POST['progress_suit']
        );
        mysqli_stmt_execute($stmt);

        // Update order status
        $update_status = "UPDATE addneworder SET progress_suit = ? WHERE id = ?";
        $stmt2 = mysqli_prepare($conn, $update_status);
        mysqli_stmt_bind_param($stmt2, "si", $_POST['progress_suit'], $_POST['suit_no']);
        mysqli_stmt_execute($stmt2);

        mysqli_commit($conn);
        
        // 3. GENERATE INVOICE PDF
        $mpdf = new \Mpdf\Mpdf(['margin_top' => 50, 'margin_bottom' => 20]);
        
        // Build header of the invoice        
        // <td><img src="assets/img/logo.jpeg" alt="Darat ul Balad logo" width=30% height=7%></td>
        $company = [
            'name' => 'DURAT AL BALAD-TMS',
            'address' => "123 Tailor Street Garment District Karachi, Pakistan",
            'phone' => '+92 300 1234567',
            'email' => 'info@durat-al-balad.com',
            'website' => 'www.durat-al-balad.com'
        ];
            
            
            $header = '
                <div style="width: 100%; margin-bottom: 15px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 20%; text-align: center; vertical-align: middle;"><img src="assets/img/logo.jpeg" alt="Darat ul Balad logo" width=30% height=10%></td>                            
                        </td>
                        <td style="width: 80%; text-align: center; vertical-align: middle;">
                            <h1 style="margin: 0; color: #333; font-size: 24px; font-weight: bold;">' . $company['name'] . '</h1>
                            <p style="margin: 5px 0 0; color: #666; font-size: 12px; line-height: 1.4;">' . nl2br($company['address']) . '</p>
                            <p style="margin: 2px 0; color: #666; font-size: 12px; line-height: 1.4;">Ph: ' . $company['phone'] . '</p>
                            <p style="margin: 2px 0; color: #666; font-size: 12px; line-height: 1.4;">Email: ' . $company['email'] . '</p>
                            <p style="margin: 2px 0; color: #666; font-size: 12px; line-height: 1.4;">Web: ' . $company['website'] . '</p>
                        </td>
                        
                    </tr>
                </table>
                <div style="border-top: 2px solid rgb(0, 0, 0); margin-top: 10px;"></div>
                <h2 style="text-align: center; color: #333; margin: 10px 0 5px 0; font-size: 18px;">INVOICE</h2>
                
                </div>';
        
        // Build invoice content, first table of client info
        $html = '
        <!DOCTYPE html>
        <html>
        
        <head>
            <style>
                body { font-family: Arial; margin: 0; padding: 0; }
                .details { margin: 20px 0; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .total { font-weight: bold; text-align: right; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div style="padding: 15px;">
                
                <table style="width: 100%; margin: 5px 0 15px 0; font-size: 12px;">
                    <tr>
                        <td style="width: 50%;"><strong>Invoice Date :</strong>' . $current_date . '</td>
                        <td style="width: 50%;"><strong>Suit No # :</strong>' . htmlspecialchars($_POST['suit_no'] ?? '') . '</td>                        
                    </tr>
                    <tr>
                        <td style="width: 50%;"><strong>Client Name: </strong>' . htmlspecialchars($_POST['client_name'] ?? '') . '</td>
                        <td style="width: 50%; text-align: left;"><strong>Phone: </strong> ' . htmlspecialchars($_POST['phone'] ?? '') . '</td>                        
                    </tr>
                    <tr>
                        <td style="width: 50%; text-align: left;"><strong>Order Date: </strong> ' . date('F j, Y') . '</td>
                        <td style="width: 50%;"><strong>Delivery Date: </strong>' .date('F j, Y', strtotime(htmlspecialchars($_POST['delivery_date']))). '</td>                       
                    </tr>
                </table>
                
                    <table>
                        <tr>
                            <th>Suit No</th>
                            <th>Product</th>
                            <th>Rate</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>' . htmlspecialchars($_POST['suit_no'] ?? '') . '</td>
                            <td>' . htmlspecialchars($_POST['product'] ?? '') . '</td>
                            <td>' . htmlspecialchars($_POST['rate'] ?? '') . '</td>
                            <td>' . htmlspecialchars($_POST['quantity'] ?? '') . '</td>
                            <td>' . htmlspecialchars($_POST['sub_total'] ?? '') . '</td>
                        </tr>
                    </table>
                    <div class="total" style="margin-top: 20px;">
                        <p><strong>Basic Amount:</strong> ' . htmlspecialchars($_POST['sub_total'] ?? '') . '</p>
                        <p><strong>Discount:</strong> ' . htmlspecialchars($_POST['discount'] ?? '0') . '</p>
                        <p><strong>Advance Paid:</strong> ' . htmlspecialchars($_POST['paid_amount'] ?? '0') . '</p>
                        <p><strong>Grand Total:</strong> ' . htmlspecialchars($_POST['grand_total'] ?? '') . '</p>
                    </div>
                
                
            </div>
        </body>
        </html>';

        $mpdf->SetHTMLHeader($header);
        $mpdf->WriteHTML($html);
        
        // Save PDF
        $pdfFileName = 'invoice_' . $_POST['suit_no'] . '_' . date('YmdHis') . '.pdf';
        $pdfPath = 'invoices/' . $pdfFileName;
        
        if (!file_exists('invoices')) {
            mkdir('invoices', 0777, true);
        }
        
        $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);
        
        echo json_encode([
            'success' => true,
            'pdfUrl' => $pdfPath,
            'pdfName' => $pdfFileName
        ]);
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

function getLogoBase64() {
    $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/SM-IMS/testTMS/assets/img/logo.jpeg';
    if (file_exists($logoPath)) {
        return 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    return '';
}


// // Gate pass old code
// if (isset($_POST['action']) && trim($_POST['action']) === 'gatePass_pdf_file_by_ajax') {
//     if (isset($_POST['pass_date'], $_POST['gatePass_vendor']) &&
//         trim($_POST['pass_date']) !== '' && trim($_POST['gatePass_vendor']) !== '' ) {
        
//         // Assign POST values to variables
//         $pass_date = $_POST['pass_date'];
//         $gatePass_vendor = $_POST['gatePass_vendor'];

//         // Create registration number randomly
//         // $reg_no = 'SM_' . rand(10,100) . date('Yd');
//         $reg_no = rand(20,100) . date('Yd');
//         // print_r($reg_no);
//         // die();
//         $pass_query = "SELECT * FROM `productout` WHERE `date` = '$pass_date' AND `vendor_name` = '$gatePass_vendor' ";
//         $gatePass_table_data = mysqli_query($conn, $pass_query);
//         $gatePass_row = mysqli_num_rows($gatePass_table_data);
       
//         // PDF generation logic
        
//         $random_gatepass_number = 'SM-' . date('ymds') . '-' . rand(1, 99999); // Generate a random gatepass number
//         $current_date = date('Y-m-d');
//         $html = "<table><tbody>
//                     <tr>
//                         <td style='width:10%;'></td>
//                         <td><img src='assets/img/logo.jpg' alt='Darat ul Balad logo' width=30% height=7%></td>
//                         <td><h1 style='letter-spacing: 5px; cellspacing: 15; cellpadding: 5;'>DURAT AL BALAD</h1></td>
//                     </tr>
//                 </tbody></table>";
//         $html .= "<h5 style='text-align: center; text-decoration: underline;'>GATE PASS FOR PRODUCT OUT</h5>";

//         // Add lines with labels
//             $html .= "<table width='100%' style='margin: 20 0 20 0;'>
//                 <tr>
//                     <td style='width: 7%;'><strong>GP#:</strong></td>
//                     <td style='width: 10%;'><strong> $random_gatepass_number</strong></td>
//                     <td style='width: 10%;'><strong>Dated:</strong></td>
//                     <td style='width: 20%;'><strong>$current_date</strong></td>
//                     <td style='width: 20%;'><strong>Vendor Name:</strong></td>
//                     <td style='width: 40%;'><h3 style='font-family: xbriyaz; text-transform: capitalize;font-size:1.5rem;'>$gatePass_vendor</h3></td>
//                 </tr>
//             </table>";


//         $html .=    "<table width='100%' class='table'>
//                             <tr>
//                                 <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Sr.No.</th>
//                                 <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Code#</th>
//                                 <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Product Name</th>
//                                 <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Piece</th>
//                             </tr>
//                     <tbody>";
//             $count = 0;
//             while ($rows = mysqli_fetch_assoc($gatePass_table_data)) {
//                 $rowStyle = ($count % 2 == 0) ? "background-color: #f2f2f2;" : ""; //it is used to add striped gray line for even rows for each tr tag
//                 $html .= "<tr style='$rowStyle'>
//                             <td style='text-align: center;'>" . ++$count . "</td>
//                             <td style='text-align: center;'>" . $rows['code'] . "</td>
//                             <td style='text-align: center; font-family: lateef;font-size:1.8rem;'><span style=''>" . $rows['name'] . "</span></td>
//                             <td style='text-align: center;'>" . $rows['qty'] . "</td>
//                         </tr>";
//             }
//             $html .= "</tbody></table>";
        
//         // Add lines with labels as footer
//         $html .= "<table width='100%' style='border-collapse: collapse; margin-top:40px;'>
//                     <tr>
//                         <td style='width: 25%; font-size: 16px;'><strong>Managed By:</strong></td>
//                         <td style='width: 25%;'></td>
//                         <td style='width: 25%; font-size: 16px;'><strong>Delivered By:</strong></td>
//                         <td style='width: 25%;'></td>
//                     </tr>
//                     <tr>
//                         <td style='font-size: 12px; width:5%; padding-top:20px;'><strong>Name:</strong></td>
//                         <td style='padding: 20 20 0 0;'>
//                             <hr style='width: 100%; border: 2px solid black; margin: 0;'>
//                         </td>
//                         <td style='font-size: 12px;padding-top:20px;'><strong>Name:</strong></td>
//                         <td style='padding-top:20px;'>
//                             <hr style='width: 100%; border: 2px solid black; margin: 0;'>
//                         </td>
//                     </tr>
//                     <tr>
//                         <td style='font-size: 12px; padding-top:30px;'><strong>Signature:</strong></td>
//                         <td style=' padding:30 20 0 0;'>
//                             <hr style='width: 100%; border: 2px solid black;'>
//                         </td>
//                         <td style='font-size: 12px; padding-top:30px;'><strong>Signature:</strong></td>
//                         <td style='padding-top:30px;'>
//                             <hr style='width: 100%; border: 2px solid black;'>
//                         </td>
//                     </tr>
//                 </table>";
//         $html .= "<table width='100%' style='border-collapse: collapse; margin-top:40px;'>
//                     <tr>
//                         <td style='width: 20%; font-size: 16px;'><strong>Received By:</strong></td>
//                          <td style='font-size: 12px; width:10%;'><strong>Vendor Name:</strong></td>
//                         <td>
//                             <hr style='width: 100%; border: 2px solid black; margin: 0;'>
//                         </td>                
//                          <td style='font-size: 12px; width:10%;'><strong>Signature:</strong></td>
//                         <td>
//                             <hr style='width: 100%; border: 2px solid black;'>
//                         </td>                
//                     </tr>
                     
                    
//                 </table>";
//         $html .= "<table width='100%' style='margin-top:10px;'>
//                     <tr style='width:100%;'>
//                         <td><strong>Note:</strong>Goods/Items checked & received as per above list & found correct.</td>
//                     </tr>
//                 </table>";

//         $mpdf = new \Mpdf\Mpdf(['format' => 'A4']); // Create an object named $mpdf, and A4 size with landscape orientation
       
//         // $mpdf->WriteHTML($styleSheet, \Mpdf\HTMLParserMode::HEADER_CSS);
//         // Write $html content to PDF using above created object $mpdf
//         $mpdf->WriteHTML($html);
        
//         // Define PDF file name
//         $pdf_file_name = "Gate Pass_" . $pass_date . ".pdf";
//         // Output the PDF file
//         $mpdf->Output($pdf_file_name, \Mpdf\Output\Destination::FILE);
        
//         // $pdf_path = "mpdf data";
//         echo json_encode(array('success' => true, 'pdfUrl' => $pdf_file_name));
        
//     } else {
//         echo json_encode(array('success' => false, 'message' => 'All fields are required'));
//         exit();
//     }
//     exit;
// }





?>