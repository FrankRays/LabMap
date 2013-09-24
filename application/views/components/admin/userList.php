<?php
$utypes_text = array("SUadmin", "admin", "helper");
if (!isset($mode) || !in_array($mode, array(UTYPE_SU_ADMIN, UTYPE_ADMIN, UTYPE_HELPER))) {
	$mode = UTYPE_HELPER;
}

$edit_available = true;

if ($mode == UTYPE_HELPER) {
	$edit_available = false;
}
?>

<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">Users</span>
			<button type="button" id="addNewUser" class="btn btn-link btn-xs pull-right">
				<span class="glyphicon glyphicon-plus"></span> 
				Add
			</button>
		</div>
		<div class="panel-body">
			<?php if($val_errors !=null){
			?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong class="border-bottom">Error: </strong>
					<?php echo $val_errors; ?>
				</div>
			<?php
			}?>
			<div id="addNewUserFormComtainer" class="well">
				<script language="javascript">
					$(document).ready(function(){
						$('#addNewUserFormComtainer').hide();
						$('#addNewUser').click(function(){
							$('#addNewUserFormComtainer').toggle(500);
						});
					});
				</script>
				<div class="col-lg-12 col-md-12 col-msm-12">
					<form id="addNewUserForm" method="POST" action="<?php echo site_url("/user/add");?>" class="form-horizontal" role="form">
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="uname">Username</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<input tabindex="1" type="text" name="uname" id="uname" class="form-control" placeholder="User Name" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="utype">User Type</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<select tabindex="2" name="utype" id="utype" class="form-control" placeholder="Username">
									<option selected="selected" value="<?php echo UTYPE_HELPER; ?>"><?php echo $utypes_text[UTYPE_HELPER - 1]; ?></option>
									<option value="<?php echo UTYPE_ADMIN; ?>"><?php echo $utypes_text[UTYPE_ADMIN - 1]; ?></option>
									<?php if ($mode == UTYPE_SU_ADMIN) { ?>
										<option value="<?php echo UTYPE_SU_ADMIN; ?>"><?php echo $utypes_text[UTYPE_SU_ADMIN - 1]; ?></option>
										<?php }
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="active">Active?</label>
							<div class="col-lg-2 col-md-2 col-sm-2">
								<input tabindex="3" type="checkbox" checked="true" name="active" id="active" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-4 col-md-4 col-sm-4"></div>
							<div class="col-lg-2 col-md-2 col-sm-2">
								<input type="submit" id="saveNewUser" class="btn btn-primary" value="Save">
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>uname</th>
							<th>utype</th>
							<th>Access (
								<span class="glyphicon glyphicon-ok text-color-green"></span>
								/
								<span class="glyphicon glyphicon-lock text-color-red"></span>
								)
							</th>
							<?php if ($edit_available) { ?>
								<th>edit / delete</th>
							<?php }
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						foreach ($obj_users as $user_list_item) {
							?>
							<tr>
								<td><?php echo $count; ?></td>
								<td><?php echo $user_list_item->uname; ?></td>
								<td><?php echo $utypes_text[$user_list_item->utype - 1]; ?></td>
								<td><a href="<?php echo site_url("/user/statuschange/".$user_list_item->userId_pk);?>"><?php 
									if($user_list_item->active==true){
										?><span title="Active" class="glyphicon glyphicon-ok text-color-green"></span><?php
									}else{
										?><span title="Blocked" class="glyphicon glyphicon-lock text-color-red"></span><?php
									}
								?></a></td>
								<?php if ($edit_available) { ?>
									<td>
										<span class="glyphicon glyphicon-edit"></span>
										<a href="<?php echo site_url("/user/delete/".$user_list_item->userId_pk);?>">
											<span title="Delete" class="glyphicon glyphicon-remove text-color-red"></span>
										</a>
									</td>
								<?php }
								?>
							</tr>
							<?php
							$count++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
/* End of file userList.php */
/* Location:  */