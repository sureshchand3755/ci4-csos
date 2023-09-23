<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    .header_p { color:green; font-weight:600;margin-bottom: 3px; }
</style>
<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading" style="margin-top: 59px;">
        <h3>
            View Status Fiscal Reports
            
        </h3>
    </div>
    <hr>
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

<div class="modal" id="choose_due_date_modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document" style="width:40%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Set Due Dates</h5>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <th style="width:30%">Due Date</th>
                <th>Financial Reports</th>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_11" value=""></td>
                    <td>Annual Adopted Budget</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_12" value=""></td>
                    <td>Unaudited Actuals</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_13" value=""></td>
                    <td>First Interim</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_14" value=""></td>
                    <td>Second Interim</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_16" value=""></td>
                    <td>Third Interim(Annual)</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_15" value=""></td>
                    <td>LCAP</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_4" value=""></td>
                    <td>Annual Audit</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_1" value=""></td>
                    <td>P 1</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_2" value=""></td>
                    <td>P 2</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_3" value=""></td>
                    <td>P 3</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_5" value=""></td>
                    <td>Report Review</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_6" value=""></td>
                    <td>FCMAT Calculator</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_7" value=""></td>
                    <td>Misc Report</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_8" value=""></td>
                    <td>Misc Report</td>
                </tr>
            </tbody>
        </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit_due_date">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="panel-body">
    <div class="row">
    	<section class="content">
            <div class="col-md-12">
                <div class="col-md-2">
                    <label style="font-weight:600">Filter By School:</label>
                    <select name="filter_school" class="form-control filter_school">
                        <?php
                        $district_id = $this->session->userdata('gowritedistrictadmin_Userid');
                        $schools = $this->db->select('*')->from('go_schools')->where('district_id',$district_id)->get()->result_array();
                        $output = '';
                        if(!empty($schools))
                        {
                            $output.= '<option value="">Select School</option>';
                            foreach($schools as $school)
                            {
                                $output.='<option value="'.$school['id'].'">'.$school['school_name'].'</option>';
                            }
                        }
                        else{
                            $output.='<option value="">No Schools Found</option>';
                        }
                        echo $output;
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="font-weight:600">Select Year:</label>
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
                <div class="col-md-2">

                    <input type="button" name="submit_filter" class="btn btn-primary submit_filter" value="Submit" style="margin-top:26px">
                </div>
                <div class="col-md-6">
                    &nbsp;
                </div>
                <table class="table" style="margin-top:80px;width:50%">
                    <thead>
                        <th>Due Date</th>
                        <th>Financial Reports</th>
                        <?php 
                            $month = date('m');
                            if($month < 7)
                            {
                                $current_year = date('Y');
                                $prev_year = $current_year - 1;
                            }
                            else{
                                $prev_year = date('Y');
                                $current_year = $prev_year + 1;
                            }
                        ?>
                        <th><?php echo $prev_year.' - '.$current_year; ?></th>
                    </thead>
                    <tbody id="report_tbody">
                        
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
        $( ".change_due_date" ).datepicker({ dateFormat: 'mm/dd/yy' });
    });
    $(window).click(function(e) {
        if($(e.target).hasClass('submit_due_date'))
        {
            var due_date_11 = $(".change_due_date_11").val();
            var due_date_12 = $(".change_due_date_12").val();
            var due_date_13 = $(".change_due_date_13").val();
            var due_date_14 = $(".change_due_date_14").val();
            var due_date_16 = $(".change_due_date_16").val();
            var due_date_15 = $(".change_due_date_15").val();
            var due_date_4 = $(".change_due_date_4").val();
            var due_date_1 = $(".change_due_date_1").val();
            var due_date_2 = $(".change_due_date_2").val();
            var due_date_3 = $(".change_due_date_3").val();
            var due_date_5 = $(".change_due_date_5").val();
            var due_date_6 = $(".change_due_date_6").val();
            var due_date_7 = $(".change_due_date_7").val();
            var due_date_8 = $(".change_due_date_8").val();

            var school_id = $(".filter_school").val();
            var year = $(".select_year").val();

            if(due_date_11 == "")
            {
                alert("Please choose the due date for Annual Adopted Budget");
            }
            else if(due_date_12 == "")
            {
                alert("Please choose the due date for Unaudited Actuals");
            }
            else if(due_date_13 == "")
            {
                alert("Please choose the due date for First Interim");
            }
            else if(due_date_14 == "")
            {
                alert("Please choose the due date for Second Interim");
            }
            else if(due_date_15 == "")
            {
                alert("Please choose the due date for LCAP");
            }
            else if(due_date_16 == "")
            {
                alert("Please choose the due date for Third Interim (Annual)");
            }
            else if(due_date_1 == "")
            {
                alert("Please choose the due date for P 1");
            }
            else if(due_date_2 == "")
            {
                alert("Please choose the due date for P 2");
            }
            else if(due_date_3 == "")
            {
                alert("Please choose the due date for P 3");
            }
            else if(due_date_4 == "")
            {
                alert("Please choose the due date for Annual Audit");
            }   
            else if(due_date_5 == "")
            {
                alert("Please choose the due date for Report Review");
            }
            else if(due_date_6 == "")
            {
                alert("Please choose the due date for FCMAT Calculator");
            }
            else if(due_date_7 == "")
            {
                alert("Please choose the due date for Misc Report");
            }
            else if(due_date_8 == "")
            {
                alert("Please choose the due date for Misc Report");
            }
            else{
                $.ajax({
                    url:"<?php echo BASE_URL.'district/set_due_dates'; ?>",
                    type:"post",
                    data:{school_id:school_id,year:year,due_date_11:due_date_11,due_date_12:due_date_12,due_date_13:due_date_13,due_date_14:due_date_14,due_date_15:due_date_15,due_date_16:due_date_16,due_date_1:due_date_1,due_date_2:due_date_2,due_date_3:due_date_3,due_date_4:due_date_4,due_date_5:due_date_5,due_date_6:due_date_6,due_date_7:due_date_7,due_date_8:due_date_8},
                    success:function(result)
                    {
                        $(".due_date_td_11").html(due_date_11);
                        $(".due_date_td_12").html(due_date_12);
                        $(".due_date_td_13").html(due_date_13);
                        $(".due_date_td_14").html(due_date_14);
                        $(".due_date_td_15").html(due_date_15);
                        $(".due_date_td_16").html(due_date_16);
                        $(".due_date_td_1").html(due_date_1);
                        $(".due_date_td_2").html(due_date_2);
                        $(".due_date_td_3").html(due_date_3);
                        $(".due_date_td_4").html(due_date_4);
                        $(".due_date_td_5").html(due_date_5);
                        $(".due_date_td_6").html(due_date_6);
                        $(".due_date_td_7").html(due_date_7);
                        $(".due_date_td_8").html(due_date_8);
                    }
                })
            }
        }
        if($(e.target).hasClass('submit_filter'))
        {
            var school_id = $(".filter_school").val();
            var year = $(".select_year").val();

            if(school_id == "")
            {
                alert("Please select the School to view fiscal report result");
            }
            else if(year == "")
            {
                alert("Please select the Year to view fiscal report result");
            }
            else{
                $.ajax({
                    url:"<?php echo BASE_URL.'district/reports_result'; ?>",
                    type:"post",
                    data:{school_id:school_id,year:year},
                    success:function(result)
                    {
                        $("#report_tbody").html(result);
                        $(".edit_date_reports").show();
                    }
                })
            }
        }
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
        if($(e.target).hasClass('principal_submit'))
        {
            e.preventDefault();
            var school_checked = $(".school_select:checked").length;
            if(school_checked > 0)
            {
                $("#form_sample_3").submit();
            }
            else{
                alert("Please select atleast one or more schools to proceed.");
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