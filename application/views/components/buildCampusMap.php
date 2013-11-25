<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">Map Builder</span>
		</div>
		<div class="panel-body">
			<div class="mapBuilderContainer" id="<?php echo $map_object->mapId;?>" style="<?php echo "width:".$map_object->mWidth."px; height:".$map_object->mHeight."px;"?>">
				
				<?php
				foreach ($building_object as $build){
					?>
					<div class="buildingDemarcation" style='<?php echo "height:".$build->y2."px; width:".$build->x2."px; top:".$build->y1."px; left:".$build->x1."px;";?>'>
						<div class="listOfLabs">
							<div class="mapLabListHeading"><?php echo $build->building;?></div>
						</div>
					</div>
					<?php
				}
				?>
				
				<img class="mapBg" id="map" src="<?php echo base_url('/bgImages')."/".$map_object->bgImage;?>" height="<?php echo $map_object->mHeight;?>" width="<?php echo $map_object->mWidth;?>" />
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$mapBuilderContainer = $('.mapBuilderContainer');
				$('.mapBg').click(function(e){
					var containerOffset = $mapBuilderContainer.offset();
					var relX = e.pageX - containerOffset.left;
					var relY = e.pageY - containerOffset.top;
					console.log($mapBuilderContainer.attr('id'));
					var bname=prompt("Please enter building name:");
					var height, width;
					if(bname!==null){
						height= prompt("Height");
					}
					if(bname!==null && height!==null){
						width=prompt("Width");
					}
					
					if(bname !==null && height !==null && width !==null){
						$.ajax({
							url:"<?php echo site_url('/map/createBuilding')?>",
							data:{
								'mapId':$mapBuilderContainer.attr('id'),
								'x1':relX,
								'y1':relY,
								'x2':width,
								'y2':height,
								'bname':bname
							},
							type:'POST'
						}).done(function(response){
							console.log(response);
							$mapBuilderContainer.append("<div class='buildingDemarcation' style='width:"+width+"px; height:"+height+"px; top:"+relY+"px; left:"+relX+"px;'><div class='listOfLabs'><div class='mapLabListHeading'>"+bname+"</div></div></div>");
						});
					}
					else{
						alert("You have to fill all the data.");
					}
				});
			});
		</script>
	</div>
</div>
<?php
/* End of file buildCampusMap.php */
/* Location:  ./application/views/components/buildCampusMap.php*/