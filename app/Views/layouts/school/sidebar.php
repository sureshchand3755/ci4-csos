<!-- <nav class="left-menu" left-menu>
    <div class="logo-container">
        <a href="<?php echo BASE_URL.'school/dashboard'; ?>" class="logo">
<style>
.csos_logo{
    width: 220px !important;
    min-width: 220px !important;
    max-width: 220px !important;
    max-height: 200px !important;
    margin-top: -54px !important;
    margin-left: -12px !important;
}
</style>
             <img class="csos_logo" src="<?php echo BASE_URL; ?>/assets/images/csoc_logo.png"> 
        </a>
    </div>
    <?php
    $method = $this->router->fetch_method();
    ?>
    <div class="left-menu-inner scroll-pane">
        <ul class="left-menu-list left-menu-list-root list-unstyled">
            <li <?php if($method == "dashboard") { echo 'class="left-menu-list-active"'; } ?>>
                <a class="left-menu-link" href="<?php echo BASE_URL.'school/dashboard'; ?>">
                    <i class="left-menu-link-icon icmn-home2"></i>
                    <span class="menu-top-hidden">Dashboard</span>
                </a>
            </li>
            <li <?php if($method == "addtemplate" || $method == "addtemplate_step2" || $method == "addtemplate_step3" || $method == "manage_schools" || $method == "addschool" || $method == "manage_surveys") { echo 'class="left-menu-list-active"'; } ?>>
                <a class="left-menu-link" href="<?php echo BASE_URL.'school/manage_surveys'; ?>">
                    <i class="left-menu-link-icon fa fa-university"></i>
                    <span class="menu-top-hidden">Manage Surveys</span>
                </a>
            </li>
        </ul>
    </div>
</nav> -->