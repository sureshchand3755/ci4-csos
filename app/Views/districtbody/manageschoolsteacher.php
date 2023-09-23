<style>
	#selecterror2
	{
		color:#f00;
	}
    .checkinput
    {
        width: 30%;
        margin-top: 5px;
    }
	.checkinput1
	{
		width: 35%;
        margin-top: 5px;
	}
</style>
<?php
if(!empty($_GET['manage'])) {
    echo "<script>
            $( window ).load(function() {
                $('#myModal').modal('show');
            });
        </script>";
}
?>
<?php
if(!empty($_GET['manageclass'])) {
    echo "<script>
            $( window ).load(function() {
                $('#myModal1').modal('show');
            });
        </script>";
}
?>
<?php
if(!empty($_GET['manageteacher'])) {
    echo "<script>
            $( window ).load(function() {
                $('#myModal2').modal('show');
            });
        </script>";
}
?>
<?php
if(!empty($_GET['viewteacher'])) {
    echo "<script>
            $( window ).load(function() {
                $('#myModal3').modal('show');
            });
        </script>";
}
?>
<?php
if(!empty($_GET['managegrade'])) {
    echo "<script>
            $( window ).load(function() {
                $('#myModal4').modal('show');
            });
        </script>";
}
?>
<?php
if(!empty($_GET['managegradeclass'])) {
    echo "<script>
            $( window ).load(function() {
                $('#myModal5').modal('show');
            });
        </script>";
}
?>
<!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	    <h1>
		MANAGE DEPARTMENT TEACHERS
		<small>Control panel</small>
	    </h1>
	</section>
	
	<!-- Main content -->
	<section class="content">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="<?php if((!empty($_GET['school'])) && (empty($_GET['manage'])) && (empty($_GET['managegradeclass'])) && (empty($_GET['managegrade_department'])) && (empty($_GET['manageclass_department'])) && (empty($_GET['manageteacher_department'])) && (empty($_GET['manageclass'])) && (empty($_GET['manageteacher'])) && (empty($_GET['viewteacher']))) { if(!empty($_GET['managegrade']) || !empty($_GET['managegrade_school'])) { echo "active"; } else { echo "active"; } }  ?>"><a href="#grade" aria-controls="home" role="tab" data-toggle="tab">MANAGE GRADE</a></li>
                <?php $school = $this->Madmin->GetSchool_id(SCHOOL_DETAILS,$_GET['school']); 
				if($school['school_type']!=1)
				{
				?>
                <li role="presentation" class="<?php if((!empty($_GET['school'])) && (empty($_GET['manageteacher'])) && (empty($_GET['viewteacher'])) && (empty($_GET['manageclass']))) { if(!empty($_GET['manage']) || !empty($_GET['managegrade_department'])) { echo "active"; } else { echo ""; } }  ?>"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">MANAGE GRADE DEPARTMENT</a></li>
                <?php } ?>
                <li role="presentation" class=" <?php if(!empty($_GET['school'])) { if((!empty($_GET['manageteacher'])) || (!empty($_GET['viewteacher'])) || (!empty($_GET['manageteacher_department']))) { echo "active"; } else { } } ?>"><a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">MANAGE TEACHER DEPARTMENT</a></li>
                
            </ul>
			<!------------------------Modal--------------------------->
			<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<form id="grade_select_school" name="" method="post">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><b>Select Grade <small id="gradeschool_error" style="color:#f00"></small></b></h4>
							</div>
							<div class="modal-body">
								<?php
								if(!empty($select_grade_id))
								{
									$i=1;
									$j = 1;
									foreach($select_grade_id as $grade)
									{
										if($school['school_type']==1 && $i <= 7){
											if(!empty($select_grade))
											{
												$arr = array();
												foreach($select_grade as $selgrade)
												{
													array_push($arr,$selgrade['grade_id']);
												}
											}
											if(in_array($grade['id'],$arr))
											{
												$j++;
												$checked = "checked disabled";
											}
											else
											{
												$checked = "";
											}
												echo '<label class="checkinput" for="grade'.$i.'"><input type="checkbox" name="gradeschool[]" class="gradeclass" id="grade'.$i.'" value="'.$grade['id'].'" '.$checked.'> '.$grade['grade_name'].'</label>';
										}
										elseif($school['school_type']==2 && $i >= 7 && $i <= 9){
											if(!empty($select_grade))
											{
												$arr = array();
												foreach($select_grade as $selgrade)
												{
													array_push($arr,$selgrade['grade_id']);
												}
											}
											if(in_array($grade['id'],$arr))
											{
												$j++;
												$checked = "checked disabled";
											}
											else
											{
												$checked = "";
											}
												echo '<label class="checkinput" for="grade'.$i.'"><input type="checkbox" name="gradeschool[]" class="gradeclass" id="grade'.$i.'" value="'.$grade['id'].'" '.$checked.'> '.$grade['grade_name'].'</label>';
										}
										elseif($school['school_type']==3 && $i >= 8 && $i <= 9){
											if(!empty($select_grade))
											{
												$arr = array();
												foreach($select_grade as $selgrade)
												{
													array_push($arr,$selgrade['grade_id']);
												}
											}
											if(in_array($grade['id'],$arr))
											{
												$j++;
												$checked = "checked disabled";
											}
											else
											{
												$checked = "";
											}
												echo '<label class="checkinput" for="grade'.$i.'"><input type="checkbox" name="gradeschool[]" class="gradeclass" id="grade'.$i.'" value="'.$grade['id'].'" '.$checked.'> '.$grade['grade_name'].'</label>';
										}
										elseif($school['school_type']==4 && $i >= 10 && $i <= 13){
											if(!empty($select_grade))
											{
												$arr = array();
												foreach($select_grade as $selgrade)
												{
													array_push($arr,$selgrade['grade_id']);
												}
											}
											if(in_array($grade['id'],$arr))
											{
												$j++;
												$checked = "checked disabled";
											}
											else
											{
												$checked = "";
											}
												echo '<label class="checkinput" for="grade'.$i.'"><input type="checkbox" name="gradeschool[]" class="gradeclass" id="grade'.$i.'" value="'.$grade['id'].'" '.$checked.'> '.$grade['grade_name'].'</label>';
										}
										$i++;
									}
								}
								?>
							<p style="color:#f00; margin-top:15px;">Note: Once you set the grade for school you cant able to change again. So please confirm while clicking update button</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<?php
								if($j == 1)
								{ ?>
								<input type="submit" class="btn btn-primary" name="updategrade_school" id="updategrade_school" value="Update">
								<?php
								} else { ?>
								<input type="submit" class="btn btn-primary" name="updategrade_school" id="updategrade_school" value="Update" disabled>
								<?php } ?>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<form id="create_class" name="" method="post">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><b>Create Class</b></h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-3">
										<label style="float:right; margin-top:5px"> Class Name : </label>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<span class="input-group-addon">Class</span>
											<input type="text" name="class_name" class="form-control input-sm">
										</div>
										<label id="class_name-error" class="error" for="class_name"></label>
									</div>
									<div class="col-md-4">
										<input type="submit" class="btn btn-primary btn-sm" name="updategrade_class" value="SUBMIT">
									</div>
								</div>
								<br/>
								<table class="table">
									<thead>
										<tr>
											<th>S.No</th>
											<th class="tablehide">Grade</th>
											<th class="tablehide">Class Name</th>
											<th class="tablehide">Delete</th>
										</tr>
									</thead>
									<tbody id="tclass">
									    <?php
                                                $i = 1;
                                                if(!empty($select_class)) {
                                                    foreach($select_class as $class) {
														$gname = $this->Madmin->GetGrade_id(GRADE_DETAILS,$class['grade_id']);
														$gid = $gname['grade_id'];
														$gradenamee = $this->Madmin->Get_CreatedGrade_id(CREATE_GRADE,$gid);
                                                ?>
                                               <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $gradenamee['grade_name']; ?></td>
												<td><?php echo $class['class_name']; ?></td>
                                                <td><a href="">Delete</a></td>
                                               </tr>
                                               <?php $i++; } } ?>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php 
			if($school['school_type']!=1)
			{
			?>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<form id="select_department_form" name="" method="post">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><b>Select Department for Grade <small id="select_department_error" style="color:#f00;"></small></b></h4>
							</div>
							<div class="modal-body">
								<?php
								if(!empty($select_department))
								{
									$i=1;
									foreach($select_department as $department)
									{
										if(!empty($grade_details['department_id']))
										{
											$id = $department['id'];
											$explode = explode(",",$grade_details['department_id']);
											if(in_array($id,$explode))
											{
												$checked ="checked";
											}
											else
											{
												$checked ="";
											}
										}
										else
										{
											$checked ="";
										}
											echo '<label class="checkinput" for="dept'.$i.'"><input type="checkbox" class="departmentclass" id="dept'.$i.'" value="'.$department['id'].'" '.$checked.'> '.$department['department_name'].'</label>';
										
									$i++;
									}
								}
								?>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="hiddencheckbox" id="hiddencheckbox" value="<?php if(!empty($grade_details['department_id'])) { echo $grade_details['department_id']; } ?>">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" class="btn btn-primary" name="updategrade_department" id="updategrade_department" value="Update">
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php } ?>
            <?php 
			if($school['school_type']!=1)
			{
			?>
			<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<form name="" method="post">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><b>Select Department for Grade <small id="select_class_error" style="color:#f00"></small></b></h4>
							</div>
							<div class="modal-body">
								<?php
								if(!empty($classgrade_details['department_id']))
								{
									$j=1;
									$deptexp  = explode(",",$classgrade_details['department_id']);
									foreach($deptexp as $dept)
									{
										$departmentt = $this->Madmin->GetDepartment_id(DEPARTMENT_DETAILS,$dept);
										if(!empty($class_details['department_id']))
										{
											$idd = $departmentt['id'];
											$exploded = explode(",",$class_details['department_id']);
											if(in_array($idd,$exploded))
											{
												$checkedd ="checked";
											}
											else
											{
												$checkedd ="";
											}
										}
										else
										{
											$checkedd ="";
										}
										echo '<label class="checkinput" for="deptt'.$j.'"><input type="checkbox" class="departmentgradeclass" id="deptt'.$j.'" value="'.$departmentt['id'].'" '.$checkedd.'> '.$departmentt['department_name'].'</label>';
										 $j++;
									}
								}
								?>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="hiddencheckbox2" id="hiddencheckbox2" value="<?php if(!empty($class_details['department_id'])) { echo $class_details['department_id']; } ?>">
								
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" class="btn btn-primary" name="updateclass_department" id="updateclass_department" value="Update">
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php } ?>
			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<form id="teacher_select_form" name="" method="post">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><b>Select Department for Teacher <small id="select_teacher_error" style="color:#f00;"></small></b></h4>
							</div>
							<div class="modal-body">
								<div><label>Please Select the Grade</label><a style="float:right" href="<?php echo BASE_URL.'admin/manage_schoolsteacher?school='.$_GET['school'].'&manageteacher='.$_GET['manageteacher']; ?>" class="btn btn-sm btn-primary">Reset / Edit</a></div><br/>
									<div>
										<?php
											if(!empty($select_grade))
											{
												$teacher = $_GET['manageteacher'];
												$teacherdet = $this->Madmin->GetTeacher_id(TEACHER_DETAILS,$teacher);
												$deptteacher = $teacherdet['department_id'];
												
												$x = 1;
												foreach($select_grade as $grade) {
													$grade_name = $this->Madmin->Get_CreatedGrade_id(CREATE_GRADE,$grade['grade_id']);
													if($school['school_type']==1)
													{
														if($deptteacher=="")
														{
															echo '<label class="checkinput" for="grdee'.$x.'"><input type="radio" name="gdept" value="'.$grade['id'].'" id="grdee'.$x.'" class="gradeteacher_radio"> '.$grade_name['grade_name'].'</label>';
														}
														else{
															echo '<label class="checkinput" for="grdee'.$x.'"><input type="radio" name="gdept" value="'.$grade['id'].'" id="grdee'.$x.'" class="gradeteacher_radio" disabled> '.$grade_name['grade_name'].'</label>';
														}
													}
													else{
														echo '<label class="checkinput" for="grdee'.$x.'"><input type="checkbox" name="gdept" value="'.$grade['id'].'" id="grdee'.$x.'" class="gradeteacher"> '.$grade_name['grade_name'].'</label>';
													}
													$x++;
												}
												if($school['school_type']==1)
												{
													if($deptteacher!="")
													{
														echo '<p style="color:#f00">Note: Selected Teacher have already alloted with the class. If you want to change the class please delete the previous class from View section and try again.</p>';
													}
												}
											}
										?>
									</div>
								<br/>
								<div id="classhide" style="display:none;border-top: 1px solid #E0D8D8;padding: 15px 0px;">
									<label>Please Select the Class</label><br/>
									<p id="classdiv">
										
									</p>
								</div>
								<div id="departmenthide" style="display:none;border-top: 1px solid #E0D8D8;padding: 15px 0px;">
									<label>Please Select the Department</label><br/>
									<p id="departmentdiv">
										
									</p>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="hiddencheckbox3" id="hiddencheckbox3" value="">
								<input type="hidden" name="hiddencheckbox4" id="hiddencheckbox4" value="<?php if($teachers['department_id']==""){ echo ""; } else { echo $teachers['department_id'].","; } ?>">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" class="btn btn-primary" name="updateteacher_department" id="updateteacher_department" value="Update">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<form name="" method="post">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><b>Teacher Departments</b></h4>
							</div>
							<div class="modal-body">
											<table class="table">
												<thead>
													<tr>
														<th>S.No</th>
														<th class="tablehide">Grade</th>
														<th>Class</th>
														<?php if($school['school_type']==1) { } else{ ?><th>Department</th><?php } ?>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if(!empty($teachers))
													{
														$id = $teachers['department_id'];
														$explode = explode(",",$id);
														$i = 1;
														if($id!="") {
															foreach($explode as $dept){
																$gradeclass = explode("-",$dept);
																$grade = $gradeclass[0];
																$class = $gradeclass[1];
																$department = $gradeclass[2];
																
																$gradename = $this->Madmin->GetGrade_id(GRADE_DETAILS,$grade);
																$gname = $this->Madmin->Get_CreatedGrade_id(CREATE_GRADE,$gradename['grade_id']);
																$classname = $this->Madmin->GetClass_id(CLASS_DETAILS,$class);
																$departmentname = $this->Madmin->GetDepartment_id(DEPARTMENT_DETAILS,$department);
															?>
																<tr>
																	<td><?php echo $i; ?></td>
																	<td><?php echo $gname['grade_name']; ?></td>
																	<td><?php echo $classname['class_name']; ?></td>
																	<?php if($school['school_type']==1) { } else{ ?><td><?php echo $departmentname['department_name']; ?></td><?php } ?>
																	<?php $href=BASE_URL.ADMIN_DELETETEACHERDEPARTMENT.'?grade='.$grade.'&class='.$class.'&department='.$department.'&teacher='.$_GET['viewteacher'].'&school='.$_GET['school']; ?>
																	<td><a href="#" Onclick="confirmDelete(<?php echo "'".$href."'"; ?>)">DELETE</a></td>
																</tr>
														   <?php $i++; }
														}
													} ?>
												</tbody>
											</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
            <!--------------------------------Tab panes-------------------------------->
            <div class="tab-content">
				<div role="tabpanel" class="tab-pane <?php if((!empty($_GET['school'])) && (empty($_GET['manage'])) && (empty($_GET['managegradeclass'])) && (empty($_GET['managegrade_department'])) && (empty($_GET['manageclass_department'])) && (empty($_GET['manageteacher_department'])) && (empty($_GET['manageclass'])) && (empty($_GET['manageteacher'])) && (empty($_GET['viewteacher']))) { if(!empty($_GET['managegrade']) || !empty($_GET['managegrade_school'])) { echo "active"; } else { echo "active"; } }  ?>" id="grade">
                    <br/>
                    <div class="span9" id="content">
                        <div class="row-fluid">
							<div class="col-md-6 col-md-offset-1">
                            <!-- block -->
                            <!--For Flash message-->
                            <?php if ($this->session->flashdata('sucess_msg')) { ?>
                            <div class="alert alert-success">
                                     <a href="#" class="close" data-dismiss="alert">&times;</a>
                                      <?php
                                             echo $this->session->flashdata('sucess_msg');
                                             $this->session->unset_userdata('sucess_msg');
                                      ?>
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                     <?php
                                            echo $this->session->flashdata('error_msg');
                                            $this->session->unset_userdata('error_msg');
                                     ?>
                            </div>
                            <?php } ?>
                            <!--End Flash message-->
                                <div class="block-content collapse in">
                                    <div class="span12">
										<a href="<?php echo BASE_URL.'admin/manage_schoolsteacher?school='.$_GET['school'].'&managegrade=1'; ?>" class="btn btn-primary add_button" style="float: right;">Add Grade To School<i class="icon-plus icon-white"></i></a>
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th>S.No</th>
                                                <th class="tablehide">Grade</th>
                                              </tr>
                                            </thead>
                                            <tbody id="tschools">
                                                <?php
                                                $i = 1;
                                                if(!empty($select_grade)) {
                                                    foreach($select_grade as $grade) {
														$gradename = $this->Madmin->Get_CreatedGrade_id(CREATE_GRADE,$grade['grade_id']);
                                                ?>
                                               <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $gradename['grade_name']; ?></td>
                                               </tr>
                                               <?php $i++; } } ?>
                                            </tbody>
                                        </table>

                                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <h3 id="myModalLabel">Delete</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <a href="" class="adelete btn btn-primary">DELETE</a>
                                            </div>
                                        </div>
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">
                                            <input type="hidden" name="hiddenstate" id="hiddenstate" value="">
                                            <input type="hidden" name="hiddendistrict" id="hiddendistrict" value="">
                                            <input type="hidden" name="hiddentype" id="hiddentype" value="">
                                            <input type="hidden" name="hiddenschool" id="hiddenschool" value="">
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane <?php if((!empty($_GET['school'])) && (empty($_GET['manageteacher'])) && (empty($_GET['viewteacher'])) && (empty($_GET['manageclass']))) { if(!empty($_GET['manage']) || !empty($_GET['managegrade_department'])) { echo "active"; } else { echo ""; } }  ?>" id="home">
                    <br/>
                    <div class="span9" id="content">
                        <div class="row-fluid">
                            <!-- block -->
                            <!--For Flash message-->
                            <?php if ($this->session->flashdata('sucess_msg')) { ?>
                            <div class="alert alert-success">
                                     <a href="#" class="close" data-dismiss="alert">&times;</a>
                                      <?php
                                             echo $this->session->flashdata('sucess_msg');
                                             $this->session->unset_userdata('sucess_msg');
                                      ?>
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                     <?php
                                            echo $this->session->flashdata('error_msg');
                                            $this->session->unset_userdata('error_msg');
                                     ?>
                            </div>
                            <?php } ?>
                            <!--End Flash message-->
                                <div class="block-content collapse in">
                                    <div class="span12">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th>S.No</th>
                                                <th class="tablehide">Grade</th>
                                                <th>Actions</th>
                                              </tr>
                                            </thead>
                                            <tbody id="tschools">
                                                <?php
                                                $i = 1;
                                                if(!empty($select_grade)) {
                                                    foreach($select_grade as $grade) {
														$gradenamee = $this->Madmin->Get_CreatedGrade_id(CREATE_GRADE,$grade['grade_id']);
                                                ?>
                                               <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $gradenamee['grade_name']; ?></td>
                                                <td><a href="<?php echo BASE_URL.'admin/manage_schoolsteacher?school='.$_GET['school'].'&manage='.$grade['id']; ?>">Manage</a></td>
                                               </tr>
                                               <?php $i++; } } ?>
                                            </tbody>
                                        </table>

                                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <h3 id="myModalLabel">Delete</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <a href="" class="adelete btn btn-primary">DELETE</a>
                                            </div>
                                        </div>
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">
                                            <input type="hidden" name="hiddenstate" id="hiddenstate" value="">
                                            <input type="hidden" name="hiddendistrict" id="hiddendistrict" value="">
                                            <input type="hidden" name="hiddentype" id="hiddentype" value="">
                                            <input type="hidden" name="hiddenschool" id="hiddenschool" value="">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
				<div role="tabpanel" class="tab-pane <?php if(!empty($_GET['school'])) { if((!empty($_GET['manageteacher'])) || (!empty($_GET['viewteacher'])) || (!empty($_GET['manageteacher_department']))) { echo "active"; } else { } } ?>" id="teacher">
                    <br/>
                    <div class="span9" id="content">
                        <div class="row-fluid">
                            <!-- block -->
                            <!--For Flash message-->
                            <?php if ($this->session->flashdata('sucess_msg')) { ?>
                            <div class="alert alert-success">
                                     <a href="#" class="close" data-dismiss="alert">&times;</a>
                                      <?php
                                             echo $this->session->flashdata('sucess_msg');
                                             $this->session->unset_userdata('sucess_msg');
                                      ?>
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                     <?php
                                            echo $this->session->flashdata('error_msg');
                                            $this->session->unset_userdata('error_msg');
                                     ?>
                            </div>
                            <?php } ?>
                            <!-- Modal -->
                            
							
                            <!--End Flash message-->
                                <div class="block-content collapse in">
                                    <div class="span12">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th>S.No</th>
                                                <th class="tablehide">Teacher Name</th>
                                                <th>Actions</th>
                                              </tr>
                                            </thead>
                                            <tbody id="tschools">
                                                <?php
                                                $i = 1;
                                                if(!empty($teacher_details)) {
                                                    foreach($teacher_details as $teacher) {
                                                ?>
                                               <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $teacher['fullname']; ?></td>
                                                <td><a href="<?php echo BASE_URL.'admin/manage_schoolsteacher?school='.$_GET['school'].'&manageteacher='.$teacher['id']; ?>">Manage</a>
												<a style="margin-left:15px" href="<?php echo BASE_URL.'admin/manage_schoolsteacher?school='.$_GET['school'].'&viewteacher='.$teacher['id']; ?>">View</a></td>
                                               </tr>
                                               <?php $i++; } } ?>
                                            </tbody>
                                        </table>

                                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <h3 id="myModalLabel">Delete</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <a href="" class="adelete btn btn-primary">DELETE</a>
                                            </div>
                                        </div>
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>">
                                            <input type="hidden" name="hiddenstate" id="hiddenstate" value="">
                                            <input type="hidden" name="hiddendistrict" id="hiddendistrict" value="">
                                            <input type="hidden" name="hiddentype" id="hiddentype" value="">
                                            <input type="hidden" name="hiddenschool" id="hiddenschool" value="">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	    <!-- Small boxes (Stat box) -->
    </div>
	</section>
	</aside>
	
<script>
	$("#updateclass_department").click(function(e) {
		var value = $("#hiddencheckbox2").val();
		if (value=="") {
			e.preventDefault();
			$("#select_class_error").html("Please select the Class");
		}
	});
	$("#updategrade_department").click(function(e) {
		var value=$("#hiddencheckbox").val();
		if (value=="") {
			e.preventDefault();
			$("#select_department_error").html("Please select the department");
		}
	});
	$( "#create_class" ).validate({
      rules: {
        class_name : {required: true,},
    },
    messages: {
        class_name : {
          required : "Class Name is required",
        },
    },
    });
$("#updateteacher_department").click(function(e) {
	var value = $("#hiddencheckbox3").val();
	if (value=="") {
		e.preventDefault();
		$("#select_teacher_error").html("Please select the grade and class");
	}
});
$("#updategrade_school").click(function(e) {
	var i = 1;
	$(".gradeclass").each(function() {
		if ($(this).is(":checked")) {
			i = i + 1;
		}
	});
	if (i==1) {
		e.preventDefault();
		$("#gradeschool_error").html("Please select the grade");
	}
});
function confirmDelete(url) {
    if (confirm("Are you sure you want to delete this?")) {
        window.location.replace(url);
    } else {
        return false;
    }       
}
jQuery(document).ready(function(){
	var Search_val = "<?php echo $search_val; ?>";
    var base_url = $("#base_url").val();

	$("#gradeselect2").change(function() {
		var stateid = $("#hiddenstate2").val();
		var districtid = $("#hiddendistrict2").val();
        var type = $("#hiddentype2").val();
		var school = $("#hiddenschool2").val();
		var id = $(this).val();
		$("#hiddengrade2").val(id);
		$.ajax({
			url: base_url+"admin/class_list_grade?state="+stateid+"&district="+districtid+"&type="+type+"&school="+school+"&grade="+id,
			success:function(result){
			   $("#tclassss").html(result);
			}
		});
	});
    
    $(".departmentclass").click(function(event) {
		if ($(this).is(":checked")) {
			var id = $(this).val();
			var hiddencheckbox = $("#hiddencheckbox").val();
			if (hiddencheckbox=="") {
				$("#hiddencheckbox").val(id);
			}
			else{
				$("#hiddencheckbox").val(hiddencheckbox+","+id);
			}
		}
    });
    $(".departmentclass").click(function(event) {
		if ($(this).is(":unchecked")) {
        var id = $(this).val();
        var hiddencheckbox = $("#hiddencheckbox").val();
        var n = hiddencheckbox.indexOf(","+id+",");
        if (n>=0) {
           var replacestr = hiddencheckbox.replace(","+id+",", ",");
        }
        else
        {
            var n1 = hiddencheckbox.indexOf(id+",");
            if (n1>=0) {
                var replacestr = hiddencheckbox.replace(id+",", "");
            }
            else
            {
                var replacestr = hiddencheckbox.replace(","+id, "");
            }
        }
		 var i = 0;
		$(".departmentclass:checked").each(function () {
			i = parseInt(i) + parseInt(1);
		});
		if (i==0) {
			$("#hiddencheckbox").val("");
		}
		else
		{
			$("#hiddencheckbox").val(replacestr);
		}
		}
    });
	$(".departmentgradeclass").click(function(event) {
		if ($(this).is(":checked")) {
        var id = $(this).val();
        var hiddencheckbox = $("#hiddencheckbox2").val();
        if (hiddencheckbox=="") {
            $("#hiddencheckbox2").val(id);
        }
        else{
            $("#hiddencheckbox2").val(hiddencheckbox+","+id);
        }
		}
    });
    $(".departmentgradeclass").click(function(event) {
		if ($(this).is(":unchecked")) {
        var id = $(this).val();
        var hiddencheckbox = $("#hiddencheckbox2").val();
        var n = hiddencheckbox.indexOf(","+id+",");
        if (n>=0) {
           var replacestr = hiddencheckbox.replace(","+id+",", ",");
        }
        else
        {
            var n1 = hiddencheckbox.indexOf(id+",");
            if (n1>=0) {
                var replacestr = hiddencheckbox.replace(id+",", "");
            }
            else
            {
                var replacestr = hiddencheckbox.replace(","+id, "");
            }
        }
		 var i = 0;
		$(".departmentgradeclass:checked").each(function () {
			i = parseInt(i) + parseInt(1);
		});
		if (i==0) {
			$("#hiddencheckbox2").val("");
		}
		else
		{
			$("#hiddencheckbox2").val(replacestr);
		}
		}
    });
	$(".gradeteacher").click(function(event) {
		if ($(this).is(":checked")) {
		$("#classhide").show();
		var id = $(this).val();
		var school = <?php echo $_GET['school']; ?>;
		if($("#classdiv"+id).length != 0) {
			$("#classdiv"+id).show();
		}
		else
		{
			$.ajax({
				url: base_url+"admin/class_list_checkbox?&school="+school+"&grade="+id,
				success:function(result){
					var html = $("#classdiv").html();
					$("#classdiv").html(html+result);
					
						$(".classteacher").click(function(){
							$(".gradeteacher").prop("disabled",true);
                        <?php 
						if($school['school_type']!=1)
							{
								?>
							$("#departmenthide").show();
                            
							var classid =  $(this).val();
							var parentdiv = $(this).closest('div').attr('id');
							var strparentdiv = parentdiv.substr(8,9);
							if ($(this).is(':checked')) {
								$(this).attr("checked","checked");
								if($("#deptdiv"+strparentdiv+"-"+classid).length == 0) {
									$.ajax({
										url: base_url+"admin/department_list_checkbox?&school="+school+"&grade="+id+"&class="+classid,
										success:function(resulttt){
											var htmll = $("#departmentdiv").html();
											$("#departmentdiv").html(htmll+resulttt);
											$("#hiddencheckbox3").val("");
											$(".deptteacher").click(function(){
												$(".classteacher").prop("disabled",true);
												if($(this).is(':checked')) {
													var id = $(this).val();
													var hiddencheckbox = $("#hiddencheckbox3").val();
													if (hiddencheckbox=="") {
														$("#hiddencheckbox3").val(id);
													}
													else{
														$("#hiddencheckbox3").val(hiddencheckbox+","+id);
													}
												}
												if($(this).is(':unchecked')) {
													var id = $(this).val();
													var hiddencheckbox = $("#hiddencheckbox3").val();
													var n = hiddencheckbox.indexOf(","+id+",");
													if (n>=0) {
													   var replacestr = hiddencheckbox.replace(","+id+",", ",");
													}
													else
													{
														var n1 = hiddencheckbox.indexOf(id+",");
														if (n1>=0) {
															var replacestr = hiddencheckbox.replace(id+",", "");
														}
														else
														{
															var replacestr = hiddencheckbox.replace(","+id, "");
														}
													}
													 var i = 0;
													$(".deptteacher:checked").each(function () {
														i = parseInt(i) + parseInt(1);
													});
													if (i==0) {
														$("#hiddencheckbox3").val("");
													}
													else
													{
														$("#hiddencheckbox3").val(replacestr);
													}
												}
											});
										}
									});
								}
								else
								{
									$("#deptdiv"+strparentdiv+"-"+classid).show();
									$("#deptdiv"+strparentdiv+"-"+classid).prop("checked",false);
									$("#hiddencheckbox3").val("");
								}
							}
							if ($(this).is(':unchecked')) {
								
								$("#deptdiv"+strparentdiv+"-"+classid).hide();
								$(".deptteacher").prop("checked",false);
								$("#hiddencheckbox3").val("");
							}
                            <?php } else { ?>
                            $("#departmenthide").hide();
							if ($(this).is(':checked')) {
								$(this).attr("checked","checked");
                                var classid =  $(this).val();
                                var parentdiv = $(this).closest('div').attr('id');
								var strparentdiv = parentdiv.substr(8,9);
                                
                                var deptid = strparentdiv+"-"+classid+"-"+0;
                                var hiddencheckbox = $("#hiddencheckbox3").val();
                                if (hiddencheckbox=="") {
                                    $("#hiddencheckbox3").val(deptid);
                                }
                                else{
                                    $("#hiddencheckbox3").val(hiddencheckbox+","+deptid);
                                }
                             }
                                if($(this).is(':unchecked')) {
                                    var classid =  $(this).val();
                                    var parentdiv = $(this).closest('div').attr('id');
                                    var strparentdiv = parentdiv.substr(8,9);
                                    
                                    var deptid = strparentdiv+"-"+classid+"-"+0;
                                    
                                    var hiddencheckbox = $("#hiddencheckbox3").val();
                                    var n = hiddencheckbox.indexOf(","+deptid+",");
                                    if (n>=0) {
                                       var replacestr = hiddencheckbox.replace(","+deptid+",", ",");
                                    }
                                    else
                                    {
                                        var n1 = hiddencheckbox.indexOf(id+",");
                                        if (n1>=0) {
                                            var replacestr = hiddencheckbox.replace(deptid+",", "");
                                        }
                                        else
                                        {
                                            var replacestr = hiddencheckbox.replace(","+deptid, "");
                                        }
                                    }
                                     var i = 0;
                                    $(".classteacher:checked").each(function () {
                                        i = parseInt(i) + parseInt(1);
                                    });
                                    if (i==0) {
                                        $("#hiddencheckbox3").val("");
                                    }
                                    else
                                    {
                                        $("#hiddencheckbox3").val(replacestr);
                                    }
                                }
                            <?php } ?>
						});
				}
			});
		}
		}
	});
	$(".gradeteacher_radio").click(function(event) {
		if ($(this).is(":checked")) {
		$("#classhide").show();
		var id = $(this).val();
		var school = <?php echo $_GET['school']; ?>;
		if($("#classdiv"+id).length != 0) {
			$("#classdiv"+id).show();
		}
		else
		{
			$.ajax({
				url: base_url+"admin/class_list_checkbox?&school="+school+"&grade="+id,
				success:function(result){
					var html = $("#classdiv").html();
					$("#classdiv").html(result);
						$(".classteacher_radio").click(function(){
							$(".gradeteacher_radio").prop("disabled",true);
                            $("#departmenthide").hide();
							$(".classteacher_radio").each(function(){
								if ($(this).is(':checked')) {
									$(this).attr("checked","checked");
									var classid =  $(this).val();
									var parentdiv = $(this).closest('div').attr('id');
									var strparentdiv = parentdiv.substr(8,9);
									
									var deptid = strparentdiv+"-"+classid+"-"+0;
									$("#hiddencheckbox3").val(deptid);
								}
							});
						});
				}
			});
		}
		}
	});
	$(".gradeteacher").click(function(event) {
		if ($(this).is(":unchecked")) {
		var id = $(this).val();
		$("#classdiv"+id).hide();
		$("#classdiv"+id+" .classteacher").prop("checked",false);
		$(".deptclass").each(function() {
			var divid = $(this).attr("id");
			var divname = divid.substr(0, 8);
			if (divname=="deptdiv"+id) {
				$(this).hide();
			}
		});
		}
	});
	
});
</script>