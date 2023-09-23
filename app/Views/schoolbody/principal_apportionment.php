<style>

    .header_p { color:green; font-weight:600;margin-bottom: 3px; }

</style>

<section class="page-content">

    <div class="page-content-inner">

	<section class="panel">

    <div class="panel-heading">

        <h3>

            Manage 

            <?php if($type == "1") { $category = 'PRINCIPAL APPORTIONMENT  (P 1)'; }

            elseif($type == "2") { $category = 'PRINCIPAL APPORTIONMENT  (P 2)'; }

            elseif($type == "3") { $category = 'PRINCIPAL APPORTIONMENT  (P 3)'; }

            elseif($type == "4") { $category = 'ANNUAL AUDIT'; }

            elseif($type == "5") { $category = 'REPORT REVIEW'; }

            elseif($type == "6") { $category = 'FCMAT CALCULATOR'; }

            elseif($type == "7") { $category = 'MISC REPORT'; }

            elseif($type == "8") { $category = 'MISC REPORT'; }

            elseif($type == "9") { $category = 'EXPANDED LEARNING OPPURTUNITIES GRANT PLAN'; }

            elseif($type == "11") { $category = 'Annual Adopted Budget'; }

            elseif($type == "12") { $category = 'Unaudited Actuals'; }

            elseif($type == "13") { $category = 'First Interim'; }

            elseif($type == "14") { $category = 'Second Interim'; }

            elseif($type == "15") { $category = 'Lcap'; }

            elseif($type == "16") { $category = 'Third Interim (Annual)'; }

            else { $category = ''; }



            echo $category;

            ?>

        </h3>

    </div>

    <hr>

<div class="modal" id="show_pdf_modal" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <iframe src="" style="width:100%;height:800px" class="show_iframe_pdf"></iframe>

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

<div class="modal fade alert_modal_single" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false" style="margin-top: 5%;z-index:99999999999">

  <div class="modal-dialog modal-sm" role="document" style="width:40%;">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title" style="font-weight:700;font-size:20px">Alert</h4>

          </div>

          <div class="modal-body" style="padding: 5px;">

            <p style="font-size: 18px;padding: 10px;color: #1eac00;font-weight: 800;">Are you sure you selected the correct icon? Selecting this icon will upload the <?php echo $category; ?> fiscal report. Also, if this Report has multiple parts then please multi-select all the parts and upload them at once.</p>

            <p style="font-size: 18px;padding: 10px;color: #1eac00;font-weight: 800;">Do you want to proceed with your current selection?</p>

          </div>

          <div class="modal-footer" style="padding: 18px 5px;">  

            <input type="button" class="btn btn-primary no_alert" id="no_alert" value="No" style="float: right;font-size:12px">

            <input type="button" class="btn btn-primary yes_alert" id="yes_alert" value="Yes" style="float: right;font-size:12px;margin-right: 10px;">

          </div>

        </div>

  </div>

</div>

<div class="modal fade alert_modal_multiple" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false" style="margin-top: 5%;z-index:99999999999">

  <div class="modal-dialog modal-sm" role="document" style="width:40%;">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title" style="font-weight:700;font-size:20px">Alert</h4>

          </div>

          <div class="modal-body" style="padding: 5px;">

            <p style="font-size: 18px;padding: 10px;color: #1eac00;font-weight: 800;">Are you sure you selected the correct icon? Selecting this icon will upload the <?php echo $category; ?> fiscal report, do you want to proceed?</p>

          </div>

          <div class="modal-footer" style="padding: 18px 5px;">  

            <input type="button" class="btn btn-primary no_alert" id="no_alert" value="No" style="float: right;font-size:12px">

            <input type="button" class="btn btn-primary yes_alert" id="yes_alert" value="Yes" style="float: right;font-size:12px;margin-right: 10px;">

          </div>

        </div>

  </div>

</div>

    <div class="panel-body">

	<!-- Content Header (Page header) -->

	    <div class="row">

        	<section class="content">

                <form action="<?php echo BASE_URL.'school/update_principal_apportionment'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">

                    <div class="row" id="content">

                        <div class="col-md-12">

                            <div class="col-md-6">

                                <div class="row-fluid">

                                    <div class="block">

                                        <div class="block-content collapse in">

                                            <div class="row content_div">

                                                <fieldset style="margin-left: 17px">

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Attach File<span class="required">*</span></b>

                                                        <div class="controls">

                                                            <div class="col-md-10">

                                                                <input type="file" name="file[]" class="form-control file_principal" value="" multiple required/>

                                                            </div>

                                                            <div class="col-md-2">

                                                                <input type="hidden" name="hidden_type" id="hidden_type" value="<?php echo $type; ?>">

                                                                <input type="button" name="principal_submit" class="btn btn-primary principal_submit" value="Submit">

                                                            </div>

                                                        </div>

                                                    </div>

                                                </fieldset>



                                                <!-- <h5 style="margin-top:20px">Attached Files</h5> -->

                                                <!-- <table class="table">

                                                    <thead>

                                                        <th>S.No</th>

                                                        <th>Filename</th>

                                                        <th>Date & Time</th>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                        $school = $this->session->userdata('gowriteschooladmin_Userid');

                                                        $files = $this->db->select('*')->from('principal_attachments')->where('type',$type)->where('school_id',$school)->order_by('id','desc')->get()->result_array();

                                                        $i = 1;

                                                        if(!empty($files))

                                                        {

                                                            foreach($files as $file)

                                                            {

                                                                echo '<tr>

                                                                    <td>'.$i.'</td>

                                                                    <td><a href="'.BASE_URL.$file['url'].'/'.$file['filename'].'" download>'.$file['filename'].'</td>

                                                                    <td>'.date('d M Y', strtotime($file['updatetime'])).'</td>

                                                                </tr>';

                                                                $i++;

                                                            }

                                                        }

                                                        ?>

                                                    </tbody>

                                                </table> -->

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

                <div class="col-md-12" style="margin-top:30px">

                    <table class="table">

                        <thead>

                            <th>S.No</th>

                            <th>Filename</th>

                            <th>Date</th>

                            <th>Action</th>

                        </thead>

                        <tbody id="report_tbody">

                            <?php

                            $reports = $this->db->select('*')->from('principal_attachments')->where('type',$_GET['type'])->where('school_id',$this->session->userdata('gowriteschooladmin_Userid'))->get()->result_array();

                            $i = 1;

                            if(!empty($reports))

                            {

                                foreach($reports as $report)

                                {

                                    $explodefile = explode("||",$report['filename']);

                                    if(!empty($explodefile))

                                    {

                                        foreach($explodefile as $exp)

                                        {

                                            $expfilename = explode(".",$exp);

                                            array_pop($expfilename);

                                            $impfilename = implode(" ",$expfilename);





                                            echo '<tr class="report_tr_'.$report['id'].'">

                                                <td>'.$i.'</td>

                                                <td>'.$impfilename.'</td>

                                                <td>Report Submitted

                                                </td>

                                                <td>';

                                                    $exp_attachment = explode(".",$exp);

                                                    if(end($exp_attachment) == "pdf")

                                                    {

                                                        echo '<a href="javascript:" data-src="'.$report['url'].'/'.$exp.'" class="fa fa-eye view_pdf" title="View Report" style="font-size:23px"></a>';

                                                    }

                                                    else{

                                                        echo '<a href="'.BASE_URL.$report['url'].'/'.$exp.'" class="fa fa-eye" title="View Report" download style="font-size:23px"></a>';

                                                    }

                                                    echo '

                                                    

                                                    <a href="javascript:" data-src="'.$report['url'].'/'.$exp.'" class="fa fa-comment link_to_task_specifics" data-element="'.$report['id'].'" title="Comment Report" style="font-size:23px"></a>

                                                </td>

                                            </tr>';

                                            $i++;

                                        }

                                    }

                                }

                            }

                            else{

                                echo '<tr><td colspan="5">No Reports Found</td></tr>';

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </section>

        </div>

    </div>

    </section>

    </div>

</section>

<script>

    $(window).change(function(e) {

        if($(e.target).hasClass('select_district'))

        {

            var value = $(e.target).val();

            if(value != ""){

                $.ajax({

                    url:"<?php echo BASE_URL.'admin/school_lists_checkbox'; ?>",

                    type:"post",

                    data:{district_id:value},

                    success:function(result)

                    {

                        $(".select_schools_div").html(result);

                        $(".content_div").show();

                    }

                })

            }

            else{

                $(".content_div").hide();

                $(".select_schools_div").html("");

            }

        }

    });

    $(window).click(function(e) {

        if($(e.target).hasClass('principal_submit'))

        {

            var files = $(".file_principal")[0].files;

            if(files.length == 1)

            {

                $(".alert_modal_single").modal("show");

            }

            else{

                $(".alert_modal_multiple").modal("show");

            }

        }

        if($(e.target).hasClass('yes_alert'))

        {

            $("#form_sample_3").submit();

        }

        if($(e.target).hasClass('no_alert'))

        {

            $(".alert_modal").modal("hide");

        }

        if($(e.target).hasClass('link_to_task_specifics'))

        {

            if (CKEDITOR.instances.editor_1) CKEDITOR.instances.editor_1.destroy();

            $("#editor_1").val("");

            $("body").addClass("loading");

            setTimeout(function() {

              var task_id = $(e.target).attr("data-element");

              $.ajax({

                url:"<?php echo BASE_URL.'school/show_existing_comments'; ?>",

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

                url:"<?php echo BASE_URL.'school/add_comment_specifics'; ?>",

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

    });

</script>