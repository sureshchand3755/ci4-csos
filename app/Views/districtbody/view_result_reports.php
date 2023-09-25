<?php 
$this->session= \Config\Services::session();
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .header_p { color:green; font-weight:600;margin-bottom: 3px; }
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
.select_school_div p { margin-bottom: 0px !important; }
</style>
<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading" style="margin-top: 59px;">
        <h3>
            View Status Fiscal Reports
            <input type="button" name="download_reports" class="btn btn-primary download_reports" value="Download Report" style="float: right;">
            <input type="button" name="edit_date_reports" class="btn btn-primary edit_date_reports" value="Edit Due Date" style="float: right;margin-right: 10px">
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
<div class="modal" id="download_reports_modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document" style="width:40%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Download Report</h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12" style="margin-top:20px">
                <label style="font-weight:600">Select School:</label>
                <div class="select_school_div">
                    <?php
                    $district_id = $this->session->get('gowritedistrictadmin_Userid');
                    $schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->get()->getResultArray();
                    $output = '';
                    if(!empty($schools))
                    {
                        foreach($schools as $school)
                        {
                            $output.='<p><input type="checkbox" name="school_select[]" class="school_select" id="school_'.$school['id'].'" value="'.$school['id'].'"><label for="school_'.$school['id'].'" style="margin-left: 10px;font-size: 14px;font-weight: 600;">'.$school['school_name'].'</label></p>';
                        }
                    }
                    else{
                        $output.='<p>No Schools found in this district.</p>';
                    }
                    echo $output;
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <label style="font-weight:600">Select Category:</label>
                <div style="width:100%"><input type="checkbox" name="select_all_cat" class="select_all_cat" id="select_all_cat" value=""><label for="select_all_cat" style="margin-left: 10px;font-size: 14px;font-weight: 600;color:green">Select All</label></div>
                <div class="select_category_div" style="min-height: 200px;overflow-y: scroll;height: 200px;">
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_11" value="11"><label for="category_11" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Annual Adopted Budget</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_12" value="12"><label for="category_12" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Unaudited Actuals</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_13" value="13"><label for="category_13" style="margin-left: 10px;font-size: 14px;font-weight: 600;">First Interim</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_14" value="14"><label for="category_14" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Second Interim</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_16" value="16"><label for="category_16" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Third Interim (Annual)</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_15" value="15"><label for="category_15" style="margin-left: 10px;font-size: 14px;font-weight: 600;">LCAP</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_4" value="4"><label for="category_4" style="margin-left: 10px;font-size: 14px;font-weight: 600;">ANNUAL AUDIT</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_1" value="1"><label for="category_1" style="margin-left: 10px;font-size: 14px;font-weight: 600;">P 1</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_2" value="2"><label for="category_2" style="margin-left: 10px;font-size: 14px;font-weight: 600;">P 2</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_3" value="3"><label for="category_3" style="margin-left: 10px;font-size: 14px;font-weight: 600;">P 3</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_5" value="5"><label for="category_5" style="margin-left: 10px;font-size: 14px;font-weight: 600;">REPORT REVIEW</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_6" value="6"><label for="category_6" style="margin-left: 10px;font-size: 14px;font-weight: 600;">FCMAT CALCULATOR</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_9" value="9"><label for="category_9" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Expanded Learning Opportunities Grant Plan</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_7" value="7"><label for="category_7" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Misc Report</label></div>
                    <div style="width:100%"><input type="checkbox" name="category_select[]" class="category_select" id="category_8" value="8"><label for="category_8" style="margin-left: 10px;font-size: 14px;font-weight: 600;">Misc Report</label></div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top:10px">
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
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit_download_report">Submit</button>
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
        <div class="col-md-12" style="margin-top:20px">
            <label style="font-weight:600">Select School:</label><br/>
            <input type="checkbox" name="select_all_schools" class="select_all_schools" id="select_all_schools"><label for="select_all_schools" class="select_all_schools_cls" style="display:none">&nbsp;&nbsp;Select All</label>
            <div class="select_school_div_due" style="margin-top:10px">
                <?php
                $district_id = $this->session->get('gowritedistrictadmin_Userid');
                $schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->get()->getResultArray();
                $output = '';
                if(!empty($schools))
                {
                    foreach($schools as $school)
                    {
                        $output.='<p><input type="checkbox" name="school_select[]" class="school_select" id="school_'.$school['id'].'" value="'.$school['id'].'"><label for="school_'.$school['id'].'" style="margin-left: 10px;font-size: 14px;font-weight: 600;">'.$school['school_name'].'</label></p>';
                    }
                }
                else{
                    $output.='<p>No Schools found in this district.</p>';
                }
                echo $output;
                ?>
            </div>
        </div>
        <div class="col-md-12" style="margin-top:10px">
            <label style="font-weight:600">Select Year:</label>
            <select name="select_year_due" class="form-control select_year_due">
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
        <table class="table">
            <thead>
                <th style="width:30%">Due Date</th>
                <th>Financial Reports</th>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_11" value="" placeholder="Optional"></td>
                    <td>Annual Adopted Budget</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_12" value="" placeholder="Optional"></td>
                    <td>Unaudited Actuals</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_13" value="" placeholder="Optional"></td>
                    <td>First Interim</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_14" value="" placeholder="Optional"></td>
                    <td>Second Interim</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_16" value="" placeholder="Optional"></td>
                    <td>Third Interim(Annual)</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_15" value="" placeholder="Optional"></td>
                    <td>LCAP</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_4" value="" placeholder="Optional"></td>
                    <td>Annual Audit</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_1" value="" placeholder="Optional"></td>
                    <td>P 1</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_2" value="" placeholder="Optional"></td>
                    <td>P 2</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_3" value="" placeholder="Optional"></td>
                    <td>P 3</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_5" value="" placeholder="Optional"></td>
                    <td>Report Review</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_6" value="" placeholder="Optional"></td>
                    <td>FCMAT Calculator</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_7" value="" placeholder="Optional"></td>
                    <td>Misc Report</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_8" value="" placeholder="Optional"></td>
                    <td>Misc Report</td>
                </tr>
                <tr>
                    <td><input type="text" name="change_due_date" class="form-control change_due_date change_due_date_9" value="" placeholder="Optional"></td>
                    <td>Expanded Learning Opportunities Grant Plan</td>
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
                        $district_id = $this->session->get('gowritedistrictadmin_Userid');
                        $schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->get()->getResultArray();
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
                        <th class="year_header"><?php echo $prev_year.' - '.$current_year; ?></th>
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
<div class="modal_load"></div>
<script>
    jQuery(document).ready(function(){
        var base_url = $("#base_url").val();
        $( ".change_due_date" ).datepicker({ dateFormat: 'mm/dd/yy' });
    });
    $(window).change(function(e) {
        if($(e.target).hasClass('select_year'))
        {
            var year = $(e.target).val();
            var nextyear = parseInt(year) + 1;
            $(".year_header").html(year+' - '+nextyear);
        }
    });
    function detectPopupBlocker_download() {
      var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");
      if (!myTest) {
        return 1;
      } else {
        myTest.close();
        return 0;
      }
    }
    function SaveToDiskdownload(fileURL, fileName) {
        var idval = detectPopupBlocker_download();
        if(idval == 1)
        {
            alert("A popup blocker was detected. Please Allow the popups to download the file.");
        }
        else{
            // for non-IE
            if (!window.ActiveXObject) {
              var save = document.createElement('a');
              save.href = fileURL;
              save.target = '_blank';
              save.download = fileName || 'unknown';
              var evt = new MouseEvent('click', {
                'view': window,
                'bubbles': true,
                'cancelable': false
              });
              save.dispatchEvent(evt);
              (window.URL || window.webkitURL).revokeObjectURL(save.href);
            }
            // for IE < 11
            else if ( !! window.ActiveXObject && document.execCommand)     {
              var _window = window.open(fileURL, '_blank');
              _window.document.close();
              _window.document.execCommand('SaveAs', true, fileName || fileURL)
              _window.close();
            }
        }
        $("body").removeClass("loading");
    }
    $(window).click(function(e) {
        if($(e.target).hasClass('select_all_schools'))
        {
            if($(e.target).is(":checked"))
            {
                $(".select_school_div_due").find(".school_select").prop("checked",true);
            }
            else{
                $(".select_school_div_due").find(".school_select").prop("checked",false);
            }
        }
        if($(e.target).hasClass('select_all_cat'))
        {
            if($(e.target).is(":checked"))
            {
                $(".category_select").prop("checked",true);
            }
            else{
                $(".category_select").prop("checked",false);
            }
        }
        if($(e.target).hasClass('download_reports'))
        {
            $("#download_reports_modal").modal("show");
            $(".category_select").prop("checked",false);
            $(".school_select").prop("checked",false);
            $(".select_all_cat").prop("checked",false);
            $(".select_district").val("");
        }
        if($(e.target).hasClass('submit_download_report'))
        {
            var district = $(".select_district").val();
            var schools = $(".school_select:checked").length;
            var category = $(".category_select:checked").length;
            var year = $(".filter_year").val();
            if(schools == 0)
            {
                alert("Please select the School");
            }
            else if(category == 0)
            {
                alert("Please select the Category");   
            }
            else if(year == "")
            {
                alert("Please select the Year");   
            }
            else{
                $("body").addClass("loading");
                setTimeout(function() {
                    var school_ids = '';
                    $(".school_select:checked").each(function() {
                        if(school_ids == "")
                        {
                            school_ids = $(this).val();
                        }
                        else{
                            school_ids = school_ids+','+$(this).val();
                        }
                    });
                    var cat_ids = '';
                    $(".category_select:checked").each(function() {
                        if(cat_ids == "")
                        {
                            cat_ids = $(this).val();
                        }
                        else{
                            cat_ids = cat_ids+','+$(this).val();
                        }
                    });
                    var base_url = "<?php echo BASE_URL; ?>";
                    $.ajax({
                        url:"<?php echo BASE_URL.'district/download_view_reports'; ?>",
                        type:"post",
                        data:{district:district,year:year,school_ids:school_ids,cat_ids:cat_ids},
                        success:function(result)
                        {
                            $("#download_reports_modal").modal("hide");
                            $("body").removeClass("loading");
                            SaveToDiskdownload(base_url+'papers/district/'+result,result);
                        }
                    })
                },1000);
            }
        }
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
            var due_date_9 = $(".change_due_date_9").val();
            var school_ids = '';
            $(".select_school_div_due").find(".school_select:checked").each(function() {
                if(school_ids == "")
                {
                    school_ids = $(this).val();
                }
                else{
                    school_ids = school_ids+','+$(this).val();
                }
            });
            var year = $(".select_year_due").val();
            if(school_ids == "")
            {
                alert("Please select the Schools");
            }
            else if(year == "")
            {
                alert("Please select the Year");
            }
            else if(due_date_11 == "" && due_date_12 == "" && due_date_13 == "" && due_date_14 == "" && due_date_15 == "" && due_date_16 == "" && due_date_1 == "" && due_date_2 == "" && due_date_3 == "" && due_date_4 == "" && due_date_5 == "" && due_date_6 == "" && due_date_7 == "" && due_date_8 == "" && due_date_9 == "")
            {
                alert("Please choose the due date for atlease one Report.");
            }
            else{
                $.ajax({
                    url:"<?php echo BASE_URL.'district/set_due_dates'; ?>",
                    type:"post",
                    data:{school_ids:school_ids,year:year,due_date_11:due_date_11,due_date_12:due_date_12,due_date_13:due_date_13,due_date_14:due_date_14,due_date_15:due_date_15,due_date_16:due_date_16,due_date_1:due_date_1,due_date_2:due_date_2,due_date_3:due_date_3,due_date_4:due_date_4,due_date_5:due_date_5,due_date_6:due_date_6,due_date_7:due_date_7,due_date_8:due_date_8,due_date_9:due_date_9},
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
                        $(".due_date_td_9").html(due_date_9);
                        $("#choose_due_date_modal").modal("hide");
                    }
                })
            }
        }
        if($(e.target).hasClass('edit_date_reports'))
        {
            $("#select_all_schools").hide();
            $(".select_all_schools_cls").hide();
            $(".select_school_div_due").html("<h6 style='margin-left: 27px;color: #717171;'>Please select the District</h6>");
            $(".select_year_due").val("");
            $(".select_school_div_due").prop("checked",false);
            $("#choose_due_date_modal").modal("show");
        }
        if($(e.target).hasClass('submit_filter'))
        {
            var district_id = $(".filter_district").val();
            var school_id = $(".filter_school").val();
            var year = $(".select_year").val();
            if(district_id == "")
            {
                alert("Please select the District to view fiscal report result");
            }
            else if(school_id == "")
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
                    data:{district_id:district_id,school_id:school_id,year:year},
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
            var school_id = "<?php echo isset($_GET['school_id'])?$_GET['school_id']:0; ?>";
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