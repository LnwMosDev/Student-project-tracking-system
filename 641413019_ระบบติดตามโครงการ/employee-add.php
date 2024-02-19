<?php

include 'header.php';

?>

<h1>เพิ่มข้อมูลพนักงาน</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="add_employee">
	<input type="hidden" name="action" value="add_employee">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>ข้อมูลพนักงาน</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">รหัสพนักงาน</label>
							<div class="col-sm-1" align="left">
								<input name="employee_id" type="text" required class="form-control" placeholder="รหัสพนักงาน" minlength="2" />
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">ชื่อ</label>
							<div class="col-sm-4" align="left">
								<input name="first_name" type="text" required class="form-control" placeholder="ชื่อ" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">นามสกุล</label>
							<div class="col-sm-4" align="left">
								<input name="last_name" type="text" required class="form-control" placeholder="นามสกุล" minlength="2" />
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">ที่อยู่</label>
							<div class="col-sm-4" align="left">
								<input name="address" type="text" required class="form-control" placeholder="ที่อยู่" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">ตำบล</label>
							<div class="col-sm-4" align="left">
								<input name="sub_district" type="text" required class="form-control" placeholder="ตำบล" minlength="2" />
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">อำเภอ</label>
							<div class="col-sm-4" align="left">
								<input name="district" type="text" required class="form-control" placeholder="อำเภอ" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">จังหวัด</label>
							<div class="col-sm-4" align="left">
								<input name="province" type="text" required class="form-control" placeholder="จังหวัด" minlength="2" />
							</div>

						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">รหัสไปรษณีย์</label>
							<div class="col-sm-4" align="left">
								<input name="postal_code" type="text" required class="form-control" placeholder="รหัสไปรษณีย์" minlength="2" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">เบอร์โทร</label>
							<div class="col-sm-4" align="left">
								<input name="phone_number" type="text" class="form-control" placeholder="เบอร์โทร" required />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">อีเมล์</label>
							<div class="col-sm-4" align="left">
								<input name="email" type="email" class="form-control" placeholder="อีเมล์" required />
							</div>
							<label class="col-sm-1 col-form-label" align="right">วันที่เริ่มงาน</label>
							<div class="col-sm-4" align="left">
								<input name="start_date" type="date" required class="form-control" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-1 col-form-label" align="right">รหัสผ่าน</label>
							<div class="col-sm-4" align="left">
								<input name="password" type="password" required class="form-control" placeholder="รหัสผ่าน" minlength="6" />
							</div>
							<label class="col-sm-1 col-form-label" align="right">ตำแหน่งงาน</label>
							<div class="col-sm-4" align="left">
								<input name="job_title" type="text" required class="form-control" placeholder="ตำแหน่งงาน" minlength="2" />
							</div>
						</div>
						<!-- <div class="form-group row">
							
						</div> -->
					</div>
					<!-- <div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_add_employee" class="btn btn-success float-right" value="เพิ่มข้อมูลพนักงาน" data-loading-text="Creating...">
						</div>
					</div> -->

					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_add_employee" class="btn btn-success" value="เพิ่มข้อมูลพนักงาน" style="margin-right:10px ;" data-loading-text="Creating...">
							<input type="reset" class="btn btn-danger" value="ล้างค่า">
							<a href="employee-list.php" class="btn btn-primary float-right">กลับไปยังรายชื่อพนักงาน</a>
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