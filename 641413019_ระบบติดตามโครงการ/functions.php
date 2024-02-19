<?php

include_once "includes/config.php";

// get invoice list
function getInvoices()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    $query = "SELECT *
		FROM invoices i
		JOIN customers c
		ON c.invoice = i.invoice
		WHERE i.invoice = c.invoice
		ORDER BY i.invoice";

    // mysqli select query
    $results = $mysqli->query($query);

    // mysqli select query
    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

				<th>Invoice</th>
				<th>doc_number</th>
				<th>record_date</th>
				<th>receipt_number</th>
				<th>receipt_date</th>
				<th>project_id</th>
				<th>amount</th>
				<th>status</th>
				<th>Actions</th>

			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {

            print '
				<tr>
					<td>' . $row["invoice"] . '</td>
					<td>' . $row["name"] . '</td>
				    <td>' . $row["invoice_date"] . '</td>
				    <td>' . $row["invoice_due_date"] . '</td>
				    <td>' . $row["invoice_type"] . '</td>
				';

            if ($row['status'] == "open") {
                print '<td><span class="label label-primary">' . $row['status'] . '</span></td>';
            } elseif ($row['status'] == "paid") {
                print '<td><span class="label label-success">' . $row['status'] . '</span></td>';
            }

            print '
				    <td><a href="invoice-edit.php?id=' . $row["invoice"] . '" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a href="#" data-invoice-id="' . $row['invoice'] . '" data-email="' . $row['email'] . '" data-invoice-type="' . $row['invoice_type'] . '" data-custom-email="' . $row['custom_email'] . '" class="btn btn-success btn-xs email-invoice"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> <a href="invoices/' . $row["invoice"] . '.pdf" class="btn btn-info btn-xs" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a> <a data-invoice-id="' . $row['invoice'] . '" class="btn btn-danger btn-xs delete-invoice"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
			';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no invoices to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}

// Initial invoice number
function getInvoiceId()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $query = "SELECT invoice FROM invoices ORDER BY invoice DESC LIMIT 1";

    if ($result = $mysqli->query($query)) {

        $row_cnt = $result->num_rows;

        $row = mysqli_fetch_assoc($result);

        //var_dump($row);

        if ($row_cnt == 0) {
            echo INVOICE_INITIAL_VALUE;
        } else {
            echo $row['invoice'] + 1;
        }

        // Frees the memory associated with a result
        $result->free();

        // close connection
        $mysqli->close();
    }
}

function getDocNumber($conn)
{
    $docNumber = 1;

    $sql = "SELECT MAX(customer_id) AS customer_id FROM customer";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    while ($row = mysqli_fetch_array($result)) {
        if ($row["customer_id"] !== null) {
            $docNumber = $row["customer_id"] + 1;
        }
    }

    return $docNumber;
}

function getEmployees()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    // $query = "SELECT * FROM employee ORDER BY employee_id ASC";
    $query = "SELECT * FROM employee WHERE void = 0 ORDER BY employee_id ASC";

    // mysqli select query
    $results = $mysqli->query($query);



    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

        <th>
                    <center>รหัสพนักงาน</center>
                </th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                
                <th>อีเมล</th>
                <th>พาสเวิร์ด</th>
                <th>วันที่เริ่ม</th>
                <th>ตำแหน่ง</th>
                <th>จัดการ</th>

			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
			    <tr>
               
					<td>' . $row["employee_id"] . '</td>
				    <td>' . $row["first_name"] . '</td>
				    <td>' . $row["last_name"] . '</td>
				 
				    <td>' . $row["email"] . '</td>
				    <td>' . $row["password"] . '</td>
				    <td>' . $row["start_date"] . '</td>
				    <td>' . $row["job_title"] . '</td>
				   
				    <td><a href="employee-edit.php?id=' . $row["employee_id"] . '" class="btn btn-success btn-xl"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-employee-id="' . $row['employee_id'] . '" class="btn btn-danger btn-xl delete-employee"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no products to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}

function getProjects()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    $query = "SELECT p.*, cu.first_name AS customer_first_name, emp.first_name AS employee_first_name
    FROM project p
    LEFT JOIN customer cu ON p.customer_id = cu.customer_id
    LEFT JOIN employee emp ON p.employee_id = emp.employee_id";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

        <th>
                    <center>รหัสโปรเจค</center>
                </th>
                <th>ชื่อโปรเจค</th>
                <th>รหัสลูกค้า</th>
                <th>วันที่เริ่มโครงการ</th>
                <th>วันที่สิ้นสุดโครงการ</th>
                <th>มูลค่าโครงการ</th>
                <th>ผู้ดูแลโครงการ</th>
                <th>สถานะโครงการ</th>
                <th>จัดการ</th>

			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {

            print '
			    <tr>
               
					<td>' . $row["project_id"] . '</td>
				    <td>' . $row["project_name"] . '</td>
				    <td>' . $row["customer_first_name"] . '</td>
				    <td>' . $row["start_date"] . '</td>
                    <td>' . $row["end_date"] . '</td>
				    <td>' . $row["project_value"] . '</td>
				    <td>' . $row["employee_first_name"] . '</td>
                    <td>' . $row["project_status"] . '</td>
 
				    <td><a href="project-edit.php?id=' . $row["project_id"] . '" class="btn btn-success btn-xl"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-project-id="' . $row['project_id'] . '" class="btn btn-danger btn-xl delete-project"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no products to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}

// populate product dropdown for invoice creation
function popProductsList()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // The query
    $query = "SELECT * FROM stock ORDER BY product_id ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {
        echo '<select class="form-control item-select">';
        while ($row = $results->fetch_assoc()) {
            $product_id = $row["product_id"];
            $product_name = $row["product_name"];
            $price_per_unit = $row["price_per_unit"];
            $unit = $row["unit"]; // เพิ่มการดึงหน่วย

            // เพิ่ม data-unit attribute ในแต่ละ option
            echo '<option value="' . $product_id . '" data-unit="' . $unit . '" data-price="' . $price_per_unit . '">' . $product_name . '</option>';
        }
        echo '</select>';
    } else {
        echo "<p>There are no products, please add a product.</p>";
    }

    // Free the memory associated with a result
    $results->free();

    // Close the connection
    $mysqli->close();
}



function popProjectsList()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // The query to retrieve a list of projects with customer names
    $query = "SELECT p.project_id, p.project_name, p.customer_id, c.name AS name, c.surname AS surname
              FROM project AS p
              INNER JOIN customer AS c ON p.customer_id = c.customer_id
              ORDER BY p.project_id ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
            <th>Project ID</th>
            <th>Project Name</th>
            <th>Customer ID</th>
            <th>Customer Name-surname</th>
            <th>Action</th>
        </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row["project_id"] . '</td>
                    <td>' . $row["project_name"] . '</td>
                    <td>' . $row["customer_id"] . '</td>
                    <td>' . $row["name"] . ' ' . $row["surname"] . '</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-xs project-select"
                            data-project-id="' . $row['project_id'] . '"
                            data-project-name="' . $row['project_name'] . '"
                            data-customer-id="' . $row['customer_id'] . '"
                            data-name="' . $row['name'] . '"
                            data-surname="' . $row['surname'] . '">Select</a>
                    </td>
                </tr>
            ';
        }

        print '</tbody></table>';
    } else {
        echo "<p>There are no projects to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // Close connection
    $mysqli->close();
}

function popProjectList()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // The query to retrieve a list of projects with customer names
    $query = "SELECT p.project_id, p.project_name, p.customer_id, c.first_name AS first_name, c.last_name AS last_name
              FROM project AS p
              INNER JOIN customer AS c ON p.customer_id = c.customer_id
              ORDER BY p.project_id ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
            <th>รหัสโปรเจค</th>
            <th>ชื่อโปรเจค</th>
            <th>ชื่อลูกค้า</th>
            <th>จัดการ</th>
        </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row["project_id"] . '</td>
                    <td>' . $row["project_name"] . '</td>
                    <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-xs project-select"
                            data-project-id="' . $row['project_id'] . '"
                            data-project-name="' . $row['project_name'] . '"
                            data-customer-id="' . $row['customer_id'] . '"
                            data-first-name="' . $row['first_name'] . '"
                            data-last-name="' . $row['last_name'] . '">Select</a>
                    </td>
                </tr>
            ';
        }

        print '</tbody></table>';
    } else {
        echo "<p>There are no projects to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // Close connection
    $mysqli->close();
}

function popCloseProjectList()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // The query to retrieve data from multiple tables using INNER JOIN
    $query = "SELECT projcost_hd.doc_number, projcost_hd.project_id, project.employee_id, project.project_name
              FROM projcost_hd
              INNER JOIN projcost_desc ON projcost_hd.doc_number = projcost_desc.doc_number
              INNER JOIN project ON projcost_hd.project_id = project.project_id";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results->num_rows > 0) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
        <th>เลขที่เอกสาร</th>
        <th>รหัสโปรเจค</th>
        <th>รหัสลูกค้า</th>
        <th>ชื่อโปรเจค</th>
        <th>จัดการ</th>
        </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row['doc_number'] . '</td>
                    <td>' . $row['project_id'] . '</td>
                    <td>' . $row['employee_id'] . '</td>
                    <td>' . $row['project_name'] . '</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-xs closeproject-select"
                            data-doc-number="' . $row['doc_number'] . '"
                            data-project-id="' . $row['project_id'] . '"
                            data-employee-id="' . $row['employee_id'] . '"
                            data-project-name="' . $row['project_name'] . '">Select</a>
                    </td>
                </tr>
            ';
        }

        print '</tbody></table>';
    } else {
        echo "<p>There are no projects to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // Close connection
    $mysqli->close();
}



// populate product dropdown for invoice creation
function popCustomersList()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    $query = "SELECT * FROM store_customers ORDER BY name ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>
			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {

            print '
			    <tr>
					<td>' . $row["name"] . '</td>
				    <td>' . $row["email"] . '</td>
				    <td>' . $row["phone"] . '</td>
				    <td><a href="#" class="btn btn-primary btn-xs customer-select" data-customer-name="' . $row['name'] . '" data-customer-email="' . $row['email'] . '" data-customer-phone="' . $row['phone'] . '" data-customer-address-1="' . $row['address_1'] . '" data-customer-address_2="' . $row['address_2'] . '" data-customer-town="' . $row['town'] . '" data-customer-county="' . $row['county'] . '" data-customer-postcode="' . $row['postcode'] . '" data-customer-name-ship="' . $row['name_ship'] . '" data-customer-address-1-ship="' . $row['address_1_ship'] . '" data-customer-address-2-ship="' . $row['address_2_ship'] . '" data-customer-town-ship="' . $row['town_ship'] . '" data-customer-county-ship="' . $row['county_ship'] . '" data-customer-postcode-ship="' . $row['postcode_ship'] . '">Select</a></td>
			    </tr>
		    ';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no customers to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}

// get products list
function getProducts()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    // $query = "SELECT * FROM stock ORDER BY product_name ASC";
    $query = "SELECT * FROM stock WHERE void = 0 ORDER BY product_name ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

        <th>
        <center>รหัสสินค้า</center>
    </th>
    <th>ชื่อสินค้า</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>จัดการ</th>
			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {

            print '
			    <tr>

					<td>' . $row["product_id"] . '</td>
				    <td>' . $row["product_name"] . '</td>
				    <td>' . $row["unit"] . '</td>
				    <td>$' . $row["price_per_unit"] . '</td>
				    <td><a href="product-edit.php?id=' . $row["product_id"] . '" class="btn btn-success btn-xl"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-product-id="' . $row['product_id'] . '" class="btn btn-danger btn-xl delete-product"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no products to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}

// get user list
function getUsers()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    $query = "SELECT * FROM users ORDER BY username ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>

			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {

            print '
			    <tr>
			    	<td>' . $row['name'] . '</td>
					<td>' . $row["username"] . '</td>
				    <td>' . $row["email"] . '</td>
				    <td>' . $row["phone"] . '</td>
				    <td><a href="user-edit.php?id=' . $row["id"] . '" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-user-id="' . $row['id'] . '" class="btn btn-danger btn-xs delete-user"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no users to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}

// get user list
function getCustomers()
{

    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // the query
    $query = "SELECT * FROM customer WHERE void = 0 ORDER BY first_name ASC";

    // mysqli select query
    $results = $mysqli->query($query);

    // <th>Address</th>
    // <th>Sub District</th>
    // <th>District</th>
    // <th>Province</th>
    // <th>Postal Code</th>
    // <th>phone_number</th>

    // <td>' . $row["address"] . '</td>
    // <td>' . $row["sub_district"] . '</td>
    // <td>' . $row["district"] . '</td>
    // <td>' . $row["province"] . '</td>
    // <td>' . $row["postal_code"] . '</td>
    // <td>' . $row["phone_number"] . '</td>

    if ($results) {

        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
        <th>รหัสลูกค้า</th>
        <th>ชื่อ</th>
        <th>นามสกุล</th>
        <th>อีเมล</th>
        <th>จัดการ</th>

			  </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {

            print '
			    <tr>
					<td>' . $row["customer_id"] . '</td>
					<td>' . $row["first_name"] . '</td>
				    <td>' . $row["last_name"] . '</td>
				   
				    <td>' . $row["email"] . '</td>
				    <td><a href="customer-edit.php?id=' . $row["customer_id"] . '" class="btn btn-success btn-xl"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-customer-id="' . $row['customer_id'] . '" class="btn btn-danger btn-xl delete-customer"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
        }

        print '</tr></tbody></table>';
    } else {

        echo "<p>There are no customers to display.</p>";
    }

    // Frees the memory associated with a result
    $results->free();

    // close connection
    $mysqli->close();
}
