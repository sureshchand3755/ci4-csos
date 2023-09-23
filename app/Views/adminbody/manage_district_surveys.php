<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>
<div class="modal" id="choose_template_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<select name="choose_template" class="form-control choose_template">
      		<option value="">Select template</option>
        <?php
        if(!empty($master_templates))
        {
        	foreach($master_templates as $template)
        	{
        		echo '<option value="'.$template['id'].'">'.$template['template_name'].'</option>';
        	}
        }
        else{
        	echo '<option value="">No Master Templates Found</option>';
        }
        ?>
    	</select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary take_a_copy">Take a Copy</button>
      </div>
    </div>
  </div>
</div>
<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE DISTRICT WISE SURVEYS</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">

	<section class="content">
		<div class="nav-tabs-horizontal">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" style="width:33%">
                	<a class="nav-link active" href="javascript:" style="background: #dfdfdf"><strong>Manage Surveys</strong></a>
                </li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link" href="<?php echo BASE_URL.'admin/manage_district_reports?district_id='.$_GET['district_id']; ?>" style="background: #dfdfdf"><strong>Manage Reports</strong></a>
		  		</li>
            </ul>
        </div>
		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">
		<div class="row" id="content">

			<div class="col-md-12">

				<div class="row">

					<div class="col-md-4 dropdown" role="presentation" style="float:right">

						<a class="btn btn-sm btn-primary add_button" href="javascript:" style="float:right">Add New Survey</a>

					</div>

				</div>

				<p id="selecterror"></p>

				<!-- block -->

				<!--For Flash message-->

				<?php if ($this->session->flashdata('sucess_msg')) { ?>

				<div class="alert alert-success">

						 <a href="#" class="close" data-dismiss="alert">&times;</a>

						  <?php

								 echo $this->session->flashdata('sucess_msg');

								 $this->session->unset_userdata('sucess_msg');

						  ?>

				</div>

				<?php } ?>

				<?php if ($this->session->flashdata('error_msg')) { ?>

				<div class="alert alert-danger">

						<a href="#" class="close" data-dismiss="alert">&times;</a>

						 <?php

								echo $this->session->flashdata('error_msg');

								$this->session->unset_userdata('error_msg');

						 ?>

				</div>

				<?php } ?>

				<!--End Flash message-->

					<div class="block-content collapse in">

						<div class="span12">
							

							<table class="table table-striped">

								<thead class="thead-inverse">

									<tr>

										<th>S.No</th>

										<th class="tablehide">Template Name</th>

										<th>Status</th>

										<th>Actions</th>

									</tr>

								</thead>

								<tbody id="tdistrict">

									<?php 

									if(!empty($select_templates)){

										$i = 1;

										foreach($select_templates as $template)
										{
											$href=BASE_URL.'admin/delete_survey/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td>
													<?php 
													if($template['status'] == 0){
														echo '<h6>In Progress</h6>';
													}
													else{
														echo '<h6>Completed</h6>';
													}
													?>
												</td>
												<td>
													<a href='<?php echo BASE_URL."admin/addtemplate/".$template['id']."?district_id=".$template['district_id']; ?>' class="fa fa-pencil" title="Edit Master Template" style="font-size:23px"></a>
													<?php
													if($template['active_status'] == 0)
													{
														$deactive = BASE_URL.'admin/deactivate_templates/'.$template['id'].'?status=1';
														?>
														<a href="javascript:" style="color:green;margin-left: 12px;font-size:23px" Onclick="confirmdeactivate('<?php echo $deactive; ?>')" class="fa fa-check" title="Deactivate This Template"></a>
														<?php
													}
													else{
														$deactive = BASE_URL.'admin/activate_templates/'.$template['id'].'?status=0';
														?>
														<a href="javascript:" style="margin-left: 12px;font-size:23px;color:red" Onclick="confirmactivate('<?php echo $deactive; ?>')" class="fa fa-times" title="Activate This Template"></a>
														<?php
													}
													?>

													<a href="javascript:" style="margin-left: 12px;font-size:23px" Onclick="confirmDelete('<?php echo $href; ?>')" class="fa fa-trash" title="Delete Master Template"></a>
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
	var r = confirm("Are you sure you want to delete this Survey?.");
	if(r)
	{
		window.location.replace(href);
	}
}
function confirmactivate(href = '')
{
	var r = confirm("Are you sure you want to activate this template?.");
	if(r)
	{
		window.location.replace(href);
	}
}

function confirmdeactivate(href = '')
{
	var r = confirm("Are you sure you want to deactivate this template?.");
	if(r)
	{
		window.location.replace(href);
	}
}
jQuery(document).ready(function(){

	var base_url = $("#base_url").val();

	

	

});
$(window).click(function(e) {
	if($(e.target).hasClass('add_button'))
	{
		$("#choose_template_modal").modal("show");
	}
	if($(e.target).hasClass('take_a_copy'))
	{
		var template_id = $(".choose_template").val();
		var district_id = "<?php echo $_GET['district_id']; ?>";
		if(template_id == "")
		{
			alert("Please Select the Template and then take a copy of it.")
		}
		else{
			$.ajax({
				url:"<?php echo BASE_URL.'admin/take_a_copy'; ?>",
				type:"post",
				data:{template_id:template_id,district_id:district_id},
				success:function(result)
				{
					window.location.replace("<?php echo BASE_URL.'admin/addtemplate/'; ?>"+result+"?district_id="+district_id);
				}
			});
		}
	}
});

</script>