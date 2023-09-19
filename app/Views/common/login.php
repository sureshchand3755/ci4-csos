<style>
	.single-page-block { padding : 250px 20px 80px 20px;position: absolute}
</style>
<section class="page-content">
<div class="page-content-inner" style="background-image: url(<?= base_url('assets/images/csos_bg.jpg') ?>)">
<img src="<?= base_url('assets/images/csoc_logo.png') ?>" style="width:300px;margin-top:50px;filter: brightness(11.5);">
    <!-- Login Page -->
    <div class="single-page-block-header">
        <div class="row">
        </div>
    </div>
    <div class="single-page-block">
        <div class="single-page-block-inner effect-3d-element">
            <div class="blur-placeholder"><!-- --></div>
            <div class="single-page-block-form">
                <h3 class="text-center">
                    <i class="icmn-enter margin-right-10"></i>
                    Super Admin Login
                </h3>
                <br />
                <form action="<?php echo base_url('adminlogin'); ?>" method="post" id="form-validation">  
                	<div class="form-group">
                        <input id="validation-email"
                               class="form-control"
                               placeholder="Email or Username"
                               name="email"
                               type="text"
                               data-validation="[EMAIL]">
                    </div>
                    <div class="form-group">
                        <input id="validation-password"
                               class="form-control password"
                               name="password"
                               type="password" data-validation="[L>=6]"
                               data-validation-message="$ must be at least 6 characters"
                               placeholder="Password">
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

<!-- Page Scripts -->
<script>
    $(function() {

        // Form Validation
        $('#form-validation').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-control-error',
                    errorClass: 'has-danger'
                }
            }
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
