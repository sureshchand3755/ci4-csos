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
                                                <input type="text" class="form-control template_name" name="template_name" placeholder="Enter Template Name" value="<?php echo $selectval['template_name']; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <?php
                                                    if($selectval['template'] == "Annual Adopted Budget") { $type = '11'; }
                                                    elseif($selectval['template'] == "Unaudited Actuals") { $type = '12'; }
                                                    elseif($selectval['template'] == "First Interim") { $type = '13'; }
                                                    elseif($selectval['template'] == "Second Interim") { $type = '14'; }
                                                    elseif($selectval['template'] == "LCAP") { $type = '15'; }
                                                    elseif($selectval['template'] == "Third Interim (Annual)") { $type = '16'; }
                                                    if($selectval['master'] != 1) {
                                                ?>
                                                <a href="<?php echo BASE_URL.'admin/upload_reports?template_id='.$selectval['id'].'&type='.$type.'&district_id='.$_GET['district_id'].'&school_id='.$_GET['school_id']; ?>" class="btn btn-primary skip_submission">Skip Submission and Upload Report</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-control-label" for="l0"><b>Title: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control template_title" name="template_title" placeholder="Enter Template Title" value="<?php echo $selectval['title']; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control template_title_attachment" name="template_title_attachment" value="<?php echo $selectval['title_attachment_name']; ?>">
                                            </div>
                                            <div class="col-md-1">
                                                <?php
                                                if($selectval['title_attach_status'] == "0") { $check_attach = ''; $attachvalue = 0; }
                                                else{ $check_attach = 'checked'; $attachvalue = 1; }  
                                                ?>
                                                <label class="switch">
                                                    <input type="checkbox" class="title_attach" value="1" data-element="<?php echo $selectval['id']; ?>" <?php echo $check_attach; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                                <input type="hidden" name="title_attach_status" class="title_attach_status" value="<?php  echo $attachvalue; ?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control title1" placeholder="Lcap Overview" value="<?php echo $selectval['title1']; ?>">
                                                <textarea class="form-control editor" name="editor_1" id="editor_1"><?php echo $selectval['step2_table_up_content']; ?></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control title2" placeholder="Learning Continuty and Attendance Plan" value="<?php echo $selectval['title2']; ?>">
                                                <textarea class="form-control editor" name="editor_2" id="editor_2"><?php echo $selectval['step1_table_down_content']; ?></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control title3" value="<?php echo $selectval['title3']; ?>">
                                            </div>
                                            <div class="col-md-8">
                                                <h6 style="margin-top: 10px">Upload Attachments:</h6>
                                                <?php
                                                if($selectval['attachment'] == "0") { $check_attach = ''; $attachvalue = 0; }
                                                else{ $check_attach = 'checked'; $attachvalue = 1; }  
                                                        ?>
                                                <label class="switch">
                                                    <input type="checkbox" class="attach_class" value="1" <?php echo $check_attach; ?> disabled>
                                                    <span class="slider round"></span>
                                                </label>
                                                <input type="hidden" name="attachment[]" class="attach_hidden" value="<?php  echo $attachvalue; ?>">
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

<script>
$(window).click(function(e) {
    if($(e.target).parents(".switch").length > 0)
    {
        if($(e.target).parents(".form-group:first").find(".title_attach").is(":checked"))
        {
            var template_id = $(e.target).parents(".form-group:first").find(".title_attach").attr("data-element");
            $.ajax({
                url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
                type:"post",
                data:{template_id:template_id,content:"1",type:"title_attach_status"},
                success:function(result)
                {
                    $(e.target).parents(".form-group:first").find(".title_attach_status").val("1");
                }
            })
        }
        else{
            var template_id = $(e.target).parents(".form-group:first").find(".title_attach").attr("data-element");
            $.ajax({
                url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
                type:"post",
                data:{template_id:template_id,content:"0",type:"title_attach_status"},
                success:function(result)
                {
                    $(e.target).parents(".form-group:first").find(".title_attach_status").val("0");
                }
            })
        }
    }
    if($(e.target).hasClass('submit_lcap'))
    {
        var attachment = $(".attach_hidden").val();
        if(attachment == "0")
        {
            e.preventDefault();
            alert("Please switch on the upload attachments");
        }
        else{
            var master = $("#hidden_master_template").val();
            var school_id = $("#hidden_school_id").val();
            var district_id = $("#hidden_district_id").val();

            if(master == "1")
            {
                window.location.replace("<?php echo BASE_URL.'admin/manage_reports'; ?>");
            }
            else{
                if(school_id != "" && school_id != "0")
                {
                    window.location.replace("<?php echo BASE_URL.'admin/manage_school_reports?school_id='; ?>"+school_id);
                }
                else{
                    $(".select_school_modal").modal("show");
                }
            }
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
})
$(document).ready(function() {
    $(".editor").each(function(e) {
         CKEDITOR.replace(this.id,
         {
            height: '250px',
         });
    });
});
$(".template_name").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_name = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_name,type:"template_name"},
        success:function(result)
        {

        }
    })
});
$(".template_title").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_title = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_title,type:"title"},
        success:function(result)
        {

        }
    })
});
$(".template_title_attachment").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_title_attachment = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_title_attachment,type:"title_attachment_name"},
        success:function(result)
        {

        }
    })
});
$(".title1").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_title = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_title,type:"title1"},
        success:function(result)
        {

        }
    })
});
$(".title2").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_title = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_title,type:"title2"},
        success:function(result)
        {

        }
    })
});
$(".title3").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_title = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_title,type:"title3"},
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
CKEDITOR.on('instanceCreated', function (e) {
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 second for example
        var $input = e.editor;

        $input.on('change', function () {
            var value = CKEDITOR.instances['editor_1'].getData();
            var template_id = $("#hidden_template_id").val();
            
            $.ajax({
                url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
                type:"post",
                data:{template_id:template_id,content:value,type:"step2_table_up_content"},
                success:function(result)
                {

                }
            })

            var value = CKEDITOR.instances['editor_2'].getData();
            $.ajax({
                url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
                type:"post",
                data:{template_id:template_id,content:value,type:"step1_table_down_content"},
                success:function(result)
                {

                }
            })
        });
});
</script>