<?php 
$this->db = \Config\Database::connect();
$this->session = \Config\Services::session();
?>
<nav class="top-menu">
    <div class="menu-icon-container">
        <a href="<?php echo BASE_URL.'district/dashboard'; ?>" class="logo">
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

                                <img src="<?php echo BASE_URL; ?>assets/images/avatar5.png" alt="User Image" />

                            <?php

                            }

                            else {

                            ?>

                                <img src="<?php echo BASE_URL.UPLOAD_PROFILEPICS.'districtadmin/'.$admin['image']; ?>" alt="User Image" />

                            <?php

                            }

                            ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                    <a class="dropdown-item" href="<?php echo BASE_URL.'district/admin_setting'; ?>"><i class="dropdown-icon icmn-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo BASE_URL.'district/logout'; ?>"><i class="dropdown-icon icmn-exit"></i> Logout</a>
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
                    <div class="btn-group" style="margin-top: -6px;">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php 
                            $method = $subsegment;

                            if($method == "dashboard") { echo 'DASHBOARD'; }
                            elseif($method == "admin_setting") { echo 'ADMIN SETTINGS'; } 
                            elseif($method == "addtemplate" || $method == "addtemplate_step2" || $method == "addtemplate_step3" || $method == "manage_schools" || $method == "addschool" || $method == "manage_surveys") { echo 'MANAGE SCHOOLS'; }
                            elseif($method == "terms_of_use") { echo 'Terms of Use'; } 
                            elseif($method == "privacy_policy") { echo 'Privacy Policy'; } 
                            else{
                               echo 'MANAGE SCHOOLS'; 
                            }
                        ?>

                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item <?php if($method == "dashboard") { echo 'active'; } ?>" href="<?php echo BASE_URL.'district/dashboard'; ?>">DASHBOARD</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php if($method == "manage_schools" || $method == "addschool" || $method == "manage_surveys") { echo 'active'; } ?>" href="<?php echo BASE_URL.'district/manage_schools'; ?>">MANAGE SCHOOLS</a>
                      </div>
                    </div>
                    
                </div>
            </div>
            <div class="right">
                <div class="search-block" style="width:65px">
                    <ul class="nav navbar-nav" style="float:right;margin-top: 10px;">
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <i class="fa fa-bell-o"></i>
                              <?php
                              $get_school_ids = $this->db->table('go_schools')->select('*')->where('district_id',$this->session->get('gowritedistrictadmin_Userid'))->get()->getResultArray();
                              $school_ids = '';
                              if(!empty($get_school_ids))
                              {
                                foreach($get_school_ids as $schools)
                                {
                                    if($school_ids == "")
                                    {
                                        $school_ids = $schools['id'];
                                    }
                                    else{
                                        $school_ids = $school_ids.','.$schools['id'];
                                    }
                                }
                              }
                              $explode = explode(',',$school_ids);
                              $surveys = $this->db->table('master_templates')->select('*')->whereIn('school_id',$explode)->where('district_status',0)->get()->getResultArray();
                              $notifications = $this->db->table('notifications')->select('*')->where('district_id',$this->session->get('gowritedistrictadmin_Userid'))->where('district_status',1)->get()->getResultArray();
                                $count = count($surveys) + count($notifications);
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
                                            <a href="<?php echo BASE_URL.'district/view_template/'.$survey['id']; ?>">
                                                <div style="width:100%">
                                                    <strong><?php echo $i; ?>. A New Survey Created By Admin.</strong>
                                                </div>
                                                <div style="width:100%">
                                                    <strong>Survey Name: </strong> <?php echo $survey['template_name']; ?>
                                                </div>
                                                <div style="width:100%">
                                                    <strong>Created On: </strong> <?php echo date('d-m-Y',strtotime($survey['updatetime'])); ?>
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
                                        $report_details = $this->db->table('principal_attachments')->select('*')->where('id',$notify['report_id'])->get()->getRowArray();
                                        $type = isset($report_details['type'])?$report_details['type']:'';
                                        $school_id = isset($report_details['school_id'])?$report_details['school_id']:0;
                                        ?>
                                        <li class="li_notify">
                                            <a href="<?php echo BASE_URL.'district/principal_apportionment?type='.$type.'&notify='.$notify['id']; ?>">
                                                <div style="width:100%">
                                                    <strong><?php echo $notify['message']; ?></strong>
                                                </div>
                                                <div style="width:100%">
                                                    <?php $school_details = $this->db->table('go_schools')->select('*')->where('id',$school_id)->get()->getRowArray(); 
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
                                if($i == 1){
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
            <div class="right" style="width:35%">
                <a class="btn btn-primary btn-sm" href="<?php echo BASE_URL.'uploads/LVUSD Charter Handbook1.3.pdf'; ?>" download>LVUSD Charter School Oversight Handbook</a>
            </div>
        </div>
    </div>
</nav>