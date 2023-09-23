<!-- Right side column. Contains the navbar and content of the page -->

    <aside class="right-side">

	<!-- Content Header (Page header) -->

	<section class="content-header">

	    <h1>

		MANAGE STATES

		<small>Control panel</small>

	    </h1>

	</section>

	

	<!-- Main content -->

	<section class="content">

	    <!-- Small boxes (Stat box) -->

		<div class="row" id="content">

			<div class="col-md-7 col-md-offset-2">

				<div class="row">

					<div class="col-md-9 style="float:right">

					</div>

					<div class="col-md-3 style="float:right">

						<a href="<?php echo base_url('admin/addstates'); ?>"><button class="btn btn-primary add_button">Add New State<i class="icon-plus icon-white"></i></button> </a> 

					</div>

				</div>

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

						<div>

							<table class="table">

								<thead>

								  <tr>

									<th>S.No</th>

									<th class="tablehide">State Name</th>

									<th>Action</th>

								  </tr>

								</thead>

								<tbody>

									<?php

									if(!empty($selectval))

									{

										$inc = 1;

									foreach($selectval as $val)

									{

										?>

											<tr>

											<td><?php echo $inc; ?></td>

											<td class="tablehide"><img src="<?php echo BASE_URL.'uploads/flags/'.$val['flag_image']; ?>" width="35" height="20"> <?php echo $val['state_name']; ?></td>

											<td><a href="<?php echo BASE_URL.ADMIN_ADDSTATES.'/'.$val['id']; ?>">EDIT</a></td>

											</tr>

										<?php

										$inc++;

									}

									}

									?>

								<?php

									if(empty($selectval))

									{

											echo '<td colspan="11" class="nodata">No data Found</td>';

									}

								?>

								</tbody>

							</table>

							<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

							  <div class="modal-header">

							<h3 id="myModalLabel">Delete</h3>

							  </div>

							  <div class="modal-body">

							<p>Do you want to delete?</p>

							  </div>

							  <div class="modal-footer">

							<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

							<a href="" class="adelete btn btn-primary">DELETE</a>

							  </div>

							</div>

							<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">

								</div>

							</div>

						</div>

    </div>

</div>

	</section>

	</aside>

	

<script>

jQuery(document).ready(function(){

	jQuery(document).delegate(".iddelete","click", function() {

	    var id=jQuery(this).attr("id");

	    var base_url = jQuery('#base_url').val();

	    $(".adelete").attr("href", base_url+'admin/deleteuser/'+id)

	});

});

</script>