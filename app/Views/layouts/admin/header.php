<nav class="top-menu">
    <div class="menu-icon-container">
        <a href="<?php echo BASE_URL.'admin/dashboard'; ?>" class="logo">
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
            <img class="csos_logo" src="<?php echo BASE_URL; ?>/assets/images/csoc_logo_empty.png"> 
        </a>
    </div>
    <div class="menu">
        <div class="menu-user-block">
            <div class="dropdown dropdown-avatar">
                <a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="avatar" href="javascript:void(0);">
                        <?php $admin = $users;

                            if($admin['image']=='') {

                            ?>

                                <img src="<?php echo BASE_URL.ADMIN_IMG; ?>avatar5.png" alt="User Image" />

                            <?php

                            }

                            else {

                            ?>

                                <img src="<?php echo BASE_URL.UPLOAD_PROFILEPICS.'admin/'.$admin['image']; ?>" alt="User Image" />

                            <?php

                            }

                            ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                    <a class="dropdown-item" href="<?php echo BASE_URL.'admin/admin_setting'; ?>"><i class="dropdown-icon icmn-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo BASE_URL.'admin/logout'; ?>"><i class="dropdown-icon icmn-exit"></i> Logout</a>
                </ul>
            </div>
        </div>
        <div class="menu-info-block">
            <div class="left">
                <div class="header-buttons">
                    <style>
                    .dropdown-menu{
                        width: 400px;
                    }
                    .header_notify{
                        background: #000;
                        color:#fff;
                        padding: 10px;
                        margin-top:-10px;
                    }
                    .li_notify{
                        background: #dfdfdf;
                        color:#000;
                        padding: 10px;
                    }
                    </style>
                    <!-- Example single danger button -->
                    <div class="btn-group" style="margin-top: -6px;">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php 
                            $method = $subsegment;

                            if($method == "dashboard" || $method == "admin_setting" || $method == "pages" || $method == "addpage") { echo 'DASHBOARD'; } 
                            elseif($method == "manage_district" || $method == "adddistricts") { echo 'MANAGE DISTRICTS'; } 
                            elseif($method == "manage_schools" || $method == "addschool") { echo 'MANAGE SCHOOLS'; } 
                            elseif($method == "documents_timeline") { echo 'DOCUMENTS & TIMELINE'; } 
                            elseif($method == "manage_templates") { echo 'MASTER SURVEY TEMPLATES'; } 
                            elseif($method == "manage_full_surveys" || $method == "manage_full_submitted_surveys" || $method == "manage_full_reviewed_surveys" || $method == "manage_surveys" || $method == "manage_submitted_surveys" || $method == "manage_reviewed_surveys") { echo 'MANAGE OVERSIGHT SURVEY'; } 
                            elseif($method == "manage_reports" || $method == "principal_apportionment") { echo 'MANAGE FISCAL REPORTS'; } 
                            elseif($method == "view_result_reports") { echo 'VIEW STATUS FISCAL REPORTS'; } 
                            else{
                                if(isset($_GET['district_id']) || isset($_GET['school_id']))
                                {
                                    echo 'MANAGE OVERSIGHT SURVEY';
                                }
                                else{
                                    echo 'MASTER TEMPLATES';
                                }
                            }
                        ?>

                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item <?php if($method == "dashboard" || $method == "admin_setting") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/dashboard'; ?>">DASHBOARD</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "manage_district" || $method == "adddistricts") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/manage_district'; ?>">MANAGE DISTRICTS</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "manage_schools" || $method == "addschool") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/manage_schools'; ?>">MANAGE SCHOOLS</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "documents_timeline") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/documents_timeline'; ?>">DOCUMENTS & TIMELINE</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "manage_templates") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/manage_templates'; ?>">MASTER SURVEY TEMPLATES</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "manage_full_surveys" || $method == "manage_full_submitted_surveys" || $method == "manage_full_reviewed_surveys" || $method == "manage_surveys" || $method == "manage_submitted_surveys" || $method == "manage_reviewed_surveys") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/manage_full_surveys'; ?>">MANAGE OVERSIGHT SURVEY</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "manage_reports" || $method == "principal_apportionment") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/manage_reports'; ?>">MANAGE FISCAL REPORTS</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "view_result_reports") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/view_result_reports'; ?>">VIEW STATUS FISCAL REPORTS</a>

                        <!-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "pages") { echo 'active'; } ?>" href="<?php echo BASE_URL.'admin/pages'; ?>">MANAGE PAGES</a> -->
                      </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="search-block">
                    <ul class="nav navbar-nav" style="float:right;    margin-top: 10px;">
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <i class="fa fa-bell-o"></i>
                              <?php
                                $count = (is_countable($surveys) && count($surveys)) + (is_countable($surveys) && count($notifications));
                                if($count > 0){
                                    echo '<span class="label label-warning">'.$count.'</span>';
                                }
                              ?>
                            </a>
                            <ul class="dropdown-menu" style="right:0px !important;left:auto">
                                <li class="header_notify">Notifications</li>
                                <?php
                                
                                $i = 1;
                                if(!empty($surveys))
                                {
                                    foreach($surveys as $survey)
                                    {
                                        ?>
                                        <li class="li_notify">
                                            <a href="<?php echo BASE_URL.'admin/view_template/'.$survey['id']; ?>">
                                                <div style="width:100%">
                                                    <strong><?php echo $i; ?>. A Survey has been submitted by the School Admin.</strong>
                                                </div>
                                                <div style="width:100%">
                                                    <?php $school_details = $this->db->select('*')->from('go_schools')->where('id',$survey['school_id'])->get()->row_array(); 
                                                    if(!empty($school_details))
                                                    {
                                                        $schoolname = $school_details['school_name'];
                                                    }
                                                    else{
                                                        $schoolname = '';
                                                    }
                                                    ?>
                                                    <strong>School Name: </strong> <?php echo $schoolname; ?>
                                                </div>
                                                <div style="width:100%">
                                                    <strong>Survay Name: </strong> <?php echo $survey['template_name']; ?>
                                                </div>
                                                <div style="width:100%">
                                                    <strong>Submitted On: </strong> <?php echo date('d-m-Y',strtotime($survey['updatetime'])); ?>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                }
                                if(!empty($notifications))
                                {
                                    foreach($notifications as $notify)
                                    {
                                        $report_details = $this->db->select('*')->from('principal_attachments')->where('id',$notify['report_id'])->get()->row_array();
                                        ?>
                                        <li class="li_notify">
                                            <a href="<?php echo BASE_URL.'admin/principal_apportionment?type='.$report_details['type'].'&notify='.$notify['id']; ?>">
                                                <div style="width:100%">
                                                    <strong><?php echo $notify['message']; ?></strong>
                                                </div>
                                                <div style="width:100%">
                                                    <?php $school_details = $this->db->select('*')->from('go_schools')->where('id',$report_details['school_id'])->get()->row_array(); 
                                                    if(!empty($school_details))
                                                    {
                                                        $schoolname = $school_details['school_name'];
                                                    }
                                                    else{
                                                        $schoolname = '';
                                                    }
                                                    ?>
                                                    <strong>School Name: </strong> <?php echo $schoolname; ?>
                                                </div>
                                                <div style="width:100%">
                                                    <strong>Submitted On: </strong> <?php echo date('d-m-Y',strtotime($notify['updatetime'])); ?>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                }
                                if($i == 1)
                                {
                                    ?>
                                    <li class="li_notify">
                                        <div style="width:100%">
                                            Notifications are empty
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>