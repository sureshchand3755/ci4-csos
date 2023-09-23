<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	    <h1>
		ADD STATES
		<small>Control panel</small>
	    </h1>
	</section>
    <!-- Main content -->
	<section class="content">
	    <!-- Small boxes (Stat box) -->
             <!-- BEGIN FORM-->
            <form action="" id="form_sample_2" method="post" enctype="multipart/form-data">
                <div class="row" id="content">
                <div class="col-md-4 col-md-offset-1">
                    <div class="row-fluid">
                        <div class="block">
                            <div class="block-content collapse in">
                                <div class="row">
                                    <fieldset>
                                            <div class="alert alert-error hide">
                                                <button class="close" data-dismiss="alert"></button>
                                            </div>
                                            <div class="alert alert-success hide">
                                                <button class="close" data-dismiss="alert"></button>
                                            </div>
											<div class="control-group">
                                                <label class="control-label">State Name <span class="required">*</span></label>
                                                <div class="controls">
                                                    <input type="text" name="state_name" data-required="1" class="form-control input-sm" value="<?php echo ($selectval['state_name'])?$selectval['state_name']:$selectval['state_name']; ?>"/>
                                                    <?php echo form_error('state_name');?>
                                                </div>
                                            </div>
									</fieldset>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1">
					<br/>
				</div>
				<div class="col-md-4 col-md-offset-1">
					<div class="row-fluid">
                        <div class="block">
                            <div class="block-content collapse in">
                                <div class="row">
                                    <fieldset>
                                            <div class="control-group" style="margin-top:2%">
                                                <label class="control-label">Flag Image <span class="required">*</span></label>
                                                <div class="controls">
													<div class="row">
														<div class="col-md-9">
															<br/>
															<input type="file" name="flag_image" id="imgInp" class="form-control input-sm" value="<?php echo ($selectval['flag_image'])?$selectval['flag_image']:$selectval['flag_image']; ?>"/>
														</div>
														<div class="col-md-3">
															<img id="blah" src="<?php echo ($selectval['flag_image'])?BASE_URL.'uploads/flags/'.$selectval['flag_image']:BASE_URL.'uploads/no-image.jpg';  ?>" class="img-responsive thumbnail"> 
														</div>
													</div>
                                                    <?php echo form_error('flag_image');?>
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
								<input type="hidden" id="stateid" name="stateid" value="<?php if(!empty($selectval['id'])) { echo $selectval['id']; } ?>">

                            <input type="submit" class="btn btn-primary" name="register_state" value="<?php if(!empty($selectval)) { echo "UPDATE STATE"; }  else { echo "ADD STATE"; }?>">
                            <a href="<?php echo BASE_URL.ADMIN_MANAGESTATES?>" class="btn btn-primary">BACK</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--END FORM-->
        </div>
    </section>
</aside>

<div class="span9" id="content">
    <!-- morris stacked chart -->

    <div class="row-fluid">
         <!-- block -->
        
        <!-- /block -->
    </div>
</div>

<script>
   var base_url = $('#base_url').val();
    $.ajaxSetup({async:false});
    $( "#form_sample_2" ).validate({
      rules: {
        state_name : {required: true,remote: base_url+"admin/check_statename/"+"<?php echo $state_id; ?>"},
    },
    messages: {
        state_name : {
          required : "State Name is required",
          remote : "State Name is already Used",
        },
    },
    });
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
				var image = new Image();
				image.src = e.target.result;
				
				image.onload = function() {
					console.log(this.height);
				}
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
	
</script>