<?php

if (!isset($mode) || !in_array($mode, array(UTYPE_ADMIN, UTYPE_TA))) {
	$mode = UTYPE_TA;
}

$edit_available = false;

if ($mode == UTYPE_ADMIN) {
	$edit_available = true;
}
?>

<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">Maps</span>
			<button type="button" id="addNewMap" class="btn btn-link btn-xs pull-right">
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
			<div id="addNewMapFormComtainer" class="well">
				<script language="javascript">
					$(document).ready(function(){
						$('#addNewMapFormComtainer').hide();
						$('#addNewMap').click(function(){
							$('#addNewMapFormComtainer').toggle(500);
						});
					});
				</script>
				<div class="col-lg-12 col-md-12 col-msm-12">
					<form id="addNewMapForm" method="POST" action="<?php echo site_url("/map/add");?>" enctype="multipart/form-data" class="form-horizontal" role="form">
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="mname">Map Name</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<input tabindex="1" type="text" name="mname" id="mname" class="form-control" placeholder="Map Name" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="mtype">Map Type</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<select tabindex="2" name="mtype" id="mtype" class="form-control" placeholder="Map Type">
									<option selected="selected" value="<?php echo MTYPE_LAB; ?>">Lab</option>
									<option value="<?php echo MTYPE_CAMPUS; ?>">Campus</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="mwidth">Map Width</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<input tabindex="3" type="number" name="mwidth" id="mwidth" class="form-control" placeholder="Map Width" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="mheight">Map Height</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<input tabindex="4" type="number" name="mheight" id="mheight" class="form-control" placeholder="Map Height" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="mBg">Map Background</label>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<input tabindex="5" type="file" name="mBg" id="mBg" class="form-control" placeholder="map background" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-4 col-md-4 col-sm-4"></div>
							<div class="col-lg-2 col-md-2 col-sm-2">
								<input tabindex="6" type="submit" id="saveNewMap" class="btn btn-primary" value="Save">
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
							<th>Map Name</th>
							<th>Thumb</th>
							<th>Size</th>
							<th>Map Type</th>
							<th>isLive?</th>
							<?php if ($edit_available) { ?>
								<th>edit / delete</th>
							<?php }
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						foreach ($obj_maps as $map_list_item) {
							?>
							<tr>
								<td><?php echo $count; ?></td>
								<td><a href="<?php echo site_url('/map/build/'.$map_list_item->mapId);?>"><?php echo $map_list_item->mName; ?></a></td>
								<td><image src="<?php echo base_url('bgImages/thumbs').'/'.$map_list_item->bgImage;?>"></td>
								<td><?php echo $map_list_item->mWidth ." x ".$map_list_item->mHeight;?></td>
								<td>
									<?php if($map_list_item->mType==MTYPE_CAMPUS){
										echo "Campus Map";
									}else{
										echo "Lab Map";
									}?>
								</td>
								<td>
									<?php if($map_list_item->isLive==1){
										?>
										<span class="glyphicon glyphicon-ok text-color-green"></span>
										<?php
									} else{
										?>
										<span class="glyphicon glyphicon-ban-circle text-color-red"></span>
										<?php
									}
									?>
								</td>
								<?php if ($edit_available) { ?>
									<td>
										<span class="glyphicon glyphicon-edit"></span>
										<a href="<?php echo site_url("/map/delete/".$map_list_item->mapId);?>">
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
/* End of file mapList.php */
/* Location:  ./application/views/components/admin/mapList.php*/