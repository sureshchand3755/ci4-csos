
<!-- <nav class="left-menu" left-menu>
    
    <?php
    $method = $this->router->fetch_method();
    ?>
    <div class="left-menu-inner scroll-pane">
        <ul class="left-menu-list left-menu-list-root list-unstyled">
            <li <?php if($method == "dashboard") { echo 'class="left-menu-list-active"'; } ?>>
                <a class="left-menu-link" href="<?php echo BASE_URL.'admin/dashboard'; ?>">
                    <i class="left-menu-link-icon icmn-home2"></i>
                    <span class="menu-top-hidden">Dashboard</span>
                </a>
            </li>
            <li <?php if($method == "admin_setting") { echo 'class="left-menu-list-active"'; } ?>>
                <a class="left-menu-link" href="<?php echo BASE_URL.'admin/admin_setting'; ?>">
                    <i class="left-menu-link-icon fa fa-user"></i>
                    <span class="menu-top-hidden">My Profile</span>
                </a>
            </li>
            <li <?php if($method == "manage_district" || $method == "adddistricts" || $method == "manage_schools" || $method == "addschool" || $method == "manage_surveys") { echo 'class="left-menu-list-active"'; } ?>>
                <a class="left-menu-link" href="<?php echo BASE_URL.'admin/manage_district'; ?>">
                    <i class="left-menu-link-icon fa fa-university"></i>
                    <span class="menu-top-hidden">Manage Districts</span>
                </a>
            </li>
            <li <?php if($method == "manage_templates") { echo 'class="left-menu-list-active"'; } ?>>
                <a class="left-menu-link" href="<?php echo BASE_URL.'admin/manage_templates'; ?>">
                    <i class="left-menu-link-icon fa fa-clone"></i>
                    <span class="menu-top-hidden">Master Template</span>
                </a>
            </li>
        </ul>
    </div>
</nav> -->