<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CSOS</title>

    
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/jscrollpane/style/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/ladda/dist/ladda-themeless.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/cleanhtmlaudioplayer/src/player.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/cleanhtmlvideoplayer/src/player.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/bootstrap-sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/summernote/dist/summernote.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/ionrangeslider/css/ion.rangeSlider.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/datatables/media/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/c3/c3.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/vendors/chartist/dist/chartist.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/admin/common/css/source/main.css">

    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jquery/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jquery/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/js/jquery.backDetect.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/dropzone/dist/dropzone.css" />
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/dropzone/dist/dropzone.js"></script>
    
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jquery-mousewheel/jquery.mousewheel.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jscrollpane/script/jquery.jscrollpane.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/spin.js/spin.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/ladda/dist/ladda.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/select2/dist/js/select2.full.min.js"></script>
    
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jquery-typeahead/dist/jquery.typeahead.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/autosize/dist/autosize.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/bootstrap-show-password/bootstrap-show-password.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/cleanhtmlaudioplayer/src/jquery.cleanaudioplayer.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/cleanhtmlvideoplayer/src/jquery.cleanvideoplayer.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/summernote/dist/summernote.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/ionrangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/nestable/jquery.nestable.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/datatables/media/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/datatables-fixedcolumns/js/dataTables.fixedColumns.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/editable-table/mindmup-editabletable.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/d3/d3.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/c3/c3.min.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>assets/admin/vendors/chartist/dist/chartist.min.js"></script> -->
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/peity/jquery.peity.min.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>assets/admin/vendors/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.min.js"></script> -->
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/gsap/src/minified/TweenMax.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/hackertyper/hackertyper.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/vendors/jquery-countTo/jquery.countTo.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/common/js/common.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/common/js/demo.temp.js"></script>
    <script src="https://cdn.ckeditor.com/4.9.2/standard-all/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/admin/js/ckeditor/src/js/main_1.js"></script>
</head>
<style>
.error{
    color:#f00;
}
</style>
<body class="theme-default">
    <div class="main">
        <main class="content">
            <div class="container-fluid p-0">
                <?= $this->renderSection('content'); ?>
            </div>
        </main>
    </div>
    <div class="modal" id="show_pdf_modal_header" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <iframe src="" style="width:100%;height:800px" class="show_iframe_pdf_header"></iframe>
        </div>
      </div>
    </div>
</body>
<script>
$(window).click(function(e) {
    if($(e.target).hasClass('view_pdf_header'))
    {
        var src = $(e.target).attr("data-src");
        src = src.replace("=","@");
        src = src.replace("=","@");
        src = src.replace("=","@");
        src = src.replace("=","@");
        src = src.replace("=","@");
        
        src = "<?php echo BASE_URL.'uploads/index.html?file=../'; ?>"+src;
        $(".show_iframe_pdf_header").attr("src",src);
        $("#show_pdf_modal_header").modal("show");
    }
});
</script>
</html>