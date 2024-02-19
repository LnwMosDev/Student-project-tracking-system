<?php

include 'header.php';
include 'functions.php';

?>

<h1>รายชื่อพนักงาน</h1>
<hr>

<div class="row">

	<div class="col-xs-12">
		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>พนักงาน</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<?php getEmployees();?>
			</div>
		</div>
	</div>
<div>

<div id="delete_employee" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ลบข้อมูลลูกค้า</h4>
      </div>
      <div class="modal-body">
        <p>ต้องการลบข้อมูลลูกค้าท่านนี้จริงๆใช่มั้ย</p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">ลบ</button>
		<button type="button" data-dismiss="modal" class="btn">ยกเลิก</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
include 'footer.php';
?>