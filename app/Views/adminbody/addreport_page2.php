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
                                       <a class="nav-link" href="<?php echo BASE_URL.'admin/manage_report_template/'.$template_id; ?>">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:">Step 2</a>
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
                                            <div class="col-md-2">
                                                <label class="form-control-label" for="l0"><b>Title: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control template_title" name="template_title" placeholder="Enter Title" value="<?php echo $selectval['title_step2']; ?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <textarea class="form-control editor" name="editor_1" id="editor_1"><?php echo $selectval['step2_table_up_content']; ?></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <table class="table" style="width:70%">
                                            <thead>
                                                <th style="border:1px solid #dfdfdf;width:40%"><input type="text" name="step2_table_title_1" class="form-control step2_table_title_1" value="<?php if($selectval['step2_table_title_1'] == ""){ echo 'Supplemental Information'; }else { echo $selectval['step2_table_title_1']; } ?>"></th>
                                                <th style="border:1px solid #dfdfdf"><input type="text" name="step2_table_title_2" class="form-control step2_table_title_2" value="<?php if($selectval['step2_table_title_2'] == ""){ echo 'Provide Supplemental Information as Follows:'; }else { echo $selectval['step2_table_title_2']; } ?>"></th>
                                                <th style="border:1px solid #dfdfdf;width:3%"> </th>
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
                                                                <textarea name="content1[]" class="form-control content1" style="height:150px"><?php echo $report['content1']; ?></textarea>
                                                            </td>
                                                            <td style="border:1px solid #dfdfdf"><textarea name="content2[]" class="form-control content2" style="height:150px"><?php echo $report['content2']; ?></textarea></td>
                                                            <td style="border:1px solid #dfdfdf;vertical-align: bottom;">
                                                                <label class="switch">
                                                                    <input type="checkbox" class="attach_class" value="1" data-element="<?php echo $report['id']; ?>" <?php echo $check_attach; ?>>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <input type="hidden" name="attachment[]" class="attach_hidden" value="<?php  echo $attachvalue; ?>">
                                                                <a href="javascript:" class="fa fa-minus remove_content" data-element="<?php echo $report['id']; ?>"></a>
                                                                <a href="javascript:" class="fa fa-plus add_content"></a>
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
                                                <textarea class="form-control editor" name="editor_2" id="editor_2"><?php echo $selectval['step2_table_down_content']; ?></textarea>
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

$(".template_title").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var template_title = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:template_title,type:"title_step2"},
        success:function(result)
        {

        }
    })
});
$(".step2_table_title_1").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var title1 = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:title1,type:"step2_table_title_1"},
        success:function(result)
        {

        }
    })
});
$(".step2_table_title_2").on("blur", function() {
    var template_id = $("#hidden_template_id").val();
    var title2 = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
        type:"post",
        data:{template_id:template_id,content:title2,type:"step2_table_title_2"},
        success:function(result)
        {

        }
    })
});
$(".content1").on("blur", function() {
    var form_id = $(this).parents(".content_tr:first").attr("data-element");
    var content = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_reportform_content'; ?>",
        type:"post",
        data:{form_id:form_id,content:content,type:"content1"},
        success:function(result)
        {

        }
    })
});
$(".content2").on("blur", function() {
    var form_id = $(this).parents(".content_tr:first").attr("data-element");
    var content = $(this).val();
    $.ajax({
        url:"<?php echo BASE_URL.'admin/save_reportform_content'; ?>",
        type:"post",
        data:{form_id:form_id,content:content,type:"content2"},
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
                data:{template_id:template_id,content:value,type:"step2_table_down_content"},
                success:function(result)
                {

                }
            })
        });
});

function step2_content()
{
    $(".template_title").on("blur", function() {
        var template_id = $("#hidden_template_id").val();
        var template_title = $(this).val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
            type:"post",
            data:{template_id:template_id,content:template_title,type:"title_step2"},
            success:function(result)
            {

            }
        })
    });
    $(".step2_table_title_1").on("blur", function() {
        var template_id = $("#hidden_template_id").val();
        var title1 = $(this).val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
            type:"post",
            data:{template_id:template_id,content:title1,type:"step2_table_title_1"},
            success:function(result)
            {

            }
        })
    });
    $(".step2_table_title_2").on("blur", function() {
        var template_id = $("#hidden_template_id").val();
        var title2 = $(this).val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/save_template_name_report'; ?>",
            type:"post",
            data:{template_id:template_id,content:title2,type:"step2_table_title_2"},
            success:function(result)
            {

            }
        })
    });
    $(".content1").on("blur", function() {
        var form_id = $(this).parents(".content_tr:first").attr("data-element");
        var content = $(this).val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/save_reportform_content'; ?>",
            type:"post",
            data:{form_id:form_id,content:content,type:"content1"},
            success:function(result)
            {

            }
        })
    });
    $(".content2").on("blur", function() {
        var form_id = $(this).parents(".content_tr:first").attr("data-element");
        var content = $(this).val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/save_reportform_content'; ?>",
            type:"post",
            data:{form_id:form_id,content:content,type:"content2"},
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
                    data:{template_id:template_id,content:value,type:"step2_table_down_content"},
                    success:function(result)
                    {

                    }
                })
            });
    });
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
        var master = $("#hidden_master_template").val();
        var school_id = $("#hidden_school_id").val();
        var district_id = $("#hidden_district_id").val();

        <?php if($selectval['status'] < 1) { ?>
          var template_id = $("#hidden_template_id").val();
          $.ajax({
            url:"<?php echo BASE_URL.'admin/change_template_status_completed'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
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
          })
        <?php } else { ?>
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
});
</script>