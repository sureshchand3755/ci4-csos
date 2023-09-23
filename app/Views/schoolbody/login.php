<style>
    .single-page-block { padding : 250px 20px 80px 20px;position: absolute}
    .login_btn:focus { background: #01a8fe73 !important; border-radius: 27px; }
</style>
<div id="login_modal" class="modal login_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Login</h5>
      </div>
      <div class="modal-body">
            <form action="<?php echo base_url('school/login'); ?>" method="post" id="form-validation">  
                <div class="form-group">
                    <input id="validation-email"
                           class="form-control"
                           placeholder="Email or Username"
                           name="email"
                           type="text" required>
                </div>
                <div class="form-group">
                    <input id="validation-password"
                           class="form-control password"
                           name="password"
                           type="password"
                           placeholder="Password" required>
                </div>
                <div class="form-group">
                   <label>Select Login User Type</label>
                    <select name="usertype" class="form-control" id="validation-usertype">
                        <option value="1">School Admin</option>
                        <option value="2">District Admin</option>
                    </select>
                </div>
                <!-- <div class="form-group">
                    <a href="javascript: void(0);" class="pull-right">Forgot Password?</a>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="example6" checked>
                            Remember me
                        </label>
                    </div>
                </div> -->
                <div class="form-actions">
                    <input type="submit" class="btn btn-primary width-150" name="login" value="Sign In">
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<div class="modal aboutus_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">About US</h5>
      </div>
      <div class="modal-body">
        <p>Academy & School Resources. LLC is a California based company providing
charter school oversight services as well as software design and consulting services.
Our team includes educational professionals with over 100 years of cumulative experience at the pre-K-12 and college level.</p>
      </div>
    </div>
  </div>
</div>
<section class="page-content">
<div class="page-content-inner" style="background-image: url(<?php echo BASE_URL; ?>/assets/images/csos_bg.jpg)">
    <ul style="list-style: none;width:100%;margin-top:30px">
        <li style="float:right;margin-left: 12px;"><a href="<?php echo BASE_URL.'school/user_documents_timeline'; ?>" class="btn btn-primary" target="_blank" style="text-align: center">Lucern Valley Unified School District <br/>Charter School Information</a></li>
        <li style="float:right"><a href="javascript:" class="btn btn-primary" data-toggle="modal" data-target=".aboutus_modal">About US</a></li>
    </ul>
    <img src="<?php echo BASE_URL; ?>/assets/images/csoc_logo.png" style="width:300px;filter: brightness(11.5);position: absolute;top:-25px;left:0px">
    <div class="single-page-block-header">
        <div class="row"><!-- 
            <div class="col-lg-4">
                <div class="logo">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="single-page-block-header-menu">
                    <ul class="list-unstyled list-inline">
                        <li><a href="javascript: history.back();">&larr; Back</a></li>
                        <li class="active"><a href="javascript: void(0);">Login</a></li>
                        <li><a href="javascript: void(0);">About</a></li>
                        <li><a href="javascript: void(0);">Support</a></li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
    <div class="single-page-block" style="text-align:center;margin-top:100px">
        <input type="button" class="login_btn btn btn-primary" value="LOGIN" data-toggle="modal" data-target="#login_modal" data-backdrop="static" data-keyboard="false" style="font-size: 30px;width: 10%;height: 100px;background: #01a8fe73 !important;border-radius: 27px;margin-top: -50px;">
    </div>
    <p style="color:#fff;text-align:center;font-weight:600">Academy & School Services LLC<br/>
        1460 E. Holt Ave<br/>
        Pomona, CA 91767<br/>
        Copyright 2021 Academy & School Services.
    </p>
</div>

<!-- Page Scripts -->
<script>
    $(function() {
        // $('#login_modal').modal({backdrop: 'static', keyboard: false});

        // Form Validation
        $( "#form-validation" ).validate({
            rules: {
                email : {required: true},
                password : { required: true},   

            },
            messages: {
                email : {
                required : "Username is required",
                },
                password : {
                    required : "Password is required",
                },

            },

        });

        // Show/Hide Password
        $('.password').password({
            eyeClass: '',
            eyeOpenClass: 'icmn-eye',
            eyeCloseClass: 'icmn-eye-blocked'
        });

        // Add class to body for change layout settings
        $('body').addClass('single-page single-page-inverse');

        // Set Background Image for Form Block
        function setImage() {
            var imgUrl = $('.page-content-inner').css('background-image');

            $('.blur-placeholder').css('background-image', imgUrl);
        };

        function changeImgPositon() {
            var width = $(window).width(),
                    height = $(window).height(),
                    left = - (width - $('.single-page-block-inner').outerWidth()) / 2,
                    top = - (height - $('.single-page-block-inner').outerHeight()) / 2;


            $('.blur-placeholder').css({
                width: width,
                height: height,
                left: left,
                top: top
            });
        };

        setImage();
        changeImgPositon();

        $(window).on('resize', function(){
            changeImgPositon();
        });

        // Mouse Move 3d Effect
        var rotation = function(e){
            var perX = (e.clientX/$(window).width())-0.5;
            var perY = (e.clientY/$(window).height())-0.5;
            TweenMax.to(".effect-3d-element", 0.4, { rotationY:15*perX, rotationX:15*perY,  ease:Linear.easeNone, transformPerspective:1000, transformOrigin:"center" })
        };

        if (!cleanUI.hasTouch) {
            $('body').mousemove(rotation);
        }

    });
</script>
<!-- End Page Scripts -->
</section>

<div class="main-backdrop"><!-- --></div>
