<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>

<section class="panel">
    <div class="panel-heading">
        <h3>SUBMITTED SURVEYS FOR THIS SCHOOL</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">

	<section class="content">
<?php 
$district_id = isset($_GET['district_id'])?$_GET['district_id']:0;
$school_id = isset($_GET['school_id'])?$_GET['school_id']:0;
?>
		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">
		<div class="nav-tabs-horizontal">
			<ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" style="width:33%">
                	<a class="nav-link active" href="<?php echo BASE_URL.'admin/manage_surveys?district_id='.$district_id; ?>" style="background: #dfdfdf"><strong>Manage Surveys</strong></a>
                </li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link" href="<?php echo BASE_URL.'admin/manage_school_reports?district_id='.$district_id.'&school_id='.$school_id; ?>" style="background: #dfdfdf"><strong>Manage Reports</strong></a>
		  		</li>
            </ul>

            <ul class="nav nav-tabs" role="tablist" style="margin-top:10px">
                <li class="nav-item" style="width:33%">
                	<a class="nav-link"href="<?php echo BASE_URL.'admin/manage_surveys?school_id='.$school_id; ?>" style="background: #dfdfdf"><strong>Surveys sent to school to be completed</strong></a>
                </li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link active" href="javascript:" style="background: #dfdfdf"><strong>Surveys completed by school and returned</strong></a>
		  		</li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link" href="<?php echo BASE_URL.'admin/manage_reviewed_surveys?school_id='.$school_id; ?>" style="background: #dfdfdf"><strong>Completed and Returned Surveys</strong></a>
		  		</li>
            </ul>
        </div>
	    <!-- Small boxes (Stat box) -->

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
											$href=BASE_URL.'/admin/delete_templates/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td>
													<?php 
													if($template['status'] == 3){
														echo '<h6>Submitted But Not Reviewed.</h6>';
													}
													else{
														echo '<h6>Reviewed Successfully.</h6>';
													}
													?>
												</td>
												<td>
													<a href='<?php echo BASE_URL."admin/add_submitted_template/".$template['id']; ?>' class="fa fa-pencil" title="View Survey" style="font-size:23px"></a>
													<a href='<?php echo BASE_URL."admin/delete_survey/".$template['id']."?district_id=".$district_id."&school_id=".$school_id.""; ?>' class="fa fa-trash delete_survey" title="Delete Survey" style="font-size:23px"></a>
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

jQuery(document).ready(function(){

	var base_url = $("#base_url").val();

	

	

});
$(window).click(function(e) {
	if($(e.target).hasClass('delete_survey'))
	{
		e.preventDefault();
		var href= $(e.target).attr("href");
		var r = confirm("Warning! if you delete this Survey, it will be deleted for all the users including District Admin and School Admin. Are you sure want to delete this?")
		if(r)
		{
			window.location.replace(href);
		}
	}
	if($(e.target).hasClass('add_button'))
	{
		$("#choose_template_modal").modal("show");
	}
	if($(e.target).hasClass('take_a_copy'))
	{
		var template_id = $(".choose_template").val();
		var school_id = "<?php echo $school_id; ?>";
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