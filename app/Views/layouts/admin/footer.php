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
$method = $this->router->fetch_method();
if($method == "addtemplate" || $method == "addtemplate_step2" || $method == "addtemplate_step3" || $method == "add_submitted_template" || $method == "add_submitted_template_step2" || $method == "add_submitted_template_step3") { } else { ?>
<div style="margin-top:40px;width:100%">&nbsp;</div>
<div class="footer">
	<a href="<?php echo BASE_URL.'district/terms_of_use'; ?>">Terms of Use</a> | 
	<a href="<?php echo BASE_URL.'district/privacy_policy'; ?>">Privacy Policy</a>
	<br/>
	<spam>All Rights Reserved © Copyright <?php echo date('Y'); ?>. Academy & School Resources</spam>
</div>
<?php } ?>