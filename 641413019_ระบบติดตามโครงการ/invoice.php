<?php
include 'header.php';
include 'functions.php';

$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

$stoday = date("d-m-Y"); // รับวันที่ปัจจุบันในรูปแบบ d-m-Y
$docdate = date("Y-m-d"); // รับวันที่ปัจจุบันในรูปแบบ Y-m-d
$fdoc = substr($stoday, 8, 2) . substr($stoday, 3, 2); // แยกปี (2 หลัก) + เดือน (2 หลัก)
$no = 1; // กำหนดค่าเริ่มต้นของ $no เป็น 1
$newCode = 1;

// ค้นหาหมายเลขเอกสาร
$sql = "SELECT MAX(doc_number) AS MAX_ID FROM projcost_hd ";
$sql .= "WHERE doc_number LIKE '$fdoc%'";
$objQuery = mysqli_query($mysqli, $sql);

// ถ้ามีข้อมูล
while ($objResult = mysqli_fetch_array($objQuery)) {
	if ($objResult["MAX_ID"] != "") {
		$no = $objResult["MAX_ID"] + 1; // เพิ่มค่าล่าสุด
	}
}

$docno = "0000" . (string) $no; // เพิ่มเลข 0 ด้านหน้าเพื่อให้มี 4 หลัก
$docno = substr($docno, -3); // รับเฉพาะ 4 หลักสุดท้าย
$docno = $fdoc . $docno; // เลขเอกสารใหม่คือ YYMM ตามด้วยหมายเลข


$no = 1;
$sql = "SELECT MAX(customer_id) AS customer_id FROM customer";
$objQuery = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

while ($objResult = mysqli_fetch_array($objQuery)) {
	if ($objResult["customer_id"] != "") {
		$no = $objResult["customer_id"] + 1;
	}
}

$customer_id = "00" . (string) $no; // เพิ่ม 0 ข้างหน้าให้ครบ 3 หลัก
$customer_id = substr($customer_id, -2); // เอา 3 ตัวสุดท้าย

?>

<head>


</head>
<h2><span class="invoice_type"></span> </h2>


<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_invoice">
	<div class="">
		<input type="hidden" name="action" value="create_invoice">

		<div class="row ">
			<div class="col-xs-4">
			</div>
			<div class="col-xs-8 ">
				<div class="row">
					<div class="col-xs-6 ">
						<h2 class="">บันทึกค่าใช้จ่ายโครงการ</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>บันทึกค่าใช้จ่ายโครงการ</h4>
						<div class="clear"></div>
					</div>
					<div class="panel-body form-group form-group-sm">
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-10 ">
								<div class="form-group ">
									<label for="doc_number" class="custom-label">เลขที่เอกสาร</label>
									<input type="text" class="form-control custom-input " name="doc_number" placeholder="เลขที่เอกสาร" disabled value="<?php echo $docno; ?>">
								</div>
							</div>
							<div class="col-xs-4 ">
								<div class="form-group ">
									<label for="record_date" class="custom-label">วันที่บันทึก</label>
									<input type="date" class="form-control custom-input " name="record_date" placeholder="วันที่บันทึก">
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label for="receipt_number" class="custom-label">เลขที่ใบเสร็จ</label>
									<input type="text" class="form-control custom-input " name="receipt_number" placeholder="เลขที่ใบเสร็จ">
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label for="receipt_date" class="custom-label">วันที่ใบเสร็จ</label>
									<input type="date" class="form-control custom-input " name="receipt_date" placeholder="วันที่ใบเสร็จ">
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<a href="#" class="float-right select-project"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เลือกโครงการ</a>

									<label for="project_id">รหัสโครงการ:</label>
									<input type="text" class="form-control" name="project_id" id="project_id" placeholder="รหัสโครงการ" disabled>

								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label for="project_name">ชื่อโครงการ:</label>
									<input type="text" class="form-control" name="project_name" id="project_name" placeholder="ชื่อโครงการ" disabled>
								</div>
							</div>
							<!-- <div class="col-xs-1">
								<div class="form-group">
									<label for="customer_id">รหัสลูกค้า:</label>
									<input type="text" class="form-control" name="customer_id" id="customer_id" placeholder="รหัสลูกค้า">
								</div>
							</div> -->
							<div class="col-xs-3">
								<div class="form-group">
									<label for="first_name">ชื่อ:</label>
									<input type="text" class="form-control" name="first_name" id="first_name" placeholder="ชื่อ" disabled>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label for="last_name">นามสกุล:</label>
									<input type="text" class="form-control" name="last_name" id="last_name" placeholder="นามสกุล" disabled>
								</div>
							</div>
						</div>

						<table class="table table-bordered table-hover table-striped " id="invoice_table">
							<thead>
								<tr>
									<th width="500">
										<h4><a href="#" class="btn btn-success btn-xs add-row"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> สินค้า</h4>
									</th>
									<th>
										<h4>รหัส</h4>
									</th>
									<th>
										<h4>หน่วยนับ</h4>
									</th>
									<th>
										<h4>จำนวน</h4>
									</th>
									<th>
										<h4>ราคา</h4>
									</th>
									<th>
										<h4>รวมทั้งหมด</h4>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="form-group form-group-sm  no-margin-bottom">
											<a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
											<input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="สินค้า">
											<!-- <p class="item-select"><span class="glyphicon glyphicon-plus" aria-hidden="true"><a href="#">เลือกสินค้า</a></p> -->
											<a href="#" class=" item-select"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เลือกสินค้า</a>
										</div>
									</td>
									<td class="text-right">
										<div class="input-group input-group-sm  no-margin-bottom">
											<input type="text" class="form-control invoice_product_id required" name="invoice_product_id[]" aria-describedby="sizing-addon1" placeholder="รหัส" disabled>
										</div>
									</td>
									<td class="text-right">
										<div class="input-group input-group-sm  no-margin-bottom">
											<input type="text" class="form-control calculate invoice_product_unit required" name="invoice_product_unit[]" aria-describedby="sizing-addon1" placeholder="หน่วยนับ" disabled>
										</div>
									</td>
									<td class="text-right">
										<div class="form-group form-group-sm no-margin-bottom">
											<input type="number" class="form-control invoice_product_qty calculate" name="invoice_product_qty[]" value="0">
										</div>
									</td>

									<td class="text-right">
										<div class="input-group input-group-sm  no-margin-bottom">
											<span class="input-group-addon"><?php echo CURRENCY ?></span>
											<input type="number" class="form-control calculate invoice_product_price required" name="invoice_product_price[]" aria-describedby="sizing-addon1" placeholder="0.00" disabled>
										</div>
									</td>
									<td class="text-right">
										<div class="input-group input-group-sm">
											<span class="input-group-addon"><?php echo CURRENCY ?></span>
											<input type="text" class="form-control calculate-sub" name="invoice_product_sub[]" id="invoice_product_sub" value="0.00" aria-describedby="sizing-addon1" disabled>
										</div>
									</td>
								</tr>
							</tbody>

						</table>
						<div id="invoice_totals" class="padding-right row text-right">

							<div class="row">
								<div class="col-xs-4 col-xs-offset-5">
									<strong>รวมทั้งหมด:</strong>
								</div>
								<div class="col-xs-3">
									<?php echo CURRENCY ?><span class="invoice-total">0.00</span>
									<input type="hidden" name="invoice_total" id="invoice_total">
								</div>
							</div>
						</div>

						<div class="col-md-12 margin-top btn-group">
							<input type="submit" id="action_create_invoice" class="btn btn-success float-right" value="บันทึกค่าใช้จ่ายโครงการ" data-loading-text="Creating...">
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	</div>
</form>

<div id="insert" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Select Product</h4>
			</div>
			<div class="modal-body">
				<?php popProductsList(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-primary" id="selected">Add</button>
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="insert_project" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">เลือกข้อมูลโครงการ</h4>
			</div>
			<div class="modal-body">
				<?php popProjectList(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn">ยกเลิก</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php
include('footer.php');
?>