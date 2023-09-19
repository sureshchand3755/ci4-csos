<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
			.modal_load {
				display:    none;
				position:   fixed;
				z-index:    999999;
				top:        0;
				left:       0;
				height:     100%;
				width:      100%;
				background: rgba( 255, 255, 255, .8 ) 
				            url(<?php echo BASE_URL.'assets/images/loading.gif'; ?>) 
				            50% 50% 
				            no-repeat;
				}
				body.loading {
				overflow: hidden;   
				}
				body.loading .modal_load {
				display: block;
				}
		</style>
<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE MASTER TEMPLATES</h3>
    </div>
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
    <hr>
    <div class="panel-body">
        <div class="row">

	<section class="content">

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">

	    <!-- Small boxes (Stat box) -->

		<div class="row" id="content">	

			<div class="col-md-12">

				<div class="row">

					<div class="col-md-4 dropdown" role="presentation" style="float:right">
						
						<a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/addtemplate'); ?>" style="float:right">Add New Master Template</a>
						<!-- <a class="btn btn-sm btn-primary add_button" href="javascript:" style="float:right;margin-right:10px">Take a Copy</a> -->

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
											$href=BASE_URL.'admin/delete_templates/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td>
													<h6>
													<?php
													if($template['status'] == 0) { echo 'In Progress'; }
													else{ echo 'Completed'; }
													?>
													</h6>
												</td>
												<td>
													<a href='<?php echo BASE_URL."admin/addtemplate/".$template['id']; ?>' class="fa fa-pencil" title="Edit Master Template" style="font-size:23px"></a>

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
													<a href="javascript:" style="margin-left: 12px;font-size:23px" class="fa fa-copy copy_master_template" title="Copy Master Template" data-element="<?php echo $template['id']; ?>"></a>

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
<div class="modal_load"></div>
<script>
function confirmDelete(href = '')
{
	var r = confirm("Are you sure you want to delete this template?.");
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
		if(template_id == "")
		{
			alert("Please Select the Template and then take a copy of it.")
		}
		else{
			$("body").addClass("loading");
			$.ajax({
				url:"<?php echo BASE_URL.'admin/take_a_copy_master_template'; ?>",
				type:"post",
				data:{template_id:template_id},
				success:function(result)
				{
					
					window.location.replace("<?php echo BASE_URL.'admin/addtemplate/'; ?>"+result);
				}
			});
		}
	}
	if($(e.target).hasClass('copy_master_template'))
	{
		$("body").addClass("loading");
		var template_id = $(e.target).attr("data-element");
		$.ajax({
			url:"<?php echo BASE_URL.'admin/take_a_copy_master_template'; ?>",
			type:"post",
			data:{template_id:template_id},
			success:function(result)
			{
				
				window.location.replace("<?php echo BASE_URL.'admin/addtemplate/'; ?>"+result);
			}
		});
	}
});

</script>