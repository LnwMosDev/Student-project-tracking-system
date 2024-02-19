<?php


include('header.php');
include('functions.php');

$getID = $_GET['id'];

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}

// the query
$query = "SELECT * FROM stock WHERE product_id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$product_id = $row['product_id']; // product name
		$product_name = $row['product_name']; // product description
		$unit = $row['unit']; // product price
		$price_per_unit = $row['price_per_unit']; 
	}
}

/* close connection */
$mysqli->close();

?>

<h1>แก้ไขข้อมูลสินค้า</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
						
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<!-- <h4>Editing Product (<?php echo $getID; ?>)</h4> -->
				<h4>ข้อมูลสินค้า</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<form method="post" id="update_product">
					<input type="hidden" name="action" value="update_product">
					<input type="hidden" name="id" value="<?php echo $getID; ?>">
					
					<div class="form-group">
						<div class="form-group">
							<!-- <div class="col-sm-0" align="right"> </div>
							<div class="col-sm-7" align="left">
								<b>รหัสสินค้า </b>
								<input name="product_id" value="<?php echo $product_id; ?>"type="text" class="form-control" placeholder="Enter Name" required />
							</div> -->
						</div>
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>ชื่อสินค้า</b>
								<input name="product_name" value="<?php echo $product_name; ?>" type="text" class="form-control" placeholder="Enter Name" required />
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>หน่วยนับ</b>
								<input name="unit" value="<?php echo $unit; ?>" type="text" required class="form-control" placeholder="Enter Description" minlength="2" />
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-sm-3" align="left">
								<b>ราคา/หน่วย</b>
								<input name="price_per_unit" value="<?php echo $price_per_unit; ?>" type="Number" required class="form-control" placeholder="Enter Price" minlength="2" />
							</div>
						</div>
					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_update_product" class="btn btn-success float-right" value="แก้ไขข้อมูลสินค้า" data-loading-text="Updating...">
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