<section class="page-content">
    <div class="page-content-inner">
    	<style>
			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }
			#submit_file{margin-top:10px}
		</style>
<section class="panel">
    <div class="panel-heading">
        <h3>MANAGE PAGES</h3>
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

				<!-- <div class="row">

					<div class="col-md-4 dropdown" role="presentation" style="float:right">

						<a class="btn btn-sm btn-primary add_button" href="<?php echo base_url('admin/addpage'); ?>" style="float:right">Add New Page</a>

					</div>

				</div> -->

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

										<th class="tablehide">Page Name</th>

										<th>Actions</th>

									</tr>

								</thead>

								<tbody id="tdistrict">

									<?php 

									if(!empty($pages)){

										$i = 1;

										foreach($pages as $key => $page)
										{
											$href=BASE_URL.'admin/delete_districts/'.$district['id'];
											?>
												<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $page['page_name']; ?></td>
												<td><a href='<?php echo BASE_URL."admin/addpage/".$page['id']; ?>' class="fa fa-pencil" title="Edit Page" style="font-size:23px"></a>
												</td>
												</tr>
											<?php 
											$i++;
										}
									}
									else{
										echo "<tr><td colspan='5'>No Page Found</td></tr>";
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