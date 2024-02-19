<?php
include 'header.php';
include 'functions.php';
?>
<head>
</head>
<h2><span class="invoice_type"></span> </h2>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_closeinvoice">
	<div class="">
		<input type="hidden" name="action" value="create_closeinvoice">

		<div class="row ">
			<div class="col-xs-4">
			</div>
			<div class="col-xs-8 ">
				<div class="row">
					<div class="col-xs-6 ">
						<h2 class="">ใบปิดโครงการ</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>ปิดโครงการ</h4>
						<div class="clear"></div>
					</div>
					<div class="panel-body form-group form-group-sm">
						<div class="form-group row">
							<div class="col-xs-2 col-xs-offset-10 ">
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<a href="#" class="float-right select-closeproject"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เลือกเลขที่เอกสาร</a>

									<label for="doc_number">เลขที่เอกสาร:</label>
									<input type="text" class="form-control" name="doc_number" id="doc_number" placeholder="เลขที่เอกสาร" disabled>

								</div>
							</div>
							<div class="col-xs-3 ">
								<div class="form-group ">
									<label for="closing_date" class="custom-label">วันที่ปิดโครงการ</label>
									<input type="date" class="form-control custom-input " name="closing_date" placeholder="วันที่ปิดโครงการ">
								</div>
							</div>
							<div class="col-xs-2">
								<div class="form-group">
									<label for="project_id">รหัสโครงการ:</label>
									<input type="text" class="form-control" name="project_id" id="project_id" disabled placeholder="รหัสโครงการ">
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
									<label for="cost">ต้นทุน:</label>
									<input type="text" class="form-control" name="cost" id="cost" placeholder="ต้นทุน">
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label for="expenses">ค่าใช้จ่าย:</label>
									<input type="text" class="form-control" name="expenses" id="expenses" placeholder="ค่าใช้จ่าย">
								</div>
							</div>
							<div class="col-xs-2">
								<div class="form-group">
									<label for="employee_id">รหัสพนักงาน:</label>
									<input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="รหัสพนักงาน" disabled>
								</div>
							</div>
							<div class="col-xs-5">
								<div class="form-group">
									<label for="comment">หมายเหตุ:</label>
									<input type="text" class="form-control" name="comment" id="comment" placeholder="หมายเหตุ">
								</div>
							</div>
						</div>
						</table>

						<div class="col-md-12 margin-top btn-group">
							<input type="submit" id="action_close_invoice" class="btn btn-success float-right" value="บันทึกปิดโครงการ" data-loading-text="Creating...">
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	</div>
</form>


<div id="insert_project" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">เลือกข้อมูลเลขที่เอกสาร</h4>
			</div>
			<div class="modal-body">
				<?php popCloseProjectList(); ?>
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