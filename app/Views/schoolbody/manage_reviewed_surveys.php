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
        <h3>OVERSIGHT SURVEYS</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">

	<section class="content">

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">
		<div class="nav-tabs-horizontal">
			<ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" style="width:33%">
                	<a class="nav-link active" href="<?php echo BASE_URL.'school/manage_surveys'; ?>" style="background: #dfdfdf"><strong>Manage Surveys</strong></a>
                </li>
            </ul>
            <ul class="nav nav-tabs" role="tablist" style="margin-top:10px">
                <li class="nav-item" style="width:33%">
                	<a class="nav-link"href="<?php echo BASE_URL.'school/manage_surveys'; ?>" style="background: #dfdfdf"><strong>Surveys Not Submitted</strong></a>
                </li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link" href="<?php echo BASE_URL.'school/manage_submitted_surveys'; ?>" style="background: #dfdfdf"><strong>Submitted Surveys</strong></a>
		  		</li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link active" href="javascript:" style="background: #dfdfdf"><strong>Reviewed Surveys</strong></a>
		  		</li>
            </ul>
        </div>
	    <!-- Small boxes (Stat box) -->

		<div class="row" id="content">

			<div class="col-md-12">

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

										<th class="tablehide">Survey Name</th>

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
											$href=BASE_URL.'school/delete_survey/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td>
													<?php 
													if($template['status'] == 1){
														echo '<h6>Waiting to Set Priority</h6>';
													}
													elseif($template['status'] == 2){
														echo '<h6>In progress</h6>';
													}
													elseif($template['status'] == 3){
														echo '<h6>Submitted But Not Reviewed.</h6>';
													}
													else{
														echo '<h6>Reviewed Successfully.</h6>';
													}
													?>
												</td>
												<td>
													<a href='<?php echo BASE_URL."school/addtemplate/".$template['id']; ?>' class="fa fa-pencil" title="Complete the Survey" style="font-size:23px"></a>
													<?php 
													if($template['status'] == 0){
														?>
														
														<?php
													}
													elseif($template['status'] == 1){
														?>
														
														<?php
													}
													elseif($template['status'] == 2){
														?>
														
														<?php
													}
													else{
														?>
														
														<?php
													}
													?>
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
		var school_id = "<?php echo $_GET['school_id']; ?>";
		if(template_id == "")
		{
			alert("Please Select the Template and then take a copy of it.")
		}
		else{
			$.ajax({
				url:"<?php echo BASE_URL.'school/take_a_copy'; ?>",
				type:"post",
				data:{template_id:template_id,school_id:school_id},
				success:function(result)
				{
					window.location.replace("<?php echo BASE_URL.'school/addtemplate/'; ?>"+result+"?school_id="+school_id);
				}
			});
		}
	}
});

</script>