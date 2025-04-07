<?php
include('./connect.php');
// to generate pdf file include autoload.php
require_once __DIR__ . '/vendor/autoload.php';

// add new category of raw material or cloth
if(isset($_POST['action']) && $_POST['action']=== 'insert_category'){
    if(isset($_POST['cat_code']) && ($_POST['cat_cloth']) && trim($_POST['cat_code']) !=='' && trim($_POST['cat_cloth']) !==''){   //medi_name is the name attribute of form input field
    
        $cat_code = $_POST['cat_code'];
        $cat_cloth = $_POST['cat_cloth'];
        $exist_code = mysqli_query($conn, "SELECT * FROM category WHERE cat_code ='$cat_code' LIMIT 1 ")
        or die(mysqli_error($conn));
        if($row_code = mysqli_fetch_assoc($exist_code)) {
            echo 0;
        }else{
            // $sr_no=1;
            // $successMessage='';
            // $sql = "select * from medicine" ;
            // $result = mysqli_query($conn, $sr_no_sql);
            // $total_number = mysqli_num_rows($result);
            
            // if( $total_number>0){
            //     $sr_no=$total_number+1;
            // }
            $sql = "INSERT INTO `category` (`cat_code`, `cat_cloth`) VALUES ('$cat_code','$cat_cloth')";

            $result = mysqli_query($conn, $sql);
            if($result){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    exit;
}

// FETCH PRODUCT CODE record and showing into PRODUCT CODE FIELD MODAL FORM
if(isset($_POST['action']) && $_POST['action']=== 'fetch_product_code'){
    if(isset($_POST['search_code'])){
        $pro_code = $_POST['search_code'];
            
            $exist_code = "SELECT * FROM product_cat WHERE code='$pro_code' LIMIT 1 ";
            $exist_code_query = mysqli_query($conn, $exist_code);

            // $sql = "SELECT * FROM category where cat_code = $search_code";
            // $sql_query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($exist_code_query) == 1){
                echo '1';
            }else{
                echo '0';
            }
    }
    exit;
}
// FETCH CATEGORY CODE record and showing into CATEGOREY CODE FIELD MODAL FORM
if(isset($_POST['action']) && $_POST['action']=== 'fetch_category_code'){
    if(isset($_POST['search_code'])){
        $category_code = $_POST['search_code'];
            
            $exist_code = "SELECT * FROM category WHERE cat_code='$category_code' LIMIT 1 ";
            $exist_code_query = mysqli_query($conn, $exist_code);

            // $sql = "SELECT * FROM category where cat_code = $search_code";
            // $sql_query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($exist_code_query) == 1){
                echo '1';
            }else{
                echo '0';
            }
    }
    exit;
}

// FETCH EMPLOYEE CODE record and showing into EMPLOYEE CODE FIELD MODAL FORM TO REGISTER NEW EMP INTO PRODUCTION UNIT
if(isset($_POST['action']) && $_POST['action']=== 'fetch_employee_code'){
    if(isset($_POST['search_code'])){
        $employe_code = $_POST['search_code'];
            
            $exist_code = "SELECT * FROM employeetbl WHERE code='$employe_code' LIMIT 1 ";
            $exist_code_query = mysqli_query($conn, $exist_code);

            // $sql = "SELECT * FROM category where cat_code = $search_code";
            // $sql_query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($exist_code_query) == 1){
                echo '1';
            }else{
                echo '0';
            }
    }
    exit;
}

// FETCH VENDOR CODE record and showing into VENDOR CODE FIELD MODAL FORM TO REGISTER NEW VENDOR INTO PRODUCTION SALE UNIT
if(isset($_POST['action']) && $_POST['action']=== 'fetch_vendor_code'){
    if(isset($_POST['search_code'])){
        $vendor_code = $_POST['search_code'];
            
            $exist_code = "SELECT * FROM vendor WHERE vendor_code='$vendor_code' LIMIT 1 ";
            $exist_code_query = mysqli_query($conn, $exist_code);

            // $sql = "SELECT * FROM category where cat_code = $search_code";
            // $sql_query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($exist_code_query) == 1){
                echo '1';
            }else{
                echo '0';
            }
    }
    exit;
}

//fetch vendor name from vendor table for gatepass and show in productout.php modal form
if (isset($_POST['action']) && $_POST['action'] === 'fetch_vendor_name') {
    if (isset($_POST['search_vendor_name'])) {
        $search_vendor_name = $_POST['search_vendor_name'];
        $vendor_name_array = array();
        // Use prepared statement to avoid SQL injection
        $vendor_name_query = "SELECT id, vendor_name from vendor WHERE vendor_name LIKE  '%".$search_vendor_name."%' ";
        $vender_name_query_execu = mysqli_query($conn, $vendor_name_query);

        if(mysqli_num_rows($vender_name_query_execu) > 0){
            $result = array();
            while ($row = mysqli_fetch_assoc($vender_name_query_execu)) {
                $result[] = array('id' => $row['id'], 'vendor_name' => $row['vendor_name']);
            }
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Vendor not found']);
        }
    }
    exit();
}

//fetch vendor name from vendor table for gatepass and show in index.php modal form
if (isset($_POST['action']) && $_POST['action'] === 'gatePass_vendor_name') {
    if (isset($_POST['search_gatePass_vendor_name'])) {
        $searchPass_vendor_name = $_POST['search_gatePass_vendor_name'];
        $vendor_name_array = array();
        // Use prepared statement to avoid SQL injection
        $vendorPass_name_query = "SELECT id, vendor_name from vendor WHERE vendor_name LIKE  '%".$searchPass_vendor_name."%' ";
        $venderPass_name_query_execu = mysqli_query($conn, $vendorPass_name_query);

        if(mysqli_num_rows($venderPass_name_query_execu) > 0){
            $result = array();
            while ($row = mysqli_fetch_assoc($venderPass_name_query_execu)) {
                $result[] = array('id' => $row['id'], 'gate_vendor_name' => $row['vendor_name']);
            }
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Vendor not found']);
        }
    }
    exit();
}
// create a gate pass pdf for vendor through mPDF Library
$showAlert = false;
$showError = false;


if (isset($_POST['action']) && trim($_POST['action']) === 'gatePass_pdf_file_by_ajax') {
    if (isset($_POST['pass_date'], $_POST['gatePass_vendor']) &&
        trim($_POST['pass_date']) !== '' && trim($_POST['gatePass_vendor']) !== '' ) {
        
        // Assign POST values to variables
        $pass_date = $_POST['pass_date'];
        $gatePass_vendor = $_POST['gatePass_vendor'];

        // Create registration number randomly
        // $reg_no = 'SM_' . rand(10,100) . date('Yd');
        $reg_no = rand(20,100) . date('Yd');
        // print_r($reg_no);
        // die();
        $pass_query = "SELECT * FROM `productout` WHERE `date` = '$pass_date' AND `vendor_name` = '$gatePass_vendor' ";
        $gatePass_table_data = mysqli_query($conn, $pass_query);
        $gatePass_row = mysqli_num_rows($gatePass_table_data);
       
        // PDF generation logic
        
        $random_gatepass_number = 'SM-' . date('ymds') . '-' . rand(1, 99999); // Generate a random gatepass number
        $current_date = date('Y-m-d');
        $html = "<table><tbody>
                    <tr>
                        <td style='width:10%;'></td>
                        <td><img src='assets/img/logo.jpg' alt='Darat ul Balad logo' width=30% height=7%></td>
                        <td><h1 style='letter-spacing: 5px; cellspacing: 15; cellpadding: 5;'>DURAT AL BALAD</h1></td>
                    </tr>
                </tbody></table>";
        $html .= "<h5 style='text-align: center; text-decoration: underline;'>GATE PASS FOR PRODUCT OUT</h5>";

        // Add lines with labels
            $html .= "<table width='100%' style='margin: 20 0 20 0;'>
                <tr>
                    <td style='width: 7%;'><strong>GP#:</strong></td>
                    <td style='width: 10%;'><strong> $random_gatepass_number</strong></td>
                    <td style='width: 10%;'><strong>Dated:</strong></td>
                    <td style='width: 20%;'><strong>$current_date</strong></td>
                    <td style='width: 20%;'><strong>Vendor Name:</strong></td>
                    <td style='width: 40%;'><h3 style='font-family: xbriyaz; text-transform: capitalize;font-size:1.5rem;'>$gatePass_vendor</h3></td>
                </tr>
            </table>";


        $html .=    "<table width='100%' class='table'>
                            <tr>
                                <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Sr.No.</th>
                                <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Code#</th>
                                <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Product Name</th>
                                <th style='font-size: 22px; font-weight: bold;padding-bottom: 10px;'>Piece</th>
                            </tr>
                    <tbody>";
            $count = 0;
            while ($rows = mysqli_fetch_assoc($gatePass_table_data)) {
                $rowStyle = ($count % 2 == 0) ? "background-color: #f2f2f2;" : ""; //it is used to add striped gray line for even rows for each tr tag
                $html .= "<tr style='$rowStyle'>
                            <td style='text-align: center;'>" . ++$count . "</td>
                            <td style='text-align: center;'>" . $rows['code'] . "</td>
                            <td style='text-align: center; font-family: lateef;font-size:1.8rem;'><span style=''>" . $rows['name'] . "</span></td>
                            <td style='text-align: center;'>" . $rows['qty'] . "</td>
                        </tr>";
            }
            $html .= "</tbody></table>";
        
        // Add lines with labels as footer
        $html .= "<table width='100%' style='border-collapse: collapse; margin-top:40px;'>
                    <tr>
                        <td style='width: 25%; font-size: 16px;'><strong>Managed By:</strong></td>
                        <td style='width: 25%;'></td>
                        <td style='width: 25%; font-size: 16px;'><strong>Delivered By:</strong></td>
                        <td style='width: 25%;'></td>
                    </tr>
                    <tr>
                        <td style='font-size: 12px; width:5%; padding-top:20px;'><strong>Name:</strong></td>
                        <td style='padding: 20 20 0 0;'>
                            <hr style='width: 100%; border: 2px solid black; margin: 0;'>
                        </td>
                        <td style='font-size: 12px;padding-top:20px;'><strong>Name:</strong></td>
                        <td style='padding-top:20px;'>
                            <hr style='width: 100%; border: 2px solid black; margin: 0;'>
                        </td>
                    </tr>
                    <tr>
                        <td style='font-size: 12px; padding-top:30px;'><strong>Signature:</strong></td>
                        <td style=' padding:30 20 0 0;'>
                            <hr style='width: 100%; border: 2px solid black;'>
                        </td>
                        <td style='font-size: 12px; padding-top:30px;'><strong>Signature:</strong></td>
                        <td style='padding-top:30px;'>
                            <hr style='width: 100%; border: 2px solid black;'>
                        </td>
                    </tr>
                </table>";
        $html .= "<table width='100%' style='border-collapse: collapse; margin-top:40px;'>
                    <tr>
                        <td style='width: 20%; font-size: 16px;'><strong>Received By:</strong></td>
                         <td style='font-size: 12px; width:10%;'><strong>Vendor Name:</strong></td>
                        <td>
                            <hr style='width: 100%; border: 2px solid black; margin: 0;'>
                        </td>                
                         <td style='font-size: 12px; width:10%;'><strong>Signature:</strong></td>
                        <td>
                            <hr style='width: 100%; border: 2px solid black;'>
                        </td>                
                    </tr>
                     
                    
                </table>";
        $html .= "<table width='100%' style='margin-top:10px;'>
                    <tr style='width:100%;'>
                        <td><strong>Note:</strong>Goods/Items checked & received as per above list & found correct.</td>
                    </tr>
                </table>";

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']); // Create an object named $mpdf, and A4 size with landscape orientation
       
        // $mpdf->WriteHTML($styleSheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        // Write $html content to PDF using above created object $mpdf
        $mpdf->WriteHTML($html);
        
        // Define PDF file name
        $pdf_file_name = "Gate Pass_" . $pass_date . ".pdf";
        // Output the PDF file
        $mpdf->Output($pdf_file_name, \Mpdf\Output\Destination::FILE);
        
        // $pdf_path = "mpdf data";
        echo json_encode(array('success' => true, 'pdfUrl' => $pdf_file_name));
        
    } else {
        echo json_encode(array('success' => false, 'message' => 'All fields are required'));
        exit();
    }
    exit;
}
// fetch employee name and its id
if(isset($_POST['action']) && $_POST['action'] === 'fetch_employee_name'){
    if(isset($_POST['search_name'])){
        $employe_name = $_POST['search_name'];
        $empname = array();
        $emp_name = "SELECT id, name FROM `employeetbl` WHERE name LIKE '%".$employe_name."%'";  
        $emp_name_query = mysqli_query($conn, $emp_name);

        if(mysqli_num_rows($emp_name_query) > 0){
            $result = array();
            while($row = mysqli_fetch_assoc($emp_name_query)){
                $result[] = array('id' => $row['id'], 'name' => $row['name']);
            }
            echo json_encode($result);
        } else {
            echo json_encode(array('error' => 'Employee not found'));
        }
    }
    exit;
}


// fetch available packed products record from packing & productout table and showing into productout pieces input field into modal form

if (isset($_POST['action']) && $_POST['action'] === 'fetch_pack_product_name') {
    if (isset($_POST['search_code'])) {
        $search_code = $_POST['search_code'];

        // Use prepared statement to avoid SQL injection
        $product_query = "SELECT name, 
                            (COALESCE((SELECT SUM(piece) FROM packing WHERE code = ? AND name = p.name), 0) 
                            - COALESCE((SELECT SUM(qty) FROM productout WHERE code = ? AND name = p.name), 0)) AS remaining_qty
                          FROM packing p
                          WHERE code = ?
                          LIMIT 1";

        $stmt = mysqli_prepare($conn, $product_query);
        mysqli_stmt_bind_param($stmt, "sss", $search_code, $search_code, $search_code);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) == 1) {
            $product_data = mysqli_fetch_assoc($result);
            echo json_encode($product_data);
        } else {
            echo json_encode(['name' => '', 'remaining_qty' => 0]);
        }

        mysqli_stmt_close($stmt);
    }
    exit;
}

// fetch product record and total available stock of products and showing into product name & qty field into modal form and same code is used for packing.php page to add new packing and fetch product name into product name field. 
if(isset($_POST['action']) && $_POST['action'] === 'fetch_product_name'){
    if(isset($_POST['search_code'])){
        $search_code = $_POST['search_code'];

        // Fetch product name and remaining quantity for the specified code
        $product_query = "SELECT name, 
                            (COALESCE((SELECT SUM(qty) FROM product WHERE code = '$search_code' AND name = p.name), 0) 
                             - COALESCE((SELECT SUM(qty) FROM productout WHERE code = '$search_code' AND name = p.name), 0)) AS remaining_qty
                          FROM product p
                          WHERE code = '$search_code'
                          LIMIT 1";

        $product_result = mysqli_query($conn, $product_query);

        if($product_result && mysqli_num_rows($product_result) == 1){
            $product_data = mysqli_fetch_assoc($product_result);
            
            // echo esc_html($product_data);
            echo json_encode($product_data);
        } else {
            echo json_encode(['name' => '', 'remaining_qty' => 0]);
        }
    }
    exit;
}

// fetch product name and showing into product name field into modal form and same code is used for packing.php page to add new packing and fetch product name into product name field.
if(isset($_POST['action']) && $_POST['action'] === 'fetch_product_name_only'){
    if(isset($_POST['search_code'])){
        $search_code = $_POST['search_code'];

        // Fetch product name and remaining quantity for the specified code
        $productcode_query = "SELECT name from product_cat where code = '$search_code' LIMIT 1";

        $productcode_result = mysqli_query($conn, $productcode_query);

        if($productcode_result && mysqli_num_rows($productcode_result) == 1){
            $productcode_data = mysqli_fetch_assoc($productcode_result);
            
            // echo esc_html($product_data);
            echo json_encode($productcode_data);
        } else {
            echo json_encode(['name' => '']);
        }
    }
    exit;
}

// fetch cloth name of raw material and showing into cloth category modal form
if(isset($_POST['action']) && $_POST['action'] === 'fetch_newCloth_only'){
    if(isset($_POST['search_code'])){
        $search_code = $_POST['search_code'];

        // Fetch category name of raw material for the specified code
        $raw_category_name = "SELECT cat_cloth FROM `category` where cat_code = '$search_code' LIMIT 1";

        $raw_category_result = mysqli_query($conn, $raw_category_name);

        if($raw_category_result && mysqli_num_rows($raw_category_result) == 1){
            $raw_category_data = mysqli_fetch_assoc($raw_category_result);
            echo json_encode($raw_category_data);
        } else {
            echo json_encode(['cat_cloth' => '']);
        }
    }
    exit;
}
// fetch cloth record and total available stock of raw material and showing into cloth category form
if(isset($_POST['action']) && $_POST['action'] === 'fetch_newCloth'){
    if(isset($_POST['search_code'])){
        $search_code = $_POST['search_code'];

        // Fetch product name and remaining quantity for the specified code
        $raw_stock_query = "SELECT cloth_cat, 
                                (COALESCE((SELECT SUM(yard) FROM cloth WHERE code = '$search_code' AND cloth_cat = p.cloth_cat), 0) 
                                - COALESCE((SELECT SUM(yard) FROM stitching WHERE code = '$search_code' AND cloth_cat = p.cloth_cat), 0)) AS remaining_yard
                          FROM cloth p
                          WHERE code = '$search_code'
                          LIMIT 1";

        $raw_stock_result = mysqli_query($conn, $raw_stock_query);

        if($raw_stock_result && mysqli_num_rows($raw_stock_result) == 1){
            $raw_stock_data = mysqli_fetch_assoc($raw_stock_result);
            echo json_encode($raw_stock_data);
        } else {
            echo json_encode(['cloth_cat' => '', 'remaining_yard' => 0]);
        }
    }
    exit;
}



// add new cloth product 
if(isset($_POST['action']) && $_POST['action']=== 'insert_newCloth'){
    if(isset($_POST['code_cat']) && ($_POST['new_cloth_cat']) && ($_POST['yard']) && trim($_POST['code_cat']) !=='' && trim($_POST['new_cloth_cat']) !=='' && trim($_POST['yard']) !==''){   
        $cat_code = $_POST['code_cat'];
        $new_cloth_cat = $_POST['new_cloth_cat'];
        $yard = $_POST['yard'];
        // $date = date('Y-m-d');
        $sql = "INSERT INTO `cloth` (`code`, `cloth_cat`, `yard`) VALUES ('$cat_code','$new_cloth_cat', '$yard')";

            $result = mysqli_query($conn, $sql);
            if($result){
                echo 1;
            }else{
                echo 0;
            }       
    }
    exit;
} 

// fetch record of RAW MATERIAL CATEGORY and load into datatable backup of table data load
if(isset($_POST['action']) && $_POST['action'] === 'get_product_data'){  

    $query = "SELECT * FROM cloth";
    $db_table_data = mysqli_query($conn, $query);
    $total_rows = mysqli_num_rows($db_table_data);
    // echo $total_rows;
    $temp = [];
    $medi_data = [];

    // $date = date('Y-m-d');
    if($total_rows != 0){
        $medi_data['data'] = []; // Initialize the 'data' array
        $number = 1;
        while($result = mysqli_fetch_assoc($db_table_data)){
            $temp[]=$number;
            // $temp[]=$date;
            $temp[]=$result['date'];
            $temp[]=$result['code'];
            $temp[]=$result['cloth_cat'];
            $temp[]=$result['yard'];
            $temp[]="<a class='me-3 edit_btn' href='' ><img src='assets/img/icons/edit.svg' alt='img'></a><a class='me-3 confirm-text' href='#'><img src='assets/img/icons/delete.svg' alt='img'></a>";
            $number++;
            $medi_data['data'][]=$temp;
            $temp = [];
        }
    }
    echo json_encode($medi_data);
    exit;
}

// fetch record of RAW MATERIAL month & yearwise in reports tab and load into datatable
if(isset($_POST['action']) && $_POST['action'] === 'searh_yearwise_data'){  

    // $year = $_POST['search_year'];
    $query = "SELECT YEAR(date) AS year, MONTHNAME(date) AS month, code, cloth_cat, SUM(yard) AS total_yard FROM cloth GROUP BY YEAR(date), MONTH(date), code, cloth_cat ORDER BY YEAR(date) DESC, MONTH(date) DESC";
    //codwise total of all cate
    // SELECT code, cloth_cat, SUM(yard) AS total_yard FROM cloth GROUP BY code, cloth_cat; 

    $db_table_data = mysqli_query($conn, $query);
    $total_rows = mysqli_num_rows($db_table_data);
    // echo $total_rows;
    $temp = [];
    $medi_data = [];

    if($total_rows != 0){
        $medi_data['data'] = []; // Initialize the 'data' array
        $number = 1;
        while($result = mysqli_fetch_assoc($db_table_data)){
            $temp[]=$number;
            // $temp[]=$date;
            $temp[]=$result['year'];
            $temp[]=$result['month'];
            $temp[]=$result['code'];
            $temp[]=$result['cloth_cat'];
            $temp[]=$result['total_yard'];
           
            
            
            
           
            $number++;
            $medi_data['data'][]=$temp;
            $temp = [];
        }
    }
    echo json_encode($medi_data);
    exit;
}

// fetch month wise report and load into datatable
if(isset($_POST['action']) && $_POST['action'] === 'monthwise_report'){  

    $query = "SELECT YEAR(date) AS year, MONTHNAME(date) AS month, code, SUM(yard) AS total_yard FROM cloth GROUP BY code, YEAR(date), MONTH(date) ORDER BY YEAR(date) DESC, MONTH(date) ASC";


    $db_table_data = mysqli_query($conn, $query);
    $total_rows = mysqli_num_rows($db_table_data);
    // echo $total_rows;
    $temp = [];
    $medi_data = [];

    // $date = date('Y-m-d');
    if($total_rows != 0){
        $medi_data['data'] = []; // Initialize the 'data' array
        $number = 1;
        while($result = mysqli_fetch_assoc($db_table_data)){
            $temp[]=$number;
            // $temp[]=$date;
            $temp[]=$result['code'];
            $temp[]=$result['year'];
            $temp[]=$result['month'];
            // $temp[]=$result['cloth_cat'];
            $temp[]=$result['total_yard'];
            
            
            
           
            $number++;
            $medi_data['data'][]=$temp;
            $temp = [];
        }
    }
    echo json_encode($medi_data);
    exit;
}

// generate excel file of Monthly production product_made_by.php
 if(isset($_POST['action']) && $_POST['action'] === 'monthly_product_made_by_excel'){

    function get_reports_by_date($start,$end){
        global $conn;
        $query = "SELECT code, name, emp_name, SUM(qty) AS total_qty 
        FROM product 
        WHERE DATE(date) BETWEEN ? AND ? 
        GROUP BY code, name, emp_name";
    
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $start, $end);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    } 
    
    if (isset($_POST['generate_monthly_report'])) {
        if (
            isset($_POST['fromDate']) && trim($_POST['fromDate']) !== '' &&
            isset($_POST['toDate']) && trim($_POST['toDate']) !== ''
        )
        {
            $fromDate = $_POST['fromDate'];
            $toDate = $_POST['toDate'];
        } else {
            // If no date range selected, default to the entire current month
            $fromDate = date('Y-m-01');
            $toDate = date('Y-m-d');
        }
        
    }else{
        $fromDate = date('Y-m-01');
        $toDate = date('Y-m-t'); 
    
    }
    $result = get_reports_by_date($fromDate, $toDate);
    echo "<h5 class='text-center'>Dated: $fromDate to $toDate</h5>";
    
    $output = '<table><tr> <td>Sr.No.</td>  <td>Code</td>  <td>Name</td>  <td>Employee Name</td>  <td>Total Quantity</td> </tr>';
    
    $number = 1; 
   // Your existing code...

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<tr> <td>' . $number . '</td>  <td>' . $row['code'] . '</td>  <td>' . $row['name'] . '</td>  <td>' . $row['emp_name'] . '</td>  <td>' . $row['total_qty'] . '</td> </tr>';
            $number++;
        }
        $output .= '</table>';

        // Generate a filename based on the date range
        $fromDateFormatted = date('Ymd', strtotime($fromDate));
        $toDateFormatted = date('Ymd', strtotime($toDate));
        $filename = 'ExcelDate_' . $fromDateFormatted . '_to_' . $toDateFormatted . '.xls';
        
        $filename1 = 'ExcelDate_' .date('Ymdhis').'.xls';



        // Send the appropriate headers for Excel download
        header('Content-Type: application/vnd.ms-excel');
        // header("Content-Disposition: attachment; filename=\" $filename1 \"");
        header("Pragma: no-cache");
        header("Expires: 0");


        echo $output;
        exit; // Don't forget to exit after sending the file.
    } else {
        echo '0';
    }

}
// generate excel file of Monthly production datewise & employeewise product_made_by.php
 if(isset($_POST['action']) && $_POST['action'] === 'datewise_monthly_product_in_excel'){

    function get_reports_by_date($start,$end){
        global $conn;
        $query = "SELECT * FROM product 
        WHERE DATE(date) BETWEEN ? AND ? ";
    
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $start, $end);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    } 
    
    if (isset($_POST['generate_monthly_report'])) {
        if (
            isset($_POST['fromDate']) && trim($_POST['fromDate']) !== '' &&
            isset($_POST['toDate']) && trim($_POST['toDate']) !== ''
        )
        {
            $fromDate = $_POST['fromDate'];
            $toDate = $_POST['toDate'];
        } else {
            // If no date range selected, default to the entire current month
            $fromDate = date('Y-m-01');
            $toDate = date('Y-m-d');
        }
        
    }else{
        $fromDate = date('Y-m-01');
        $toDate = date('Y-m-t'); 
    
    }
    $result = get_reports_by_date($fromDate, $toDate);
    echo "<h5 class='text-center'>Dated: $fromDate to $toDate</h5>";
    
    $output = '<table><tr> <td>Sr.No.</td> <td>Date</td> <td>Product Code</td>  <td>Product Name</td>  <td>Employee Name</td>  <td>Quantity</td> </tr>';
    
    $number = 1; 

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<tr> <td>' . $number . '</td> <td>' . $row['date'] . '</td> <td>' . $row['code'] . '</td>  <td>' . $row['name'] . '</td>  <td>' . $row['qty'] . '</td>  <td>' . $row['emp_name'] . '</td> </tr>';
            $number++;
        }
        $output .= '</table>';

        // Generate a filename based on the date range
        $fromDateFormatted = date('Ymd', strtotime($fromDate));
        $toDateFormatted = date('Ymd', strtotime($toDate));
        $filename = 'ExcelDate_' . $fromDateFormatted . '_to_' . $toDateFormatted . '.xls';
        
        $filename1 = 'ExcelDate_' .date('Ymdhis').'.xls';



        // Send the appropriate headers for Excel download
        header('Content-Type: application/vnd.ms-excel');
        // header("Content-Disposition: attachment; filename=\" $filename1 \"");
        header("Pragma: no-cache");
        header("Expires: 0");


        echo $output;
        exit; // Don't forget to exit after sending the file.
    } else {
        echo '0';
    }

}

// stitching delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_stitch'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM stitching WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}
// product delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_product'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM product WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}

// New Product Code delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_product_code'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM product_cat WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}
// Raw catgeory delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_raw_category'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM cloth WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}

// Raw new catgeory code delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_new_category_code'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM category WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}
// packing code delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_packing'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM packing WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}

// productout delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_productout'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM productout WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}
// employee delete btn call through sweet alert
if(isset($_POST['action']) && $_POST['action'] === 'delete_employee'){
    $id = $_POST['stitch_btn'];

    $sql = " DELETE FROM employeetbl WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 200;
    }else{
        echo 500;
    }
}


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
// fetch product rate and show in add new order form
// if(isset($_POST['action']) && $_POST['action']=== 'fetch_product_rate'){
//     if (isset($_POST['product_rate'])) {
//         $product = $_POST['product_rate'];

//         $query = "SELECT p_price FROM product_price WHERE name = '$product'";
//         $result = mysqli_query($conn, $query);

//         // if ($row = mysqli_fetch_assoc($result)) {
//         //     echo $row['p_price']; // Return product price
//         // } else {
//         //     echo "0"; // Default value if no product found
//         // }
//         if ($row = mysqli_fetch_assoc($result)) {
//             echo json_encode(["price" => $row['p_price'], "query" => $query]); // Return price & query for debugging
//         } else {
//             echo json_encode(["price" => "0", "query" => $query]); // Return 0 if no product found
//         }
//     }
// }

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

// edit_invoice.php file, fetch products and their rates
// Handle product list fetch
// if (isset($_GET['action']) && $_GET['action'] == "fetch_product_list") {
//     $stmt = $conn->prepare("SELECT p_name as name, p_price as price FROM product_price");
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     $products = [];
//     while ($row = $result->fetch_assoc()) {
//         $products[] = $row;
//     }
    
//     echo json_encode([
//         "success" => true,
//         "products" => $products
//     ]);
//     exit;
// }

// // Handle product rate fetch
// if (isset($_POST['action']) && $_POST['action'] == "fetch_product_rate" && isset($_POST['product'])) {
//     $product = $conn->real_escape_string($_POST['product']);
    
//     $stmt = $conn->prepare("SELECT p_price as price FROM product_price WHERE p_name = ?");
//     $stmt->bind_param("s", $product);
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         echo json_encode([
//             "success" => true,
//             "price" => $row['price']
//         ]);
//     } else {
//         echo json_encode(["success" => false]);
//     }
//     exit;
// }


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






?>