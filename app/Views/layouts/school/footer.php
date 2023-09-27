<?php 
$this->router= \Config\Services::router(); 
$this->db = \Config\Database::connect();
$this->session 	= \Config\Services::session();
?>
<style>
.footer
{
	padding:15px;
	background: #fff;
	text-align: center;
	position: fixed;
	bottom: 0px;
	width:100%;
	height: auto;
	line-height: 25px;
}
</style>
<?php
$method = $this->router->methodName();
if($method == "addtemplate" || $method == "addtemplate_step2" || $method == "addtemplate_step3" || $method == "add_submitted_template" || $method == "add_submitted_template_step2" || $method == "add_submitted_template_step3") { } else { ?>
<div style="margin-top:40px;width:100%">&nbsp;</div>
<div class="footer">
	<a href="<?php echo BASE_URL.'school/terms_of_use'; ?>">Terms of Use</a> | 
	<a href="<?php echo BASE_URL.'school/privacy_policy'; ?>">Privacy Policy</a>
	<br/>
	<spam>All Rights Reserved © Copyright <?php echo date('Y'); ?>. Academy & School Resources</spam>
</div>
<?php } ?>
<script>
$(window).click(function(e){
    if($(e.target).hasClass('alert_handbook_alert'))
    {
        alert("No Handbook found");
    }
    if($(e.target).hasClass('alert_fiscal_alert'))
    {
        alert("No Report found");
    }
});
</script>