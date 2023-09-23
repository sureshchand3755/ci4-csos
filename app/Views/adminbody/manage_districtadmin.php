<!-- Right side column. Contains the navbar and content of the page -->

    <aside class="right-side">

	<!-- Content Header (Page header) -->

	<section class="content-header">

	    <h1>

		MANAGE SCHOOL DISTRICT ADMIN

		<small>Control panel</small>

	    </h1>

	</section>

	

	<!-- Main content -->

	<section class="content">

	    <!-- Small boxes (Stat box) -->

		<div class="span9" id="content">

			<div class="row-fluid">

				<div class="row">

					<div class="col-md-9">

						<div class="row">

							<form class="search_form" method="post" action="<?php echo base_url('admin/manage_districtadmin/');?>">

								<div class="col-md-4">

									<input class="form-control" name="first_name" type="text" placeholder="First Name" value="<?php echo $search_val; ?>">

								</div>

								<div class="col-md-4">

									<input type="submit" name="search_submit" class="btn btn-primary search_btn" value="Search">

								</div>

							</form>

						</div>

					</div>

					<div class="col-md-3 style="float:right">

						<a href="<?php echo base_url('admin/add_districtadmin'); ?>"><button class="btn btn-primary add_button">Add New School District Admin<i class="icon-plus icon-white"></i></button> </a> 

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

						<div class="span12">

							<table class="table">

								<thead>

								  <tr>

									<th>S.No</th>

									<th class="tablehide">Full Name</th>

									<th class="tablehide">Email</th>

									<th class="tablehide">State</th>

									<th>School District name</th>

									<th>Actions</th>

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

											<td class="tablehide"><?php echo $val['fullname']; ?></td>

											<td><?php echo $val['email']; ?></td>

											<?php $statename = $this->Madmin->GetState_id(STATE_DETAILS,$val['state_id']); ?>

											<td class="tablehide"><?php echo $statename['state_name']; ?></td>

											<?php $districtname = $this->Madmin->GetDistrict_id(DISTRICT_DETAILS,$val['district_id']); ?>

											<td class="tablehide"><?php echo $districtname['district_name']; ?></td>

											<td><a href="<?php echo BASE_URL.ADMIN_ADDDISTRICTADMIN.'/'.$val['id']; ?>">EDIT</a>

											<?php //$href=BASE_URL.ADMIN_DELETEUSERS.'/'.$val['id']; ?>

											<a href="javascript:" style="margin-left: 12px;">DELETE</a></td>

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

	var Search_val = "<?php echo $search_val; ?>";

	

	if (Search_val!='') {

		$( ".pagin_li a" ).click(function(e) {

			e.preventDefault();

			var href = $(this).attr('href');

			$('.search_form').attr('action',href);

			$('.search_btn').click();

		});

	}

	

	jQuery(document).delegate(".iddelete","click", function() {

	    var id=jQuery(this).attr("id");

	    var base_url = jQuery('#base_url').val();

	    $(".adelete").attr("href", base_url+'admin/deleteuser/'+id)

	});

	

});

</script>