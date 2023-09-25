<section class="page-content">
    <div class="page-content-inner">
        <style>
.success{
    padding: 10px;
    border: 1px solid #4CAF50;
    width: 100%;
    background: #4CAF50;
    color: #fff;
}
</style>
<section class="panel">
    <div class="panel-heading">
        <h3>Admin Settings</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">

                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title">Name Settings</h3>

                    </div>

                    <form role="form" id="nameform" action="" method="post" enctype="multipart/form-data">

                        <div class="box-body">

                            <div class="form-group">

                                <label for="username">User Name</label>

                                <div class="input-group">

                                    <span class="input-group-addon">@</span>

                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo isset($selectval['username'])?$selectval['username']:''; ?>">

                                </div>

                                <label id="username-error" class="error" for="username"><?= $validation->getError('username')?></label>

                            </div>

                            <div class="form-group">

                                <label for="adminemail">Email</label>

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                    <input type="text" name="adminemail" id="adminemail" class="form-control" placeholder="Email" value="<?php echo isset($selectval['email'])?$selectval['email']:''; ?>">

                                </div>

                                <label id="adminemail-error" class="error" for="adminemail"><?= $validation->getError('adminemail')?></label>

                            </div>

                            <div class="form-group">

                                <label for="adminemail">Upload Photo</label>

                                <div class="input-group">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <input type="file" class="form-control" name="adminimage" id="adminimage"> 

                                        </div>

                                        <div class="col-md-2">
                                            <?php
                                            if($selectval['image']=='') {
                                            ?>
                                                <img src="<?php echo BASE_URL; ?>assets/images/avatar5.png" class="thumbnail" id="blah" width="170" height="200">
                                            <?php
                                            }
                                            else {
                                            ?>
                                                <img src="<?php echo BASE_URL.UPLOAD_PROFILEPICS.'admin/'.$selectval['image']; ?>" class="thumbnail" id="blah"  width="170" height="200">
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <input type="hidden" id="adminid" name="adminid" value="<?php if(!empty($admin_id)) { echo $admin_id; } ?>">

                        <div class="box-footer">

                            <input type="submit" class="btn btn-primary" name="namesetting" value="Update">

                        </div>

                    </form>

                </div>

                

                <div class="box box-primary" style="margin-top:20px">

                    <div class="box-header">

                        <h3 class="box-title">Password Settings</h3>

                    </div>

                    <form role="form" id="passwordform" action="" method="post">

                        <div class="box-body">

                            <!-- <div class="form-group">

                                <label for="oldpassword">Admin Current Password</label>

                                <input type="text" class="form-control" id="viewpassword" name="viewpassword" placeholder="View Password" value="<?php //echo $this->encrypt->decode($selectval['password']); ?>" disabled>

                            </div> -->

                            <!-- <div class="form-group">

                                <label for="oldpassword">Enter Current Password</label>

                                <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" value="">

                            </div> -->

                            <div class="form-group">

                                <label for="newpassword">Enter New Password</label>

                                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">

                            </div>

                            <div class="form-group">

                                <label for="confirmpassword">Confirm New Password</label>

                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">

                            </div>

                        </div>

                        <div class="box-footer">

                            <input type="submit" class="btn btn-primary" name="passwordsetting" value="Update">

                        </div>

                    </form>

                </div>

            </div>
            
            <div class="col-md-6">

                <div class="box box-warning">

                    <div class="box-header">

                        <h3 class="box-title">Site Settings</h3>

                    </div>

                    <div class="box-body">

                        <form role="form" id="siteform" action="" method="post">
                            <div class="form-group">

                                <label for="sitetitle">Site Title :</label>

                                <div class="input-group">

                                    <input type="text" name="sitetitle" id="sitetitle" class="form-control" value="<?php echo isset($selectval['sitetitle'])?$selectval['sitetitle']:''; ?>">

                                    <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                </div>

                                <label id="sitetitle-error" class="error" for="sitetitle"><?= $validation->getError('sitetitle')?></label>

                            </div>

                            <!--<div class="form-group">

                                <label for="metawords">Home Meta Words :</label>

                                <textarea name="metawords" id="metawords" class="form-control" rows="3" placeholder="Enter ..."><?php //echo $selectval['metawords']; ?></textarea>

                            </div>

                            <div class="form-group">

                                <label for="metadescription">Home Meta Description :</label>

                                <textarea name="metadescription" id="metadescription" class="form-control" rows="3" placeholder="Enter ..."><?php //echo $selectval['metadescription']; ?></textarea>

                            </div>

                            <div class="form-group">

                                <label for="terms">Terms and Conditions :</label>

                                <textarea name="terms" id="terms" class="form-control" rows="4" placeholder="Enter ..."><?php //echo $selectval['terms']; ?></textarea>

                            </div>-->

                            <div class="form-group">

                                <label for="youtube">Youtube</label>

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-youtube"></i></span>

                                    <input type="text" name="youtube" id="youtube" class="form-control" placeholder="Youtube" value="<?php echo isset($selectval['youtube'])?$selectval['youtube']:''; ?>">

                                </div>

                                <label id="youtube-error" class="error" for="youtube"><?= $validation->getError('youtube')?></label>

                            </div>

                            <div class="form-group">

                                <label for="facebook">Facebook</label>

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>

                                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Facebook" value="<?php echo isset($selectval['facebook'])?$selectval['facebook']:''; ?>">

                                </div>

                                <label id="facebook-error" class="error" for="facebook"><?= $validation->getError('facebook')?></label>

                            </div>

                            <div class="form-group">

                                <label for="twitter">Twitter</label>

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-twitter"></i></span>

                                    <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Twitter" value="<?php echo isset($selectval['twitter'])?$selectval['twitter']:''; ?>">

                                </div>

                                <label id="twitter-error" class="error" for="twitter"><?= $validation->getError('twitter')?></label>

                            </div>

                            <div class="form-group">

                                <label for="linkedin">LinkedIn</label>

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>

                                    <input type="text" name="linkedin" id="linkedin" class="form-control" placeholder="LinkedIn" value="<?php echo isset($selectval['linkedin'])? $selectval['linkedin']:''; ?>">

                                </div>

                                <label id="linkedin-error" class="error" for="linkedin"><?= $validation->getError('linkedin')?></label>

                            </div>

                            <div class="form-group">

                                <label for="googleplus">Google Plus</label>

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>

                                    <input type="text" name="googleplus" id="googleplus" class="form-control" placeholder="Google Plus" value="<?php echo isset($selectval['googleplus'])?$selectval['googleplus']:''; ?>">

                                </div>

                                <label id="googleplus-error" class="error" for="googleplus"><?= $validation->getError('googleplus')?></label>

                            </div>

                            <div class="box-footer">

                                <input type="submit" class="btn btn-primary" name="sitesetting" value="Update">

                            </div>

                        </form>

                         <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<script>

   var base_url = $('#base_url').val();

     $.ajaxSetup({async:false});

    $( "#nameform" ).validate({

        rules: {

            username : {required: true},

            adminemail : { required: true,email:true},   

        },

        messages: {

            username : {

              required : "Username is required",

            },

            adminemail : {

                required : "Email is required",

            },

        },

    });

    $("#passwordform" ).validate({

        rules: {

            newpassword : {required: true,},

            confirmpassword : {required: true, equalTo: newpassword},    

        },

        messages: {

            
            newpassword : "New Password is required",

            confirmpassword : {

                required: "Confirm Password Field is required",

                equalTo : "Should match to above field",

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

    

    $("#adminimage").change(function(){

        readURL(this);

    });

</script>