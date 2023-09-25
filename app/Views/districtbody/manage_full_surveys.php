<?php 
$this->db = \Config\Database::connect();
?>
<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>

<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE SURVEYS
        	
        </h3>


    </div>
    <hr>
    <div class="panel-body">
        <div class="row">

	<section class="content">

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">

		<div class="row" id="content">

			<div class="col-md-12">

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

										<th class="tablehide">Survey Name</th>

										<th class="tablehide">School Name</th>

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
											$school_details = $this->db->table('go_schools')->select('*')->where('id', $template['school_id'])->get()->getRowArray();

											$href=BASE_URL.'admin/delete_survey/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td><?php echo $school_details['school_name']; ?></td>
												<td>
													<?php 
													if($template['status'] == 0){
														echo '<h6>In Progress</h6>';
													}
													elseif($template['status'] == 1){
														echo '<h6>Waiting for District admin to set the Priority order.</h6>';
													}
													elseif($template['status'] == 2){
														echo '<h6>Priority set successfully, awaiting school admin to complete survey and return.</h6>';
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
													
													<?php 
													if($template['status'] == 0){
														?>
														<a href='<?php echo BASE_URL."district/addtemplate/".$template['id'].'?school_id='.$template['school_id']; ?>' class="fa fa-pencil" title="Edit Master Template" style="font-size:23px"></a>
														
														<?php
													}
													elseif($template['status'] == 1){
														?>
														<a href='<?php echo BASE_URL."district/addtemplate/".$template['id'].'?school_id='.$template['school_id']; ?>' class="fa fa-pencil" title="Edit Master Template" style="font-size:23px"></a>
														
														<?php
													}
													elseif($template['status'] == 2){
														?>
														<a href='<?php echo BASE_URL."district/addtemplate/".$template['id'].'?school_id='.$template['school_id']; ?>' class="fa fa-eye" title="Edit Master Template" style="font-size:23px"></a>
														
														<?php
													}
													else{
														?>
														<a href='<?php echo BASE_URL."district/addtemplate/".$template['id'].'?school_id='.$template['school_id']; ?>' class="fa fa-eye" title="Edit Master Template" style="font-size:23px"></a>
														
														<?php
													}
													?>
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
		var school_id = "<?php echo isset($_GET['school_id'])?$_GET['school_id']:''; ?>";
		if(template_id == "")
		{
			alert("Please Select the Template and then take a copy of it.")
		}
		else{
			$.ajax({
				url:"<?php echo BASE_URL.'admin/take_a_copy'; ?>",
				type:"post",
				data:{template_id:template_id,school_id:school_id},
				success:function(result)
				{
					window.location.replace("<?php echo BASE_URL.'admin/addtemplate/'; ?>"+result+"?school_id="+school_id);
				}
			});
		}
	}
});

</script>