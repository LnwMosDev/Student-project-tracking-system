<?php

include 'header.php';
include 'functions.php';

$getID = $_GET['id'];

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงรายชื่อลูกค้า
$customer_query = "SELECT customer_id, first_name FROM customer"; // แทน 'customer' และ 'customer_id' ด้วยชื่อตารางและคอลัมน์ที่เหมาะสม

$employee_query = "SELECT employee_id, first_name FROM employee";

// ประมวลผลคำสั่ง SQL
$customer_result = $mysqli->query($customer_query);

$employee_result = $mysqli->query($employee_query);

// // ตรวจสอบว่ามีข้อมูลลูกค้าหรือไม่
// if ($customer_result->num_rows > 0) {
// 	$customer_options = '';
// 	while ($row = $customer_result->fetch_assoc()) {
// 		$customer_id = $row['customer_id'];
// 		$first_name = $row['first_name'];
// 		$customer_options .= "<option value='$customer_id'>รหัสลูกค้า: $customer_id   ชื่อ:$first_name</option>";
// 	}
// } else {
// 	// ไม่พบข้อมูลลูกค้า
// 	$customer_options = "<option value=''>ไม่พบข้อมูลลูกค้า</option>";
// }

// if ($employee_result->num_rows > 0) {
// 	$employee_options = '';
// 	while ($row = $employee_result->fetch_assoc()) {
// 		$employee_id = $row['employee_id'];
// 		$first_name = $row['first_name'];
// 		$employee_options .= "<option value='$employee_id'>รหัสพนักงาน: $employee_id   ชื่อ:$first_name</option>";
// 	}
// } else {
// 	// ไม่พบข้อมูลลูกค้า
// 	$employee_options = "<option value=''>ไม่พบข้อมูลลูกค้า</option>";
// }

// the query
$query = "SELECT * FROM project WHERE project_id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$project_id = $row["project_id"];
		$project_name = $row["project_name"];
		$customer_id = $row["customer_id"];
		$start_date = $row["start_date"];
		$end_date = $row["end_date"];
		$project_value = $row["project_value"];
		$employee_id = $row["employee_id"];
		$project_status = $row["project_status"];
	}
}

/* close connection */
$mysqli->close();

?>

<h1>จัดการข้อมูลโปรเจค</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="update_project">
	<input type="hidden" name="action" value="update_project">
	<input type="hidden" name="id" value="<?php echo $getID; ?>">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<!-- <h4>แก้ไขข้อมูลโปรเจค : <?php echo $getID; ?> </h4> -->
					<h4>แก้ไขข้อมูลโปรเจค</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">

						<div class="row ">
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">รหัสโครงการ</label>
								<div class="col-sm-1" align="left">
									<input name="project_id" value="<?php echo $project_id; ?>" type="text" required class="form-control" placeholder="รหัสโครงการ" minlength="2" />
								</div>

							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">ชื่อโครงการ</label>
								<div class="col-sm-4" align="left">
									<input name="project_name" value="<?php echo $project_name; ?>" type="text" required class="form-control" placeholder="ชื่อโครงการ" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">รหัสลูกค้า</label>
								<div class="col-sm-4" align="left">
									<select name="customer_id" required class="form-control">
										<?php
										foreach ($customer_result as $row) {
											$cid = $row['customer_id'];
											$firstName = $row['first_name'];
											$selected = ($cid == $customer_id) ? 'selected' : '';
											echo "<option value='$cid' $selected>รหัสลูกค้า: $cid   ชื่อ:$firstName</option>";
										}
										?>
									</select>
								</div>


							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">วันที่เริ่มโครงการ</label>
								<div class="col-sm-4" align="left">
									<input name="start_date" value="<?php echo $start_date; ?>" type="date" required class="form-control" placeholder="วันที่เริ่มโครงการ" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">วันที่สิ้นสุดโครงการ</label>
								<div class="col-sm-4" align="left">
									<input name="end_date" value="<?php echo $end_date; ?>" type="date" required class="form-control" placeholder="วันที่สิ้นสุดโครงการ" minlength="2" />
								</div>

							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">มูลค่าโครงการ</label>
								<div class="col-sm-4" align="left">
									<input name="project_value" value="<?php echo $project_value; ?>" type="text" required class="form-control" placeholder="มูลค่าโครงการ" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">ผู้ดูแลโครงการ</label>
								<div class="col-sm-4" align="left">
									<select name="employee_id" required class="form-control">
										<?php
										foreach ($employee_result as $row) {
											$eid = $row['employee_id'];
											$firstName = $row['first_name'];
											$selected = ($eid == $employee_id) ? 'selected' : '';
											echo "<option value='$eid' $selected>รหัสพนักงาน: $eid   ชื่อ:$firstName</option>";
										}
										?>
									</select>

								</div>

							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">สถานะโครงการ</label>
								<div class="col-sm-4" align="left">
									<input name="project_status" value="<?php echo $project_status; ?>" type="text" required class="form-control" placeholder="สถานะโครงการ" minlength="2" />
								</div>
							</div> -->
							<div class="form-group row">
							
									<label class="col-sm-1 col-form-label" align="right">สถานะโครงการ</label>
									<div class="col-sm-4" align="left">
										<select name="project_status" class="form-control">
											<option value="0" <?php echo ($project_status == 0) ? 'selected' : ''; ?>>ยกเลิก</option>
											<option value="1" <?php echo ($project_status == 1) ? 'selected' : ''; ?>>อยู่ระหว่างดำเนินการ</option>
											<option value="2" <?php echo ($project_status == 2) ? 'selected' : ''; ?>>ปิดโครงการ</option>
										</select>
									</div>
								</div>

							</div>

						</div>
						<!-- <div class="row">
							<div class="col-xs-12 margin-top btn-group ">
								<input type="submit" id="action_update_project" class="btn btn-success float-right " value="Update project" data-loading-text="Updating...">

							</div>
						</div> -->
						<div class="row">
							<div class="col-xs-12 margin-top btn-group">
								<button type="submit" id="action_update_project" class="btn btn-success float-right" value="Update project" data-loading-text="Updating...">
								แก้ไขข้อมูลโปรเจค</button>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

</form>

<?php
include 'footer.php';
?>