<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading">
        <h3>ADD PAGE</h3>
    </div>
    <hr>
    <div class="panel-body">
        <style>
            .disabled{
                background: #dfdfdf !important;
                pointer-events: none;

            }
        </style>
	<!-- Content Header (Page header) -->
	    <div class="row">
        	<section class="content">

        	    <!-- Small boxes (Stat box) -->

                     <!-- BEGIN FORM-->

                    <form action="" id="form_sample_3" method="post" runat="server" enctype="multipart/form-data">

        				

                        <div class="row" id="content">

                        <div class="col-md-4 col-md-offset-1">

                            <div class="row-fluid">

                                <div class="block">

                                    <div class="block-content collapse in">

                                        <div class="row">

                                            <fieldset>
                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Page Name<span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="text" name="page_name" data-required="1" class="form-control" value="<?php echo ($selectval['page_name'])?$selectval['page_name']:$selectval['page_name']; ?>"/>

                                                            <?php echo form_error('page_name');?>

                                                        </div>

                                                    </div>

                                            </fieldset>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-8 col-md-offset-1">

                            <div class="row-fluid">

                                <div class="block">

                                    <div class="block-content collapse in">

                                        <div class="row">

                                            <fieldset>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Description <span class="required">*</span></b>

                                                        <div class="controls">
                                                            <textarea class="editor" id="editor_1" name="content"><?php echo ($selectval['content'])?$selectval['content']:$selectval['content']; ?></textarea>
                                                            <?php echo form_error('content');?>

                                                        </div>

                                                    </div>

                                            </fieldset>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        </div>

                        <div class="form-actions">

                            <div class="row" style="margin-top:10px">

                                <div class="col-md-4 col-md-offset-1">

        								<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">

        								<input type="hidden" id="pageid" name="pageid" value="<?php if(!empty($selectval['id'])) { echo $selectval['id']; } ?>">



                                    <input type="submit" class="btn btn-primary" name="register_page" value="<?php if(!empty($selectval)) { echo "UPDATE PAGE"; }  else { echo "ADD PAGE"; }?>">
                                    
                                    

                                </div>

                            </div>

                        </div>

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
            height: '300px',
         });
    });
});
</script>