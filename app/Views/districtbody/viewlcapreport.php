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
  top: 10px;
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
                                            <div class="col-md-2">
                                                <a href="javascript:" class="btn btn-primary"><?php echo $selectval['title_attachment_name']; ?></a>
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
})
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