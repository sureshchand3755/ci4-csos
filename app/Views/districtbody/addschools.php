<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <div class="panel-heading">
        <h3>ADD SCHOOL</h3>
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

                                                        <b class="control-label">School Name<span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="text" name="school_name" data-required="1" class="form-control" value="<?php echo isset($selectval['school_name'])?$selectval['school_name']:''; ?>"/>

                                                            <?php echo $validation->getError('school_name');?>

                                                        </div>

                                                    </div>

        											<div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">School Admin Full Name <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="text" name="principal_name" data-required="1" class="form-control" value="<?php echo isset($selectval['principal_name'])?$selectval['principal_name']:''; ?>"/>

                                                            <?php echo $validation->getError('principal_name');?>

                                                        </div>

                                                    </div>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Email <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="email" type="text" class="form-control" value="<?php echo isset($selectval['email'])?$selectval['email']:''; ?>"/>

                                                            <?php echo $validation->getError('email');?>

                                                        </div>

                                                    </div>

        											<div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">School Admin UserName <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="text" name="username" id="username" data-required="1" <?php if(!empty($selectval['username'])) { echo "readonly='readonly'"; } ?> class="form-control" value="<?php echo isset($selectval['username'])?$selectval['username']:''; ?>"/>

                                                            <?php echo $validation->getError('username');?>

                                                        </div>

                                                    </div>

        											<?php if(!empty($selectval['password'])) { ?>

        											<!-- <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">View Password <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="text" type="viewpassword" id="viewpassword" class="form-control" readonly="readonly" value="<?php //echo ($selectval['password'])?$this->encrypt->decode($selectval['password']):$selectval['password']; ?>"/>

                                                            <?php //echo $validation->getError('password');?>

                                                        </div>

                                                    </div> -->

        											<?php } ?>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Password <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="password" type="password" id="password" class="form-control" value="<?php echo isset($selectval['password'])?$selectval['password']:''; ?>"/>

                                                            <?php echo $validation->getError('password');?>

                                                        </div>

                                                    </div>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Confirm Password <span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input name="c_password" id="c_password" type="password" class="form-control" value="<?php echo isset($selectval['password'])?$selectval['password']:''; ?>"/>

                                                            <?php echo $validation->getError('c_password');?>

                                                        </div>

                                                    </div>

                                            </fieldset>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-4 col-md-offset-1">
                            <div class="row-fluid">
                                <div class="block">
                                    <div class="block-content collapse in">
                                        <div class="row">
                                            <fieldset>
                                                <div class="control-group" style="margin-top:30px">
                                                    <b class="control-label">Handbook Name</b>
                                                    <div class="controls">
                                                        <input type="text" name="handbook_name" data-required="1" class="form-control handbook_name" value="<?php echo isset($selectval['handbook_name'])?$selectval['handbook_name']:''; ?>"/>
                                                        <?php echo $validation->getError('handbook_name');?>
                                                    </div>
                                                </div>
                                                <div class="control-group" style="margin-top:30px">
                                                    <b class="control-label">Attach Handbook File</b>
                                                    <div class="controls">
                                                        <input type="file" name="filename" data-required="1" class="form-control filename" value="<?php echo isset($selectval['filename'])?$selectval['filename']:''; ?>"/>
                                                        <?php echo $validation->getError('filename');?>
                                                        <?php
                                                            if(isset($selectval['filename']) != "")
                                                            {
                                                                echo 'Attachment : <p>'.$selectval['filename'].'</p>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="control-group" style="margin-top:30px">
                                                    <b class="control-label">Attach Fiscal Calender</b>
                                                    <div class="controls">
                                                        <input type="file" name="fiscal_filename" data-required="1" class="form-control fiscal_filename" value="<?php echo isset($selectval['fiscal_filename'])?$selectval['fiscal_filename']:''; ?>"/>
                                                        <?php echo $validation->getError('fiscal_filename');?>
                                                        <?php
                                                            if(isset($selectval['fiscal_filename']) != "")
                                                            {
                                                                echo 'Attachment : <p>'.$selectval['fiscal_filename'].'</p>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="control-group" style="margin-top:30px">
                                                    <b class="control-label">Add Message to School Landing Page</b>
                                                    <div class="controls">
                                                        <textarea name="landing_message" class="form-control landing_message editor" id="editor_1"><?php echo isset($selectval['landing_message'])?$selectval['landing_message']:''; ?></textarea>
                                                        <?php echo $validation->getError('landing_message');?>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
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

        								<input type="hidden" id="schoolid" name="schoolid" value="<?php if(!empty($selectval['id'])) { echo $selectval['id']; } ?>">



                                    <input type="submit" class="btn btn-primary register_school" name="register_school" value="<?php if(!empty($selectval)) { echo "UPDATE SCHOOL"; }  else { echo "ADD SCHOOL"; }?>">
                                    <?php
                                    if(isset($_GET['district_id']))
                                    {
                                        ?>
                                        <a href="<?php echo BASE_URL.'district/manage_schools?district_id='.$_GET['district_id']; ?>" class="btn btn-primary">BACK</a>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <a href="<?php echo BASE_URL.'district/manage_schools'; ?>" class="btn btn-primary">BACK</a>
                                        <?php
                                    }
                                    ?>
                                    

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
            height: '150px',
         });
    });
});
   var base_url = $('#base_url').val();
   var ids = "<?php echo isset($selectval['id'])?$selectval['id']:''; ?>";

    $.ajaxSetup({async:false});

    $( "#form_sample_3" ).validate({

    rules: {

		statetext: {required: true,},

		school_name: {required: true,remote: base_url+"admin/check_schoolname/"+ids,},

		principal_name: {required: true,},

        username : {required: true,remote: base_url+"admin/check_schooladmin/"+ids},

        email : { required: true,email:true,},

        password : {required: true,},

        c_password : {required: true, equalTo: password},

	},

    messages: {

        statetext : "State is required",

        school_name : {

          required : "School Name is required",

          remote : "School Name is already Used",

        },

		principal_name: "First Name is required",

        username : {

          required : "Username is required",

          remote : "Username is already Used",

        },

        email : {

            required : "Email is required",

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

</script>