<script src="<?php echo BASE_URL; ?>assets/print.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/print.min.css">
<style>
.readonly{
  pointer-events: none;
}
.readonly .slider{
  background: #dfdfdf !important;
}
.readonly .slider:before{
  background: #000 !important;
}
input:checked + .slider{
      background-color: #2196F3 !important;
}
    .form-control{
        border:1px solid #dfdfdf;
    }
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
  top:-95px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 0px;
  bottom: 3px;
  background-color: red;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.disabled{
  cursor:pointer;
  background: #000;
}
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
</style>
<div class="modal select_school_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select School</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $schools = $this->db->select('*')->from('go_schools')->where('district_id',$selectval['district_id'])->get()->result_array();
        if(!empty($schools))
        {
            foreach($schools as $school)
            {
                ?>
                <input type="checkbox" name="select_school" class="select_school" id="select_school_<?php echo $school['id']; ?>" value="<?php echo $school['id']; ?>"><label for="select_school_<?php echo $school['id']; ?>"><?php echo $school['school_name']; ?></label><br/>
                <?php
            }
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary allocate_now">Allocate Report to schools</button>
      </div>
    </div>
  </div>
</div>
<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading">
        <h3>ADD REPORT</h3>
    </div>
    <hr>
    <div class="panel-body">
	<!-- Content Header (Page header) -->
	    <div class="row">
        	<section class="content">
        	    <!-- Small boxes (Stat box) -->
                     <!-- BEGIN FORM-->
                    <form action="<?php echo BASE_URL.'admin/save_report_content'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link" href="<?php echo BASE_URL.'admin/view_report_template_submitted/'.$template_id; ?>">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:">Step 2</a>
                                    </li>
                                    <li class="nav-item" style="float:right">
                                        <div class="dropdown">
                                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Download As PDF
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item download_pdf" href="javascript:">Download Full Report</a>
                                          </div>
                                        </div>
                                    </li>
                                    <li class="nav-item" style="float:right">
                                        <div class="dropdown">
                                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Print
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item print_pdf" href="javascript:">Print Full Report</a>
                                          </div>
                                        </div>
                                    </li>
                                </ul>
                                
                                <div class="tab-content padding-vertical-20">
                                    <div class="tab-pane active" id="home1" role="tabpanel" aria-expanded="false">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-control-label" for="l0"><b>Title: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <?php echo $selectval['title_step2']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <?php echo $selectval['step2_table_up_content']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <table class="table" style="width:100%">
                                            <thead>
                                                <th style="border:1px solid #dfdfdf;width:20%"><?php echo $selectval['step2_table_title_1']; ?></th>
                                                <th style="border:1px solid #dfdfdf;width:20%"><?php echo $selectval['step2_table_title_2']; ?></th>
                                                <th style="border:1px solid #dfdfdf;width:10%">Attachments</th>
                                                <th style="border:1px solid #dfdfdf;width:25%">School Admin Comments</th>
                                                <th style="border:1px solid #dfdfdf;width:25%">Admin Comments</th>
                                            </thead>
                                            <tbody id="report_tbody">
                                                <?php
                                                $report_forms = $this->db->select('*')->from('report_forms')->where('template_id',$selectval['id'])->where('type',1)->get()->result_array();
                                                if(!empty($report_forms))
                                                {
                                                    foreach($report_forms as $report)
                                                    {
                                                        if($report['attachment'] == "0") { $check_attach = ''; $attachvalue = 0; }
                                                        else{ $check_attach = 'checked'; $attachvalue = 1; }  
                                                        ?>
                                                        <tr class="content_tr" data-element="<?php echo $report['id']; ?>">
                                                            <td style="border:1px solid #dfdfdf">
                                                                <?php echo $report['content1']; ?>
                                                            </td>
                                                            <td style="border:1px solid #dfdfdf"> <?php echo $report['content2']; ?></td>
                                                            <td style="border:1px solid #dfdfdf;vertical-align: bottom;">
                                                                <?php
                                                                $report_attachments = $this->db->select('*')->from('report_attachments')->where('form_id',$report['id'])->get()->result_array();

                                                                $output ='<p>Attachments:</p>';
                                                                if(!empty($report_attachments))
                                                                {
                                                                    foreach($report_attachments as $attach)
                                                                    {
                                                                        echo '<p><a href="'.BASE_URL.$attach['attachment_url'].'/'.$attach['filename'].'" download>'.$attach['filename'].'</a> </p>';
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border:1px solid #dfdfdf">
                                                              <?php echo $report['school_comments']; ?>
                                                            </td>
                                                            <td style="border:1px solid #dfdfdf">
                                                              <?php if($selectval['status'] > 3) { $disabled = 'disabled'; } else { $disabled = ''; } ?>
                                                              <?php
                                                              if($report['attachment'] == 1) { ?>
                                                                    <textarea name="admin_comments" class="form-control admin_comments" <?php echo $disabled; ?> placeholder="Enter Comments" data-element="<?php echo $report['id']; ?>"><?php echo $report['admin_comments']; ?></textarea>
                                                              <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                else{
                                                    ?>
                                                    <tr class="content_tr">
                                                        <td style="border:1px solid #dfdfdf">
                                                            <input type="text" name="content1[]" class="form-control content1" value="">
                                                        </td>
                                                        <td style="border:1px solid #dfdfdf"><textarea name="content2[]" class="form-control content2" style="height:150px"></textarea></td>
                                                        <td style="border:1px solid #dfdfdf;vertical-align: bottom;"><a href="javascript:" class="fa fa-plus add_content"></a></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <?php echo $selectval['step2_table_down_content']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $template_id; ?>">
                        <input type="hidden" name="hidden_school_id" id="hidden_school_id" value="<?php echo ($_GET['school_id'] == "")?$selectval['school_id']:$_GET['school_id']; ?>">
                        <input type="hidden" name="hidden_district_id" id="hidden_district_id" value="<?php echo ($_GET['district_id'] == "")?$selectval['district_id']:$_GET['district_id']; ?>">
                        <input type="hidden" name="hidden_master_template" id="hidden_master_template" value="<?php echo $selectval['master']; ?>">
                        <a href="javascript:" class="btn btn-primary submit_report">Submit</a>
                    </form>

                    <!--END FORM-->

            </section>
        </div>
    </div>
    </section>
    </div>
</section>
<div class="modal_load"></div>
<script>
$(document).ready(function() {
    $(".content_tr").find(".remove_content").show();
    $(".content_tr").find(".add_content").hide();
    $(".content_tr:last").find(".add_content").show();
    var content_length = $(".content_tr").length;
    if(content_length < 2)
    {
        $(".content_tr:last").find(".remove_content").hide();
    }
    $(".editor").each(function(e) {
         CKEDITOR.replace(this.id,
         {
            height: '150px',
         });
    });
});
$(".admin_comments").on("blur",function() {
  var form_id = $(this).attr("data-element");
  var comments = $(this).val();
  $.ajax({
    url:"<?php echo BASE_URL.'admin/save_admin_comments'; ?>",
    type:"post",
    data:{form_id:form_id,comments:comments},
    success:function(result)
    {

    }
  })
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
function print_pdf(url){
  var idval = detectPopupBlocker_download();
  if(idval == 1)
  {
    alert("A popup blocker was detected. Please Allow the popups to download the file.");
  }
  else{
      var objFra = document.createElement('iframe');   // Create an IFrame.
        objFra.style.visibility = "hidden";    // Hide the frame.
        objFra.src = url;                      // Set source.
        document.body.appendChild(objFra);  // Add the frame to the web page.
        objFra.contentWindow.focus();       // Set focus.
        objFra.contentWindow.print();      // Print it.
  }
}
$(window).click(function(e) {
    if($(e.target).parents(".switch").length > 0)
    {
        if($(e.target).parents("td:first").find(".attach_class").is(":checked"))
        {
            var form_id = $(e.target).parents("td:first").find(".attach_class").attr("data-element");
            $.ajax({
                url:"<?php echo BASE_URL.'admin/save_reportform_content'; ?>",
                type:"post",
                data:{form_id:form_id,content:"1",type:"attachment"},
                success:function(result)
                {
                    $(e.target).parents("td:first").find(".attach_hidden").val("1");
                }
            });
        }
        else{
            var form_id = $(e.target).parents("td:first").find(".attach_class").attr("data-element");
            $.ajax({
                url:"<?php echo BASE_URL.'admin/save_reportform_content'; ?>",
                type:"post",
                data:{form_id:form_id,content:"0",type:"attachment"},
                success:function(result)
                {
                    $(e.target).parents("td:first").find(".attach_hidden").val("0");
                }
            });
        }
    }
    if($(e.target).hasClass('allocate_now'))
    {
        var school_ids = '';
        $(".select_school:checked").each(function(){
            if(school_ids == "")
            {
                school_ids = $(this).val();
            }
            else{
                school_ids = school_ids+','+$(this).val();
            }
        });
        if(school_ids == "")
        {
            alert("Please select the school to allocate the report");
        }
        else{
            var template_id = $("#hidden_template_id").val();
            var district_id = $('#hidden_district_id').val();
            $.ajax({
                url:'<?php echo BASE_URL.'admin/allocate_report_to_school'; ?>',
                type:"post",
                data:{template_id:template_id,district_id:district_id,school_ids:school_ids},
                success:function(result)
                {
                    window.location.replace("<?php echo BASE_URL.'admin/manage_district_reports?district_id='; ?>"+district_id);
                }
            })
        }
    }
    if($(e.target).hasClass('submit_report'))
    {
        <?php if($selectval['status'] < 4) { ?>
          var template_id = $("#hidden_template_id").val();
          $.ajax({
            url:"<?php echo BASE_URL.'admin/change_template_status'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              window.location.replace("<?php echo BASE_URL.'admin/manage_school_reports?school_id='.$selectval['school_id'].''; ?>");
            }
          })
        <?php } else { ?>
          window.location.replace("<?php echo BASE_URL.'admin/manage_school_reports?school_id='.$selectval['school_id'].''; ?>");
        <?php } ?>
    }
    if($(e.target).hasClass('add_content'))
    {
        var template_id = $("#hidden_template_id").val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/get_report_table_tr_step2'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
                $("#report_tbody").append(result);
                $(".content_tr").find(".remove_content").show();
                $(".content_tr").find(".add_content").hide();
                $(".content_tr:last").find(".add_content").show();
                var content_length = $(".content_tr").length;
                if(content_length < 2)
                {
                    $(".content_tr:last").find(".remove_content").hide();
                }
                step2_content();
            }
        });
    }
    if($(e.target).hasClass('remove_content'))
    {
        var template_id = $("#hidden_template_id").val();
        var report_id = $(e.target).attr("data-element");
        $.ajax({
            url:"<?php echo BASE_URL.'admin/remove_report_forms'; ?>",
            type:"post",
            data:{template_id:template_id,report_id:report_id},
            success:function(result)
            {
                $(e.target).parents(".content_tr:first").detach();
                $(".content_tr").find(".remove_content").show();
                $(".content_tr").find(".add_content").hide();
                $(".content_tr:last").find(".add_content").show();
                var content_length = $(".content_tr").length;
                if(content_length < 2)
                {
                    $(".content_tr:last").find(".remove_content").hide();
                }
            }
        });
    }
    if($(e.target).hasClass('download_pdf'))
    {
      $("body").addClass("loading");
      setTimeout( function() {
        var template_id = $("#hidden_template_id").val();
          var base_url = "<?php echo BASE_URL; ?>";
          $.ajax({
            url:"<?php echo BASE_URL.'admin/download_report_pdf'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              $("body").removeClass("loading");
              SaveToDiskdownload(base_url+'papers/admin/'+result,result);
            }
          })
      },1000);
    }
    if($(e.target).hasClass('print_pdf'))
    {
      $("body").addClass("loading");
      setTimeout( function() {
        var template_id = $("#hidden_template_id").val();
          var base_url = "<?php echo BASE_URL; ?>";
          $.ajax({
            url:"<?php echo BASE_URL.'admin/print_report_pdf'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              $("body").removeClass("loading");
              printJS(base_url+'papers/admin/'+result);
            }
          })
      },1000);
    }
});
</script>