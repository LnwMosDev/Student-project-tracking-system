<?php

include 'header.php';

// เชื่อมต่อฐานข้อมูล
include_once "includes/config.php";

// ตรวจสอบการเชื่อมต่อ
if ($mysqli->connect_error) {
	die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $mysqli->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงรายชื่อลูกค้า
$customer_query = "SELECT customer_id, first_name FROM customer"; // แทน 'customer' และ 'customer_id' ด้วยชื่อตารางและคอลัมน์ที่เหมาะสม

$employee_query = "SELECT employee_id, first_name FROM employee";

// ประมวลผลคำสั่ง SQL
$customer_result = $mysqli->query($customer_query);

$employee_result = $mysqli->query($employee_query);

// ตรวจสอบว่ามีข้อมูลลูกค้าหรือไม่
if ($customer_result->num_rows > 0) {
	$customer_options = '';
	while ($row = $customer_result->fetch_assoc()) {
		$customer_id = $row['customer_id'];
		$first_name = $row['first_name'];
		$customer_options .= "<option value='$customer_id'>รหัสลูกค้า: $customer_id   ชื่อ:$first_name</option>";
	}
} else {
	// ไม่พบข้อมูลลูกค้า
	$customer_options = "<option value=''>ไม่พบข้อมูลลูกค้า</option>";
}

if ($employee_result->num_rows > 0) {
	$employee_options = '';
	while ($row = $employee_result->fetch_assoc()) {
		$employee_id = $row['employee_id'];
		$first_name = $row['first_name'];
		$employee_options .= "<option value='$employee_id'>รหัสพนักงาน: $employee_id   ชื่อ:$first_name</option>";
	}
} else {
	// ไม่พบข้อมูลลูกค้า
	$employee_options = "<option value=''>ไม่พบข้อมูลลูกค้า</option>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$mysqli->close();
?>

<h1>เพิ่มข้อมูลโครงการ</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_project">
	<input type="hidden" name="action" value="create_project">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>ข้อมูลโครงการ</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">รหัสโครงการ</label>
							<div class="col-sm-1" align="left">
								<input name="project_id" type="text" required class="form-control" placeholder="รหัสโครงการ" minlength="2" />
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">ชื่อโครงการ</label>
							<div class="col-sm-4" align="left">
								<input name="project_name" type="text" required class="form-control" placeholder="ชื่อโครงการ" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">รหัสลูกค้า</label>
							<div class="col-sm-4" align="left">
								<select name="customer_id" required class="form-control">
									<?php echo $customer_options; ?>
								</select>
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">วันที่เริ่มโครงการ</label>
							<div class="col-sm-4" align="left">
								<input name="start_date" type="date" required class="form-control" placeholder="วันที่เริ่มโครงการ" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">วันที่สิ้นสุดโครงการ</label>
							<div class="col-sm-4" align="left">
								<input name="end_date" type="date" required class="form-control" placeholder="วันที่สิ้นสุดโครงการ" minlength="2" />
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">มูลค่าโครงการ</label>
							<div class="col-sm-4" align="left">
								<input name="project_value" type="text" required class="form-control" placeholder="มูลค่าโครงการ" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">ผู้ดูแลโครงการ</label>
							<div class="col-sm-4" align="left">
								<select name="employee_id" required class="form-control">
									<?php echo $employee_options; ?>
								</select>
							</div>

						</div>
						<!-- <div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">สถานะโครงการ</label>
							<div class="col-sm-4" align="left">
								<input name="project_status" type="text" required class="form-control" placeholder="สถานะโครงการ" minlength="2" />
							</div>
							
						</div> -->
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">สถานะโครงการ</label>
							<div class="col-sm-4" align="left">
								<select name="project_status" class="form-control">
									<option value="0" selected>ยกเลิก</option>
									<option value="1">อยู่ระหว่างดําเนินการ</option>
									<option value="2">ปิดโครงการ</option>
								</select>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_create_project" class="btn btn-success" value="เพิ่มโครงการ" style="margin: 0 10px 0 120px;" data-loading-text="Creating...">
							<input type="reset" class="btn btn-danger" value="ล้างค่า">
							<a href="project-list.php" class="btn btn-primary float-right">กลับไปยังรายการโครงการ</a>
						</div>
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