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
<div class="modal fade add_attachment_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:999999999">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="exampleModalLabel">Add Attachment</h4>
        </div>
        <div class="modal-body">
          <div class="attachment_show_div" style="display:none">
            <strong>Attachments:</strong>
            <div class="attachment_inner_div">

            </div>
          </div>
          <div class="img_div">
             <div class="image_div_attachments">
               <form action="<?php echo BASE_URL.'school/upload_report_images'; ?>" method="post" enctype="multipart/form-data" class="dropzone" id="imageUpload" style="clear:both;min-height:80px;background: #949400;color:#000;border:0px solid; height:auto; width:100%; float:left">
                   <input name="hidden_file_id" type="hidden" id="hidden_file_id" value="">
               </form>
             </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary close_dropzone">Submit</button>
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
                    <form action="<?php echo BASE_URL.'school/save_report_content'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link" href="<?php echo BASE_URL.'school/view_report_template/'.$template_id; ?>">Step 1</a>
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
                                <?php
                                if($selectval['status'] > 1)
                                {
                                    ?>
                                    <style>
                                        .form-control{ pointer-events: none; }
                                        .fa-plus,.fa-trash { display:none; }
                                    </style>
                                    <?php
                                    $disabled = 'readonly';
                                }
                                else{
                                    $disabled = '';
                                }
                                ?>
                                <div class="tab-content padding-vertical-20">
                                    <div class="tab-pane active" id="home1" role="tabpanel" aria-expanded="false">
                                        <div class="form-group row">
                                            
                                            <div class="col-md-4">
                                               <h3> <?php echo $selectval['title_step2']; ?></h3>
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
                                          <?php
                                          if($selectval['status'] == 4)
                                          {
                                            ?>
                                            <thead>
                                                <th style="border:1px solid #dfdfdf;width:20%"><?php echo $selectval['step2_table_title_1']; ?></th>
                                                <th style="border:1px solid #dfdfdf;width:20%"><?php echo $selectval['step2_table_title_2']; ?></th>
                                                <th style="border:1px solid #dfdfdf;width:10%">Attachments</th>
                                                <th style="border:1px solid #dfdfdf;width:25%">Comments</th>
                                                <th style="border:1px solid #dfdfdf;width:25%">Admin Comments</th>
                                            </thead>
                                            <?php
                                          }
                                          else{
                                            ?>
                                            <thead>
                                                <th style="border:1px solid #dfdfdf;width:20%"><?php echo $selectval['step2_table_title_1']; ?></th>
                                                <th style="border:1px solid #dfdfdf;width:30%"><?php echo $selectval['step2_table_title_2']; ?></th>
                                                <th style="border:1px solid #dfdfdf;width:20%">Attachments</th>
                                                <th style="border:1px solid #dfdfdf;width:30%">Comments</th>
                                            </thead>
                                            <?php
                                          }
                                          ?>
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

                                                                if($template_details['status'] >= 3)
                                                                {
                                                                    if($report['attachment'] == 1) {
                                                                        $output ='<p>Attachments:</p>';
                                                                        if(!empty($report_attachments))
                                                                        {
                                                                            foreach($report_attachments as $attach)
                                                                            {
                                                                                echo '<p><a href="'.BASE_URL.$attach['attachment_url'].'/'.$attach['filename'].'" download>'.$attach['filename'].'</a> </p>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    if($report['attachment'] == 1) {
                                                                        $output ='<p>Attachments:</p>';
                                                                        if(!empty($report_attachments))
                                                                        {
                                                                            foreach($report_attachments as $attach)
                                                                            {
                                                                                echo '<p><a href="'.BASE_URL.$attach['attachment_url'].'/'.$attach['filename'].'" download>'.$attach['filename'].'</a> <a href="javascript:" class="fa fa-trash trash_image" data-element="'.$attach['id'].'"></a></p>';
                                                                            }
                                                                        }
                                                                    
                                                                        echo '<i class="fa fa-plus faplus" style="margin-top:10px" aria-hidden="true" data-element="'.BASE_URL.'school/upload_report_images?file_id='.$report['id'].'" data-value="'.$report['id'].'" title="Add Attachment"></i><br/>';
                                                                    }
                                                                }
                                                                ?>
                                                                <input type="hidden" name="attachment[]" class="attach_hidden" value="<?php  echo $attachvalue; ?>">
                                                            </td>
                                                            <?php
                                                            if($selectval['status'] == 4)
                                                            {
                                                              ?>
                                                              <td style="border:1px solid #dfdfdf">
                                                              <?php echo $report['school_comments']; ?>
                                                            </td>
                                                              <td style="border:1px solid #dfdfdf">
                                                              <?php echo $report['admin_comments']; ?>
                                                            </td>
                                                              <?php
                                                            }
                                                            else{
                                                              ?>
                                                              <td style="border:1px solid #dfdfdf">
                                                                <?php if($selectval['status'] >= 3) { $disabled = 'disabled'; } else { $disabled = ''; } ?>
                                                                <?php
                                                                if($report['attachment'] == 1) { ?>
                                                                <textarea name="school_comments" class="form-control school_comments" <?php echo $disabled; ?> placeholder="Enter Comments" data-element="<?php echo $report['id']; ?>"><?php echo $report['school_comments']; ?></textarea>
                                                                <?php } ?>
                                                              </td>
                                                              <?php
                                                            }
                                                            ?>
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
    <?php
      $get_name_id = $this->db->select('*')->from('reports')->where('template',$selectval['template'])->where('master',1)->get()->row_array();
    ?>
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
$(".school_comments").on("blur",function() {
  var form_id = $(this).attr("data-element");
  var comments = $(this).val();
  $.ajax({
    url:"<?php echo BASE_URL.'school/save_school_comments'; ?>",
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
    if($(e.target).hasClass('close_dropzone'))
  {
    window.location.reload();
  }
  if($(e.target).hasClass('image_submit'))
  {
    var files = $(e.target).parent().find('.image_file').val();
    if(files == '' || typeof files === 'undefines')
    {
      $(e.target).parent().find(".error_files").text("Please Choose the files to proceed");
      return false;
    }
    else{
      $(e.target).parents('td').find('.img_div').show();
    }
  }
  else{
    $(".img_div").each(function() {
      $(this).show();
    });
  }
  if($(e.target).hasClass('image_file'))
  {
    $(e.target).parents('td').find('.img_div').show();
    $(e.target).parents('.modal-body').find('.img_div').show();
  }
  if($(e.target).hasClass("dropzone"))
  {
    $(e.target).parents('td').find('.img_div').show();    
    $(e.target).parents('.modal-body').find('.img_div').show();    
  }
  if($(e.target).hasClass("remove_dropzone_attach"))
  {
    $(e.target).parents('td').find('.img_div').show();   
    $(e.target).parents('.modal-body').find('.img_div').show();
  }
  if($(e.target).parent().hasClass("dz-message"))
  {
    $(e.target).parents('td').find('.img_div').show();
    $(e.target).parents('.modal-body').find('.img_div').show();    
  }
  if($(e.target).hasClass('fileattachment'))
  {
    e.preventDefault();
    var element = $(e.target).attr('data-element');
    $('body').addClass('loading');
    setTimeout(function(){
      SaveToDisk(element,element.split('/').reverse()[0]);
      $('body').removeClass('loading');
      }, 3000);
    return false; 
  }
  if($(e.target).hasClass('remove_dropzone_attach'))
  {
    var attachment_id = $(e.target).attr("data-element");
    $.ajax({
      url:"<?php echo BASE_URL.'school/remove_dropzone_attachment'; ?>",
      type:"post",
      data:{attachment_id:attachment_id},
      success: function(result)
      {
        $(e.target).parents("p").detach();
      }
    })
  }
  if($(e.target).hasClass('trash_image'))
  {
    var r = confirm("Are You sure you want to delete");
    if (r == true) {
      var imgid = $(e.target).attr('data-element');
      $.ajax({
          url:"<?php echo BASE_URL.'school/report_delete_image'; ?>",
          type:"get",
          data:{imgid:imgid},
          success: function(result) {
            window.location.reload();
          }
      });
    }
  }
  if($(e.target).hasClass('delete_all_image')){
    var r = confirm("Are You sure you want to delete all the attachments?");
    if (r == true) {
      var id = $(e.target).attr('data-element');
      $.ajax({
          url:"<?php echo BASE_URL.'school/infile_delete_all_image'; ?>",
          type:"get",
          data:{id:id},
          success: function(result) {
            window.location.reload();
          }
      });
    }
  }
    if($(e.target).hasClass('fa-plus'))
  {
    $(".add_attachment_modal").modal("show");
    var href = $(e.target).attr("data-element");
    var value = $(e.target).attr("data-value");

    $("#imageUpload").attr("action",href);
    $("#hidden_file_id").val(value);

    $(".attachment_show_div").hide();
    $(".attachment_inner_div").html("");

    $(".dz-message").find("span").html("Click here to BROWSE the files <br/>OR just drop files here to upload");
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
                url:'<?php echo BASE_URL.'school/allocate_report_to_school'; ?>',
                type:"post",
                data:{template_id:template_id,district_id:district_id,school_ids:school_ids},
                success:function(result)
                {
                    window.location.replace("<?php echo BASE_URL.'school/manage_district_reports?district_id='; ?>"+district_id);
                }
            })
        }
    }
    if($(e.target).hasClass('submit_report'))
    {
        <?php if($selectval['status'] < 3) { ?>
          var template_id = $("#hidden_template_id").val();
          $.ajax({
            url:"<?php echo BASE_URL.'school/change_template_status'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              window.location.replace("<?php echo BASE_URL.'school/manage_school_reports?type=1&cat='.$get_name_id['id'].''; ?>");
            }
          })
        <?php } elseif($selectval['status'] == 3) { ?>
          window.location.replace("<?php echo BASE_URL.'school/manage_school_reports?type=2&cat='.$get_name_id['id'].''; ?>");
        <?php } else { ?>
          window.location.replace("<?php echo BASE_URL.'school/manage_school_reports?type=3&cat='.$get_name_id['id'].''; ?>");
        <?php } ?>
    }
    if($(e.target).hasClass('add_content'))
    {
        var template_id = $("#hidden_template_id").val();
        $.ajax({
            url:"<?php echo BASE_URL.'school/get_report_table_tr_step2'; ?>",
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
            url:"<?php echo BASE_URL.'school/remove_report_forms'; ?>",
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
            url:"<?php echo BASE_URL.'school/download_report_pdf'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              $("body").removeClass("loading");
              SaveToDiskdownload(base_url+'papers/school/'+result,result);
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
            url:"<?php echo BASE_URL.'school/print_report_pdf'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              $("body").removeClass("loading");
              printJS(base_url+'papers/school/'+result);
            }
          })
      },1000);
    }
});
fileList = new Array();
Dropzone.options.imageUpload = {
    acceptedFiles: null,
    maxFilesize:50000,
    timeout: 10000000,
    dataType: "HTML",
    parallelUploads: 1,
    init: function() {
        this.on('sending', function(file) {
            $("body").addClass("loading");
        });
        this.on("drop", function(event) {
            $("body").addClass("loading");        
        });
        this.on("success", function(file, response) {
            var obj = jQuery.parseJSON(response);
            file.serverId = obj.id; // Getting the new upload ID from the server via a JSON response
            if(obj.id != 0)
            {
              $(".attachment_show_div").show();
              $(".attachment_inner_div").append("<p>"+obj.filename+" <a href='javascript:' class='remove_dropzone_attach' data-element='"+obj.id+"'>Remove</a></p>");
            }
            else{
              $("#attachments_text").show();
              $("#add_attachments_div").append("<p>"+obj.filename+" </p>");
              $(".img_div").each(function() {
                $(this).show();
              });
            }
            $(".dropzone").removeClass("dz-started");
            $(".dz-preview").detach();
            $(".dz-message").find("span").html("Click here to BROWSE the files <br/>OR just drop files here to upload");
        });
        this.on("complete", function (file) {
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            $("body").removeClass("loading");
          }
         });
        this.on("error", function (file) {
            console.log(file);
            $("body").removeClass("loading");
      });
        this.on("canceled", function (file) {
            $("body").removeClass("loading");
      });
    },
};
</script>