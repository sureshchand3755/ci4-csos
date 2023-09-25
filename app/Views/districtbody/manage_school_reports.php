<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<section class="page-content">

    <div class="page-content-inner">

    	<style>

    		.header_p { color:green; font-weight:600;margin-bottom: 3px; }

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

<div class="modal" id="choose_date_modal" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-sm" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

        <h5 class="modal-title">Change Date</h5>

      </div>

      <div class="modal-body">

      	<input type="text" name="change_date" class="form-control change_date" value="">

      </div>

      <div class="modal-footer">

      	<input type="hidden" name="report_id" id="report_id" value="">

      	<input type="hidden" name="hidden_type" id="hidden_type" value="">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary submit_date">Submit</button>

      </div>

    </div>

  </div>

</div>

<div class="modal fade task_specifics_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false" style="margin-top: 5%;z-index:99999999999">

  <div class="modal-dialog modal-sm" role="document" style="width:40%;">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title" style="font-weight:700;font-size:20px">Comments</h4>

          </div>

          <div class="modal-body" style="min-height: 193px;padding: 5px;">

            <label class="col-md-12" style="padding: 0px;">

              <label style="margin-top:10px">Existing Comments:</label>

            </label>

            <div class="col-md-12" style="padding: 0px;">

              <div class="existing_comments" id="existing_comments" style="width:100%;background: #c7c7c7;padding:10px;min-height:300px;height:300px;overflow-y: scroll;font-size: 16px"></div>

            </div>



            <label class="col-md-12" style="margin-top:15px;padding: 0px">New Comment:</label>

            <div class="col-md-12" style="padding: 0px">

              <textarea name="new_comment" class="form-control new_comment" id="editor_1" style="height:150px"></textarea>

            </div>

          </div>

          <div class="modal-footer" style="padding: 18px 5px;">  

            <input type="hidden" name="hidden_task_id_task_specifics" id="hidden_task_id_task_specifics" value="">

            <input type="hidden" name="show_auto_close_msg" id="show_auto_close_msg" value="">

            

            <div class="col-md-12" style="padding:0px;margin-top:10px">

              <input type="button" class="btn btn-primary add_task_specifics" id="add_task_specifics" value="Add Comment Now" style="float: right;font-size:12px">

            </div>

          </div>

        </div>

  </div>

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

        		echo '<option value="'.$template['id'].'">'.$template['template'].'</option>';

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

<section class="panel">

    <div class="panel-heading">

        <h3>MANAGE DISTRICT WISE REPORTS</h3>

    </div>

    <hr>

    <div class="panel-body">

        <div class="row">



	<section class="content">

		<div class="nav-tabs-horizontal">

            <ul class="nav nav-tabs" role="tablist">

                <li class="nav-item" style="width:33%">

                	<a class="nav-link" href="<?php echo BASE_URL.'district/manage_surveys?school_id='.$_GET['school_id']; ?>" style="background: #dfdfdf"><strong>Manage Surveys</strong></a>

                </li>

		  		<li class="nav-item" style="width:33%">

		  			<a class="nav-link active" href="javascript:" style="background: #dfdfdf"><strong>Manage Reports</strong></a>

		  		</li>

            </ul>

        </div>

		<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">

		<div class="row" id="content">



			<div class="col-md-12">



				<div class="row">



					<div class="col-md-10 dropdown" role="presentation" style="float:right">

						<div class="col-md-5">

							&nbsp;

						</div>

						<div class="col-md-2">

							<label style="float:right;margin-top:10px">Filter By Category:</label>

						</div>

						<div class="col-md-2">

							<select class="form-control select_category" name="select_category">

								<option value="">Select Report Template</option>

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

						<div class="col-md-1">

							<label style="float:right;margin-top:10px">Filter By Year:</label>

						</div>

						<div class="col-md-2">

							<select name="select_year" class="form-control select_year">

								<option value="">Select Year</option>

								<?php

								$current_year = date('Y');

								for($year=2018; $year<=$current_year; $year++)

								{

									$next_year = $year + 1;

									echo '<option value="'.$year.'">'.$year.' - '.$next_year.'</option>';

								}

								?>

							</select>

						</div>

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



										<th class="tablehide">Category Name</th>



										<th>Status</th>



										<th>Actions</th>



									</tr>



								</thead>



								<tbody id="tdistrict">



									<?php 

									$i = 1;

									if(!empty($select_attachments)){

										foreach($select_attachments as $attachment)

										{

											$explodefile = explode("||",$attachment['filename']);

							                if(!empty($explodefile))

							                {

							                    foreach($explodefile as $exp)

							                    {

													$expfilename = explode(".",$exp);

													array_pop($expfilename);

													$impfilename = implode(" ",$expfilename);

													?>

														<tr class="attach_tr_<?php echo $attachment['id']; ?>">

														<td><?php echo $i; ?></td>

														<td><?php echo $impfilename; ?></td>

														<td>

															<?php

															if($attachment['type'] == "1") { echo 'Principal attachment (P 1)'; }

															elseif($attachment['type'] == "2") { echo 'Principal attachment (P 2)'; }

															elseif($attachment['type'] == "3") { echo 'Principal attachment (P 3)'; }

															elseif($attachment['type'] == "4") { echo 'Annual Audit'; }

															elseif($attachment['type'] == "5") { echo 'Report Review'; }

															elseif($attachment['type'] == "6") { echo 'FCMAT Calculator'; }

															elseif($attachment['type'] == "7") { echo 'Misc Report'; }
															elseif($attachment['type'] == "8") { echo 'Misc Report'; }
															elseif($attachment['type'] == "9") { echo 'Expanded Learning Opportunities Grant Plan'; }
															elseif($attachment['type'] == "11") { echo 'Annual Adopted Budget'; }

															elseif($attachment['type'] == "12") { echo 'Unaudited Actuals'; }

															elseif($attachment['type'] == "13") { echo 'First Interim'; }

															elseif($attachment['type'] == "14") { echo 'Second Interim'; }

															elseif($attachment['type'] == "15") { echo 'LCAP'; }

															elseif($attachment['type'] == "16") { echo 'Third Interim (Annual)'; }

															?>

														</td>

														<td>

															<h6>Report Submitted By School <br/><br/><span class="change_date_span"><?php echo date('m/d/Y',strtotime($attachment['updatetime'])); ?></span></h6>



														</td>

														<td>

															<?php 

															$exp_attachment = explode(".",$exp);

															if(end($exp_attachment) == "pdf")

															{

																?>

																<a href="javascript:" data-src="<?php echo $attachment['url'].'/'.$exp; ?>" class="fa fa-eye view_pdf" title="View Report" style="font-size:23px"></a>

																<?php

															}

															else{

																?>

																<a href="<?php echo BASE_URL.$attachment['url'].'/'.$exp; ?>" class="fa fa-eye" title="View Report" download style="font-size:23px"></a>

																<?php

															}

															?>

															<a href="javascript:" data-src="<?php echo $attachment['url'].'/'.$exp; ?>" class="fa fa-comment link_to_task_specifics" data-element="<?php echo $attachment['id']; ?>" title="Comment Report" style="font-size:23px"></a>

														</td>

														</tr>

													<?php 

													$i++;

												}

											}

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

	$( ".change_date" ).datepicker({ dateFormat: 'mm/dd/yy' });

});

$(window).change(function(e){

	if($(e.target).hasClass('select_category'))

	{

		var category = $(e.target).val();

		var school_id = "<?php echo $_GET['school_id']; ?>";

		var year = $(".select_year").val();

		$.ajax({

			url:"<?php echo BASE_URL.'district/filter_by_school_search'; ?>",

			type:"post",

			data:{category:category,school_id:school_id,year:year},

			success: function(result)

			{

				$("#tdistrict").html(result);

			}

		})

	}

	if($(e.target).hasClass('select_year'))

	{

		var category = $(".select_category").val();

		var school_id = "<?php echo $_GET['school_id']; ?>";

		var year = $(e.target).val();

		$.ajax({

			url:"<?php echo BASE_URL.'district/filter_by_school_search'; ?>",

			type:"post",

			data:{category:category,school_id:school_id,year:year},

			success: function(result)

			{

				$("#tdistrict").html(result);

			}

		})

	}

});

$(window).click(function(e) {

	if($(e.target).hasClass('link_to_task_specifics'))

    {

        if (CKEDITOR.instances.editor_1) CKEDITOR.instances.editor_1.destroy();

        $("#editor_1").val("");

        $("body").addClass("loading");

        setTimeout(function() {

          var task_id = $(e.target).attr("data-element");

          $.ajax({

            url:"<?php echo BASE_URL.'district/show_existing_comments'; ?>",

            type:"post",

            data:{task_id:task_id},

            success:function(result)

            {

                CKEDITOR.replace('editor_1',

                {

                    height: '150px',

                    enterMode: CKEDITOR.ENTER_BR,

                    shiftEnterMode: CKEDITOR.ENTER_P,

                    autoParagraph: false,

                    entities: false,

                    contentsCss: "body {font-size: 16px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif}",

                });

                $("#hidden_task_id_task_specifics").val(task_id);

                $("#existing_comments").html(result);

                $(".task_specifics_modal").modal("show");

                $("body").removeClass("loading");

            }

          })

        },500);

    }

    if($(e.target).hasClass('add_task_specifics'))

    {

        var comments = CKEDITOR.instances['editor_1'].getData();

        var task_id = $("#hidden_task_id_task_specifics").val();

        if(comments == "")

        {

          alert("Please enter new comments and then click on the Add New Comment Button");

        }

        else{

          $.ajax({

            url:"<?php echo BASE_URL.'district/add_comment_specifics'; ?>",

            type:"post",

            data:{task_id:task_id,comments:comments},

            success:function(result)

            {

              $("#existing_comments").append(result);

              $("#editor_1").val("");

              CKEDITOR.instances['editor_1'].setData("");

            }

          })

        }

    }

	if($(e.target).hasClass('view_pdf'))

	{

		var src = $(e.target).attr("data-src");

		src = "<?php echo BASE_URL.'uploads/index.html?file=../'; ?>"+src;

		$(".show_iframe_pdf").attr("src",src);

		$("#show_pdf_modal").modal("show");

	}

	if($(e.target).hasClass('edit_report'))

	{

		var date = $(e.target).attr("data-date");

		var id = $(e.target).attr("data-element");

		$(".change_date").val(date);

		$("#report_id").val(id);

		$("#hidden_type").val("1");

		$("#choose_date_modal").modal("show");

	}

	if($(e.target).hasClass('edit_date'))

	{

		var date = $(e.target).attr("data-date");

		var id = $(e.target).attr("data-element");

		$(".change_date").val(date);

		$("#report_id").val(id);

		$("#hidden_type").val("2");

		$("#choose_date_modal").modal("show");

	}

	if($(e.target).hasClass('submit_date'))

	{

		var date = $(".change_date").val();

		var report_id = $("#report_id").val();

		var type = $("#hidden_type").val();

		$.ajax({

			url:"<?php echo BASE_URL.'district/change_date_report'; ?>",

			type:"post",

			data:{id:report_id,date:date,type:type},

			success:function(result)

			{

				if(type == "1") {

					$(".report_tr_"+report_id).find(".change_date_span").html(date);

				}

				else{

					$(".attach_tr_"+report_id).find(".change_date_span").html(date);

				}

				

				$("#choose_date_modal").modal("hide");

			}

		})

	}

	if($(e.target).hasClass('delete_report'))

	{

		e.preventDefault();

		var href= $(e.target).attr("href");

		var r = confirm("Warning! if you delete this Report, it will be deleted for all the users including District Admin and School Admin. Are you sure want to delete this?")

		if(r)

		{

			window.location.replace(href);

		}

	}

	if($(e.target).hasClass('delete_report_attach'))

	{

		e.preventDefault();

		var href= $(e.target).attr("href");

		var r = confirm("Warning! if you delete this Report, it will be deleted for all the users including District Admin and School Admin. Are you sure want to delete this?")

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

		var school_id = "<?php echo $_GET['school_id']; ?>";

		if(template_id == "")

		{

			alert("Please Select the Template and then take a copy of it.")

		}

		else{

			$.ajax({

				url:"<?php echo BASE_URL.'district/take_a_report_copy'; ?>",

				type:"post",

				dataType:"json",

				data:{template_id:template_id,school_id:school_id},

				success:function(result)

				{

					if(result['type'] == "1")

					{

						window.location.replace("<?php echo BASE_URL.'district/manage_lcap_template/'; ?>"+result['template_id']+"?school_id="+school_id);

					}

					else{

						window.location.replace("<?php echo BASE_URL.'district/manage_report_template/'; ?>"+result['template_id']+"?school_id="+school_id);

					}

				}

			});

		}

	}

});



</script>