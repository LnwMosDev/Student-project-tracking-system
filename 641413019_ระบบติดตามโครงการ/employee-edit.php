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

// the query
$query = "SELECT * FROM employee WHERE employee_id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {

		$employee_id  = $row['employee_id']; // customer name
		$first_name = $row['first_name']; // customer name
		$last_name = $row['last_name']; // customer address
		$address = $row['address']; // customer address
		$sub_district = $row['sub_district']; // customer town
		$district = $row['district']; // customer county
		$province = $row['province']; // customer postcode
		$postal_code = $row['postal_code']; // customer email
		$phone_number = $row['phone_number']; // customer email
		$email = $row['email']; // customer phone number
		$start_date = $row['start_date']; // customer email
		$password = $row['password']; // customer email
		$job_title = $row['job_title']; // customer email

	}
}

/* close connection */
$mysqli->close();

?>

<h1>จัดการข้อมูลพนักงาน</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="update_employee">
<input type="hidden" name="action" value="update_employee">
<input type="hidden" name="id" value="<?php echo $getID; ?>">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<!-- <h4>แก้ไขข้อมูลพนักงาน employee ID : <?php echo $getID; ?> </h4> -->
					<h4>แก้ไขข้อมูลพนักงาน </h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">

						<div class="row">
						<div class="form-group row">
    <label class="col-sm-1 col-form-label" align="right"></label>
    <div class="col-sm-4" align="left">
        <input name="employee_id" value="<?php echo $employee_id; ?>" type="hidden" required />
    </div>
</div>

							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">ชื่อ</label>
								<div class="col-sm-4" align="left">
									<input name="first_name" value="<?php echo $first_name; ?>" type="text" required class="form-control" placeholder="ชื่อ" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">นามสกุล</label>
								<div class="col-sm-4" align="left">
									<input name="last_name" value="<?php echo $last_name; ?>" type="text" required class="form-control" placeholder="นามสกุล" minlength="2" />
								</div>

							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">ที่อยู่</label>
								<div class="col-sm-4" align="left">
									<input name="address" type="text" value="<?php echo $address; ?>" required class="form-control" placeholder="ที่อยู่" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">ตำบล</label>
								<div class="col-sm-4" align="left">
									<input name="sub_district" value="<?php echo $sub_district; ?>" type="text" required class="form-control" placeholder="ตำบล" minlength="2" />
								</div>

							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">อำเภอ</label>
								<div class="col-sm-4" align="left">
									<input name="district" value="<?php echo $district; ?>" type="text" required class="form-control" placeholder="อำเภอ" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">จังหวัด</label>
								<div class="col-sm-4" align="left">
									<input name="province" value="<?php echo $province; ?>" type="text" required class="form-control" placeholder="จังหวัด" minlength="2" />
								</div>

							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">รหัสไปรษณีย์</label>
								<div class="col-sm-4" align="left">
									<input name="postal_code" value="<?php echo $postal_code; ?>" type="text" required class="form-control" placeholder="รหัสไปรษณีย์" minlength="2" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">เบอร์โทร</label>
								<div class="col-sm-4" align="left">
									<input name="phone_number" value="<?php echo $phone_number; ?>" type="text" class="form-control" placeholder="เบอร์โทร" required />
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">อีเมล์</label>
								<div class="col-sm-4" align="left">
									<input name="email" value="<?php echo $email; ?>" type="email" class="form-control" placeholder="อีเมล์" required />
								</div>
								<label class="col-sm-1 col-form-label" align="right">วันที่เริ่มงาน</label>
								<div class="col-sm-4" align="left">
									<input name="start_date" value="<?php echo $start_date; ?>" type="date" required class="form-control" />
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">รหัสผ่าน</label>
								<div class="col-sm-4" align="left">
									<input name="password" value="<?php echo $password; ?>" type="password" required class="form-control" placeholder="รหัสผ่าน" minlength="6" />
								</div>
								<label class="col-sm-1 col-form-label" align="right">ตำแหน่งงาน</label>
								<div class="col-sm-4" align="left">
									<input name="job_title" value="<?php echo $job_title; ?>" type="text" required class="form-control" placeholder="ตำแหน่งงาน" minlength="2" />
								</div>
							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-1 col-form-label" align="right">ตำแหน่งงาน</label>
								<div class="col-sm-4" align="left">
									<input name="job_title" value="<?php echo $job_title; ?>" type="text" required class="form-control" placeholder="ตำแหน่งงาน" minlength="2" />
								</div>
							</div> -->
						</div>
						<div class="row">
							<div class="col-xs-12 margin-top btn-group">
								<input type="submit" id="action_update_employee" class="btn btn-success float-right" value="แก้ไขข้อมูลพนักงาน" data-loading-text="Updating...">
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