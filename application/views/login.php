<?php
$this->load->helper('form');
?>
<div class="container form-signin">
	<h2 class="text-center"><?php echo $login_title; ?></h2>
	<div class="col-lg-12 col-md-12 col-msm-12 well">
		<?php
		{ echo form_open('/auth/login', array(
			'class' => 'form-horizontal',
			'role' => 'form',
			'id' => 'loginForm'
		));
		if (isset($msg)) {
			switch ($msg) {
				case "loginFail":
					?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Invalid.</b> Please check your credentials.
					</div>
					<?php
					break;
				case "unauth":
					?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Unauthorised.</b> Please login first.
					</div>
					<?php
					break;
				case "blocked":
					?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Blocked.</b> Contact Admin for access.
					</div>
					<?php
					break;
				case "logoutSuccess":
					?>
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Logged out.</b> You can now login again.
					</div>
					<?php
					break;
				case "logoutFail":
					?>
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Error.</b> Logout failed.
					</div>
					<?php
					break;
				case "timeout":
					?>
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Session Timeout.</b> You were inactive for too long.
					</div>
					<?php
					break;
			}
		}// */
		?>
		<div class="form-group">
			<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="userName">Username</label>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<input tabindex="1" type="text" name="username" id="userName" class="form-control" placeholder="Username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="passwd">Password</label>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<input tabindex="2" type="password" name="password" id="passwd" class="form-control" placeholder="Password"/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
				<input tabindex="3" type="submit" class="btn btn-primary btn-block" value="Log In" />
			</div>
		</div>
		<?php
		form_close(); }
		?>
	</div>
</div>
<?php
/* End of file login.php */
/* Location:  */