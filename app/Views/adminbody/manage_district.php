<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>
<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE DISTRICTS</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">
    

	<div class="modal fade imported_result" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">

		<div class="modal-dialog modal-lg">

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<h4 class="modal-title" id="myModalLabel">Imported Result</h4>

				</div>

				<div class="modal-body" style="padding:20px;">

					<table class="table" style="width:65%;margin: 0px 18%;">

						<thead>

							<th>Rows</th>

							<th>Errors</th>

						</thead>

						<tbody id="error_rows">

							

						</tbody>

					</table>

				</div>

				<div class="modal-footer">

				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>

			</div>

		</div>

	</div>

	<!-- Main content -->

	<section class="content">

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">

	    <!-- Small boxes (Stat box) -->

		<div class="row" id="content">

			<div class="col-md-12">

				<div class="row">

					<div class="col-md-4 dropdown" role="presentation" style="float:right">

						<a id="adddistrict" href="<?php echo base_url('admin/adddistrict'); ?>" style="float:right"><button id="adddistrictschools" class="btn btn-sm btn-primary add_button">Add New District<i class="icon-plus icon-white"></i></button></a>

					</div>

				</div>

				<p id="selecterror"></p>

				<!-- block -->

				<!--For Flash message-->
				<?= $this->include('common/alerts'); ?>
				<!--End Flash message-->

					<div class="block-content collapse in">

						<div class="span12">

							<table class="table table-striped">

								<thead class="thead-inverse">

									<tr>

										<th>S.No</th>

										<th class="tablehide">District Name</th>

										<th class="tablehide">District Admin Name</th>

										<th class="tablehide">Email</th>

										<th>Actions</th>

									</tr>

								</thead>

								<tbody id="tdistrict">

									<?php 
                                
									if(!empty($select_district)){

										$i = 1;

										foreach($select_district as $key => $district)
										{
                                           
											$href=BASE_URL.'admin/delete_districts/'.$district['id'];
											$href_deactivate=BASE_URL.'admin/deactivate_districts/'.$district['id'];
											$href_activate=BASE_URL.'admin/activate_districts/'.$district['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $district['district_name']; ?></td>
												<td><?php echo $district['fullname']; ?></td>
												<td><?php echo $district['email']; ?></td>
												<td><a href='<?php echo BASE_URL.ADMIN_ADDDISTRICTS."/".$district['id']; ?>' class="fa fa-pencil" title="Edit District" style="font-size:23px"></a>

												<!-- <a href='<?php echo BASE_URL."admin/manage_district_surveys?district_id=".$district['id']; ?>' title="Manage District's Master Survey / Reports" style="margin-left: 12px;"><img src="<?php echo BASE_URL.'assets/images/survey.png'; ?>" style="width:23px;height:23px;margin-top: -11px;"></a> -->
												<a href='<?php echo BASE_URL."admin/manage_schools?district_id=".$district['id']; ?>' class="fa fa-graduation-cap" title="Add/Modify Schools" style="margin-left: 12px;font-size:23px"></a>
												<?php
												if($district['status'] == 0) { ?>
													<a href="#" style="margin-left: 12px;font-size:23px" Onclick="confirmDeactivate('<?php echo $href_deactivate; ?>')" class="fa fa-check" title="Deactivate District"></a>
												<?php } else { ?>
													<a href="#" style="margin-left: 12px;font-size:23px" Onclick="confirmActivate('<?php echo $href_activate; ?>')" class="fa fa-times" title="Activate District"></a>
												<?php } ?>
												<a href="#" style="margin-left: 12px;font-size:23px" Onclick="confirmDelete('<?php echo $href; ?>')" class="fa fa-trash" title="Delete District"></a>
												
												</td>
												</tr>
											<?php 
											$i++;
										}
									}
									else{
										echo "<tr><td colspan='5'>No Data Found</td></tr>";
									}
									?>

								</tbody>

							</table>

							<input type="hidden" name="hiddenstate" id="hiddenstate" value="">

							<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

							  <div class="modal-header">

							<h3 id="myModalLabel">Delete</h3>

							  </div>

							  <div class="modal-body">

							<p>Do you want to delete?</p>

							  </div>

							  <div class="modal-footer">

							<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

							<a href="javascript:" class="adelete btn btn-primary">DELETE</a>

							  </div>

							</div>

							<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">

								</div>

							</div>

						</div>

    </div>

</div>

		</form>

	</section>

	</div>
</div>
</section>
<script>
function confirmDelete(href = '')
{
	var r = confirm("Are you sure you want to delete this District?.");
	if(r)
	{
		window.location.replace(href);
	}
}
function confirmDeactivate(href = '')
{
	
	var r = confirm("Are you sure you want to Deactivate this District?.");
	if(r)
	{
		window.location.replace(href);
	}
}
function confirmActivate(href = '')
{
	var r = confirm("Are you sure you want to Activate this District?.");
	if(r)
	{
		window.location.replace(href);
	}
}

jQuery(document).ready(function(){

	var base_url = $("#base_url").val();

	

	$("#adddistrictschools").click(function(e) {

		e.preventDefault();

			window.location.replace(base_url+"admin/adddistricts")

		

	});	

});

</script>