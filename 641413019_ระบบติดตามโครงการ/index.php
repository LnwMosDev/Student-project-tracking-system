<?php
include 'header-login.php';
include 'functions.php';

?>

<style>
	.panel-heading.panel-login {
    text-align: center; /* ตั้งค่าให้ข้อความอยู่ตรงกลาง */
}

.panel-heading.panel-login h1 {
    margin: 0; /* ลบ margin เพื่อให้ข้อความไม่มีระยะห่างข้างบนและด้านล่าง */
}
</style>
<div class="row vertical-offset-100">
	<div id="response" class="alert alert-success" style="display:none;">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<div class="message"></div>
	</div>

	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default login-panel">
			<div class="panel-heading panel-login">
				<!-- <h1 class="text-center">
					<img src="<?php echo COMPANY_LOGO ?>" class="img-responsive">
				</h1> -->
				<h1>ระบบติดตามโครงการ</h1>

			</div>
			<div class="panel-body">
				<form accept-charset="UTF-8" role="form" method="post" id="login_form">
					<input type="hidden" name="action" value="login">
					<fieldset>
						<div class="input-group form-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
							<input class="form-control required" name="email" id="email" type="text" placeholder="Enter Email">
						</div>
						<div class="input-group form-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
							<input class="form-control required" placeholder="Password" name="password" type="password" placeholder="Enter Password">
						</div>
						<!-- <div class="checkbox">
							<label>
								<input name="remember" type="checkbox" value="Remember Me"> Remember Me
							</label> -->
							<!--a href="forgot.php" class="float-right">Forgot password?</a-->
						<!-- </div> -->
						<button type="button" id="btn-login" class="btn btn-primary btn-block">Login</button><br>
					</fieldset>
				</form>
			</div>

		</div>
	</div>
</div>

<?php
include 'footer.php';
?>