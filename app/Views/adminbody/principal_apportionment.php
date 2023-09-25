<?php 
$this->db = \Config\Database::connect();
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<style>

    .header_p { color:green; font-weight:600;margin-bottom: 3px; }

</style>

<section class="page-content" style="margin-top: 72px;">

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

                <h5>Upload <?php echo $category; ?>:</h5>

                <div class="col-md-12">

                    <div class="col-md-4">

                        <label style="font-weight:600">Select District:</label>

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

                </div>

                <form action="<?php echo BASE_URL.'admin/update_principal_apportionment'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">

                    <div class="row" id="content">

                        <div class="col-md-12">

                            <div class="col-md-4">

                                <div class="row-fluid">

                                    <div class="block">

                                        <div class="block-content collapse in">

                                            <div class="row">

                                                <fieldset style="margin-left: 17px">

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Attach File<span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="file" name="file[]" class="form-control file_principal" value="" multiple required/>

                                                        </div>

                                                    </div>

                                                    <div class="control-group content_div" style="display: none">

                                                        <h5 style="margin-top:20px">Select Schools:</h5>

                                                        <div class="control-group select_schools_div">



                                                        </div>

                                                        <input type="hidden" name="hidden_type" id="hidden_type" value="<?php echo $type; ?>">

                                                        <input type="button" name="principal_submit" class="btn btn-primary principal_submit" value="Submit">

                                                    </div>

                                                </fieldset>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>



                <div class="col-md-12" style="margin-top:30px;border-top:1px solid #dfdfdf;padding-top:10px">

                    <div class="col-md-6">

                        <h5>Manage <?php echo $category; ?> Submitted Reports</h5>

                    </div>

                    <div class="col-md-2">

                        <label style="font-weight:600">Filter By District:</label>

                        <select name="filter_district" class="form-control filter_district">

                            <option value="">Filter By District</option>

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

                        <select name="filter_school" class="form-control filter_school">

                            <option value="">Filter By School</option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <label style="font-weight:600">Select Year:</label>

                        <select name="filter_year" class="form-control filter_year">

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

                    <table class="table" style="margin-top:88px">

                        <thead>

                            <th>S.No</th>

                            <th>Filename</th>

                            <th>School</th>

                            <th>Date</th>

                            <th>Action</th>

                        </thead>

                        <tbody id="report_tbody">



                            <?php

                            $reports = $this->db->table('principal_attachments')->select('*')->where('type',$_GET['type'])->get()->getResultArray();

                            $i = 1;
                            if(!empty($reports))

                            {

                                foreach($reports as $report)

                                {

                                    $explodefile = explode("||",$report['filename']);

                                    $school_details = $this->db->table('go_schools')->select('*')->where('id', $template['school_id'])->get()->getRowArray();

                                    if(!empty($explodefile))

                                    {

                                        foreach($explodefile as $exp)

                                        {

                                            $expfilename = explode(".",$exp);

                                            array_pop($expfilename);

                                            $impfilename = implode(" ",$expfilename);


                                            $schoolname = isset($school_details['school_name'])?$school_details['school_name']:'';


                                            echo '<tr class="report_tr_'.$report['id'].'">

                                                <td>'.$i.'</td>

                                                <td>'.$impfilename.'</td>

                                                <td>'.$schoolname.'</td>

                                                <td><h6>Report Submitted By School <br/><br/><span class="change_date_span">'.date('m/d/Y',strtotime($report['updatetime'])).'</span><a href="javascript:" class="fa fa-pencil edit_date" data-element="'.$report['id'].'" data-date="'.date('m/d/Y',strtotime($report['updatetime'])).'" style="margin-left:10px"></a></h6></td>

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

                                                    <a href="'.BASE_URL."admin/delete_report_attachment/".$report['id']."?school_id=".$report['school_id'].'" class="fa fa-trash delete_report_attach" title="Delete Report" style="font-size:23px"></a>

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

    jQuery(document).ready(function(){

        var base_url = $("#base_url").val();

        $( ".change_date" ).datepicker({ dateFormat: 'mm/dd/yy' });

    });

    $(window).change(function(e) {

        if($(e.target).hasClass('filter_district'))

        {

            var value = $(e.target).val();

            $.ajax({

                url:"<?php echo BASE_URL.'admin/school_lists'; ?>",

                type:"post",

                data:{district_id:value},

                success:function(result)

                {

                    $(".filter_school").html(result);

                }

            })

        }

        if($(e.target).hasClass('filter_school'))

        {

            var value = $(e.target).val();

            var year = $('.filter_year').val();

            $.ajax({

                url:"<?php echo BASE_URL.'admin/get_reports_from_school'; ?>",

                type:"post",

                data:{school_id:value,year:year,type:"<?php echo $_GET['type']; ?>"},

                success:function(result)

                {

                    $("#report_tbody").html(result);

                }

            })

        }

        if($(e.target).hasClass('filter_year'))

        {

            var year = $(e.target).val();

            var school_id = $(".filter_school").val();

            $.ajax({

                url:"<?php echo BASE_URL.'admin/get_reports_from_school'; ?>",

                type:"post",

                data:{school_id:school_id,year:year,type:"<?php echo $_GET['type']; ?>"},

                success:function(result)

                {

                    $("#report_tbody").html(result);

                }

            })

        }

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

            var school_checked = $(".school_select:checked").length;

            if(school_checked > 0)

            {

                var files = $(".file_principal")[0].files;

                if(files.length == 1)

                {

                    $(".alert_modal_single").modal("show");

                }

                else{

                    $("#alert_modal_multiple").modal("show");

                }

            }

            else{

                alert("Please select atleast one or more schools to proceed.");

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

                url:"<?php echo BASE_URL.'admin/show_existing_comments'; ?>",

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

                url:"<?php echo BASE_URL.'admin/add_comment_specifics'; ?>",

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

        if($(e.target).hasClass('principal_submit'))

        {

            

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

                url:"<?php echo BASE_URL.'admin/change_date_report'; ?>",

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

            var school_id = "<?php echo isset($_GET['school_id'])?$_GET['school_id']:0; ?>";

            if(template_id == "")

            {

                alert("Please Select the Template and then take a copy of it.")

            }

            else{

                $.ajax({

                    url:"<?php echo BASE_URL.'admin/take_a_report_copy'; ?>",

                    type:"post",

                    dataType:"json",

                    data:{template_id:template_id,school_id:school_id},

                    success:function(result)

                    {

                        if(result['type'] == "1")

                        {

                            window.location.replace("<?php echo BASE_URL.'admin/manage_lcap_template/'; ?>"+result['template_id']+"?school_id="+school_id);

                        }

                        else{

                            window.location.replace("<?php echo BASE_URL.'admin/manage_report_template/'; ?>"+result['template_id']+"?school_id="+school_id);

                        }

                    }

                });

            }

        }

    });

</script>