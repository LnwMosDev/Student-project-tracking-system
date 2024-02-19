<?php

include 'header.php';

?>

<h1>เพิ่มข้อมูลลูกค้า</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_customer" >
	<input type="hidden" name="action" value="create_customer">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>ข้อมูลลูกค้า</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="form-group row">
						<label class="col-sm-1 col-form-label" align="right">รหัสลูกค้า</label>
						<div class="col-sm-1" align="left">
							<input name="customer_id" id="customer_id"type="text" required class="form-control" placeholder="รหัสลูกค้า" minlength="2" />
						</div>

					</div>
					<div class="form-group row">
						<label class="col-sm-1 col-form-label" align="right">ชื่อ</label>
						<div class="col-sm-4" align="left">
							<input name="first_name" id="first_name" type="text" required class="form-control" placeholder="ชื่อ" minlength="2" />
						</div>
						<label class="col-sm-1 col-form-label" align="right">นามสกุล</label>
						<div class="col-sm-4" align="left">
							<input name="last_name" id="last_name" type="text" required class="form-control" placeholder="นามสกุล" minlength="2" />
						</div>

					</div>
					<div class="form-group row">
						<label class="col-sm-1 col-form-label" align="right">ที่อยู่</label>
						<div class="col-sm-4" align="left">
							<input name="address" id="address" type="text" required class="form-control" placeholder="ที่อยู่" minlength="2" />
						</div>
						<label class="col-sm-1 col-form-label" align="right">ตำบล</label>
						<div class="col-sm-4" align="left">
							<input name="sub_district" id="sub_district" type="text" required class="form-control" placeholder="ตำบล" minlength="2" />
						</div>

					</div>
					<div class="form-group row">
						<label class="col-sm-1 col-form-label" align="right">อำเภอ</label>
						<div class="col-sm-4" align="left">
							<input name="district" id="district" type="text" required class="form-control" placeholder="อำเภอ" minlength="2" />
						</div>
						<label class="col-sm-1 col-form-label" align="right">จังหวัด</label>
						<div class="col-sm-4" align="left">
							<input name="province" id="province" type="text" required class="form-control" placeholder="จังหวัด" minlength="2" />
						</div>

					</div>
					<div class="form-group row">
						<label class="col-sm-1 col-form-label" align="right">รหัสไปรษณีย์</label>
						<div class="col-sm-4" align="left">
							<input name="postal_code" id="postal_code" type="text" required class="form-control" placeholder="รหัสไปรษณีย์" minlength="2" />
						</div>
						<label class="col-sm-1 col-form-label" align="right">เบอร์โทร</label>
						<div class="col-sm-4" align="left">
							<input name="phone_number" id="phone_number" type="text" class="form-control" placeholder="เบอร์โทร" required />
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-1 col-form-label" align="right">อีเมล์</label>
						<div class="col-sm-4" align="left">
							<input name="email" id="email" type="email" class="form-control" placeholder="อีเมล์" required />
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_create_customer" class="btn btn-success float-right" value="เพิ่มข้อมูลลูกค้า" data-loading-text="Creating...">
						</div>
					</div> -->

					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_create_customer" class="btn btn-success" value="เพิ่มข้อมูลลูกค้า" style="margin-right:10px ;" data-loading-text="Creating...">
							<input type="reset" class="btn btn-danger" value="ล้างค่า">
							<a href="customer-list.php" class="btn btn-primary float-right">กลับไปยังรายชื่อลูกค้า</a>
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