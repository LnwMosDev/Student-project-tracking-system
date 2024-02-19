<?php

include_once 'includes/config.php';

// show PHP errors
ini_set('display_errors', 1);

// output any connection error
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$action = isset($_POST['action']) ? $_POST['action'] : "";

if ($action == 'email_invoice') {

    $fileId = $_POST['id'];
    $emailId = $_POST['email'];
    $invoice_type = $_POST['invoice_type'];
    $custom_email = $_POST['custom_email'];

    require_once 'class.phpmailer.php';

    $mail = new PHPMailer(); // defaults to using php "mail()"

    $mail->AddReplyTo(EMAIL_FROM, EMAIL_NAME);
    $mail->SetFrom(EMAIL_FROM, EMAIL_NAME);
    $mail->AddAddress($emailId, "");

    $mail->Subject = EMAIL_SUBJECT;
    //$mail->AltBody = EMAIL_BODY; // optional, comment out and test
    if (empty($custom_email)) {
        if ($invoice_type == 'invoice') {
            $mail->MsgHTML(EMAIL_BODY_INVOICE);
        } else if ($invoice_type == 'quote') {
            $mail->MsgHTML(EMAIL_BODY_QUOTE);
        } else if ($invoice_type == 'receipt') {
            $mail->MsgHTML(EMAIL_BODY_RECEIPT);
        }
    } else {
        $mail->MsgHTML($custom_email);
    }

    $mail->AddAttachment("./invoices/" . $fileId . ".pdf"); // attachment

    if (!$mail->Send()) {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mail->ErrorInfo . '</pre>',
        ));
    } else {
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'Invoice has been successfully send to the customer',
        ));
    }
}
// download invoice csv sheet
if ($action == 'download_csv') {

    header("Content-type: text/csv");

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $file_name = 'invoice-export-' . date('d-m-Y') . '.csv'; // file name
    $file_path = 'downloads/' . $file_name; // file path

    $file = fopen($file_path, "w"); // open a file in write mode
    chmod($file_path, 0777); // set the file permission

    $query_table_columns_data = "SELECT *
									FROM invoices i
									JOIN customers c
									ON c.invoice = i.invoice
									WHERE i.invoice = c.invoice
									ORDER BY i.invoice";

    if ($result_column_data = mysqli_query($mysqli, $query_table_columns_data)) {

        // fetch table fields data
        while ($column_data = $result_column_data->fetch_row()) {

            $table_column_data = array();
            foreach ($column_data as $data) {
                $table_column_data[] = $data;
            }

            // Format array as CSV and write to file pointer
            fputcsv($file, $table_column_data, ",", '"');
        }
    }

    //if saving success
    if ($result_column_data = mysqli_query($mysqli, $query_table_columns_data)) {
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'CSV has been generated and is available in the /downloads folder for future reference, you can download by <a href="downloads/' . $file_name . '">clicking here</a>.',
        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    // close file pointer
    fclose($file);

    $mysqli->close();
}
// Adding new employee
if ($action == 'add_employee') {

    $employee_id = $_POST["employee_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address = $_POST["address"];
    $sub_district = $_POST["sub_district"];
    $district = $_POST["district"];
    $province = $_POST["province"];
    $postal_code = $_POST["postal_code"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $start_date = $_POST["start_date"];
    $password = $_POST["password"];
    $job_title = $_POST["job_title"];

    //our insert query query
    $query = "INSERT INTO employee
				(
    employee_id,
    first_name,
    last_name,
    address,
    sub_district,
    district,
    province,
    postal_code,
    phone_number,
    email,
    start_date,
    password,
    job_title,
    void
    )
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

    header('Content-Type: application/json');

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    $password = md5($password);
    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param(
        'sssssssssssss',
        $employee_id,
        $first_name,
        $last_name,
        $address,
        $sub_district,
        $district,
        $province,
        $postal_code,
        $phone_number,
        $email,
        $start_date,
        $password,
        $job_title
    );


    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => '
            เพิ่มพนักงานสำเร็จแล้ว!',
        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    //close database connection
    $mysqli->close();
}



// Adding new employee
if ($action == 'update_employee') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // $employee_id = $_POST['id'];
    // $getID = $_POST['id'];
    $employee_id = $_POST["employee_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address = $_POST["address"];
    $sub_district = $_POST["sub_district"];
    $district = $_POST["district"];
    $province = $_POST["province"];
    $postal_code = $_POST["postal_code"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $start_date = $_POST["start_date"];
    $password = $_POST["password"];
    $job_title = $_POST["job_title"];

    // the query
    $query = "UPDATE employee SET
            first_name = ?,
            last_name = ?,
            address = ?,
            sub_district = ?,
            district = ?,
            province = ?,
            postal_code = ?,
            phone_number = ?,
            email = ?,
            start_date = ?,
            password = ?,
            job_title = ?
        WHERE employee_id = ?";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }
    $password = md5($password);
    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param(
        'sssssssssssss',
        $first_name,
        $last_name,
        $address,
        $sub_district,
        $district,
        $province,
        $postal_code,
        $phone_number,
        $email,
        $start_date,
        $password,
        $job_title,
        $employee_id
    );

    //execute the query
    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'อัปเดตพนักงานเรียบร้อยแล้ว!',
        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => '
            มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    //close database connection
    $mysqli->close();
}

// Delete Customer
if ($action == 'delete_employee') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $id = $_POST["delete"];

    // the query
    // $query = "DELETE FROM employee WHERE employee_id = ?";
    $query = "UPDATE employee SET void = 1 WHERE employee_id = ?";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param('s', $id);

    if ($stmt->execute()) {
        //if updating success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'เปลี่ยนสถานะพนักงานสำเร็จแล้ว!',
        ));
    } else {
        //if unable to update record
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    // close connection
    $mysqli->close();
}

if ($action == 'create_invoice') {

    // invoice details
    $doc_number = $_POST['doc_number']; // เลขที่เอกสาร
    $record_date = $_POST['record_date']; // วันที่บันทึก
    $receipt_number = $_POST['receipt_number']; // เลขที่ใบเสร็จ
    $receipt_date = $_POST['receipt_date']; // วันที่ใบเสร็จ
    $project_id = $_POST['project_id']; // รหัสโครงการ
    $total_cost = $_POST['invoice_total']; // รวมราคา

    // insert invoice into database
    $query = "INSERT INTO projcost_hd (
        doc_number,
        record_date,
        receipt_number,
        receipt_date,
        project_id,
        Total_cost,
        status
    ) VALUES (
        '" . $doc_number . "',
        '" . $record_date . "',
        '" . $receipt_number . "',
        '" . $receipt_date . "',
        '" . $project_id . "',
        '" . $total_cost . "',
        '0'  -- ตั้งค่า status เป็น 0 ตาม default
    );
    ";

    // invoice product items
    foreach ($_POST['invoice_product'] as $key => $value) {
        $product_id = $_POST['invoice_product_id'][$key]; // รหัสสินค้า
        $quantity = $_POST['invoice_product_qty'][$key]; // จำนวน
        $price_per_unit = $_POST['invoice_product_price'][$key]; // ราคาต่อหน่วย
        $subtotal = $_POST['invoice_product_sub'][$key]; // ราคารวม

        // insert invoice items into database
        $query .= "INSERT INTO projcost_desc (
            doc_number,
            product_id,
            quantity,
            price_per_unit,
            Total_cost
        ) VALUES (
            '" . $doc_number . "',
            '" . $product_id . "',
            '" . $quantity . "',
            '" . $price_per_unit . "',
            '" . $subtotal . "'
        );
        ";
    }

    // รายชื่อฟิลด์ที่เปลี่ยนชื่อแล้วต้องแก้ไขเป็นชื่อใหม่ตามโครงสร้างฐานข้อมูล

    header('Content-Type: application/json');

    // execute the query
    if ($mysqli->multi_query($query)) {
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'Invoice has been created successfully!',
        ));
    } else {
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'Error: ' . $mysqli->error,
        ));
    }

    //close database connection
    $mysqli->close();
}

// Adding new product
if ($action == 'delete_invoice') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $id = $_POST["delete"];

    // the query
    $query = "DELETE FROM invoices WHERE invoice = " . $id . ";";
    $query .= "DELETE FROM customers WHERE invoice = " . $id . ";";
    $query .= "DELETE FROM invoice_items WHERE invoice = " . $id . ";";

    unlink('invoices/' . $id . '.pdf');

    if ($mysqli->multi_query($query)) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'Product has been deleted successfully!',
        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    // close connection
    $mysqli->close();
}

if ($action == 'create_closeinvoice') {
    // รับค่าจาก POST request
    $doc_number = $_POST['doc_number'];
    $closing_date = $_POST['closing_date'];
    $project_id = $_POST['project_id'];
    $cost = $_POST['cost'];
    $expenses = $_POST['expenses'];
    $employee_id = $_POST['employee_id'];
    $comment = $_POST['comment'];

    // SQL query สำหรับการแทรกข้อมูลลงในตาราง project_close
    $insertQuery = "INSERT INTO project_close (doc_number, closing_date, project_id, cost, expenses, employee_id, comment) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement สำหรับการแทรกข้อมูล
    $insertStmt = $mysqli->prepare($insertQuery);
    if ($insertStmt === false) {
        trigger_error('Wrong SQL: ' . $insertQuery . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    // Bind parameters สำหรับการแทรกข้อมูล. Types: s = string, i = integer, d = double, b = blob
    $insertStmt->bind_param('sssssss', $doc_number, $closing_date, $project_id, $cost, $expenses, $employee_id, $comment);

    // Execute คำสั่งแทรกข้อมูล
    if ($insertStmt->execute()) {
        // หากแทรกข้อมูลลงในตารางสำเร็จ ทำการอัปเดต project_status
        $updateQuery = "UPDATE project SET project_status='2' WHERE project_id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        if ($updateStmt === false) {
            trigger_error('Wrong SQL: ' . $updateQuery . ' Error: ' . $mysqli->error, E_USER_ERROR);
        }

        // Bind parameter สำหรับคำสั่งอัปเดต
        $updateStmt->bind_param('s', $project_id);

        // Execute คำสั่งอัปเดต
        if ($updateStmt->execute()) {
            // อัปเดตสถานะโครงการสำเร็จ
            echo json_encode(array(
                'status' => 'Success',
                'message' => 'บันทึกปิดโครงการสำเร็จ!',
            ));
        } else {
            // ไม่สามารถอัปเดตโครงการได้
            echo json_encode(array(
                'status' => 'Error',
                'message' => 'มีข้อผิดพลาดในการอัปเดตโครงการ.',
            ));
        }

        // ปิดคำสั่งอัปเดต
        $updateStmt->close();
    } else {
        // ไม่สามารถแทรกข้อมูลได้
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'มีข้อผิดพลาดในการบันทึกปิดโครงการ.',
        ));
    }

    // ปิดคำสั่งแทรกข้อมูล
    $insertStmt->close();

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $mysqli->close();
}



// Create customer
if ($action == 'create_customer') {

    // invoice customer information
    // billing
    $customer_id = $_POST["customer_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address = $_POST["address"];
    $sub_district = $_POST["sub_district"];
    $district = $_POST["district"];
    $province = $_POST["province"];
    $postal_code = $_POST["postal_code"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];


    $query = "INSERT INTO customer (
        customer_id,
        first_name,
        last_name,
        address,
        sub_district,
        district,
        province,
        postal_code,
        phone_number,
        email,
        void
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,0)";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param(
        'ssssssssss',
        $customer_id,
        $first_name,
        $last_name,
        $address,
        $sub_district,
        $district,
        $province,
        $postal_code,
        $phone_number,
        $email
    );

    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'เพิ่มลูกค้าสำเร็จแล้ว!',
        ));
    } else {
        // if unable to create invoice
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.',
            // debug
            //'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
        ));
    }

    //close database connection
    $mysqli->close();
}

// Adding new customer
if ($action == 'update_customer') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $getID = $_POST['id'];
    // $customer_id = $_POST["customer_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $address = $_POST["address"];
    $sub_district = $_POST["sub_district"];
    $district = $_POST["district"];
    $province = $_POST["province"];
    $postal_code = $_POST["postal_code"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];

    // the query
    $query = "UPDATE customer SET
                --  customer_id = ?,
				first_name = ?,
				last_name = ?,
				address = ?,
				sub_district = ?,
				district = ?,
				province = ?,
				postal_code = ?,
                phone_number = ?,
				email = ?
			WHERE customer_id = ?
			";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param(
        'ssssssssss',
        // $customer_id,
        $first_name,
        $last_name,
        $address,
        $sub_district,
        $district,
        $province,
        $postal_code,
        $phone_number,
        $email,
        $getID
    );

    //execute the query
    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'ข้อมูลลูกค้าได้รับการอัปเดตเรียบร้อยแล้ว!',
        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    //close database connection
    $mysqli->close();
}



// Delete Customer
if ($action == 'delete_customer') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $id = $_POST["delete"];

    // the query
    // $query = "DELETE FROM customer WHERE customer_id = ?";
    $query = "UPDATE customer SET void = 1 WHERE customer_id = ?";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param('s', $id);

    // if ($stmt->execute()) {
    //     //if saving success
    //     echo json_encode(array(
    //         'status' => 'Success',
    //         'message' => 'ลบลูกค้าสำเร็จแล้ว!',
    //     ));
    // } else {
    //     //if unable to create new record
    //     echo json_encode(array(
    //         'status' => 'Error',
    //         //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
    //         'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
    //     ));
    // }
    if ($stmt->execute()) {
        //if updating success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'เปลี่ยนสถานะลูกค้าสำเร็จแล้ว!',
        ));
    } else {
        //if unable to update record
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    // close connection
    $mysqli->close();
}

if ($action == 'create_project') {
    $project_id = $_POST["project_id"];
    $project_name = $_POST["project_name"];
    $customer_id = $_POST["customer_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $project_value = $_POST["project_value"];
    $employee_id = $_POST["employee_id"];
    $project_status = $_POST["project_status"];

    $query = "INSERT INTO project (
       project_id,
       project_name,
       customer_id,
       start_date,
       end_date,
       project_value,
       employee_id,
       project_status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. Types: s = string, i = integer, d = double, b = blob */
    $stmt->bind_param(
        'ssssssss',
        $project_id,
        $project_name,
        $customer_id,
        $start_date,
        $end_date,
        $project_value,
        $employee_id,
        $project_status
    );
    if ($stmt->execute()) {
        // ถ้าบันทึกสำเร็จ
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'โครงการถูกสร้างเรียบร้อยแล้ว!',
        ));
    } else {
        // ถ้าไม่สามารถสร้างโครงการได้
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง',
            // debug
            //'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
        ));
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $mysqli->close();
}

if ($action == 'update_project') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    // $employee_id = $_POST['id'];
    // $getID = $_POST['id'];

    $project_id = $_POST["project_id"];
    $project_name = $_POST["project_name"];
    $customer_id = $_POST["customer_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $project_value = $_POST["project_value"];
    $employee_id = $_POST["employee_id"];
    $project_status = $_POST["project_status"];

    // the query
    $query = "UPDATE project SET
   project_name = ?,
   customer_id = ?,
   start_date = ?,
   end_date = ?,
   project_value = ?,
    employee_id = ?,
   project_status = ?
WHERE project_id = ?";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }
    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param(
        'ssssssss',
        $project_name,
        $customer_id, //เปลี่ยนไม่ได้เป็น fk
        $start_date,
        $end_date,
        $project_value,
        $employee_id, //เปลี่ยนไม่ได้เป็น fk
        $project_status,
        $project_id
    );

    //execute the query
    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'โครงการได้รับการอัปเดตเรียบร้อยแล้ว!',

        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    //close database connection
    $mysqli->close();
}

// Delete peoject
if ($action == 'delete_project') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $id = $_POST["delete"];

    // the query
    $query = "DELETE FROM project WHERE project_id = ?";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param('s', $id);

    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'ลบโปรเจ็กต์สำเร็จแล้ว!',
        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    // close connection
    $mysqli->close();
}

// Adding new product
if ($action == 'update_invoice') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $id = $_POST["update_id"];

    // the query
    $query = "DELETE FROM invoices WHERE invoice = " . $id . ";";
    //$query .= "DELETE FROM customers WHERE invoice = ".$id.";";
    $query .= "DELETE FROM invoice_items WHERE invoice = " . $id . ";";

    unlink('invoices/' . $id . '.pdf');

    // invoice customer information
    // billing
    $customer_name = $_POST['customer_name']; // customer name
    $customer_email = $_POST['customer_email']; // customer email
    $customer_address_1 = $_POST['customer_address_1']; // customer address
    $customer_address_2 = $_POST['customer_address_2']; // customer address
    $customer_town = $_POST['customer_town']; // customer town
    $customer_county = $_POST['customer_county']; // customer county
    $customer_postcode = $_POST['customer_postcode']; // customer postcode
    $customer_phone = $_POST['customer_phone']; // customer phone number

    //shipping
    $customer_name_ship = $_POST['customer_name_ship']; // customer name (shipping)
    $customer_address_1_ship = $_POST['customer_address_1_ship']; // customer address (shipping)
    $customer_address_2_ship = $_POST['customer_address_2_ship']; // customer address (shipping)
    $customer_town_ship = $_POST['customer_town_ship']; // customer town (shipping)
    $customer_county_ship = $_POST['customer_county_ship']; // customer county (shipping)
    $customer_postcode_ship = $_POST['customer_postcode_ship']; // customer postcode (shipping)

    // invoice details
    $invoice_number = $_POST['invoice_id']; // invoice number
    $custom_email = $_POST['custom_email']; // invoice custom email body
    $invoice_date = $_POST['invoice_date']; // invoice date
    $invoice_due_date = $_POST['invoice_due_date']; // invoice due date
    $invoice_subtotal = $_POST['invoice_subtotal']; // invoice sub-total
    $invoice_shipping = $_POST['invoice_shipping']; // invoice shipping amount
    $invoice_discount = $_POST['invoice_discount']; // invoice discount
    $invoice_vat = $_POST['invoice_vat']; // invoice vat
    $invoice_total = $_POST['invoice_total']; // invoice total
    $invoice_notes = $_POST['invoice_notes']; // Invoice notes
    $invoice_type = $_POST['invoice_type']; // Invoice type
    $invoice_status = $_POST['invoice_status']; // Invoice status

    // insert invoice into database
    $query .= "INSERT INTO invoices (
					invoice,
					invoice_date,
					invoice_due_date,
					subtotal,
					shipping,
					discount,
					vat,
					total,
					notes,
					invoice_type,
					status
				) VALUES (
				  	'" . $invoice_number . "',
				  	'" . $invoice_date . "',
				  	'" . $invoice_due_date . "',
				  	'" . $invoice_subtotal . "',
				  	'" . $invoice_shipping . "',
				  	'" . $invoice_discount . "',
				  	'" . $invoice_vat . "',
				  	'" . $invoice_total . "',
				  	'" . $invoice_notes . "',
				  	'" . $invoice_type . "',
				  	'" . $invoice_status . "'
			    );
			";
    // insert customer details into database
    $query .= "INSERT INTO customers (
					invoice,
					custom_email,
					name,
					email,
					address_1,
					address_2,
					town,
					county,
					postcode,
					phone,
					name_ship,
					address_1_ship,
					address_2_ship,
					town_ship,
					county_ship,
					postcode_ship
				) VALUES (
					'" . $invoice_number . "',
					'" . $custom_email . "',
					'" . $customer_name . "',
					'" . $customer_email . "',
					'" . $customer_address_1 . "',
					'" . $customer_address_2 . "',
					'" . $customer_town . "',
					'" . $customer_county . "',
					'" . $customer_postcode . "',
					'" . $customer_phone . "',
					'" . $customer_name_ship . "',
					'" . $customer_address_1_ship . "',
					'" . $customer_address_2_ship . "',
					'" . $customer_town_ship . "',
					'" . $customer_county_ship . "',
					'" . $customer_postcode_ship . "'
				);
			";

    // invoice product items
    foreach ($_POST['invoice_product'] as $key => $value) {
        $item_product = $value;
        // $item_description = $_POST['invoice_product_desc'][$key];
        $item_qty = $_POST['invoice_product_qty'][$key];
        $item_price = $_POST['invoice_product_price'][$key];
        $item_discount = $_POST['invoice_product_discount'][$key];
        $item_subtotal = $_POST['invoice_product_sub'][$key];

        // insert invoice items into database
        $query .= "INSERT INTO invoice_items (
				invoice,
				product,
				qty,
				price,
				discount,
				subtotal
			) VALUES (
				'" . $invoice_number . "',
				'" . $item_product . "',
				'" . $item_qty . "',
				'" . $item_price . "',
				'" . $item_discount . "',
				'" . $item_subtotal . "'
			);
		";
    }

    header('Content-Type: application/json');

    if ($mysqli->multi_query($query)) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'Product has been updated successfully!',
        ));

        //Set default date timezone
        date_default_timezone_set(TIMEZONE);
        //Include Invoicr class
        include 'invoice.php';
        //Create a new instance
        $invoice = new invoicr("A4", CURRENCY, "en");
        //Set number formatting
        $invoice->setNumberFormat('.', ',');
        //Set your logo
        $invoice->setLogo(COMPANY_LOGO, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT);
        //Set theme color
        $invoice->setColor(INVOICE_THEME);
        //Set type
        $invoice->setType("Invoice");
        //Set reference
        $invoice->setReference($invoice_number);
        //Set date
        $invoice->setDate($invoice_date);
        //Set due date
        $invoice->setDue($invoice_due_date);
        //Set from
        $invoice->setFrom(array(COMPANY_NAME, COMPANY_ADDRESS_1, COMPANY_ADDRESS_2, COMPANY_COUNTY, COMPANY_POSTCODE, COMPANY_NUMBER, COMPANY_VAT));
        //Set to
        $invoice->setTo(array($customer_name, $customer_address_1, $customer_address_2, $customer_town, $customer_county, $customer_postcode, "Phone: " . $customer_phone));
        //Ship to
        $invoice->shipTo(array($customer_name_ship, $customer_address_1_ship, $customer_address_2_ship, $customer_town_ship, $customer_county_ship, $customer_postcode_ship, ''));
        //Add items
        // invoice product items
        foreach ($_POST['invoice_product'] as $key => $value) {
            $item_product = $value;
            // $item_description = $_POST['invoice_product_desc'][$key];
            $item_qty = $_POST['invoice_product_qty'][$key];
            $item_price = $_POST['invoice_product_price'][$key];
            $item_discount = $_POST['invoice_product_discount'][$key];
            $item_subtotal = $_POST['invoice_product_sub'][$key];

            if (ENABLE_VAT == true) {
                $item_vat = (VAT_RATE / 100) * $item_subtotal;
            }

            $invoice->addItem($item_product, '', $item_qty, $item_vat, $item_price, $item_discount, $item_subtotal);
        }
        //Add totals
        $invoice->addTotal("Total", $invoice_subtotal);
        if (!empty($invoice_discount)) {
            $invoice->addTotal("Discount", $invoice_discount);
        }
        if (!empty($invoice_shipping)) {
            $invoice->addTotal("Delivery", $invoice_shipping);
        }
        if (ENABLE_VAT == true) {
            $invoice->addTotal("TAX/VAT " . VAT_RATE . "%", $invoice_vat);
        }
        $invoice->addTotal("Total Due", $invoice_total, true);
        //Add Badge
        $invoice->addBadge($invoice_status);
        // Customer notes:
        if (!empty($invoice_notes)) {
            $invoice->addTitle("Customer Notes");
            $invoice->addParagraph($invoice_notes);
        }
        //Add Title
        $invoice->addTitle("Payment information");
        //Add Paragraph
        $invoice->addParagraph(PAYMENT_DETAILS);
        //Set footer note
        $invoice->setFooternote(FOOTER_NOTE);
        //Render the PDF
        $invoice->render('invoices/' . $invoice_number . '.pdf', 'F');
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    // close connection
    $mysqli->close();
}



// Login to system
if ($action == 'login') {

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    session_start();

    extract($_POST);

    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $pass_encrypt = md5($password);

    $query = "SELECT * FROM `employee` WHERE email='$email' AND `password` = '$pass_encrypt'";

    $results = mysqli_query($mysqli, $query) or die(mysqli_error());
    $count = mysqli_num_rows($results);

    if ($count > 0) {
        $row = $results->fetch_assoc();

        $_SESSION['login_email'] = $row['email'];

        // Processing "remember me" option and setting a cookie with a long expiry date
        if (isset($_POST['remember'])) {
            setcookie('remember_me', $_SESSION['login_email'], time() + 604800); // One week (value in seconds)
            session_regenerate_id(true);
        }

        echo json_encode(array(
            'status' => 'Success',
            'message' => 'Login was a success! Transferring you to the system now, hold tight!',
        ));
    } else {
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'Login incorrect, does not exist or there is a problem! Try again!',
        ));
    }
}


// Adding new product
if ($action == 'add_product') {

    // $product_name = $_POST['product_name'];
    // $product_desc = $_POST['product_desc'];
    // $product_price = $_POST['product_price'];

    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $unit = $_POST["unit"];
    $price_per_unit  = $_POST["price_per_unit"];

    //our insert query query
    $query = "INSERT INTO stock
				(
					-- product_name,
					-- product_desc,
					-- product_price
                    product_id,
                    product_name,
                    unit,
                    price_per_unit,
                    void
				)
				VALUES (
					?,
                	?,
                	?,
                    ?,
                    0
                );
              ";

    header('Content-Type: application/json');

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param('ssss', $product_id, $product_name, $unit, $price_per_unit);

    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'เพิ่มสินค้าสำเร็จแล้ว!',

        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    //close database connection
    $mysqli->close();
}


// Update product
if ($action == 'update_product') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // invoice product information
    $getID = $_POST['id']; // id
    $product_name = $_POST['product_name']; // product name
    $unit = $_POST['unit']; // product desc
    $price_per_unit = $_POST['price_per_unit']; // product price

    // the query
    $query = "UPDATE stock SET
				product_name = ?,
				unit = ?,
				price_per_unit = ?
			 WHERE product_id = ?
			";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param(
        'ssss',
        $product_name,
        $unit,
        $price_per_unit,
        $getID
    );

    //execute the query
    if ($stmt->execute()) {
        //if saving success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'อัปเดตสินค้าสำเร็จแล้ว!',

        ));
    } else {
        //if unable to create new record
        echo json_encode(array(
            'status' => 'Error',
            //'message'=> 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.'
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }

    //close database connection
    $mysqli->close();
}

// Adding new product
if ($action == 'delete_product') {

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $id = $_POST["delete"];

    // the query
    // $query = "DELETE FROM stock WHERE product_id = ?";
    $query = "UPDATE stock SET void = 1 WHERE product_id = ?";

    /* Prepare statement */
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
    }

    /* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
    $stmt->bind_param('s', $id);

    //execute the query
    if ($stmt->execute()) {
        //if updating success
        echo json_encode(array(
            'status' => 'Success',
            'message' => 'เปลี่ยนสถานะสินค้าสำเร็จแล้ว!',
        ));
    } else {
        //if unable to update record
        echo json_encode(array(
            'status' => 'Error',
            'message' => 'มีข้อผิดพลาดเกิดขึ้น โปรดลองอีกครั้ง.<pre>' . $mysqli->error . '</pre><pre>' . $query . '</pre>',
        ));
    }


    // close connection
    $mysqli->close();
}
