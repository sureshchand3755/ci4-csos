<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading">
        <h3>ADD TEMPLATE / SURVEY</h3>
    </div>
    <hr>
    <div class="panel-body">
	<!-- Content Header (Page header) -->
	    <div class="row">
        	<section class="content">
        	    <!-- Small boxes (Stat box) -->
                     <!-- BEGIN FORM-->
                    <form action="<?php echo BASE_URL.'school/save_template_content'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <?php
                                        if(!empty($selectval)) { ?>
                                            <a class="nav-link" href="<?php echo BASE_URL.'school/addtemplate_step2/'.$template_id; ?>">Step 2</a>
                                        <?php } else { ?>
                                            <a class="nav-link" href="javascript:">Step 2</a>
                                        <?php } ?>
                                    </li>
                                    <li class="nav-item">
                                        <?php
                                        if(!empty($selectval)) { ?>
                                            <a class="nav-link" href="<?php echo BASE_URL.'school/addtemplate_step3/'.$template_id; ?>">Step 3</a>
                                        <?php } else { ?>
                                            <a class="nav-link" href="javascript:">Step 3</a>
                                        <?php } ?>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">
                                    <div class="tab-pane active" id="home1" role="tabpanel" aria-expanded="false">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-control-label" for="l0"><b>Template Name: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control template_name" name="template_name" placeholder="Enter Template Name" value="<?php echo $selectval['template_name']; ?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div id="append_div_body">
                                            <?php
                                            if(!empty($selectval))
                                            {
                                                $unserialize = unserialize($selectval['content']);
                                                $total_count = count($unserialize);
                                                if(count($unserialize)){
                                                    $i = 1;
                                                    foreach($unserialize as $key => $content)
                                                    {
                                                        ?>
                                                        <div class="form-group take_copy_div row">
                                                            <div class="col-md-8">
                                                                <h3><?php echo $key; ?></h3>
                                                            </div>
                                                            <div class="col-md-4 action_div">
                                                                &nbsp;
                                                            </div>
                                                            <div class="col-md-8" style="margin-top:20px">
                                                                <?php echo $content; ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                &nbsp;
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                            }
                                            else{
                                                ?>
                                                <div class="form-group take_copy_div row">
                                                    <div class="col-md-2">
                                                        <label class="form-control-label" for="l0"><b>Title: </b></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control content_title content_title_1" name="content_title[]" placeholder="Enter Title" required>
                                                    </div>
                                                    <div class="col-md-4 action_div">
                                                        &nbsp;
                                                    </div>
                                                    <div class="col-md-8" style="margin-top:20px">
                                                        <textarea class="form-control editor" name="editor_1" id="editor_1"></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $template_id; ?>">
                        <input type="hidden" name="hidden_school_id" id="hidden_school_id" value="<?php echo $_GET['school_id']; ?>">
                        <input type="submit" class="btn btn-primary submit_step_1" name="Submit_step1" value="Proceed to Step 2">
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
    $(".editor").each(function(e) {
         CKEDITOR.replace(this.id,
         {
            height: '150px',
         });
         CKEDITOR.config.readOnly = true;
    });
    $(".content_title").prop("readonly","true");
    $(".template_name").prop("readonly","true");

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
            var value = CKEDITOR.instances[$input.name].getData();
            $("#"+$input.name).text(value);
        });
});

// function ajax_response(e){
//     var template_name = $(".template_name").val();
//     var hidden_template_id = $("#hidden_template_id").val();
//     if(hidden_template_id == "")
//     {
//         if(template_name != "")
//         {
//             $(".editor").each(function(e) {
//                 var id = $(this).attr("id");
//                 var data = CKEDITOR.instances[id].getData();
                
//                 $.ajax({
//                     url:"<?php echo BASE_URL.'admin/ajax_create_master_template'; ?>",
//                     type:"post",
//                     data:{formdatas:$("#form_sample_3").serialize(),template_name:template_name,template_id:hidden_template_id},
//                     success: function(result)
//                     {
//                         $("#hidden_template_id").val(result);
//                         $.urlParam = function(name){
//                             var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
//                             if (results==null){
//                                return null;
//                             }
//                             else{
//                                return decodeURI(results[1]) || 0;
//                             }
//                         }
//                         var url = 'admin/addtemplate/'+result;
//                         //window.history.replaceState(null, null, "<?php echo BASE_URL; ?>"+url);
//                     }
//                 });
//             });
//         }
//     }
//     setTimeout(ajax_response,3000);
// }

// setTimeout(ajax_response,3000);
$(window).click(function(e) {
    if($(e.target).hasClass('add_content'))
    {
        var count = $("#append_div_body").find(".take_copy_div").length;
        var nextval = count + 1;
        var htmlcontent = '<div class="form-group take_copy_div row"><div class="col-md-2"><label class="form-control-label" for="l0"><b>Title: </b></label></div><div class="col-md-6"><input type="text" class="form-control content_title content_title_'+nextval+'" name="content_title[]" placeholder="Enter Title" required></div><div class="col-md-4 action_div">&nbsp;</div><div class="col-md-8" style="margin-top:20px"><textarea class="form-control editor" name="editor_'+nextval+'" id="editor_'+nextval+'"></textarea></div><div class="col-md-4">&nbsp;</div></div>';
        $("#append_div_body").append(htmlcontent);
        var k = 1;
        $(".editor").each(function(e) {
            var x = 'editor_'+k;
            if (CKEDITOR.instances[x]) CKEDITOR.instances[x].destroy();
             CKEDITOR.replace(x,
             {
                height: '150px',
             });
            k++;
        });

        $("#append_div_body").find(".action_div").find(".add_content").detach();
        $("#append_div_body").find(".take_copy_div:last").find(".action_div").html('');

    }
    if($(e.target).hasClass('remove_content'))
    {
        $(e.target).parents(".take_copy_div").detach();
        $(".editor").each(function(e) {
            var x = $(this).attr("id");
            if (CKEDITOR.instances[x]) CKEDITOR.instances[x].destroy();
        });
        var k = 1;
        $(".editor").each(function(e) {
            var x = 'editor_'+k;
            $(this).attr("id",x);
            $(this).attr("name",x);
             CKEDITOR.replace(x,
             {
                height: '150px',
             });
            k++;
        });


        $("#append_div_body").find(".action_div").find(".add_content").detach();
        $("#append_div_body").find(".take_copy_div:last").find(".action_div").html('');
    }
});
</script>