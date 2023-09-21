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
  top:8px;
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
                                                <label class="form-control-label" for="l0"><b>Template Name: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <?php echo $selectval['template_name']; ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-control-label" for="l0"><b>Title: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <?php echo $selectval['title']; ?>
                                            </div>
                                            <div class="col-md-2" style="font-size:18px">
                                                <?php
                                                if($selectval['title_attach_status'] == 1)
                                                {
                                                    if($selectval['title_attachment_filename'] == "")
                                                    {
                                                        echo '';
                                                    }
                                                    else{
                                                        $url = BASE_URL.$selectval['title_attachment_url'].'/'.$selectval['title_attachment_filename'];
                                                        echo '<a href="'.$url.'" download>'.$selectval['title_attachment_filename'].'</a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <h3><?php echo $selectval['title1']; ?></h3>
                                                <?php echo $selectval['step2_table_up_content']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <h3><?php echo $selectval['title2']; ?></h3>
                                                <?php echo $selectval['step1_table_down_content']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <h3><?php echo $selectval['title3']; ?></h3>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 style="margin-top: 10px">Upload Attachments:</h6>
                                                <table class="table">
                                                      <thead>
                                                        <th>Attachments</th>
                                                        <th>Comments</th>
                                                      </thead>
                                                      <tbody>
                                                        <?php
                                                        if($selectval['status'] > 2) { $disabled = 'disabled'; } else { $disabled = ''; } 
                                                        $lcap_attachments = $this->db->select('*')->from('report_lcap_attachments')->where('form_id',$template_id)->get()->result_array();
                                                        if(!empty($lcap_attachments))
                                                        {
                                                          foreach($lcap_attachments as $attach)
                                                          {
                                                            echo '<tr>
                                                              <td><a href="'.BASE_URL.$attach['attachment_url'].'/'.$attach['filename'].'" download style="font-weight:800;font-size:18px">'.$attach['filename'].'</a></td>
                                                              <td><textarea name="school_comments" class="form-control school_comments" '.$disabled.' placeholder="Enter Comments" data-element="'.$attach['id'].'">'.$attach['school_comments'].'</textarea></td>
                                                            </tr>';
                                                          }
                                                        }
                                                        ?>
                                                    </tbody>
                                                  </table>
                                            </div>
                                            <div class="col-md-8">
                                                <h3>Admin Comments</h3>
                                                <?php
                                                if($selectval['status'] > 3) { $disabled = 'disabled'; } else { $disabled = ''; } ?>

                                                <textarea name="admin_comments" class="form-control admin_comments" placeholder="Enter Comments" data-element="<?php echo $selectval['id']; ?>" <?php echo $disabled; ?>><?php echo $selectval['admin_comments']; ?></textarea>
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
                        <a href="javascript:" class="btn btn-primary submit_lcap">Submit</a>
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
    if($(e.target).hasClass('submit_lcap'))
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
    if($(e.target).hasClass('download_pdf'))
    {
      $("body").addClass("loading");
      setTimeout( function() {
        var template_id = $("#hidden_template_id").val();
          var base_url = "<?php echo BASE_URL; ?>";
          $.ajax({
            url:"<?php echo BASE_URL.'admin/download_lcap_report_pdf'; ?>",
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
            url:"<?php echo BASE_URL.'admin/print_lcap_report_pdf'; ?>",
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
})
$(".admin_comments").on("blur",function() {
  var form_id = $(this).attr("data-element");
  var comments = $(this).val();
  $.ajax({
    url:"<?php echo BASE_URL.'admin/save_lcap_admin_comments'; ?>",
    type:"post",
    data:{form_id:form_id,comments:comments},
    success:function(result)
    {

    }
  })
});
$(document).ready(function() {
    $(".editor").each(function(e) {
         CKEDITOR.replace(this.id,
         {
            height: '250px',
         });
    });
});

$.ajaxSetup({async:false});
$( "#form_sample_3" ).validate({
    rules: {
        template_name: {required: true,},
        'content_title[]':{required: true,},
    },
    messages: {
        template_name : "Template Name is required",
        'content_title[]': "Title is required",
    },
});

</script>