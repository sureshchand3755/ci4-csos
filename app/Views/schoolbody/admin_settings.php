<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        <h3>School Admin Settings</h3>
    </div>
    <hr>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">

                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title">Admin Settings</h3>

                    </div>

                    <form role="form" id="nameform" action="" method="post" enctype="multipart/form-data" autocomplete="off">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="principal_name">Executive Director/Principal</label>
                                <input type="text" name="principal_name" id="principal_name" class="form-control" placeholder="Principal Name" value="<?php echo $selectval['principal_name']; ?>"  required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo $selectval['phone']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="username">User Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $selectval['username']; ?>" required>
                                </div>
                                <label id="username-error" class="error" for="username"></label>
                            </div>
                            <div class="form-group">
                                <label for="adminemail">Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="text" name="adminemail" id="adminemail" class="form-control" placeholder="Email" value="<?php echo $selectval['email']; ?>" required>
                                </div>
                                <label id="adminemail-error" class="error" for="adminemail"></label>
                            </div>

                            <div class="form-group">
                                <label for="contact_name">Contact Name(If different from above)</label>
                                <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Principal Name" value="<?php echo $selectval['contact_name']; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="phone_1">Phone</label>
                                <input type="text" name="phone_1" id="phone_1" class="form-control" placeholder="Phone_1" value="<?php echo $selectval['phone_1']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="contactemail">Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="text" name="contactemail" id="contactemail" class="form-control" placeholder="Contact Email" value="<?php echo $selectval['contactemail']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="oldpassword">Admin Current Password</label>
                                <input type="text" class="form-control" id="viewpassword" name="viewpassword" placeholder="View Password" value="<?php echo $this->encrypt->decode($selectval['password']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="newpassword">Enter New Password</label>
                                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" autocomplete="off" value="">
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" autocomplete="off" value="">
                            </div>
                            <div class="form-group">
                                <label for="adminemail">Upload Photo</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="adminimage" id="adminimage"> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        if($selectval['image']=='') {
                                        ?>
                                            <img src="<?php echo BASE_URL.ADMIN_IMG; ?>avatar5.png" class="thumbnail" id="blah" width="170" height="200">
                                        <?php
                                        }
                                        else {
                                        ?>
                                            <img src="<?php echo BASE_URL.UPLOAD_PROFILEPICS.'principal/'.$selectval['image']; ?>" class="thumbnail" id="blah"  width="170" height="200">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="school_name">Name of School</label>
                                <input type="text" name="school_name" id="school_name" class="form-control" placeholder="School Name" value="<?php echo $selectval['school_name']; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="address">Admin Office Address</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Address"><?php echo $selectval['address']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="school_email">School Email</label>
                                <input type="text" name="school_email" id="school_email" class="form-control" placeholder="School Email" value="<?php echo $selectval['school_email']; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="school_phone">School Phone</label>
                                <input type="text" name="school_phone" id="school_phone" class="form-control" placeholder="School Phone" value="<?php echo $selectval['school_phone']; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="school_fax">School Fax</label>
                                <input type="text" name="school_fax" id="school_fax" class="form-control" placeholder="School Fax" value="<?php echo $selectval['school_fax']; ?>" >
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="cds_code">CDS Code #</label>
                                        <input type="text" name="cds_code" id="cds_code" class="form-control" placeholder="CDS Code" value="<?php echo $selectval['cds_code']; ?>" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="charter">Charter #</label>
                                        <input type="text" name="charter" id="charter" class="form-control" placeholder="Charter" value="<?php echo $selectval['charter']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="charter_school_petition">Charter School Petition</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="charter_school_petition" id="charter_school_petition"> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        if($selectval['charter_school_petition']=='') {
                                            echo '';
                                        }
                                        else {
                                        ?>
                                            <a href="<?php echo BASE_URL.'uploads/school_notes/'.$selectval['charter_school_petition']; ?>" download><?php echo $selectval['charter_school_petition']; ?></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="from_school">Term</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="from_school" id="from_school" class="form-control" placeholder="From" value="<?php echo $selectval['from_school']; ?>">
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                    <div class="col-md-5">
                                        <input type="text" name="to_school" id="to_school" class="form-control" placeholder="to" value="<?php echo $selectval['to_school']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="material_revision">Material Revision</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="material_revision" id="material_revision"> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        if($selectval['material_revision']=='') {
                                            echo '';
                                        }
                                        else {
                                        ?>
                                            <a href="<?php echo BASE_URL.'uploads/school_notes/'.$selectval['material_revision']; ?>" download><?php echo $selectval['material_revision']; ?></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="from_one_school">Term</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="from_one_school" id="from_one_school" class="form-control" placeholder="From" value="<?php echo $selectval['from_one_school']; ?>">
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                    <div class="col-md-5">
                                        <input type="text" name="to_one_school" id="to_one_school" class="form-control" placeholder="to" value="<?php echo $selectval['to_one_school']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="charter_school_mou">Charter School MOU</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="charter_school_mou" id="charter_school_mou"> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        if($selectval['charter_school_mou']=='') {
                                            echo '';
                                        }
                                        else {
                                        ?>
                                            <a href="<?php echo BASE_URL.'uploads/school_notes/'.$selectval['charter_school_mou']; ?>" download><?php echo $selectval['charter_school_mou']; ?></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="from_two_school">Term</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="from_two_school" id="from_two_school" class="form-control" placeholder="From" value="<?php echo $selectval['from_two_school']; ?>">
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                    <div class="col-md-5">
                                        <input type="text" name="to_two_school" id="to_two_school" class="form-control" placeholder="to" value="<?php echo $selectval['to_two_school']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mou_material_revision">MOU Meterial Revision</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="mou_material_revision" id="mou_material_revision"> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        if($selectval['mou_material_revision']=='') {
                                            echo '';
                                        }
                                        else {
                                        ?>
                                            <a href="<?php echo BASE_URL.'uploads/school_notes/'.$selectval['mou_material_revision']; ?>" download><?php echo $selectval['mou_material_revision']; ?></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="from_three_school">Term</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="from_three_school" id="from_three_school" class="form-control" placeholder="From" value="<?php echo $selectval['from_three_school']; ?>">
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                    <div class="col-md-5">
                                        <input type="text" name="to_three_school" id="to_three_school" class="form-control" placeholder="to" value="<?php echo $selectval['to_three_school']; ?>" >
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
            </div>
           <!--  <div class="col-md-6">
                <div class="box box-primary" style="margin-top:20px">
                    <div class="box-header">
                        <h3 class="box-title">Password Settings</h3>
                    </div>
                    <form role="form" id="passwordform" action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="oldpassword">Admin Current Password</label>
                                <input type="text" class="form-control" id="viewpassword" name="viewpassword" placeholder="View Password" value="<?php echo $this->encrypt->decode($selectval['password']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="oldpassword">Enter Current Password</label>
                                <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" value="">
                            </div>
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
            </div> -->
        </div>
    </div>
</section>
<script>
  $( function() {
    $( "#from_school" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#to_school" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $( "#from_one_school" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#to_one_school" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $( "#from_two_school" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#to_two_school" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $( "#from_three_school" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#to_three_school" ).datepicker({ dateFormat: 'yy-mm-dd' });

      //$( "#from_school" ).datepicker("option","dateFormat",'yy-mm-dd');
      //$( "#to_school" ).datepicker("option","dateFormat",'yy-mm-dd');
    setTimeout( function() { $("#newpassword").val(""); },500);
    $("#confirmpassword").val("");
  } );
   var base_url = $('#base_url').val();

     $.ajaxSetup({async:false});

    $( "#nameform" ).validate({
        rules: {
            username : {required: true},
            adminemail : { required: true,email:true},   
            confirmpassword: { equalTo: "#newpassword" }
        },
        messages: {
            username : {
              required : "Username is required",
            },
            adminemail : {
                required : "Email is required",
            },
            confirmpassword : {
                equalTo : "Should match the New password field",
            },
        },

    });

    // $("#passwordform" ).validate({

    //     rules: {

    //         oldpassword : {required: true,},

    //         newpassword : {required: true,},

    //         confirmpassword : {required: true, equalTo: newpassword},    

    //     },

    //     messages: {

    //         oldpassword : "Old Password is required",

    //         newpassword : "New Password is required",

    //         confirmpassword : {

    //             required: "Confirm Password Field is required",

    //             equalTo : "Should match to above field",

    //         },

    //     },

    // });

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