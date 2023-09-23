<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>
<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE MASTER TEMPLATES</h3>
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

						<a class="btn btn-sm btn-primary add_button" href="<?php echo base_url('school/addtemplate'); ?>" style="float:right">Add New Master Template</a>

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
											$href=BASE_URL.'/school/delete_templates/'.$template['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $template['template_name']; ?></td>
												<td></td>
												<td>
													<a href='<?php echo BASE_URL."school/addtemplate/".$template['id']; ?>' class="fa fa-edit" title="Edit Master Template" style="font-size:23px"></a>
													<a href="#" style="margin-left: 12px;font-size:23px" Onclick="confirmDelete(<?php echo $href; ?>)" class="fa fa-trash" title="Delete Master Template"></a></td>
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

</script>