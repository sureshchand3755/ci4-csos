<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        $helpers = ['form'];
    }
    public function index()
    {
        $data = $this->commonData(lang('admin_dashboard'));
        
        $data['district_count']=$this->adminModel->getDistrictCount();
        $data['schools_count']=$this->adminModel->getSchoolsCount();
        $data['template_count']=$this->adminModel->getTemplateCount();
        $data['survey_count']=$this->adminModel->getSurveysCount();
        $data['report_count']=$this->adminModel->getReportCount();
        return $this->adminBodyTemplate('adminbody/dashboard', $data);
    }
    public function manage_district()
	{
		$data = $this->commonData('ADMIN');
        $data['select_district']= $this->adminModel->GetDistrictadmin();
		$config['base_url'] = BASE_URL.'admin/manage_district/';
		$this->adminBodyTemplate('adminbody/manage_district',$data);
	}
    public function commonData($title=null){ 
        $data = array_merge($this->data, [
			'title'         => $title,
            'users'		=> $this->adminModel->GetAdminDetail($this->session->get('gowriteadmin_Userid'), ADMIN_DETAILS),
            
            'surveys'		=> $this->adminModel->getSurveys(),
            'notifications'		=> $this->adminModel->getNotifications(),
		]);
        return $data ;
    }
    public function check_districtname($id=NULL){
        
		if($this->request->isAJAX()) {
			$districtname = $this->request->getVar('district_name');
			if($id==''){
			    $result = $this->commonModel->Select_District_Where_row(DISTRICTADMIN_DETAILS,$districtname);
			}else{
			    $result = $this->commonModel->Select_District_Where_row(DISTRICTADMIN_DETAILS,$districtname,$id);
			}
			if($result!=0)
				$valid = false;
			else
				$valid = true;
			echo json_encode($valid);
			exit;
		}
	}
    public function check_districtadmin($id=NULL){
		if($this->request->isAJAX()) {
			$username = $this->request->getVar('username');
			if($id==''){
				$result = $this->commonModel->Select_DistrictAdmin_Where_row(DISTRICTADMIN_DETAILS,$username);
			}else{
				$result = $this->commonModel->Select_DistrictAdmin_Where_row(DISTRICTADMIN_DETAILS,$username,$id);
			}
			if($result!=0)
				$valid = false;
			else
				$valid = true;
			echo json_encode($valid);
			exit;
		}
	}
	public function check_districtadmin_email($id=NULL){
		if($this->request->isAJAX()) {
			$email = $this->request->getVar('email');
			if($id==''){
				$result = $this->commonModel->Select_DistrictAdmin_email_Where_row(DISTRICTADMIN_DETAILS,$email);
			}else{
				$result = $this->commonModel->Select_DistrictAdmin_email_Where_row(DISTRICTADMIN_DETAILS,$email,$id);
			}
			if($result!=0)
				$valid = false;
			else
				$valid = true;
			echo json_encode($valid);
			exit;
		}
	}
    
    public function adddistricts($district_id=null){
		$data = $this->commonData(lang('Admin.admin_district'));
        if($this->request->getPost('register_district')){
            $rules=[
                'district_name'=> ['label' => 'District Name', 'rules' => 'required'],
            ];
			
            if ($this->validate($rules)) {
                $input['district_name']     = trim($this->request->getVar('district_name'));
                $input['allow_discreation'] = trim($this->request->getVar('allow_discreation'));
                $input['fullname']          = trim($this->request->getVar('full_name'));
                $input['username']          = trim($this->request->getVar('username'));
                $input['email']			    = trim($this->request->getVar('email'));
                $input['password']          = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                if($district_id==''){
                    $resultadmin = $this->commonModel->Insert_Values(DISTRICTADMIN_DETAILS,$input);							
                }else{
                    $resultadmin = $this->commonModel->Update_Values(DISTRICTADMIN_DETAILS,$input,$district_id);
                }
                session()->setFlashdata('notif_success', lang('Admin.district_saved'));
				return $this->response->redirect(site_url('admin/manage_district'));
			}else{
					$data['selectval']=$this->request->getPost();
			}
        }
		
       $data['validation'] = $this->validation;
        if($district_id!=''){
		    $data['selectval']=$this->commonModel->Select_Val_Id(DISTRICTADMIN_DETAILS,$district_id);
		}else{
		    $data['selectval']=$this->request->getPost();
		}
		$data['district_id']= $district_id;
	   $this->adminBodyTemplate('adminbody/adddistricts',$data);
    }

	public function manage_schools()
	{
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_schools/';
		if(isset($_GET['district_id']))
		{
			$data['select_schools'] = $this->adminModel->getSchoolsDetails($_GET['district_id']);
		}
		else{
			$data['select_schools'] = $this->adminModel->getSchoolsDetails();
		}
		$data['select_district'] = $this->adminModel->GetDistrictadmin_activated();
		$this->adminBodyTemplate('adminbody/manage_schools',$data);
	}

	public function delete_districts($id = '')
	{
		$get_schools = $this->adminModel->getSchools($id);
		if(!empty($get_schools)){
			foreach($get_schools as $school)
			{
				$get_templates = $this->adminModel->getTemplate($school['id']);
				if(!empty($get_templates))
				{
					foreach($get_templates as $template)
					{
						$this->commonModel->Delete_Values('master_templates',$template['id']);
						$this->commonModel->Delete_Related_Values('template_forms','template_id',$template['id']);
					}
				}
			}
		}
		$this->commonModel->Delete_Related_Values('go_schools','district_id',$id);
		$this->commonModel->Delete_Values('go_district_admin',$id);
		session()->setFlashdata('notif_success', 'District Deleted Successfully');
		return $this->response->redirect(site_url('admin/manage_district'));
	}
	public function deactivate_districts($id = '')
	{
		$data['status'] = 1;
		$this->commonModel->Update_Values_district_id('go_schools',$data,$id);
		$this->commonModel->Update_Values('go_district_admin',$data,$id);
		session()->setFlashdata('notif_success', 'District Deactivated Successfully');
		return $this->response->redirect(site_url('admin/manage_district'));
	}
	public function activate_districts($id = '')
	{
		$data['status'] = 0;
		$this->commonModel->Update_Values('go_schools',$data,$id);
		$this->commonModel->Update_Values('go_district_admin',$data,$id);
		session()->setFlashdata('notif_success', 'District Activated Successfully');
		return $this->response->redirect(site_url('admin/manage_district'));
	}

	public function addschool($school_id=null)
	{
		$data = $this->commonData();
		if($this->request->getPost('register_school'))
		{
			
			$rules=[
                'school_name'=> ['label' => 'School Name', 'rules' => 'required'],
            ];			
            if ($this->validate($rules)) {
				
					$input['school_name']   	= trim($this->request->getVar('school_name'));
					$input['district_id']   	= trim($this->request->getVar('district_id'));
					$input['principal_name']	= trim($this->request->getVar('principal_name'));
					$input['username']      	= trim($this->request->getVar('username'));
					$input['email']				= trim($this->request->getVar('email'));
					$input['password'] 			= password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
					$input['landing_message']	= trim($this->request->getVar('landing_message'));
					
					if($school_id=='')
					{
						$resultadmin = $this->commonModel->Insert_Values(SCHOOL_DETAILS,$input);	
						$school_id =$resultadmin;						
					}
					else
					{
						$resultadmin = $this->commonModel->Update_Values(SCHOOL_DETAILS,$input,$school_id);
					}
					
					$inputData['handbook_name'] = $this->request->getVar('handbook_name');
					if($_FILES['filename']['name']!='')
					{
						
						$name = $_FILES['filename']['name'];
						$tmp_name = $_FILES['filename']['tmp_name'];
						$upload_dir = 'uploads/school';
						if (!file_exists($upload_dir)) {
							mkdir($upload_dir);
						}
						$upload_dir = $upload_dir.'/'.base64_encode($school_id);
						if (!file_exists($upload_dir)) {
							mkdir($upload_dir);
						}
						move_uploaded_file($tmp_name,$upload_dir.'/'.$name);
						$inputData['attach_url'] = $upload_dir.'/'.$name;
						$inputData['filename'] = $name;
					}
					if($_FILES['fiscal_filename']['name']!='')
					{
						$name = $_FILES['fiscal_filename']['name'];
						$tmp_name = $_FILES['fiscal_filename']['tmp_name'];
						$upload_dir = 'uploads/school';
						if (!file_exists($upload_dir)) {
							mkdir($upload_dir);
						}
						$upload_dir = $upload_dir.'/'.time();
						if (!file_exists($upload_dir)) {
							mkdir($upload_dir);
						}
						move_uploaded_file($tmp_name,$upload_dir.'/'.$name);
						$inputData['fiscal_url'] = $upload_dir.'/'.$name;
						$inputData['fiscal_filename'] = $name;
					}
					$this->commonModel->Update_Values(SCHOOL_DETAILS,$inputData,$school_id);
					session()->setFlashdata('notif_success', 'School Saved Successfully');
					if(isset($_GET['district_id']))
					{
						return $this->response->redirect(site_url('admin/manage_schools?district_id='.$_GET['district_id']));
					}
					else{
						return $this->response->redirect(site_url('admin/manage_schools'));
					}
			}
			else{
				$data['selectval']=$this->request->getPost();
			}
		}
		
		$data['validation'] = $this->validation;
		if($school_id!='')
		{
			$data['title'] = 'Edit School';
			$data['selectval']=$this->commonModel->Select_Val_Id(SCHOOL_DETAILS,$school_id);
		}
		else
		{
			$data['title'] = 'Add School';
			$data['selectval']=$this->request->getPost();
		}
		$data['school_id']= $school_id;
		$data['districts'] = $this->adminModel->GetDistrictadmin_activated();
		$this->adminBodyTemplate('adminbody/addschools',$data);
	}
	public function check_schoolname($id=NULL){
		if($this->request->isAJAX()) {
			$schoolname = $this->request->getVar('school_name');
			if($id=='')
			{
				$result = $this->commonModel->Select_Schoolname_Where_row(SCHOOL_DETAILS,$schoolname);
			}
			else{
				$result = $this->commonModel->Select_Schoolname_Where_row(SCHOOL_DETAILS,$schoolname,$id);
			}
			if($result!=0)
				$valid = false;
			else
				$valid = true;
			echo json_encode($valid);
			exit;
		}
	}

	public function check_schooladmin($id=NULL){
		if($this->request->isAJAX()) {
			$username = $this->request->getVar('username');
			if($id=='')
			{
				$result = $this->commonModel->Select_SchoolAdmin_Where_row(SCHOOL_DETAILS,$username);
			}
			else{
				$result = $this->commonModel->Select_SchoolAdmin_Where_row(SCHOOL_DETAILS,$username,$id);
			}
			if($result!=0)
				$valid = false;
			else
				$valid = true;
			echo json_encode($valid);
			exit;
		}
	}

	public function manage_surveys()
	{
		$school_id = $_GET['school_id'];
		$school_details = $this->commonModel->Select_Val_Id('go_schools',$school_id);
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_surveys/';
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status >',0)->where('status <',3)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->where('district_id',0)->where('active_status',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_surveys',$data);
	}

	public function documents_timeline()
	{
		$data = $this->commonData('ADMIN');
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->orderBy('district_name','asc')->get()->getResultArray();
		$config['base_url'] = BASE_URL.'admin/principal_apportionment/';
		$this->adminBodyTemplate('adminbody/documents_timeline',$data);
	}

	public function school_lists_not_all()
	{
		$district_id = $this->request->getVar('district_id');
		$schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->orderBy('school_name','asc')->get()->getResultArray();
		$output = '';
		if(!empty($schools))
		{
			$output.= '<option value="">Select School</option>';
			foreach($schools as $school)
			{
				$output.='<option value="'.$school['id'].'">'.$school['school_name'].'</option>';
			}
		}
		else{
			$output.='<option value="">No Schools Found</option>';
		}
		echo $output;
	} 
	public function get_documents_timeline()
	{
		$district = $this->request->getVar('district');
		$school = $this->request->getVar('school');
		$year = $this->request->getVar('year');
		$nxtyear = $year + 1;
		$current_year = $year.'-07-01 00:00:00';
		$next_year = $nxtyear.'-06-30 23:55:00';
		$surveys = $this->db->table('master_templates')->select('*')->where('school_id',$school)->where('status',4)->where('updatetime >=',$current_year)->where('updatetime <=',$next_year)->orderBy('updatetime','asc')->get()->getResultArray();
		
		$output = '<table class="table">
			<thead>
				<th></th>
				<th>Jul</th>
				<th>Aug</th>
				<th>Sep</th>
				<th>Oct</th>
				<th>Nov</th>
				<th>Dec</th>
				<th>Jan</th>
				<th>Feb</th>
				<th>Mar</th>
				<th>Apr</th>
				<th>May</th>
				<th>Jun</th>
			</thead>
			<tbody>
				<tr>
					<td style="vertical-align: middle;">Financial Reports</td>';
					for($i=7; $i<=12; $i++)
					{
						if($i < 10)
						{
							$i = '0'.$i;
						}
						$currentmonthyear = $year.'-'.$i;
						$attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school)->where('type !=',15)->like('updatetime',$currentmonthyear)->get()->getResultArray();
						
						$output.='<td style="border-top: 0px;">';
						if(!empty($attachments))
						{
							foreach($attachments as $attach)
							{
								$pval = '';
								if($attach['type'] == 4) { $pval = 'ANNUAL AUDIT'; }
								elseif($attach['type'] == 1) { $pval = 'P 1'; }
								elseif($attach['type'] == 2) { $pval = 'P 2'; }
								elseif($attach['type'] == 3) { $pval = 'P 3'; }
								elseif($attach['type'] == 5) { $pval = 'REPORT REVIEW'; }
								elseif($attach['type'] == 6) { $pval = 'FCMAT CALCULATOR'; }
								elseif($attach['type'] == 7) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 8) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 9) { $pval = 'Expanded Learning Opportunities Grant Plan'; }
								elseif($attach['type'] == 11) { $pval = 'Annual Adopted Budget'; }
								elseif($attach['type'] == 12) { $pval = 'Unaudited Actuals'; }
								elseif($attach['type'] == 13) { $pval = 'First Interim'; }
								elseif($attach['type'] == 14) { $pval = 'Second Interim'; }
								elseif($attach['type'] == 15) { $pval = 'LCAP'; }
								elseif($attach['type'] == 16) { $pval = 'Third Interim (Annual)'; }
								
								$output.='<h6>'.$pval.'</h6>';
								$explodefile = explode("||",$attach['filename']);
                                $filenme = '';
                                if(!empty($explodefile))
                                {
                                    foreach($explodefile as $exp)
                                    {
                                    	$get_ext = explode('.',$exp);
										$img = BASE_URL.'assets/images/pdf.png';
										if(end($get_ext) == "pdf") { 
											$img = BASE_URL.'assets/images/pdf.png'; 
											$output.='<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
														<img src="'.$img.'" style="width:35px" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
													</a>';
										}
										else{
											if(end($get_ext) == "xls" || end($get_ext) == "xlsx") { $img = BASE_URL.'assets/images/excel.png'; }
											elseif(end($get_ext) == "doc" || end($get_ext) == "docx") { $img = BASE_URL.'assets/images/doc.png'; }
											elseif(end($get_ext) == "jpg" || end($get_ext) == "jpeg" || end($get_ext) == "png" || end($get_ext) == "gif" || end($get_ext) == "svg") { $img = BASE_URL.'assets/images/img.png'; }
											$output.='<a href="'.BASE_URL.$attach['url'].'/'.$exp.'" download>
														<img src="'.$img.'" style="width:35px">
													</a>';
										}
                                    }
                                }
                                else{
									$output.='-';
								}
							}
						}
						else{
							$output.='-';
						}
						$output.='</td>';
					}
					for($j=1; $j<=6; $j++)
					{
						if($j < 10)
						{
							$j = '0'.$j;
						}
						$currentmonthyear = $nxtyear.'-'.$j;
						$attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school)->where('type !=',15)->like('updatetime',$currentmonthyear)->get()->getResultArray();
						
						$output.='<td style="border-top: 0px;">';
						if(!empty($attachments))
						{
							foreach($attachments as $attach)
							{
								$pval = '';
								if($attach['type'] == 4) { $pval = 'ANNUAL AUDIT'; }
								elseif($attach['type'] == 1) { $pval = 'P 1'; }
								elseif($attach['type'] == 2) { $pval = 'P 2'; }
								elseif($attach['type'] == 3) { $pval = 'P 3'; }
								elseif($attach['type'] == 5) { $pval = 'REPORT REVIEW'; }
								elseif($attach['type'] == 6) { $pval = 'FCMAT CALCULATOR'; }
								elseif($attach['type'] == 7) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 8) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 9) { $pval = 'Expanded Learning Opportunities Grant Plan'; }
								elseif($attach['type'] == 11) { $pval = 'Annual Adopted Budget'; }
								elseif($attach['type'] == 12) { $pval = 'Unaudited Actuals'; }
								elseif($attach['type'] == 13) { $pval = 'First Interim'; }
								elseif($attach['type'] == 14) { $pval = 'Second Interim'; }
								elseif($attach['type'] == 15) { $pval = 'LCAP'; }
								elseif($attach['type'] == 16) { $pval = 'Third Interim (Annual)'; }
								$output.='<h6>'.$pval.'</h6>';
								$explodefile = explode("||",$attach['filename']);
                                $filenme = '';
                                if(!empty($explodefile))
                                {
                                    foreach($explodefile as $exp)
                                    {
                                    	$get_ext = explode('.',$exp);
										$img = BASE_URL.'assets/images/pdf.png';
										if(end($get_ext) == "pdf") { 
											$img = BASE_URL.'assets/images/pdf.png'; 
											$output.='<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
														<img src="'.$img.'" style="width:35px" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
													</a>';
										}
										else{
											if(end($get_ext) == "xls" || end($get_ext) == "xlsx") { $img = BASE_URL.'assets/images/excel.png'; }
											elseif(end($get_ext) == "doc" || end($get_ext) == "docx") { $img = BASE_URL.'assets/images/doc.png'; }
											elseif(end($get_ext) == "jpg" || end($get_ext) == "jpeg" || end($get_ext) == "png" || end($get_ext) == "gif" || end($get_ext) == "svg") { $img = BASE_URL.'assets/images/img.png'; }
											$output.='<a href="'.BASE_URL.$attach['url'].'/'.$exp.'" download>
														<img src="'.$img.'" style="width:35px">
													</a>';
										}
                                    }
                                }
                                else{
									$output.='-';
								}
							}
						}
						else{
							$output.='-';
						}
						$output.='</td>';
					}
				$output.='</tr>
				<tr>
					<td>LCAP</td>';
					for($i=7; $i<=12; $i++)
					{
						if($i < 10)
						{
							$i = '0'.$i;
						}
						$currentmonthyear = $year.'-'.$i;
						$attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school)->where('type',15)->like('updatetime',$currentmonthyear)->get()->getResultArray();
						
						$output.='<td style="border-top: 0px;">';
						if(!empty($attachments))
						{
							foreach($attachments as $attach)
							{
								$pval = '';
								if($attach['type'] == 4) { $pval = 'ANNUAL AUDIT'; }
								elseif($attach['type'] == 1) { $pval = 'P 1'; }
								elseif($attach['type'] == 2) { $pval = 'P 2'; }
								elseif($attach['type'] == 3) { $pval = 'P 3'; }
								elseif($attach['type'] == 5) { $pval = 'REPORT REVIEW'; }
								elseif($attach['type'] == 6) { $pval = 'FCMAT CALCULATOR'; }
								elseif($attach['type'] == 7) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 8) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 9) { $pval = 'Expanded Learning Opportunities Grant Plan'; }
								elseif($attach['type'] == 11) { $pval = 'Annual Adopted Budget'; }
								elseif($attach['type'] == 12) { $pval = 'Unaudited Actuals'; }
								elseif($attach['type'] == 13) { $pval = 'First Interim'; }
								elseif($attach['type'] == 14) { $pval = 'Second Interim'; }
								elseif($attach['type'] == 15) { $pval = 'LCAP'; }
								elseif($attach['type'] == 16) { $pval = 'Third Interim (Annual)'; }
								
								$output.='<h6>'.$pval.'</h6>';
								$explodefile = explode("||",$attach['filename']);
                                $filenme = '';
                                if(!empty($explodefile))
                                {
                                    foreach($explodefile as $exp)
                                    {
                                    	$get_ext = explode('.',$exp);
										$img = BASE_URL.'assets/images/pdf.png';
										if(end($get_ext) == "pdf") { 
											$img = BASE_URL.'assets/images/pdf.png'; 
											$output.='<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
														<img src="'.$img.'" style="width:35px" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
													</a>';
										}
										else{
											if(end($get_ext) == "xls" || end($get_ext) == "xlsx") { $img = BASE_URL.'assets/images/excel.png'; }
											elseif(end($get_ext) == "doc" || end($get_ext) == "docx") { $img = BASE_URL.'assets/images/doc.png'; }
											elseif(end($get_ext) == "jpg" || end($get_ext) == "jpeg" || end($get_ext) == "png" || end($get_ext) == "gif" || end($get_ext) == "svg") { $img = BASE_URL.'assets/images/img.png'; }
											$output.='<a href="'.BASE_URL.$attach['url'].'/'.$exp.'" download>
														<img src="'.$img.'" style="width:35px">
													</a>';
										}
                                    }
                                }
                                else{
									$output.='-';
								}
							}
						}
						else{
							$output.='-';
						}
						$output.='</td>';
					}
					for($j=1; $j<=6; $j++)
					{
						if($j < 10)
						{
							$j = '0'.$j;
						}
						$currentmonthyear = $nxtyear.'-'.$j;
						$attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school)->where('type',15)->like('updatetime',$currentmonthyear)->get()->getResultArray();
						
						$output.='<td style="border-top: 0px;">';
						if(!empty($attachments))
						{
							foreach($attachments as $attach)
							{
								$pval = '';
								if($attach['type'] == 4) { $pval = 'ANNUAL AUDIT'; }
								elseif($attach['type'] == 1) { $pval = 'P 1'; }
								elseif($attach['type'] == 2) { $pval = 'P 2'; }
								elseif($attach['type'] == 3) { $pval = 'P 3'; }
								elseif($attach['type'] == 5) { $pval = 'REPORT REVIEW'; }
								elseif($attach['type'] == 6) { $pval = 'FCMAT CALCULATOR'; }
								elseif($attach['type'] == 7) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 8) { $pval = 'Misc Report'; }
								elseif($attach['type'] == 9) { $pval = 'Expanded Learning Opportunities Grant Plan'; }
								elseif($attach['type'] == 11) { $pval = 'Annual Adopted Budget'; }
								elseif($attach['type'] == 12) { $pval = 'Unaudited Actuals'; }
								elseif($attach['type'] == 13) { $pval = 'First Interim'; }
								elseif($attach['type'] == 14) { $pval = 'Second Interim'; }
								elseif($attach['type'] == 15) { $pval = 'LCAP'; }
								elseif($attach['type'] == 16) { $pval = 'Third Interim (Annual)'; }
								$output.='<h6>'.$pval.'</h6>';
								$explodefile = explode("||",$attach['filename']);
                                $filenme = '';
                                if(!empty($explodefile))
                                {
                                    foreach($explodefile as $exp)
                                    {
                                    	$get_ext = explode('.',$exp);
										$img = BASE_URL.'assets/images/pdf.png';
										if(end($get_ext) == "pdf") { 
											$img = BASE_URL.'assets/images/pdf.png'; 
											$output.='<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
														<img src="'.$img.'" style="width:35px" data-src="'.$attach['url'].'/'.$exp.'" class="view_pdf">
													</a>';
										}
										else{
											if(end($get_ext) == "xls" || end($get_ext) == "xlsx") { $img = BASE_URL.'assets/images/excel.png'; }
											elseif(end($get_ext) == "doc" || end($get_ext) == "docx") { $img = BASE_URL.'assets/images/doc.png'; }
											elseif(end($get_ext) == "jpg" || end($get_ext) == "jpeg" || end($get_ext) == "png" || end($get_ext) == "gif" || end($get_ext) == "svg") { $img = BASE_URL.'assets/images/img.png'; }
											$output.='<a href="'.BASE_URL.$attach['url'].'/'.$exp.'" download>
														<img src="'.$img.'" style="width:35px">
													</a>';
										}
                                    }
                                }
                                else{
									$output.='-';
								}
							}
						}
						else{
							$output.='-';
						}
						$output.='</td>';
					}
				$output.='</tr>
				<tr>
					<td>Self Study Survey</td>';
					for($i=7; $i<=12; $i++)
					{
						if($i < 10)
						{
							$i = '0'.$i;
						}
						$currentmonthyear = $year.'-'.$i;
						$surveys = $this->db->table('master_templates')->select('*')->where('school_id',$school)->where('status',4)->like('updatetime',$currentmonthyear)->get()->getResultArray();
						$output.='<td>';
						if(!empty($surveys))
						{
							foreach($surveys as $survey)
							{
								$output.='<h6>'.$survey['template_name'].'</h6>';
								$output.='<a href="javascript:" class="download_full_survey" data-element="'.$survey['id'].'">
											<img src="'.BASE_URL.'assets/images/pdf.png'.'" class="download_full_survey" data-element="'.$survey['id'].'" style="width:35px">
										</a>';
							}
						}
						else{
							$output.='-';
						}
						$output.='</td>';
					}
					for($j=1; $j<=6; $j++)
					{
						if($j < 10)
						{
							$j = '0'.$j;
						}
						$currentmonthyear = $nxtyear.'-'.$j;
						$surveys = $this->db->table('master_templates')->select('*')->where('school_id',$school)->where('status',4)->like('updatetime',$currentmonthyear)->get()->getResultArray();
						$output.='<td>';
						if(!empty($surveys))
						{
							foreach($surveys as $survey)
							{
								$output.='<h6>'.$survey['template_name'].'</h6>';
								$output.='<a href="javascript:" class="download_full_survey" data-element="'.$survey['id'].'">
											<img src="'.BASE_URL.'assets/images/pdf.png'.'" class="download_full_survey" data-element="'.$survey['id'].'" style="width:35px">
										</a>';
							}
						}
						else{
							$output.='-';
						}
						$output.='</td>';
					}
				$output.='</tr>
			</tbody>
		</table>';
		$school_details = $this->commonModel->Select_Val_Id('go_schools',$school);
		if($school_details['charter_school_petition'] != "")
		{
			$charter_petition = 'uploads/school_notes/'.$school_details['charter_school_petition'];
		}
		else{
			$charter_petition = '';
		}
		if($school_details['charter_school_mou'] != "")
		{
			$mou = 'uploads/school_notes/'.$school_details['charter_school_mou'];
		}
		else{
			$mou = '';
		}
		echo json_encode(array("output" => $output,"charter_petition" => $charter_petition,"mou" => $mou));
	}

	public function manage_templates()
	{
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_templates/';
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->where('district_id',0)->where('active_status',0)->get()->getResultArray();
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->where('district_id',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_templates',$data);
	}
	
}
