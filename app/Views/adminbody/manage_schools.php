<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>
<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE SCHOOLS</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">

	<!-- Main content -->

	<section class="content">

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">

	    <!-- Small boxes (Stat box) -->

		<div class="row" id="content">

			<div class="col-md-12">

				<div class="row">
					<div class="col-md-2 col-lg-2 dropdown" role="presentation">
						<label>Select District</label>
					</div>
					<div class="col-md-3 col-lg-3 dropdown" role="presentation">
						<select name="choose_district" class="form-control input-sm choose_district">
							<option value="">Select District</option>
							<?php
							if(!empty($select_district))
							{
								foreach($select_district as $district)
								{
									$selected='';
									$district_id = isset($_GET['district_id'])?$_GET['district_id']:0;
									if($district['id']===$district_id){ 
										$selected = 'selected'; 
									}
									?>
									<option value="<?php echo $district['id']; ?>" <?php echo $selected; ?>><?php echo $district['district_name']; ?></option>
									<?php
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-7 col-lg-7 dropdown" role="presentation" style="float:right">

						<a class="btn btn-sm btn-primary add_button adddistrict" href="javascript:" style="float:right">Add New School<i class="icon-plus icon-white"></i></a>

					</div><br/><br/>
					<div class="col-md-5 col-lg-5">
						<label style="font-size:13px;color:#f00">NOTE: You can also manage the Charter Schools of Other School Districts using the above filter option.</label>
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

										<th class="tablehide">School Name</th>

										<th class="tablehide">School Admin Name</th>

										<th class="tablehide">Email</th>

										<th>Actions</th>

									</tr>

								</thead>

								<tbody id="tdistrict">

									<?php 

									if(!empty($select_schools)){

										$i = 1;

										foreach($select_schools as $school)
										{
											$href=BASE_URL.'admin/delete_school/'.$school['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $school['school_name']; ?></td>
												<td><?php echo $school['principal_name']; ?></td>
												<td><?php echo $school['email']; ?></td>
												<td>
												<?php
			                                    if(isset($_GET['district_id']))
			                                    {
			                                        ?>
			                                        <a href='<?php echo BASE_URL."admin/addschool/".$school['id']; ?>?district_id=<?php echo $_GET['district_id']; ?>' class="fa fa-pencil" style="font-size:23px" title="Edit School Details"></a>
			                                        <?php
			                                    }
			                                    else{
			                                        ?>
			                                        <a href='<?php echo BASE_URL."admin/addschool/".$school['id']; ?>' class="fa fa-pencil" style="font-size:23px" title="Edit School Details"></a>
			                                        <?php
			                                    }
			                                    ?>
			                                    <a href="<?php echo BASE_URL.'admin/manage_surveys?school_id='.$school['id']; ?>" style="margin-left: 12px;" title="Add-Manage Survey/ Reports"><img src="<?php echo BASE_URL.'assets/images/survey.png'; ?>" style="width:23px;height:23px;margin-top: -11px;"></a>

			                                    <?php if($school['handbook_name'] != "") { ?>
			                                    	<?php if($school['filename'] != "") { ?>
														<a class="fa fa-book" style="margin-left: 12px;font-size:23px" href="<?php echo BASE_URL.$school['attach_url']; ?>" title="<?php echo $school['handbook_name']; ?>" download></a>
													<?php }
													else{
														?>
														<a class="fa fa-book alert_handbook_alert" style="margin-left: 12px;font-size:23px" href="javascript:" title="<?php echo $school['handbook_name']; ?>" download></a>
														<?php
													}
												} else { ?>
													<a class="fa fa-book alert_handbook_alert" style="margin-left: 12px;font-size:23px" href="javascript:" download></a>
												<?php } ?>
			                                    	<?php if($school['fiscal_filename'] != "") { ?>
														<a class="fa fa-paperclip" style="margin-left: 12px;font-size:23px" href="<?php echo BASE_URL.$school['fiscal_url']; ?>" title="<?php echo $school['fiscal_filename']; ?>" download></a>
													<?php }
													else{
														?>
														<a class="fa fa-paperclip alert_fiscal_alert" style="margin-left: 12px;font-size:23px" href="javascript:" title="<?php echo $school['fiscal_filename']; ?>" download></a>
														<?php
													}
												?>

												<a href="#" style="margin-left: 12px;font-size:23px" Onclick="confirmDelete('<?php echo $href; ?>')" class="fa fa-trash" title="Delete School Details"></a></td>
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
	var r = confirm("Are you sure you want to delete this School?.");
	if(r)
	{
		window.location.replace(href);
	}
}

$(window).change(function(e) {
	if($(e.target).hasClass('choose_district'))
	{
		var district_id = $(e.target).val();console.log("====", district_id);
		if(district_id == "")
		{
			window.location.replace("<?php echo BASE_URL.'admin/manage_schools'; ?>")
		}
		else{
			window.location.replace("<?php echo BASE_URL.'admin/manage_schools?district_id='; ?>"+district_id);
		}
	}
});
$(window).click(function(e){
	if($(e.target).hasClass('adddistrict'))
	{
		var district_id = $(".choose_district").val();
		if(district_id == "")
		{
			alert("Please choose the District from the dropdown and click on the Add new School Button.");
		}
		else{
			window.location.replace("<?php echo base_url('admin/addschool'); ?>?district_id="+district_id);
		}
	}
	if($(e.target).hasClass('alert_handbook_alert'))
    {
        alert("No Handbook found");
    }
    if($(e.target).hasClass('alert_fiscal_alert'))
    {
        alert("No Attachment found");
    }
})
</script>