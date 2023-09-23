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
<div class="panel-body">
    <div class="row">
    	<section class="content">
            <div class="col-md-12">
                <div class="col-md-2">
                    <label style="font-weight:600">Select Year:</label>
                    <select name="select_year" class="form-control select_year">
                        <option value="">Select Year</option>
                        <?php
                        $current_year = date('Y');
                        for($year=2018; $year<=$current_year; $year++)
                        {
                            if($current_year == $year) { $selected = 'selected'; } else { $selected = ''; }
                            $next_year = $year + 1;
                            echo '<option value="'.$year.'" '.$selected.'>'.$year.' - '.$next_year.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="button" name="submit_filter" class="btn btn-primary submit_filter" value="Submit" style="margin-top:26px">
                </div>
                <div class="col-md-8">
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
                        <?php
                        $school_id = $this->session->userdata('gowriteschooladmin_Userid');
                        $year = date('Y');
                        $result = $this->db->select('*')->from('report_result')->where('school_id',$school_id)->where('year',$year)->get()->row_array();
                        if(!empty($result))
                        {
                            $due_dates = unserialize($result['due_dates']);
                        }
                        else{
                            $due_dates = array();
                        }
                        $prev_year = $year;
                        $current_year = $year + 1;
                        $report_1 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '11' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_2 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '12' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_3 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '13' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_4 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '14' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_5 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '16' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_6 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '15' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_7 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '4' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_8 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '1' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_9 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '2' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_10 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '3' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_11 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '5' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_12 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '6' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_15 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '9' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_13 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '7' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $report_14 = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '8' AND (`updatetime` LIKE '$prev_year%' OR `updatetime` LIKE '$current_year%') ORDER BY `updatetime` desc")->row_array();
                        $output.='<tr>
                            <td class="due_date_td_11">'; if(isset($due_dates[0])) { $output.=date('F d Y', strtotime($due_dates[0])); } $output.='</td>
                            <td>Annual Adopted Budget</td>
                            <td>'; if(!empty($report_1)) { $output.=date('F d Y',strtotime($report_1['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_12">'; if(isset($due_dates[1])) { $output.=date('F d Y', strtotime($due_dates[1])); } $output.='</td>
                            <td>Unaudited Actuals</td>
                            <td>'; if(!empty($report_2)) { $output.=date('F d Y',strtotime($report_2['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_13">'; if(isset($due_dates[2])) { $output.=date('F d Y', strtotime($due_dates[2])); } $output.='</td>
                            <td>First Interim</td>
                            <td>'; if(!empty($report_3)) { $output.=date('F d Y',strtotime($report_3['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_14">'; if(isset($due_dates[3])) { $output.=date('F d Y', strtotime($due_dates[3])); } $output.='</td>
                            <td>Second Interim</td>
                            <td>'; if(!empty($report_4)) { $output.=date('F d Y',strtotime($report_4['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_16">'; if(isset($due_dates[4])) { $output.=date('F d Y', strtotime($due_dates[4])); } $output.='</td>
                            <td>Third Interim(Annual)</td>
                            <td>'; if(!empty($report_5)) { $output.=date('F d Y',strtotime($report_5['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_15">'; if(isset($due_dates[5])) { $output.=date('F d Y', strtotime($due_dates[5])); } $output.='</td>
                            <td>LCAP</td>
                            <td>'; if(!empty($report_6)) { $output.=date('F d Y',strtotime($report_6['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_4">'; if(isset($due_dates[6])) { $output.=date('F d Y', strtotime($due_dates[6])); } $output.='</td>
                            <td>Annual Audit</td>
                            <td>'; if(!empty($report_7)) { $output.=date('F d Y',strtotime($report_7['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_1">'; if(isset($due_dates[7])) { $output.=date('F d Y', strtotime($due_dates[7])); } $output.='</td>
                            <td>P 1</td>
                            <td>'; if(!empty($report_8)) { $output.=date('F d Y',strtotime($report_8['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_2">'; if(isset($due_dates[8])) { $output.=date('F d Y', strtotime($due_dates[8])); } $output.='</td>
                            <td>P 2</td>
                            <td>'; if(!empty($report_9)) { $output.=date('F d Y',strtotime($report_9['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_3">'; if(isset($due_dates[9])) { $output.=date('F d Y', strtotime($due_dates[9])); } $output.='</td>
                            <td>P 3</td>
                            <td>'; if(!empty($report_10)) { $output.=date('F d Y',strtotime($report_10['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_5">'; if(isset($due_dates[10])) { $output.=date('F d Y', strtotime($due_dates[10])); } $output.='</td>
                            <td>Report Review</td>
                            <td>'; if(!empty($report_11)) { $output.=date('F d Y',strtotime($report_11['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_6">'; if(isset($due_dates[11])) { $output.=date('F d Y', strtotime($due_dates[11])); } $output.='</td>
                            <td>FCMAT Calculator</td>
                            <td>'; if(!empty($report_12)) { $output.=date('F d Y',strtotime($report_12['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_9">'; if(isset($due_dates[14])) { $output.=date('F d Y', strtotime($due_dates[14])); } $output.='</td>
                            <td>Expanded Learning Opportunities Grant Plan</td>
                            <td>'; if(!empty($report_15)) { $output.=date('F d Y',strtotime($report_15['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_7">'; if(isset($due_dates[12])) { $output.=date('F d Y', strtotime($due_dates[12])); } $output.='</td>
                            <td>Misc Report</td>
                            <td>'; if(!empty($report_13)) { $output.=date('F d Y',strtotime($report_13['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>
                        <tr>
                            <td class="due_date_td_8">'; if(isset($due_dates[13])) { $output.=date('F d Y', strtotime($due_dates[13])); } $output.='</td>
                            <td>Misc Report</td>
                            <td>'; if(!empty($report_14)) { $output.=date('F d Y',strtotime($report_14['updatetime'])); } else { $output.='-'; } $output.='</td>
                        </tr>';
                        echo $output;
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
        $( ".change_due_date" ).datepicker({ dateFormat: 'mm/dd/yy' });
    });
    $(window).click(function(e) {
        if($(e.target).hasClass('submit_filter'))
        {
            var year = $(".select_year").val();
            if(year == "")
            {
                alert("Please select the Year to view fiscal report result");
            }
            else{
                $.ajax({
                    url:"<?php echo BASE_URL.'school/reports_result'; ?>",
                    type:"post",
                    data:{year:year},
                    success:function(result)
                    {
                        $("#report_tbody").html(result);
                        $(".edit_date_reports").show();
                    }
                })
            }
        }
    });
</script>