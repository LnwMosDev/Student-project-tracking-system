<?php
include('header.php');

?>

<h2>เพิ่มสินค้า</h2>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>ข้อมูลสินค้า</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<form method="post" id="add_product">
					<input type="hidden" name="action" value="add_product">

					<div class="form-group">
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>รหัสสินค้า </b>
								<input name="product_id" type="text" class="form-control" placeholder="รหัสสินค้า" required />
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>ชื่อสินค้า</b>
								<input name="product_name" type="text" class="form-control" placeholder="ชื่อสินค้า" required />
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>หน่วยนับ</b>
								<input name="unit" type="text" required class="form-control" placeholder="หน่วยนับ" minlength="2" />
							</div>
							
						</div>
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>ราคา/หน่วย</b>
								<input name="price_per_unit" type="Number" required class="form-control" placeholder="ราคา/หน่วย" minlength="2" />
							</div>
						</div>
						
					</div>
					<!-- <div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_add_product" class="btn btn-success float-right" value="Add Product" data-loading-text="Adding...">
						</div>
					</div> -->
					<br><br><br><br>
					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_add_product" class="btn btn-success" value="เพิ่มข้อมูลสินค้า" style="margin-right:10px ;" data-loading-text="Creating...">
							<input type="reset" class="btn btn-danger" value="ล้างค่า">
							<a href="product-list.php" class="btn btn-primary float-right">กลับไปยังรายการสินค้า</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<div>

		<?php
		include('footer.php');
		?>