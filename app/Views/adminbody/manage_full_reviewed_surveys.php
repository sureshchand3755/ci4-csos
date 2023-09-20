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
        <h3>SUBMITTED SURVEYS FOR THIS SCHOOL</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">

	<section class="content">

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">
		<div class="nav-tabs-horizontal">
			<div class="col-md-12">
				<div class="col-md-8">&nbsp;</div>
				<div class="col-md-2">
					<label style="font-weight:600">Filter By District:</label>
					<select name="select_district" class="form-control select_district">
						<option value="">Select District</option>
						<?php
						if(!empty($districts))
						{
							foreach($districts as $district)
							{
								echo '<option value="'.$district['id'].'">'.$district['district_name'].'</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="col-md-2">
					<label style="font-weight:600">Filter By School:</label>
					<select name="select_school" class="form-control select_school">
						<option value="all">All Schools</option>
					</select>
				</div>
			</div>
            <ul class="nav nav-tabs" role="tablist" style="margin-top:10px">
                <li class="nav-item" style="width:33%">
                	<a class="nav-link"href="<?php echo BASE_URL.'admin/manage_full_surveys'; ?>" style="background: #dfdfdf"><strong>Surveys sent to school to be completed</strong></a>
                </li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link " href="<?php echo BASE_URL.'admin/manage_full_submitted_surveys'; ?>" style="background: #dfdfdf"><strong>Surveys completed by school and returned</strong></a>
		  		</li>
		  		<li class="nav-item" style="width:33%">
		  			<a class="nav-link active" href="javascript:" style="background: #dfdfdf"><strong>Completed and Returned Surveys</strong></a>
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
										<th>School Name</th>
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
											
                                            $district_id = isset($_GET['district_id'])?$_GET['district_id']:0;
                                            $school_id = isset($_GET['school_id'])?$_GET['school_id']:0;
                                            $href=BASE_URL.'/admin/delete_templates/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td><?php echo $school_details['school_name']; ?></td>
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
$(window).change(function(e) {
	if($(e.target).hasClass('select_district'))
	{
		var value = $(e.target).val();
		$.ajax({
			url:"<?php echo BASE_URL.'admin/school_lists'; ?>",
			type:"post",
			data:{district_id:value},
			success:function(result)
			{
				$(".select_school").html(result);
			}
		})
	}
	if($(e.target).hasClass('select_school'))
	{
		var value = $(e.target).val();
		$.ajax({
			url:"<?php echo BASE_URL.'admin/get_school_full_surveys'; ?>",
			type:"post",
			data:{school_id:value,type:"3"},
			success:function(result)
			{
				$("#tdistrict").html(result);
			}
		})
	}
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
		var school_id = "<?php echo isset($_GET['school_id'])?$_GET['school_id']:0; ?>";
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