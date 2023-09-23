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
</style>

<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading">
        <h3>ADD REPORT</h3>
    </div>
    <hr>
    <div class="panel-body">
    	<div class="modal fade add_attachment_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:999999999">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?php echo BASE_URL.'school/upload_report_title_images'; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">Add Attachment</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control" value="">
                       <input name="hidden_file_id" type="hidden" id="hidden_file_id" value="<?php echo $template_id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
	<!-- Content Header (Page header) -->
	    <div class="row">
        	<section class="content">
        	    <!-- Small boxes (Stat box) -->
                     <!-- BEGIN FORM-->
                    
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
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
                                                        echo '<a href="javascript:" class="btn btn-primary open_attach_title_modal">'.$selectval['title_attachment_name'].'</a>';
                                                    }
                                                    else{
                                                        $url = BASE_URL.$selectval['title_attachment_url'].'/'.$selectval['title_attachment_filename'];
                                                        echo '<a href="'.$url.'" download>'.$selectval['title_attachment_filename'].'</a>';
                                                        if($selectval['status'] < 3)
                                                        {
                                                            $delete_url = BASE_URL.'school/delete_report_title_attachment/'.$selectval['id'];
                                                            echo '<a href="javascript:" data-element="'.$delete_url.'" class="fa fa-times delete_report_title" style="margin-left:10px"></a>';

                                                        }
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
                                              <?php if($selectval['status'] > 2){
                                                ?>
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
                                                <?php
                                              } else {
                                              ?>
                                                <h6 style="margin-top: 10px">Upload Attachments:</h6>
                                                <form action="<?php echo BASE_URL.'school/save_lcap_attachments'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                                                  <input type="file" name="attach_lcap[]" class="form-control attach_lcap" value="" multiple style="width:50%;float:left">
                                                  <input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $template_id; ?>">
                                                  <input type="submit" name="submit_lcap_attach" class="btn btn-primary" value="Submit">
                                                </form>
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
                                              <?php } ?>
                                            </tbody>
                                          </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="hidden_school_id" id="hidden_school_id" value="<?php echo ($_GET['school_id'] == "")?$selectval['school_id']:$_GET['school_id']; ?>">
                        <input type="hidden" name="hidden_district_id" id="hidden_district_id" value="<?php echo ($_GET['district_id'] == "")?$selectval['district_id']:$_GET['district_id']; ?>">
                        <input type="hidden" name="hidden_master_template" id="hidden_master_template" value="<?php echo $selectval['master']; ?>">
                        <a href="javascript:" class="btn btn-primary submit_lcap">Submit</a>
                    

                    <!--END FORM-->

            </section>
        </div>
    </div>
    </section>
    </div>
</section>
<?php
  $get_name_id = $this->db->select('*')->from('reports')->where('template',$selectval['template'])->where('master',1)->get()->row_array();
?>
<script>
$(window).click(function(e) {
    if($(e.target).hasClass('submit_lcap'))
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
})
$(".school_comments").on("blur",function() {
  var form_id = $(this).attr("data-element");
  var comments = $(this).val();
  $.ajax({
    url:"<?php echo BASE_URL.'school/save_lcap_school_comments'; ?>",
    type:"post",
    data:{form_id:form_id,comments:comments},
    success:function(result)
    {

    }
  })
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