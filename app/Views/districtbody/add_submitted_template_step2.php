<section class="page-content">
    <div class="page-content-inner">
    <section class="panel">
    <hr>
    <div class="panel-body">
    <!-- Content Header (Page header) -->
        <div class="row">
            <section class="content">
                <!-- Small boxes (Stat box) -->
                     <!-- BEGIN FORM-->
                    <form action="<?php echo BASE_URL.'district/save_template_content_step2_submitted'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BASE_URL.'district/add_submitted_template/'.$template_id; ?>">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:">Step 2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BASE_URL.'district/add_submitted_template_step3/'.$template_id; ?>">Step 3</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">
                                    <div class="tab-pane active" id="home1" role="tabpanel" aria-expanded="false">
                                        <div class="col-md-12" style="overflow-x:scroll;">
                                            <table class="table" style="width:1500px;max-width:1500px;border-collapse: collapse;border:1px solid #dfdfdf">
                                                <thead>
                                                    <th colspan="4" style="text-align: center;font-weight:600;font-size:20px">Addendum</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $selectval = unserialize($addendum['addendum']);
                                                    $answers = unserialize($addendum['answers']);
                                                    ?>
                                                    <tr>
                                                        <td colspan="4">
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['addendum_title']; } else{ echo 'In compliance with the annual oversight process please provide the following information, complete the subsequent self-study survey and return to the district not later than May 1.'; } ?></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['school_information']; } else{ echo 'Charter School Information'; } ?></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['school_name_title']; } else{ echo 'Charter School:'; } ?></h5>
                                                        </td>
                                                        <td colspan="3">
                                                            <input type="text" name="school_name" class="form-control school_name" id="school_name" placeholder="<?php if(!empty($selectval)) { echo $selectval['school_name']; } else{ echo 'Name'; } ?>" value="<?php if(!empty($answers)) { echo $answers['school_name']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['location_title']; } else{ echo 'Charter School: Location- School Address:'; } ?></h5>
                                                        </td>
                                                        <td colspan="3">
                                                            <input type="text" name="location" class="form-control location" id="location" placeholder="<?php if(!empty($selectval)) { echo $selectval['location']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['location']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['contact_title']; } else{ echo 'Charter School Contact: Name'; } ?></h5>
                                                        </td>
                                                        <td colspan="3">
                                                            <input type="text" name="contact_name" class="form-control contact_name" id="contact_name" placeholder="<?php if(!empty($selectval)) { echo $selectval['contact_name']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['contact_name']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['home_address_title']; } else{ echo 'Home Address'; } ?></h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="home_address" class="form-control home_address" id="home_address" placeholder="<?php if(!empty($selectval)) { echo $selectval['home_address']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['home_address']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['email_title']; } else{ echo 'Email Address:'; } ?></h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="email_address" class="form-control email_address" id="email_address" placeholder="<?php if(!empty($selectval)) { echo $selectval['email_address']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['email_address']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['phone_title']; } else{ echo 'Phone Number:'; } ?></h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="phone" class="form-control phone" id="phone" placeholder="<?php if(!empty($selectval)) { echo $selectval['phone']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['phone']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['school_phone_title']; } else{ echo 'School Phone Number:'; } ?></h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="school_phone" class="form-control school_phone" id="school_phone" placeholder="<?php if(!empty($selectval)) { echo $selectval['school_phone']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['school_phone']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                        <td>
                                                            <h5><?php if(!empty($selectval)) { echo $selectval['fax_title']; } else{ echo 'Fax Number:'; } ?></h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="fax" class="form-control fax" id="fax" placeholder="<?php if(!empty($selectval)) { echo $selectval['fax']; } else{ echo ''; } ?>" value="<?php if(!empty($answers)) { echo $answers['fax']; } else{ echo ''; } ?>" <?php if($addendum['status'] == 3) { echo 'disabled'; } else { echo ''; } ?>>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $template_id; ?>">

                        <input type="submit" class="btn btn-primary submit_step_2" name="submit_step2" value="Proceed to Step 3">
                    </form>

                    <!--END FORM-->

            </section>
        </div>
    </div>
    </section>
    </div>
</section>

<script>


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
//                     url:"<?php echo BASE_URL.'district/ajax_create_master_template'; ?>",
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
//                         var url = 'district/addtemplate/'+result;
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
        var htmlcontent = '<div class="form-group take_copy_div row"><div class="col-md-2"><label class="form-control-label" for="l0"><b>Title: </b></label></div><div class="col-md-6"><input type="text" class="form-control content_title content_title_'+nextval+'" name="content_title[]" placeholder="Enter Title" required></div><div class="col-md-4 action_div"><a href="javascript:" class="fa fa-trash remove_content" style="font-size:20px;color:#f00;padding: 8px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-right:3px" title="Remove this Content"></a><a href="javascript:" class="fa fa-plus add_content" style="font-size:20px;color:green;padding: 8px;border: 1px solid #dfdfdf;background: #dfdfdf;" title="Add New Content"></a></div><div class="col-md-8" style="margin-top:20px"><textarea class="form-control editor" name="editor_'+nextval+'" id="editor_'+nextval+'"></textarea></div><div class="col-md-4">&nbsp;</div></div>';
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
        $("#append_div_body").find(".take_copy_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_content" style="font-size:20px;color:#f00;padding: 8px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-right:3px" title="Remove this Content"></a><a href="javascript:" class="fa fa-plus add_content" style="font-size:20px;color:green;padding: 8px;border: 1px solid #dfdfdf;background: #dfdfdf;" title="Add New Content"></a>');

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
        $("#append_div_body").find(".take_copy_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_content" style="font-size:20px;color:#f00;padding: 8px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-right:3px" title="Remove this Content"></a><a href="javascript:" class="fa fa-plus add_content" style="font-size:20px;color:green;padding: 8px;border: 1px solid #dfdfdf;background: #dfdfdf;" title="Add New Content"></a>');
    }
});
</script>