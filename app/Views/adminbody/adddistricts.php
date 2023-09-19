<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading">
        <h3>ADD DISTRICT AND DISTRICT ADMIN</h3>
    </div>
    <hr>
<style>
    .btn.btn-default-outline:hover:active, .btn.btn-default-outline:focus, .btn.btn-default-outline.active, .open > .btn.btn-default-outline:hover:active, .open > .btn.btn-default-outline:focus, .open > .btn.btn-default-outline.active
    {
        background: #4CAF50;
        border-color: #4CAF50;
    }
</style>
    <div class="panel-body">
	<!-- Content Header (Page header) -->
	    <div class="row">
        	<section class="content">

        	    <!-- Small boxes (Stat box) -->
               
                     <!-- BEGIN FORM-->

                    <form action="" id="form_sample_3" method="post" runat="server" enctype="multipart/form-data">

        				<?php

        				if((!empty($_GET['state'])))

        				{

        				$state = base64_decode($_GET['state']);

        					echo "<input type='hidden' name='hiddenstate' value='".$state."'>";

        				}

        				else{

        					echo "<input type='hidden' name='hiddenstate' value=''>";

        				}

        				?>

                        <div class="row" id="content">

                        <div class="col-md-4 col-md-offset-1">

                            <div class="row-fluid">

                                <div class="block">

                                    <div class="block-content collapse in">

                                        <div class="row">

                                            <fieldset>
                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">District Name<span class="required">*</span></b>

                                                        <div class="controls">
                                                            <input type="text" name="district_name" data-required="1" class="form-control" value="<?=isset($selectval['district_name']) ? $selectval['district_name'] : ""?>"/>
                                                            <?php echo $validation->getError('district_name');?>
                                                        </div>

                                                    </div>

        											<div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">District Admin Name <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="text" name="full_name" data-required="1" class="form-control" value="<?=isset($selectval['fullname']) ? $selectval['fullname'] : ""?>"/>
                                                            <?php echo $validation->getError('full_name');?>

                                                        </div>

                                                    </div>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">DistrictAdmin Email <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="email" type="text" class="form-control" value="<?=isset($selectval['email']) ? $selectval['email'] : ""?>"/>
                                                            <?php echo $validation->getError('email');?>

                                                        </div>

                                                    </div>
                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Allow District Admin to Set Discretionary <span class="required">*</span></b>
                                                        
                                                        <div class="controls">
                                                            <div class="btn-group" data-toggle="buttons">
                                                                <label class="btn btn-default-outline allow_discreation_btn <?= (isset($selectval['allow_discreation'])==0)?'active' :''  ?>">
                                                                    <input type="radio" name="example5" class="allow_discreation_radio" value="0">
                                                                    No
                                                                </label>
                                                                <label class="btn btn-default-outline allow_discreation_btn <?= (isset($selectval['allow_discreation'])==1)? 'active':'' ?>">
                                                                    <input type="radio" name="example5" class="allow_discreation_radio" value="1">
                                                                    YES
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="allow_discreation" id="allow_discreation" value="<?php if(!empty($selectval)) { echo $selectval['allow_discreation']; } else { echo '0'; } ?>">
                                                        </div>

                                                    </div>

        											<div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">DistrictAdmin UserName <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="text" name="username" id="username" data-required="1" class="form-control" <?php if(!empty($selectval['username'])) { echo "readonly='readonly'"; } ?> value="<?=isset($selectval['username']) ? $selectval['username'] : ""?>"/>
                                                            <?php echo $validation->getError('username');?>
                                                        </div>

                                                    </div>

        											<?php if(!empty($selectval['password'])) { ?>

        											<!-- <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">View Password <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="text" type="viewpassword" id="viewpassword" class="form-control" readonly="readonly" value="<?php //isset($selectval['password']) ? $selectval['password'] : ""?>"/>
                                                            <?php //echo $validation->getError('password');?>

                                                        </div>

                                                    </div> -->

        											<?php } ?>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Password <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="password" type="password" id="password" class="form-control" value="<?=isset($selectval['password']) ? $selectval['password'] : ""?>"/>

                                                            <?php echo $validation->getError('password');?>
                                                        </div>

                                                    </div>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Confirm Password <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="c_password" id="c_password" type="password" class="form-control" value="<?=isset($selectval['password']) ? $selectval['password'] : ""?>"/>

                                                            <?php echo $validation->getError('c_password');?>
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

        								<input type="hidden" id="districtid" name="districtid" value="<?php if(!empty($selectval['id'])) { echo $selectval['id']; } ?>">



                                    <input type="submit" class="btn btn-primary" name="register_district" value="<?php if(!empty($selectval)) { echo "UPDATE DISTRICT"; }  else { echo "ADD DISTRICT"; }?>">

                                    <a href="<?php echo BASE_URL.ADMIN_MANAGEDISTRICT?>" class="btn btn-primary">BACK</a>

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
    
   var base_url = $('#base_url').val();

    $.ajaxSetup({async:false});

    $( "#form_sample_3" ).validate({

    rules: {

		statetext: {required: true,},

		district_name: {required: true,remote: base_url+"admin/check_districtname/"+"<?php echo $district_id;?>",},

		full_name: {required: true,},

        username : {required: true,remote: base_url+"admin/check_districtadmin/"+"",},

        email : { required: true,email:true,remote: base_url+"admin/check_districtadmin_email/"+"",},

        password : {required: true,},

        c_password : {required: true, equalTo: password},

	},

    messages: {

        statetext : "State is required",

        district_name : {

          required : "District Name is required",

          remote : "District Name is already Used",

        },

		full_name: "First Name is required",

        username : {

          required : "Username is required",

          remote : "Username is already Used",

        },

        email : {

            required : "Email is required",

			remote : "Email is already Used",

        },

        password : "Password is required",

        c_password : {

            required: "Confirm Password Field is required",

            equalTo : "Should match to above field",

        },

    },

    });

	function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $('#imgcourse').attr('src', e.target.result);

            }

            reader.readAsDataURL(input.files[0]);

        }

    }

    $("#course_image").change(function(){

        readURL(this);

    });
$(window).click(function(e) {
    if($(e.target).hasClass('allow_discreation_btn'))
    {
        console.log('sjdhsjd');
        var value = $('.allow_discreation_radio:checked').val();
        $("#allow_discreation").val(value);
    }
});
</script>