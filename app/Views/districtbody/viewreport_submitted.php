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
                                        <a class="nav-link active" href="javascript:">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <?php
                                        if(!empty($selectval)) { ?>
                                            <a class="nav-link" href="<?php echo BASE_URL.'admin/view_report_template_step2_submitted/'.$template_id; ?>">Step 2</a>
                                        <?php } else { ?>
                                            <a class="nav-link" href="javascript:">Step 2</a>
                                        <?php } ?>
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
                                                <label class="form-control-label" for="l0"><b>Template Name: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <h5><?php echo $selectval['template_name']; ?></h5>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-control-label" for="l0"><b>Title: </b></label>
                                            </div>
                                            <div class="col-md-4">
                                                <h5><?php echo $selectval['title']; ?></h5>
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
                                        <table class="table" style="width:70%">
                                            <thead>
                                                <th style="border:1px solid #dfdfdf;width:40%"><?php echo $selectval['step1_table_title_1']; ?>"></th>
                                                <th style="border:1px solid #dfdfdf"><?php echo $selectval['step1_table_title_2']; ?></th>
                                            </thead>
                                            <tbody id="report_tbody">
                                                <?php
                                                $report_forms = $this->db->select('*')->from('report_forms')->where('template_id',$selectval['id'])->where('type',0)->get()->result_array();
                                                if(!empty($report_forms))
                                                {
                                                    foreach($report_forms as $report)
                                                    {
                                                        ?>
                                                        <tr class="content_tr" data-element="<?php echo $report['id']; ?>">
                                                            <td style="border:1px solid #dfdfdf">
                                                                <?php echo $report['content1']; ?>
                                                                <p style="text-align: center;margin-top:10px;font-size:18px">Comply</p>
                                                                <div class="col-md-6" style="text-align: center">
                                                                    <h4><?php echo $report['yes_content']; ?></h4>
                                                                    <input type="radio" name="comply_<?php echo $report['id']; ?>" class="comply_option" value="1" data-element="<?php echo $report['id']; ?>" <?php if($report['comply_option'] == "1") { echo 'checked '; } else { echo ''; } echo 'disabled'; ?> >
                                                                </div>
                                                                <div class="col-md-6" style="text-align: center">
                                                                    <h4><?php echo $report['no_content']; ?></h4>
                                                                    <input type="radio" name="comply_<?php echo $report['id']; ?>" class="comply_option" value="0" data-element="<?php echo $report['id']; ?>" <?php if($report['comply_option'] == "0") { echo 'checked '; } else { echo ''; } echo 'disabled'; ?>>
                                                                </div>
                                                            </td>
                                                            <td style="border:1px solid #dfdfdf"><?php echo $report['content2']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                else{
                                                    ?>
                                                    <tr class="content_tr">
                                                        <td style="border:1px solid #dfdfdf">
                                                            <input type="text" name="content1[]" class="form-control content1" value="">
                                                            <p style="text-align: center;margin-top:10px;font-size:18px">Comply</p>
                                                            <input type="text" name="yes_content[]" class="form-control yes_content" value="YES" style="width:45%;float:left">
                                                            <input type="text" name="no_content[]" class="form-control no_content" value="NO" style="width:45%;margin-left:10px;float:left">
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
                                                <?php echo $selectval['step1_table_down_content']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $template_id; ?>">
                        <input type="hidden" name="hidden_school_id" id="hidden_school_id" value="<?php echo $_GET['school_id']; ?>">
                        <input type="hidden" name="hidden_district_id" id="hidden_district_id" value="<?php echo $_GET['district_id']; ?>">
                        <a href="<?php echo BASE_URL.'admin/view_report_template_step2_submitted/'.$template_id; ?>" class="btn btn-primary submit_step_1">Proceed to Step 2</a>
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

$(window).click(function(e) {
    if($(e.target).hasClass('add_content'))
    {
        var template_id = $("#hidden_template_id").val();
        $.ajax({
            url:"<?php echo BASE_URL.'admin/get_report_table_tr'; ?>",
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
                step1_content();
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