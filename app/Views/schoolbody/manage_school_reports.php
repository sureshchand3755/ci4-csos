<section class="page-content">

    <div class="page-content-inner">

    	<style>

			.menudropdown{width:80%;padding:10px;background: #EAEAEA; }

			#submit_file{margin-top:10px}

		</style>

<div class="modal" id="show_pdf_modal" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <iframe src="" style="width:100%;height:800px" class="show_iframe_pdf"></iframe>

    </div>

  </div>

</div>

<section class="panel">

    <div class="panel-heading">

        <h3>MANAGE REPORTS</h3>

    </div>

    <hr>

    <div class="panel-body">

        <div class="row">



	<section class="content">

		<div class="nav-tabs-horizontal">

            <ul class="nav nav-tabs" role="tablist">

		  		<li class="nav-item" style="width:33%">

		  			<a class="nav-link active" href="javascript:" style="background: #dfdfdf"><strong>Manage Reports</strong></a>

		  		</li>

		  		<li class="nav-item" style="width:33%;float:right">

		  			<div class="col-md-4">

						<label style="float:right;margin-top:10px;font-weight:600;font-size:18px">Select Category:</label>

					</div>

					<div class="col-md-8">

						<select class="form-control select_category" name="select_category">

							<option value="">Select Report Template</option>

							<option value="all">All</option>

					        <option value="i">Annual Adopted Budget</option>

				        	<option value="j">Unaudited Actuals</option>

				        	<option value="k">First Interim</option>

				        	<option value="l">Second Interim</option>

				        	<option value="m">Third Interim (Annual)</option>

				        	<option value="n">Lcap</option>

				        	<option value="a">Principal Apportionment (P 1)</option>

				        	<option value="b">Principal Apportionment (P 2)</option>

				        	<option value="c">Principal Apportionment (P 3)</option>

				        	<option value="d">Annual Audit</option>

				        	<option value="e">Report Review</option>

				        	<option value="f">FCMAT Calculator</option>

				        	<option value="o">Expanded Learning Opportunities Grant Plan</option>

				        	<option value="g">Misc Report</option>

				        	<option value="h">Misc Report</option>

						</select>

					</div>

		  		</li>

            </ul>

            <?php

            $cat = '';

            if(isset($_GET['cat']))

            {

            	$cat = '&cat='.$_GET['cat'].'';

            }

            

            ?>

            <ul class="nav nav-tabs" role="tablist" style="margin-top:10px">

                <li class="nav-item" style="width:33%">

                	<a class="nav-link <?php if(isset($_GET['type']) && $_GET['type'] == '1') { echo 'active'; } ?>" href="<?php echo BASE_URL.'school/manage_school_reports?type=1'.$cat.''; ?>" style="background: #dfdfdf"><strong>Reports Not Submitted</strong></a>

                </li>

		  		<li class="nav-item" style="width:33%">

		  			<a class="nav-link <?php if(isset($_GET['type']) && $_GET['type'] == '2') { echo 'active'; } ?>" href="<?php echo BASE_URL.'school/manage_school_reports?type=2'.$cat.''; ?>" style="background: #dfdfdf"><strong>Submitted Reports</strong></a>

		  		</li>

		  		<li class="nav-item" style="width:33%">

		  			<a class="nav-link <?php if(isset($_GET['type']) && $_GET['type'] == '3') { echo 'active'; } ?>" href="<?php echo BASE_URL.'school/manage_school_reports?type=3'.$cat.''; ?>" style="background: #dfdfdf"><strong>Reviewed Reports</strong></a>

		  		</li>

            </ul>

        </div>

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">

		<div class="row" id="content">



			<div class="col-md-12">



				<div class="row">



					<div class="col-md-10 dropdown" role="presentation" style="float:right">

						<div class="col-md-8">

							&nbsp;

						</div>

						

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



										<th class="tablehide">Category Name</th>



										<th>Status</th>



										<th>Actions</th>



									</tr>



								</thead>



								<tbody id="tdistrict">



									<?php 

									$i = 1;

									if(count($select_attachments))

									{

										foreach($select_attachments as $attach)

										{

											$school_details = $this->Madmin->Select_Val_Id('go_schools',$attach['school_id']);

											$expfilename = explode(".",$attach['filename']);

											array_pop($expfilename);

											$impfilename = implode(" ",$expfilename);

											

											echo '<tr>

												<td>'.$i.'</td>

												<td>'.$impfilename.'</td>

												<td>';

													if($attach['type'] == "1") { echo 'Principal attach (P 1)'; }

													elseif($attach['type'] == "2") { echo 'Principal attach (P 2)'; }

													elseif($attach['type'] == "3") { echo 'Principal attach (P 3)'; }

													elseif($attach['type'] == "4") { echo 'Annual Audit'; }

													elseif($attach['type'] == "5") { echo 'Report Review'; }

													elseif($attach['type'] == "6") { echo 'FCMAT Calculator'; }

													elseif($attach['type'] == "7") { echo 'Misc Report'; }
													elseif($attach['type'] == "8") { echo 'Misc Report'; }
													elseif($attach['type'] == "9") { echo 'Expanded Learning Opportunities Grant Plan'; }

													elseif($attach['type'] == "11") { echo 'Annual Adopted Budget'; }

													elseif($attach['type'] == "12") { echo 'Unaudited Actuals'; }

													elseif($attach['type'] == "13") { echo 'First Interim'; }

													elseif($attach['type'] == "14") { echo 'Second Interim'; }

													elseif($attach['type'] == "15") { echo 'LCAP'; }

													elseif($attach['type'] == "16") { echo 'Third Interim (Annual)'; }

												echo '</td>

												<td>

													<h6>Report Submitted <br/><br/><span class="change_date_span">'.date('m/d/Y',strtotime($attach['updatetime'])).'</span></h6>

												</td>

												<td>';

													$exp_attachment = explode(".",$attach['filename']);

													if(end($exp_attachment) == "pdf")

													{

														echo '<a href="javascript:" data-src="'.$attach['url'].'/'.$attach['filename'].'" class="fa fa-eye view_pdf" title="View Report" style="font-size:23px"></a>';

													}

													else{

														echo '<a href="'.BASE_URL.$attach['url'].'/'.$attach['filename'].'" class="fa fa-eye view_pdf" title="View Report" download style="font-size:23px"></a>';

													}

												echo '</td>

											</tr>';

											$i++;

										}

									}

									if($i == 1){

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

$(window).change(function(e){

	if($(e.target).hasClass('select_category'))

	{

		var category = $(e.target).val();

		var school_id = "<?php echo $_GET['school_id']; ?>";

		$.ajax({

			url:"<?php echo BASE_URL.'school/filter_by_school_search'; ?>",

			type:"post",

			data:{category:category,school_id:school_id,type:"<?php echo $_GET['type']; ?>"},

			success: function(result)

			{

				$("#tdistrict").html(result);

			}

		})

	}

});

$(window).click(function(e) {

	if($(e.target).hasClass('view_pdf'))

	{

		var src = $(e.target).attr("data-src");

		src = "<?php echo BASE_URL.'uploads/index.html?file=../'; ?>"+src;

		$(".show_iframe_pdf").attr("src",src);

		$("#show_pdf_modal").modal("show");

	}

});



</script>