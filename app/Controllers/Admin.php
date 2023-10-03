<?php

namespace App\Controllers;
use Mpdf\Mpdf;

class Admin extends BaseController
{
    public function __construct()
    {
	   $this->is_session_available();
    }
    public function index()
    {
        $data = $this->commonData(lang('Admin.admin_dashboard'));        
        $data['district_count']=$this->adminModel->getDistrictCount();
        $data['schools_count']=$this->adminModel->getSchoolsCount();
        $data['template_count']=$this->adminModel->getTemplateCount();
        $data['survey_count']=$this->adminModel->getSurveysCount();
        $data['report_count']=$this->adminModel->getReportCount();
		return $this->adminBodyTemplate('adminbody/dashboard', $data);
    }
	public function admin_setting()
	{
		$data = $this->commonData();        
		if($this->request->getVar('namesetting'))
		{
			$rules=[
                'username'=> ['label' => 'Username', 'rules' => 'required'],
                'adminemail'=> ['label' => 'Email', 'rules' => 'required'],
            ];
			
            if ($this->validate($rules)) {
			
					$userid = $this->session->get('gowriteadmin_Userid');
					$inputData['username']      = trim($this->request->getVar('username'));
					$inputData['email']= trim($this->request->getVar('adminemail'));
					if($_FILES['adminimage']['name']!='')
					{
						$name = $_FILES['adminimage']['name'];
						$tmp_name = $_FILES['adminimage']['tmp_name'];
						$upload_dir = UPLOAD_PROFILEPICS.'admin/';
						$inputData['image'] = $name;
						move_uploaded_file($tmp_name,$upload_dir.$name);
					}
					$result = $this->commonModel->Update_Values(ADMIN_DETAILS,$inputData,$userid);
					session()->setFlashdata('notif_success', lang('Admin.admin_name_settings_updated'));
					return $this->response->redirect(site_url('admin/admin_setting'));
			}
			else{
				$data['selectval']=$this->request->getVar();
			}
		}
		if($this->request->getVar('passwordsetting'))
		{
			$rules=[
                'newpassword'=> ['label' => 'New Password', 'rules' => 'required'],
                'confirmpassword'=> ['label' => 'Confirm Password', 'rules' => 'required'],
            ];
			if ($this->validate($rules))
			{
					$userid = $this->session->get('gowriteadmin_Userid');
					$inputData['password']= password_hash(trim($this->request->getVar('newpassword')), PASSWORD_DEFAULT);
					$result = $this->commonModel->Update_Values(ADMIN_DETAILS,$inputData,$userid);
					session()->setFlashdata('notif_success', lang('Admin.admin_password_settings_updated'));
					return $this->response->redirect(site_url('admin/admin_setting'));
					
			}
			else{
				$data['selectval']=$this->request->getVar();
			}
		}
		if($this->request->getVar('sitesetting'))
		{
			$rules=[
                'sitetitle'=> ['label' => 'Sitetitle', 'rules' => 'required'],
                'youtube'=> ['label' => 'Youtube', 'rules' => 'required'],
                'facebook'=> ['label' => 'Facebook', 'rules' => 'required'],
                'twitter'=> ['label' => 'Twitter', 'rules' => 'required'],
                'linkedin'=> ['label' => 'Linkedin', 'rules' => 'required'],
                'googleplus'=> ['label' => 'Googleplus', 'rules' => 'required'],
            ];
			if ($this->validate($rules))
			{
				$userid = $this->session->get('gowriteadmin_Userid');
				$inputData['sitetitle']= $this->request->getVar('sitetitle');
				$inputData['youtube']= $this->request->getVar('youtube');
				$inputData['facebook']= $this->request->getVar('facebook');
				$inputData['twitter']= $this->request->getVar('twitter');
				$inputData['linkedin']= $this->request->getVar('linkedin');
				$inputData['googleplus']= $this->request->getVar('googleplus');
				$result = $this->commonModel->Update_Values(ADMIN_DETAILS,$inputData,$userid);
				session()->setFlashdata('notif_success', lang('Admin.admin_site_settings_updated'));
				return $this->response->redirect(site_url('admin/admin_setting'));
			}
			else{
				$data['selectval']=$this->request->getPost();
			}
		}
		$data['validation'] = $this->validation;
		$data['title'] = lang('Admin.admin_settings_title');
		$data['admin_id']= session()->get('gowriteadmin_Userid');
		$data['selectval'] = $this->commonModel->Select_Val_Id(ADMIN_DETAILS,$data['admin_id']);
		$this->adminBodyTemplate('adminbody/admin_settings',$data);
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
				if(strlen($this->request->getVar('password'))!=60){
					$input['password']          = password_hash(trim($this->request->getVar('password')), PASSWORD_DEFAULT);
				}
                
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

	public function delete_school($id = '')
	{
		$school = $this->commonModel->Select_Val_Id('go_schools',$id);
		if(!empty($school))
		{
			$district_id = $school['district_id'];
			$get_templates = $this->db->table('master_templates')->select('*')->where('school_id',$school['id'])->get()->getResultArray();
			if(!empty($get_templates))
			{
				foreach($get_templates as $template)
				{
					$this->commonModel->Delete_Values('master_templates',$template['id']);
					$this->commonModel->Delete_Related_Values('template_forms','template_id',$template['id']);
				}
			}
			$this->commonModel->Delete_Values('go_schools',$id);
			session()->setFlashdata('notif_success', 'School Deleted Successfully');
			return $this->response->redirect(site_url('admin/manage_schools?district_id='.$district_id));
		}
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
					if(strlen($this->request->getVar('password'))!=60){
						$input['password']          = password_hash(trim($this->request->getVar('password')), PASSWORD_DEFAULT);
					}
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
		$school_id = isset($_GET['school_id'])?$_GET['school_id']:0;
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
	public function update_principal_apportionment()
	{
		$type = $this->request->getVar('hidden_type');
		$upload_dir = 'uploads/admin';
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir);
		}
		$upload_dir = $upload_dir.'/'.time();
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir);
		}
		$total = count($_FILES['file']['name']);
		$fname = '';
		for($i=0;$i < $total;$i++) {
			$filename = $_FILES['file']['name'][$i];
			$tmp_name = $_FILES['file']['tmp_name'][$i];
			move_uploaded_file($tmp_name,$upload_dir.'/'.$filename);
			if($fname == "")
			{
				$fname = $filename;
			}
			else{
				$fname = $fname.'||'.$filename;
			}
		}
		if($type == "11") { $typeval = 'Annual Adopted Budget'; }
        elseif($type == "12") { $typeval = 'Unaudited Actuals'; }
        elseif($type == "13") { $typeval = 'First Interim'; }
        elseif($type == "14") { $typeval = 'Second Interim'; }
        elseif($type == "15") { $typeval = 'LCAP'; }
        elseif($type == "16") { $typeval = 'Third Interim (Annual)'; }
        elseif($type == "1") { $typeval = 'Principal attach (P 1)'; }
		elseif($type == "2") { $typeval = 'Principal attach (P 2)'; }
		elseif($type == "3") { $typeval = 'Principal attach (P 3)'; }
		elseif($type == "4") { $typeval = 'Annual Audit'; }
		elseif($type == "5") { $typeval = 'Report Review'; }
		elseif($type == "6") { $typeval = 'FCMAT Calculator'; }
		elseif($type == "7") { $typeval = 'Misc'; }
		elseif($type == "8") { $typeval = 'Misc'; }
		elseif($type == "9") { $typeval = 'Expanded Learning Opportunities Grant Plan'; }
        else { $typeval = ''; }

		$inputData['url'] = $upload_dir;
		$inputData['filename'] = $fname;
		$inputData['type'] = $type;
		$schools = $this->request->getVar('school_select');
		if(!empty($schools))
		{
			foreach($schools as $school)
			{
				$school_details = $this->commonModel->Select_Val_Id('go_schools',$school);
				$inputData['district_id'] = $school_details['district_id'];
				$inputData['school_id'] = $school;
				$lastinsertId = $this->commonModel->Insert_Values('principal_attachments',$inputData);
				$task_id = $lastinsertId;		

				$report = $this->commonModel->Select_Val_Id('principal_attachments',$task_id);
				$datanotify['report_id'] = $task_id;
				$datanotify['message'] = '<p>'.$typeval.' Report has been submitted from Super Admin</p>';
				$datanotify['type'] = 1;
				$datanotify['created_by'] = 1;
				$datanotify['user_id'] = 1;
				$datanotify['admin'] = 0;
				$datanotify['district_id'] = $school_details['district_id'];
				$datanotify['school_id'] = $school;
				$datanotify['status'] = 0;
				$datanotify['district_status'] = 1;
				$datanotify['school_status'] = 1;
				$this->commonModel->Insert_Values('notifications',$datanotify);
				$district_subject = $typeval.' Report has been submitted from Super Admin';
				$school_subject = $typeval.' Report has been submitted from Super Admin';

				$district_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">The '.$typeval.' has been uploaded by Super Admin for the school '.$school_details['school_name'].'. Please login to the CSOS website to view the submitted Report.</p>';
				$school_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">The '.$typeval.' has been uploaded by Super Admin for your School. Please login to the CSOS website to view the submitted Report.</p>';
				$this->send_email_to_district_school($school_details['district_id'],$school,$district_subject,$school_subject,$district_message,$school_message);
			}
		}
		session()->setFlashdata('notif_success', 'File Attached Successfully');
		return $this->response->redirect(site_url('admin/principal_apportionment?type='.$type.''));
	}
	public function change_date_report()
	{
		$id = $this->request->getVar('id');
		$dateexp = explode('/',$this->request->getVar('date'));
		$date = $dateexp[2].'-'.$dateexp[0].'-'.$dateexp[1];
		$type = $this->request->getVar('type');
		$data['updatetime'] = $date.' 00:00:00';
		if($type == "1")
		{
			$this->commonModel->Update_Values('reports',$data,$id);
		}
		else{
			$this->commonModel->Update_Values('principal_attachments',$data,$id);
		}
	}
	public function manage_templates()
	{
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_templates/';
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->where('district_id',0)->where('active_status',0)->get()->getResultArray();
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->where('district_id',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_templates',$data);
	}
	public function addtemplate($template_id = '')
	{
		$data = $this->commonData();
		if($template_id!='')
		{
		$data['title'] = 'Edit Master Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('master_templates',$template_id);
		}
		else
		{
		$data['title'] = 'Add Master Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $template_id;
		$this->adminBodyTemplate('adminbody/addtemplate',$data);
	}

	public function addtemplate_step2($template_id = '')
	{
		$data = $this->commonData();
		$data['title'] = 'Edit Master Template Step 2';
		$data['addendum']=$this->commonModel->Select_Val_Id('master_templates',$template_id);
		$data['template_id']= $template_id;
		$this->adminBodyTemplate('adminbody/addtemplate_step2',$data);
	}
	public function addtemplate_step3($template_id = '')
	{
		$data = $this->commonData();
		$data['title'] = 'Edit Master Template Step 2';
		$data['forms']=$this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
		$data['template_id']= $template_id;
		$data['templates'] = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		$this->adminBodyTemplate('adminbody/addtemplate_step3',$data);
	}

	public function save_template_content()
	{
		$template_name = $this->request->getVar('template_name');
		$content_title = $this->request->getVar('content_title');
		$template_id = $this->request->getVar('hidden_template_id');
		$school_id = $this->request->getVar('hidden_school_id');
		$district_id = $this->request->getVar('hidden_district_id');
		if(count($content_title))
		{
			foreach($content_title as $key => $title)
			{
				$count = $key+1;
				if($title != "")
				{
					$data[$title] = $this->request->getVar('editor_'.$count);
				}
			}
		}
		$serialize = serialize($data);
		if($template_id == "")
		{
			$dataval['district_id'] = $district_id;
			$dataval['school_id'] = $school_id;
			$dataval['template_name'] = $template_name;
			$dataval['content'] = $serialize;
			$dataval['active_page'] = 2;
			$resultadmin = $this->commonModel->Insert_Values('master_templates',$dataval);
			$id = $resultadmin;
			return $this->response->redirect(site_url("admin/addtemplate_step2/".$id));
		}
		else{
			$dataval['district_id'] = $district_id;
			$dataval['school_id'] = $school_id;
			$dataval['template_name'] = $template_name;
			$dataval['content'] = $serialize;
			$dataval['active_page'] = 2;
			$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
			return $this->response->redirect(site_url("admin/addtemplate_step2/".$template_id));
		}			
	}
	public function save_template_content_step2()
	{
		$template_id = $this->request->getVar('hidden_template_id');
		$data['addendum_title'] = $this->request->getVar('addendum_title');
		$data['school_information'] = $this->request->getVar('school_information');
		$data['school_name_title'] = $this->request->getVar('school_name_title');
		$data['school_name'] = $this->request->getVar('school_name');
		$data['location_title'] = $this->request->getVar('location_title');
		$data['location'] = $this->request->getVar('location');
		$data['contact_title'] = $this->request->getVar('contact_title');
		$data['contact_name'] = $this->request->getVar('contact_name');
		$data['home_address_title'] = $this->request->getVar('home_address_title');
		$data['home_address'] = $this->request->getVar('home_address');
		$data['email_title'] = $this->request->getVar('email_title');
		$data['email_address'] = $this->request->getVar('email_address');
		$data['phone_title'] = $this->request->getVar('phone_title');
		$data['phone'] = $this->request->getVar('phone');
		$data['school_phone_title'] = $this->request->getVar('school_phone_title');
		$data['school_phone'] = $this->request->getVar('school_phone');
		$data['fax_title'] = $this->request->getVar('fax_title');
		$data['fax'] = $this->request->getVar('fax');
		$serialize = serialize($data);
		$dataval['addendum'] = $serialize;
		$dataval['active_page'] = 3;
		$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
		return $this->response->redirect(site_url("admin/addtemplate_step3/".$template_id));
				
	}
	public function save_template_content_step3()
	{
		$template_id = $this->request->getVar('hidden_template_id');
		$check_title = $this->request->getVar('check_title');
		$attachment = $this->request->getVar('attachment');
		$section = $this->request->getVar('section');
		$strong = $this->request->getVar('strong');
		$sufficient = $this->request->getVar('sufficient');
		$insufficient = $this->request->getVar('insufficient');
		$na = $this->request->getVar('na');
		$legend = $this->request->getVar('editor_1');
		$priority = $this->request->getVar('priority');
		
		
		$this->commonModel->Delete_Related_Values('template_forms','template_id',$template_id);
		if(count($check_title))
		{
			$sub_id = 0;
			$key_summary = 0;
			foreach($check_title as $key => $check)
			{
				if($check == 2)
				{
					$datatemplate['template_id'] = $template_id;
					$datatemplate['attachment'] = 0;
					$datatemplate['sub_id'] = 0;
					$datatemplate['section'] = $section[$key];
					$datatemplate['strong'] = $strong[$key];
					$datatemplate['sufficient'] = $sufficient[$key];
					$datatemplate['insufficient'] = $insufficient[$key];
					$datatemplate['na'] = $na[$key];
					$datatemplate['set_title'] = 2;
					$datatemplate['priority'] = 0;
					// $datatemplate['summary'] = $summary[$key_summary];
					$lastinsertId = $this->commonModel->Insert_Values('template_forms',$datatemplate);
					$sub_id = $lastinsertId;
					$key_summary++;
				}
				elseif($check == 1){
					$datatemplate['template_id'] = $template_id;
					$datatemplate['attachment'] = 0;
					$datatemplate['sub_id'] = $sub_id;
					$datatemplate['section'] = $section[$key];
					$datatemplate['strong'] = $strong[$key];
					$datatemplate['sufficient'] = $sufficient[$key];
					$datatemplate['insufficient'] = $insufficient[$key];
					$datatemplate['na'] = $na[$key];
					$datatemplate['set_title'] = 1;
					$datatemplate['priority'] = 0;
					// $datatemplate['summary'] = '';
					$this->commonModel->Insert_Values('template_forms',$datatemplate);
				}
				else{
					$datatemplate['template_id'] = $template_id;
					$datatemplate['attachment'] = $attachment[$key];
					$datatemplate['sub_id'] = $sub_id;
					$datatemplate['section'] = $section[$key];
					$datatemplate['strong'] = $strong[$key];
					$datatemplate['sufficient'] = $sufficient[$key];
					$datatemplate['insufficient'] = $insufficient[$key];
					$datatemplate['na'] = $na[$key];
					$datatemplate['set_title'] = 0;
					$datatemplate['priority'] = ($priority[$key])?$priority[$key]:0;
					// $datatemplate['summary'] = '';
					$this->commonModel->Insert_Values('template_forms',$datatemplate);
				}
			}
		}
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		$school_details = $this->commonModel->Select_Val_Id('go_schools',$template_details['school_id']);
		$district_details = $this->commonModel->Select_Val_Id('go_district_admin',isset($school_details['district_id'])?$school_details['district_id']:0);
		if($template_details['school_id'] != '0')
		{
			if($district_details['allow_discreation'] == 1)
			{
				$dataval['district_status'] = 0;
				$dataval['status'] = 1;
			}
			else{
				$dataval['district_status'] = 1;
				$dataval['status'] = 2;
			}
		}
		else{
			$dataval['district_status'] = 0;
			$dataval['status'] = 1;
		}
		
		$dataval['active_page'] = 3;
		$dataval['legend'] = $legend;
		$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		if($template_details['school_id'] != '0')
		{
			$school_details = $this->db->table('go_schools')->select('*')->where('id',$template_details['school_id'])->get()->getResultArray();
			if(!empty($school_details))
			{
				$district_id = $school_details['district_id'];
				$district_details = $this->db->table('go_district_admin')->select('*')->where('id',$district_id)->get()->getResultArray();
				$district_email = $district_details['email'];
				$adminemail = 'info@csos.com';
				$contactsubject = 'New Survey Created By Admin';
				
				$contactmsg = '<!DOCTYPE HTML>'.
				'<head>'.
				'<meta http-equiv="content-type" content="text/html">'.
				'<title>Email notification</title>'.
				'</head>'.
				'<body>'.
				'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.
					   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'.
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><b>Dear '.$district_details['fullname'].',</b></p>'.
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">The Charter School Oversight Survey has been created by Super Admin. Please login to the CSOS website to set discretionary for each Survey question and send it to the respective Charter School Admin to complete the Survey.</p>'.
							
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Completed Survey was sent on '.date('l jS \of F Y h:i:s A').'</p>'.
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Sincerely,<br/>CSOS Team<br/>'.
					   '</div>'.
				'</div>'.
				'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #ffcd44; color:#fff;">'.
					'All rights reserved @ csos - '.date('Y').''.
				'</div>'.
				'</body>';
				$contactheaders  = "From: ".$adminemail."\r\n";
				$contactheaders .= "Reply-To: ".$adminemail."\r\n";
				$contactheaders .= "MIME-Version: 1.0\r\n";
				$contactheaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($district_email, $contactsubject, $contactmsg, $contactheaders);
			}
			session()->setFlashdata('notif_success', 'Survey Created Successfully');
			return $this->response->redirect(site_url("admin/manage_surveys?school_id=".$template_details['school_id']));
		}
		elseif($template_details['district_id'] != '0')
		{
			session()->setFlashdata('notif_success', 'Template Created Successfully');
			return $this->response->redirect(site_url("admin/manage_district_surveys?district_id=".$template_details['district_id']));
		}
		else
		{
			session()->setFlashdata('notif_success', 'Template Created Successfully');
			return $this->response->redirect(site_url("admin/manage_templates"));
		}	
	}

	public function ajax_create_master_template()
	{
		parse_str($_POST['formdatas'], $searcharray);
		$count = $this->request->getVar('count_editor');
		$template_id = $this->request->getVar('template_id');
		if($count > 0)
		{
			for($i=1; $i<= $count; $i++)
			{
				$title_key = $i - 1;
				$title = $searcharray['content_title'];
				$titleval = $title[$title_key];
				$data[$titleval] = $searcharray['editor_'.$i];
			}
			$serialize = serialize($data);
			if($template_id == "")
			{
				$dataval['school_id'] = $searcharray['hidden_school_id'];
				$dataval['template_name'] = $this->request->getVar('template_name');
				$dataval['content'] = $serialize;
				$dataval['active_page'] = 1;
				$lastinsertId = $this->commonModel->Insert_Values('master_templates',$dataval);
				echo $lastinsertId;
			}
			else{
				$dataval['school_id'] = $searcharray['hidden_school_id'];
				$dataval['template_name'] = $this->request->getVar('template_name');
				$dataval['content'] = $serialize;
				$dataval['active_page'] = 1;
				$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
				echo $template_id;
			}
		}
		
	}
	public function ajax_create_master_template_step2()
	{
		parse_str($_POST['formdatas'], $searcharray);
		$template_id = $searcharray['hidden_template_id'];
		$data['addendum_title'] = $searcharray['addendum_title'];
		$data['school_information'] = $searcharray['school_information'];
		$data['school_name_title'] = $searcharray['school_name_title'];
		$data['school_name'] = $searcharray['school_name'];
		$data['location_title'] = $searcharray['location_title'];
		$data['location'] = $searcharray['location'];
		$data['contact_title'] = $searcharray['contact_title'];
		$data['contact_name'] = $searcharray['contact_name'];
		$data['home_address_title'] = $searcharray['home_address_title'];
		$data['home_address'] = $searcharray['home_address'];
		$data['email_title'] = $searcharray['email_title'];
		$data['email_address'] = $searcharray['email_address'];
		$data['phone_title'] = $searcharray['phone_title'];
		$data['phone'] = $searcharray['phone'];
		$data['school_phone_title'] = $searcharray['school_phone_title'];
		$data['school_phone'] = $searcharray['school_phone'];
		$data['fax_title'] = $searcharray['fax_title'];
		$data['fax'] = $searcharray['fax'];
		$serialize = serialize($data);
		$dataval['addendum'] = $serialize;
		$dataval['active_page'] = 2;
		$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
	}
	public function ajax_create_master_template_step3()
	{
		parse_str($_POST['formdatas'], $searcharray);
		$template_id = $searcharray['hidden_template_id'];
		$check_title = $searcharray['check_title'];
		$section = $searcharray['section'];
		$strong = $searcharray['strong'];
		$sufficient = $searcharray['sufficient'];
		$insufficient = $searcharray['insufficient'];
		$na = $searcharray['na'];
		$legend = $searcharray['editor_1'];
		$this->commonModel->Delete_Related_Values('template_forms','template_id',$template_id);
		if(count($check_title))
		{
			$sub_id = 0;
			$key_summary = 0;
			foreach($check_title as $key => $check)
			{
				if($check == 2)
				{
					$datatemplate['template_id'] = $template_id;
					$datatemplate['sub_id'] = 0;
					$datatemplate['section'] = $section[$key];
					$datatemplate['strong'] = $strong[$key];
					$datatemplate['sufficient'] = $sufficient[$key];
					$datatemplate['insufficient'] = $insufficient[$key];
					$datatemplate['na'] = $na[$key];
					$datatemplate['set_title'] = 2;
					$lastinsertId = $this->commonModel->Insert_Values('template_forms',$datatemplate);
					$sub_id = $lastinsertId;
					$key_summary++;
				}
				elseif($check == 1){
					$datatemplate['template_id'] = $template_id;
					$datatemplate['sub_id'] = $sub_id;
					$datatemplate['section'] = $section[$key];
					$datatemplate['strong'] = $strong[$key];
					$datatemplate['sufficient'] = $sufficient[$key];
					$datatemplate['insufficient'] = $insufficient[$key];
					$datatemplate['na'] = $na[$key];
					$datatemplate['set_title'] = 1;
					$this->commonModel->Insert_Values('template_forms',$datatemplate);
				}
				else{
					$datatemplate['template_id'] = $template_id;
					$datatemplate['sub_id'] = $sub_id;
					$datatemplate['section'] = $section[$key];
					$datatemplate['strong'] = $strong[$key];
					$datatemplate['sufficient'] = $sufficient[$key];
					$datatemplate['insufficient'] = $insufficient[$key];
					$datatemplate['na'] = $na[$key];
					$datatemplate['set_title'] = 0;
					$this->commonModel->Insert_Values('template_forms',$datatemplate);
				}
			}
		}
		$dataval['active_page'] = 3;
		$dataval['legend'] = $legend;
		$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
	}

	public function activate_templates($id = '')
	{
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$id);
		$data['active_status'] = $_GET['status'];
		$this->commonModel->Update_Values('master_templates',$data,$id);
		if($template_details['district_id'] == 0)
		{
			session()->setFlashdata('notif_success', 'Template Activated Successfully');
			return $this->response->redirect(site_url('admin/manage_templates'));
		}
		else{
			session()->setFlashdata('notif_success', 'Template Activated Successfully');
			return $this->response->redirect(site_url('admin/manage_district_surveys?district_id='.$template_details['district_id']));
		}
		
	}
	public function deactivate_templates($id = '')
	{
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$id);
		$data['active_status'] = $_GET['status'];
		$this->commonModel->Update_Values('master_templates',$data,$id);
		if($template_details['district_id'] == 0)
		{
			session()->setFlashdata('notif_success', 'Template Deactivated Successfully');
			return $this->response->redirect(site_url('admin/manage_templates'));
		}
		else{
			session()->setFlashdata('notif_success', 'Template Deactivated Successfully');
			return $this->response->redirect(site_url('admin/manage_district_surveys?district_id='.$template_details['district_id']));
		}
	}
	public function take_a_copy_master_template()
	{
		$template_id = $this->request->getVar('template_id');
		$school_id = 0;
		$district_id = 0;
		$sub_id=0;
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		$forms = $this->db->table('template_forms')->select('*')->where('template_id',$template_id)->get()->getResultArray();
		if(count($template_details))
		{
			$data['template_name'] = $template_details['template_name'];
			$data['district_id'] = $district_id;
			$data['school_id'] = $school_id;
			$data['content'] = $template_details['content'];
			$data['addendum'] = $template_details['addendum'];
			$data['forms'] = $template_details['forms'];
			$data['legend'] = $template_details['legend'];
			$data['status'] = 0;
			$data['active_page'] = 0;
			$lastinsertId = $this->commonModel->Insert_Values('master_templates',$data);
			$new_id = $lastinsertId;
			if(count($forms))
			{
				foreach($forms as $form)
				{
					if($form['set_title'] == 2)
					{
						$datatemplate['template_id'] = $new_id;
						$datatemplate['sub_id'] = 0;
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['section'] = $form['section'];
						$datatemplate['strong'] = $form['strong'];
						$datatemplate['sufficient'] = $form['sufficient'];
						$datatemplate['insufficient'] = $form['insufficient'];
						$datatemplate['na'] = $form['na'];
						$datatemplate['set_title'] = 2;
						$datatemplate['priority'] = 0;
						$datatemplate['summary'] = $form['summary'];
						$lastinsertId = $this->commonModel->Insert_Values('template_forms',$datatemplate);
						$sub_id = $lastinsertId;
					}
					elseif($form['set_title'] == 1){
						$datatemplate['template_id'] = $new_id;
						$datatemplate['sub_id'] = $sub_id;
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['section'] = $form['section'];
						$datatemplate['strong'] = $form['strong'];
						$datatemplate['sufficient'] = $form['sufficient'];
						$datatemplate['insufficient'] = $form['insufficient'];
						$datatemplate['na'] = $form['na'];
						$datatemplate['set_title'] = 1;
						$datatemplate['priority'] = 0;
						$datatemplate['summary'] = '';
						$this->commonModel->Insert_Values('template_forms',$datatemplate);
					}
					else{
						$datatemplate['template_id'] = $new_id;
						$datatemplate['sub_id'] = $sub_id;
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['section'] = $form['section'];
						$datatemplate['strong'] = $form['strong'];
						$datatemplate['sufficient'] = $form['sufficient'];
						$datatemplate['insufficient'] = $form['insufficient'];
						$datatemplate['na'] = $form['na'];
						$datatemplate['set_title'] = 0;
						$datatemplate['priority'] = $form['priority'];
						$datatemplate['summary'] = '';
						$this->commonModel->Insert_Values('template_forms',$datatemplate);
					}
				}
			}
			echo $new_id;
		}
	}
	public function delete_templates($id = '')
	{
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$id);
		$this->commonModel->Delete_Values('master_templates',$id);
		$this->commonModel->Delete_Related_Values('template_forms','template_id',$id);
		if($template_details['district_id'] == 0)
		{
			session()->setFlashdata('notif_success', 'Template Deleted Successfully');
			return $this->response->redirect(site_url('admin/manage_templates'));
		}
		else{
			session()->setFlashdata('notif_success', 'Template Deleted Successfully');
			return $this->response->redirect(site_url('admin/manage_district_surveys?district_id='.$template_details['district_id']));
		}
	}
	public function manage_full_surveys()
	{
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_full_surveys/';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->where('status >',0)->where('status <',3)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->where('district_id',0)->where('active_status',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_full_surveys',$data);
	}

	public function manage_full_submitted_surveys()
	{
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_full_surveys/';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->where('status',3)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_full_submitted_surveys',$data);
	}
	public function manage_full_reviewed_surveys()
	{
		$data = $this->commonData('ADMIN');
		$config['base_url'] = BASE_URL.'admin/manage_full_surveys/';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->where('status',4)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_full_reviewed_surveys',$data);
	}

	public function school_lists()
	{
		$district_id = $this->request->getVar('district_id');
		$schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->orderBy('school_name','asc')->get()->getResultArray();
		$output = '';
		if(!empty($schools))
		{
			$output.= '<option value="">Select School</option>
			<option value="all">All Schools</option>';
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
	
	public function get_school_full_surveys()
	{
		$school_id = $this->request->getVar('school_id');
		$type = $this->request->getVar('type');
		if($type == "1")
		{
			if($school_id == "all")
			{
				$select_templates = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->where('status >',0)->where('status <',3)->get()->getResultArray();
			}
			else{
				$select_templates = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status >',0)->where('status <',3)->get()->getResultArray();
			}
		}
		elseif($type == "2")
		{
			if($school_id == "all")
			{
				$select_templates = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->where('status',3)->get()->getResultArray();
			}
			else{
				$select_templates = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',3)->get()->getResultArray();
			}
		}
		elseif($type == "3")
		{
			if($school_id == "all")
			{
				$select_templates = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->where('status',4)->get()->getResultArray();
			}
			else{
				$select_templates = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',4)->get()->getResultArray();
			}
		}
		$output = '';
		if(!empty($select_templates)){
			$i = 1;
			foreach($select_templates as $template)
			{
				$school_details = $this->commonModel->Select_Val_Id('go_schools',$template['school_id']);
				$output.='<tr>
					<td>'.$i.'</td>
					<td>'.$template['template_name'].'</td>
					<td>'.$school_details['school_name'].'</td>
					<td>';
						if($template['status'] == 0){
							$output.='<h6>In Progress</h6>';
						}
						elseif($template['status'] == 1){
							$output.='<h6>Waiting for District admin to set the Priority order.</h6>';
						}
						elseif($template['status'] == 2){
							$output.='<h6>Priority set successfully, awaiting school admin to complete survey and return.</h6>';
						}
						elseif($template['status'] == 3){
							$output.='<h6>Submitted But Not Reviewed.</h6>';
						}
						else{
							$output.='<h6>Reviewed Successfully.</h6>';
						}

					$district_id =  isset($_GET['district_id'])?$_GET['district_id']:0;	
					$school_id =  isset($_GET['school_id'])?$_GET['school_id']:0;	
					$output.='</td>
					
					<td>
						<a href="'.BASE_URL.'admin/addtemplate/'.$template['id'].'?school_id='.$template['school_id'].'" class="fa fa-pencil" title="Edit Master Template" style="font-size:23px"></a>
						<a href="'.BASE_URL.'admin/delete_survey/'.$template['id']."?district_id=".$district_id."&school_id=".$school_id.'" class="fa fa-trash delete_survey" title="Delete Survey" style="font-size:23px"></a>
						</td>
					</tr>';
				$i++;
			}
		}
		else{
			$output.='<tr><td colspan="5">No Data Found</td></tr>';
		}
		echo $output;
	}
	public function add_submitted_template($template_id = '')
	{
		$data = $this->commonData();
		if($template_id!='')
		{
		$data['title'] = 'Edit Master Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('master_templates',$template_id);
		}
		else
		{
		$data['title'] = 'Add Master Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $template_id;
		$this->adminBodyTemplate('adminbody/add_submitted_template',$data);
	}
	public function save_template_content_submitted()
	{
		$template_id = $this->request->getVar('hidden_template_id');
		return $this->response->redirect(site_url("admin/add_submitted_template_step2/".$template_id));
	}
	public function save_template_content_step2_submitted()
	{
		$template_id = $this->request->getVar('hidden_template_id');
		return $this->response->redirect(site_url("admin/add_submitted_template_step3/".$template_id));
	}
	public function add_submitted_template_step2($template_id = '')
	{
		$data = $this->commonData();
		$data['title'] = 'Edit Master Template Step 2';
		$data['addendum']=$this->commonModel->Select_Val_Id('master_templates',$template_id);
		$data['template_id']= $template_id;
		$this->adminBodyTemplate('adminbody/add_submitted_template_step2',$data);
	}
	public function add_submitted_template_step3($template_id = '')
	{
		$data = $this->commonData();
		$data['title'] = 'Edit Master Template Step 2';
		$data['forms']=$this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
		$data['template_id']= $template_id;
		$data['template'] = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		$this->adminBodyTemplate('adminbody/add_submitted_template_step3',$data);
	}
	public function print_pdf_sections()
	{
		ob_end_clean();
        
		$template_id = $this->request->getVar('template_id');
		$sections = $this->request->getVar('sections');
		$section_array = explode("||",$sections);
		$selectval = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
		$html = '';
		if(!empty($selectval))
		{
			$html.='<h3 style="text-align:center">'.$selectval['template_name'].'</h3>';
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$selectval['school_id']);
			$name = time();
			
			$unserialize = unserialize($selectval['content']);
            $total_count = count($unserialize);
            if(count($unserialize)){
                foreach($unserialize as $key => $content)
                {
                	if(in_array($key, $section_array))
                	{
                		$html.='<h5>'.$key.'</h5>'.$content.'';
                	}
                }
            }
            if(in_array('addendum', $section_array))
            {
            	$html.='<div style="page-break-before: always;">
                <table style="border-collapse: collapse;border:1px solid #dfdfdf;">
                <tbody>';
                    $select_add = unserialize($selectval['addendum']);
                    $answers = unserialize($selectval['answers']);
                    $html.='
                    <tr style="border:1px solid #dfdfdf">
                        <td colspan="4" style="border:1px solid #dfdfdf;height:50px;text-align:center">
                            <h5>Addendum</h5>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td colspan="4" style="border:1px solid #dfdfdf;padding:10px">
                            <h6>'; if(!empty($select_add)) { $html.=$select_add['addendum_title']; } else{ $html.='In compliance with the annual oversight process please provide the following information, complete the subsequent self-study survey and return to the district not later than May 1.'; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td colspan="4" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                            <h6>';if(!empty($select_add)) { $html.=$select_add['school_information']; } else{ $html.= 'Charter School Information'; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                            <h6>'; if(!empty($select_add)) { $html.= $select_add['school_name_title']; } else{ $html.= 'Charter School:'; } $html.='</h6>
                        </td>
                        <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                            <h6>'; if(!empty($answers)) { $html.= $answers['school_name']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['location_title']; } else{ $html.= 'Charter School: Location- School Address:'; } $html.='</h6>
                        </td>
                        <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['location']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['contact_title']; } else{ $html.= 'Charter School Contact: Name'; } $html.='</h6>
                        </td>
                        <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['contact_name']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['home_address_title']; } else{ $html.= 'Home Address'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['home_address']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['email_title']; } else{ $html.= 'Email Address:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['email_address']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['phone_title']; } else{ $html.= 'Phone Number:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['phone']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['school_phone_title']; } else{ $html.= 'School Phone Number:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['school_phone']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['fax_title']; } else{ $html.= 'Fax Number:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['fax']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                </tbody>
            	</table></div>';
            }
            
        	$forms = $this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
        	if(!empty($forms))
        	{
        		$outputval = '<h5>Legend</h5>
        		<h5 class="legend_h5" style="font-size:10px">
        			'.$selectval['legend'].'
        		</h5>';
        		foreach($forms as $key => $form)
        		{
        			if(in_array($form['section'], $section_array))
            		{
            			$keycountval = $key + 1;
            			$outputval.= '<div style="page-break-before: always;">
        				<table>';
                			$checkbox = '<td style="width:45%;padding:10px;min-height:30px">
                            	<h6>'.$keycountval.'. '.$form['section'].'</h6>
                            </td>';
            			
                            $outputval.='
                            	<tr style="margin-top:15px">
                                    '.$checkbox.'
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['strong'].'</h6>
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['sufficient'].'</h6>
                                    	
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['insufficient'].'</h6>
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['na'].'</h6>
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">Comments</h6>
                                    	<h6 style="display:none">'.$form['comments'].'</h6>
                                    </td>
                                </tr>';
                            $get_sub_inputs = $this->db->table('template_forms')->select('*')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
                            if(!empty($get_sub_inputs))
                            {
                            	foreach($get_sub_inputs as $keyvalinput => $input)
                            	{
                            		if($input['set_title'] == "1")
                    				{
                    					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                        	<h6>'.$input['section'].'</h6>
                                        </td>';
                    				}
                    				else{
                    					if($input['priority'] == 1)
                    					{
                    						$priority_icon = '<strong class="priority_icon">√</strong>';
                    					}
                    					elseif($input['priority'] == 2)
                    					{
                    						$priority_icon = '<strong class="priority_icon">∆</strong>';
                    					}
                    					elseif($input['priority'] == 3)
                    					{
                    						$priority_icon = '<strong class="priority_icon">∑</strong>';
                    					}
                    					else{
                    						$priority_icon = '';
                    					}
                    					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                        	<h6>'.$priority_icon.' '.$input['section'].'</h6>
                                        </td>';
                    				}
                                    if($input['set_title'] == "1")
                        			{
                            			$outputval.='
                            			<tr style="margin-top:15px">
	                                        '.$checkbox_sub.'
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	<h6 style="display:none">'.$input['comments'].'</h6>
	                                        </td>
	                                    </tr>
	                                    ';
	                                }
	                                else{
	                                	if($input['strong'] == "1") { $strong_selected = '√'; } else { $strong_selected = '-';  }
	                                	if($input['sufficient'] == "1") { $sufficient_selected = '√'; } else { $sufficient_selected = '-';  }
	                                	if($input['insufficient'] == "1") { $insufficient_selected = '√'; } else { $insufficient_selected = '-';  }
	                                	if($input['na'] == "1") { $na_selected = '√'; } else { $na_selected = '-';  }
	                                	if($input['strong'] == "1") { $mark_value = 1; }
	                                	elseif($input['sufficient'] == "1") { $mark_value = 2; }
	                                	elseif($input['insufficient'] == "1") { $mark_value = 3; }
	                                	elseif($input['na'] == "1") { $mark_value = 4; }
	                                	else{$mark_value = 0; }
	                                	if($selectval['status'] >= 3) { $disabled = 'disabled'; } else { $disabled = ''; }
	                                	$outputval.='
                            			<tr>
	                                        '.$checkbox_sub.'
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$strong_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$sufficient_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$insufficient_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$na_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	<h6>'.$input['comments'].'</h6>
	                                        </td>
	                                    </tr>';
	                                }
                            	}
                            }
                        if($selectval['status'] == 4) { $outputval.='<tr>
                    	<td colspan="6">
                            <h5>Summary:</h5><br/>
                            <h6>'.$form['summary'].'</h6>
                        </td>
                    </tr>'; }
                    $outputval.='</table></div>
                        ';
            		}
        		}
        		$html.=$outputval;
        	}
        	else{
        		$html.='<div class="table_row">
            		<div class="col-md-12 inside_table_div main_div">
                        <div class="col-md-5">
                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">1.</span>
                        	<h6>1. Education Program</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Strong</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Sufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Insufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>N/A</h6>
                        </div>
                    </div>
                </div>';
        	}
		}
		$upload_dir = 'papers/admin/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/admin/".$name.".pdf","F");
		echo $name.".pdf";
	}
	public function print_pdf()
	{
		ob_end_clean();
		$template_id = $this->request->getVar('template_id');
		$selectval = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
		$print_pdf_name = time();
		$html = '';
		if(!empty($selectval))
		{
			$html.='<h3 style="text-align:center">'.$selectval['template_name'].'</h3>';
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$selectval['school_id']);
			
			
			$unserialize = unserialize($selectval['content']);
            $total_count = count($unserialize);
            if(count($unserialize)){
                foreach($unserialize as $key => $content)
                {
                    $html.='<h5>'.$key.'</h5>'.$content.'';
                }
            }
            $html.='<div style="page-break-before: always;">
            <table style="border-collapse: collapse;border:1px solid #dfdfdf;">
            <tbody>';
                $select_add = unserialize($selectval['addendum']);
                $answers = unserialize($selectval['answers']);
                $html.='
                <tr style="border:1px solid #dfdfdf">
                    <td colspan="4" style="border:1px solid #dfdfdf;height:50px;text-align:center">
                        <h5>Addendum</h5>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td colspan="4" style="border:1px solid #dfdfdf;padding:10px">
                        <h6>'; if(!empty($select_add)) { $html.=$select_add['addendum_title']; } else{ $html.='In compliance with the annual oversight process please provide the following information, complete the subsequent self-study survey and return to the district not later than May 1.'; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td colspan="4" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        <h6>';if(!empty($select_add)) { $html.=$select_add['school_information']; } else{ $html.= 'Charter School Information'; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        <h6>'; if(!empty($select_add)) { $html.= $select_add['school_name_title']; } else{ $html.= 'Charter School:'; } $html.='</h6>
                    </td>
                    <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        <h6>'; if(!empty($answers)) { $html.= $answers['school_name']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['location_title']; } else{ $html.= 'Charter School: Location- School Address:'; } $html.='</h6>
                    </td>
                    <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['location']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['contact_title']; } else{ $html.= 'Charter School Contact: Name'; } $html.='</h6>
                    </td>
                    <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['contact_name']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['home_address_title']; } else{ $html.= 'Home Address'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['home_address']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['email_title']; } else{ $html.= 'Email Address:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['email_address']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['phone_title']; } else{ $html.= 'Phone Number:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['phone']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['school_phone_title']; } else{ $html.= 'School Phone Number:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['school_phone']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['fax_title']; } else{ $html.= 'Fax Number:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['fax']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
            </tbody>
        	</table></div>
        	<h5>Legend</h5>
    		<h5 class="legend_h5" style="font-size:10px">
    			'.$selectval['legend'].'
    		</h5>';
        	$forms = $this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
        	if(!empty($forms))
        	{
        		$outputval = '';
        		foreach($forms as $key => $form)
        		{
        			$keycountval = $key + 1;
        			if($key == 0)
        			{
        				$outputval.= '<div style="page-break-before: always;">';
        			}
        			else{
        				$outputval.= '<div>';
        			}
        			$outputval.= '<table>';
            			$checkbox = '<td style="width:45%;padding:10px;min-height:30px">
                        	<h6>'.$keycountval.'. '.$form['section'].'</h6>
                        </td>';
        			
                        $outputval.='
                        	<tr style="margin-top:15px">
                                '.$checkbox.'
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['strong'].'</h6>
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['sufficient'].'</h6>
                                	
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['insufficient'].'</h6>
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['na'].'</h6>
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">Comments</h6>
                                	<h6 style="display:none">'.$form['comments'].'</h6>
                                </td>
                            </tr>';
                        $get_sub_inputs = $this->db->table('template_forms')->select('*')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
                        if(!empty($get_sub_inputs))
                        {
                        	foreach($get_sub_inputs as $keyvalinput => $input)
                        	{
                        		if($input['set_title'] == "1")
                				{
                					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                    	<h6>'.$input['section'].'</h6>
                                    </td>';
                				}
                				else{
                					if($input['priority'] == 1)
                					{
                						$priority_icon = '<strong class="priority_icon">√</strong>';
                					}
                					elseif($input['priority'] == 2)
                					{
                						$priority_icon = '<strong class="priority_icon">∆</strong>';
                					}
                					elseif($input['priority'] == 3)
                					{
                						$priority_icon = '<strong class="priority_icon">∑</strong>';
                					}
                					else{
                						$priority_icon = '';
                					}
                					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                    	<h6>'.$priority_icon.' '.$input['section'].'</h6>
                                    </td>';
                				}
                                if($input['set_title'] == "1")
                    			{
                        			$outputval.='
                        			<tr style="margin-top:15px">
                                        '.$checkbox_sub.'
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	<h6 style="display:none">'.$input['comments'].'</h6>
                                        </td>
                                    </tr>
                                    ';
                                }
                                else{
                                	if($input['strong'] == "1") { $strong_selected = '√'; } else { $strong_selected = '-';  }
                                	if($input['sufficient'] == "1") { $sufficient_selected = '√'; } else { $sufficient_selected = '-';  }
                                	if($input['insufficient'] == "1") { $insufficient_selected = '√'; } else { $insufficient_selected = '-';  }
                                	if($input['na'] == "1") { $na_selected = '√'; } else { $na_selected = '-';  }
                                	if($input['strong'] == "1") { $mark_value = 1; }
                                	elseif($input['sufficient'] == "1") { $mark_value = 2; }
                                	elseif($input['insufficient'] == "1") { $mark_value = 3; }
                                	elseif($input['na'] == "1") { $mark_value = 4; }
                                	else{$mark_value = 0; }
                                	if($selectval['status'] >= 3) { $disabled = 'disabled'; } else { $disabled = ''; }
                                	$outputval.='
                        			<tr>
                                        '.$checkbox_sub.'
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$strong_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$sufficient_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$insufficient_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$na_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	<h6>'.$input['comments'].'</h6>
                                        </td>
                                    </tr>';
                                }
                        	}
                        }
                        if($selectval['status'] == 4) { $outputval.='<tr>
                        	<td colspan="6">
	                            <h5>Summary:</h5><br/>
	                            <h6>'.$form['summary'].'</h6>
                            </td>
                        </tr>'; }
                    $outputval.='</table></div>
                    ';
        		}
        		$html.=$outputval;
        	}
        	else{
        		$html.='<div class="table_row">
            		<div class="col-md-12 inside_table_div main_div">
                        <div class="col-md-5">
                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">1.</span>
                        	<h6>1. Education Program</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Strong</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Sufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Insufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>N/A</h6>
                        </div>
                    </div>
                </div>';
        	}
		}
		
		$upload_dir = 'papers/admin/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/admin/".$print_pdf_name.".pdf","F");
		echo $print_pdf_name.".pdf";
	}
	public function download_pdf_sections()
	{
		$template_id = $this->request->getVar('template_id');
		$sections = $this->request->getVar('sections');
		$section_array = explode("||",$sections);
		$selectval = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
		$html = '';
		if(!empty($selectval))
		{
			$html.='<h3 style="text-align:center">'.$selectval['template_name'].'</h3>';
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$selectval['school_id']);
			$name = trim($school_details['school_name']).'_'.trim($selectval['template_name']);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			
			
			$unserialize = unserialize($selectval['content']);
            $total_count = count($unserialize);
            if(count($unserialize)){
                foreach($unserialize as $key => $content)
                {
                	if(in_array($key, $section_array))
                	{
                		$html.='<h5>'.$key.'</h5>'.$content.'';
                	}
                }
            }
            if(in_array('addendum', $section_array))
            {
            	$html.='<div style="page-break-before: always;">
                <table style="border-collapse: collapse;border:1px solid #dfdfdf;">
                <tbody>';
                    $select_add = unserialize($selectval['addendum']);
                    $answers = unserialize($selectval['answers']);
                    $html.='
                    <tr style="border:1px solid #dfdfdf">
                        <td colspan="4" style="border:1px solid #dfdfdf;height:50px;text-align:center">
                            <h5>Addendum</h5>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td colspan="4" style="border:1px solid #dfdfdf;padding:10px">
                            <h6>'; if(!empty($select_add)) { $html.=$select_add['addendum_title']; } else{ $html.='In compliance with the annual oversight process please provide the following information, complete the subsequent self-study survey and return to the district not later than May 1.'; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td colspan="4" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                            <h6>';if(!empty($select_add)) { $html.=$select_add['school_information']; } else{ $html.= 'Charter School Information'; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                            <h6>'; if(!empty($select_add)) { $html.= $select_add['school_name_title']; } else{ $html.= 'Charter School:'; } $html.='</h6>
                        </td>
                        <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                            <h6>'; if(!empty($answers)) { $html.= $answers['school_name']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['location_title']; } else{ $html.= 'Charter School: Location- School Address:'; } $html.='</h6>
                        </td>
                        <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['location']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['contact_title']; } else{ $html.= 'Charter School Contact: Name'; } $html.='</h6>
                        </td>
                        <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['contact_name']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['home_address_title']; } else{ $html.= 'Home Address'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['home_address']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['email_title']; } else{ $html.= 'Email Address:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['email_address']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['phone_title']; } else{ $html.= 'Phone Number:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['phone']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                    <tr style="border:1px solid #dfdfdf">
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['school_phone_title']; } else{ $html.= 'School Phone Number:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['school_phone']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($select_add)) { $html.= $select_add['fax_title']; } else{ $html.= 'Fax Number:'; } $html.='</h6>
                        </td>
                        <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        	<h6>'; if(!empty($answers)) { $html.= $answers['fax']; } else{ $html.= ''; } $html.='</h6>
                        </td>
                    </tr>
                </tbody>
            	</table></div>';
            }
            
        	$forms = $this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
        	if(!empty($forms))
        	{
        		$outputval = '<h5>Legend</h5>
        		<h5 class="legend_h5" style="font-size:10px">
        			'.$selectval['legend'].'
        		</h5>';
        		foreach($forms as $key => $form)
        		{
        			if(in_array($form['section'], $section_array))
            		{
            			$keycountval = $key + 1;
            			$outputval.= '<div style="page-break-before: always;">
        				<table>';
                			$checkbox = '<td style="width:45%;padding:10px;min-height:30px">
                            	<h6>'.$keycountval.'. '.$form['section'].'</h6>
                            </td>';
            			
                            $outputval.='
                            	<tr style="margin-top:15px">
                                    '.$checkbox.'
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['strong'].'</h6>
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['sufficient'].'</h6>
                                    	
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['insufficient'].'</h6>
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">'.$form['na'].'</h6>
                                    </td>
                                    <td style="padding:10px;min-height:30px">
                                    	<h6 style="text-align:center">Comments</h6>
                                    	<h6 style="display:none">'.$form['comments'].'</h6>
                                    </td>
                                </tr>';
                            $get_sub_inputs = $this->db->table('template_forms')->select('*')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
                            if(!empty($get_sub_inputs))
                            {
                            	foreach($get_sub_inputs as $keyvalinput => $input)
                            	{
                            		if($input['set_title'] == "1")
                    				{
                    					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                        	<h6>'.$input['section'].'</h6>
                                        </td>';
                    				}
                    				else{
                    					if($input['priority'] == 1)
                    					{
                    						$priority_icon = '<strong class="priority_icon">√</strong>';
                    					}
                    					elseif($input['priority'] == 2)
                    					{
                    						$priority_icon = '<strong class="priority_icon">∆</strong>';
                    					}
                    					elseif($input['priority'] == 3)
                    					{
                    						$priority_icon = '<strong class="priority_icon">∑</strong>';
                    					}
                    					else{
                    						$priority_icon = '';
                    					}
                    					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                        	<h6>'.$priority_icon.' '.$input['section'].'</h6>
                                        </td>';
                    				}
                                    if($input['set_title'] == "1")
                        			{
                            			$outputval.='
                            			<tr style="margin-top:15px">
	                                        '.$checkbox_sub.'
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	&nbsp;
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	<h6 style="display:none">'.$input['comments'].'</h6>
	                                        </td>
	                                    </tr>
	                                    ';
	                                }
	                                else{
	                                	if($input['strong'] == "1") { $strong_selected = '√'; } else { $strong_selected = '-';  }
	                                	if($input['sufficient'] == "1") { $sufficient_selected = '√'; } else { $sufficient_selected = '-';  }
	                                	if($input['insufficient'] == "1") { $insufficient_selected = '√'; } else { $insufficient_selected = '-';  }
	                                	if($input['na'] == "1") { $na_selected = '√'; } else { $na_selected = '-';  }
	                                	if($input['strong'] == "1") { $mark_value = 1; }
	                                	elseif($input['sufficient'] == "1") { $mark_value = 2; }
	                                	elseif($input['insufficient'] == "1") { $mark_value = 3; }
	                                	elseif($input['na'] == "1") { $mark_value = 4; }
	                                	else{$mark_value = 0; }
	                                	if($selectval['status'] >= 3) { $disabled = 'disabled'; } else { $disabled = ''; }
	                                	$outputval.='
                            			<tr>
	                                        '.$checkbox_sub.'
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$strong_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$sufficient_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$insufficient_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	'.$na_selected.'
	                                        </td>
	                                        <td style="padding:10px;min-height:30px;text-align:center">
	                                        	<h6>'.$input['comments'].'</h6>
	                                        </td>
	                                    </tr>';
	                                }
                            	}
                            }
                        if($selectval['status'] == 4) { $outputval.='<tr>
                        	<td colspan="6">
	                            <h5>Summary:</h5><br/>
	                            <h6>'.$form['summary'].'</h6>
                            </td>
                        </tr>'; }
                        $outputval.='</table></div>
                        ';
            		}
        		}
        		$html.=$outputval;
        	}
        	else{
        		$html.='<div class="table_row">
            		<div class="col-md-12 inside_table_div main_div">
                        <div class="col-md-5">
                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">1.</span>
                        	<h6>1. Education Program</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Strong</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Sufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Insufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>N/A</h6>
                        </div>
                    </div>
                </div>';
        	}
		}
		$upload_dir = 'papers/admin/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/admin/".$name.".pdf","F");
		echo $name.".pdf";
	}
	public function download_pdf()
	{
		$template_id = $this->request->getVar('template_id');
		$selectval = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
		$html = '';
		if(!empty($selectval))
		{
			$html.='<h3 style="text-align:center">'.$selectval['template_name'].'</h3>';
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$selectval['school_id']);
			$name = trim($school_details['school_name']).'_'.trim($selectval['template_name']);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			$name = str_replace("/","-",$name);
			
			$unserialize = unserialize($selectval['content']);
            $total_count = count($unserialize);
            if(count($unserialize)){
                foreach($unserialize as $key => $content)
                {
                    $html.='<h5>'.$key.'</h5>'.$content.'';
                }
            }
            $html.='<div style="page-break-before: always;">
            <table style="border-collapse: collapse;border:1px solid #dfdfdf;">
            <tbody>';
                $select_add = unserialize($selectval['addendum']);
                $answers = unserialize($selectval['answers']);
                $html.='
                <tr style="border:1px solid #dfdfdf">
                    <td colspan="4" style="border:1px solid #dfdfdf;height:50px;text-align:center">
                        <h5>Addendum</h5>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td colspan="4" style="border:1px solid #dfdfdf;padding:10px">
                        <h6>'; if(!empty($select_add)) { $html.=$select_add['addendum_title']; } else{ $html.='In compliance with the annual oversight process please provide the following information, complete the subsequent self-study survey and return to the district not later than May 1.'; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td colspan="4" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        <h6>';if(!empty($select_add)) { $html.=$select_add['school_information']; } else{ $html.= 'Charter School Information'; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        <h6>'; if(!empty($select_add)) { $html.= $select_add['school_name_title']; } else{ $html.= 'Charter School:'; } $html.='</h6>
                    </td>
                    <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                        <h6>'; if(!empty($answers)) { $html.= $answers['school_name']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['location_title']; } else{ $html.= 'Charter School: Location- School Address:'; } $html.='</h6>
                    </td>
                    <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['location']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['contact_title']; } else{ $html.= 'Charter School Contact: Name'; } $html.='</h6>
                    </td>
                    <td colspan="3" style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['contact_name']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['home_address_title']; } else{ $html.= 'Home Address'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['home_address']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['email_title']; } else{ $html.= 'Email Address:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['email_address']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['phone_title']; } else{ $html.= 'Phone Number:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['phone']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
                <tr style="border:1px solid #dfdfdf">
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['school_phone_title']; } else{ $html.= 'School Phone Number:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['school_phone']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($select_add)) { $html.= $select_add['fax_title']; } else{ $html.= 'Fax Number:'; } $html.='</h6>
                    </td>
                    <td style="border:1px solid #dfdfdf;padding:10px;min-height:30px;">
                    	<h6>'; if(!empty($answers)) { $html.= $answers['fax']; } else{ $html.= ''; } $html.='</h6>
                    </td>
                </tr>
            </tbody>
        	</table></div>
        	<h5>Legend</h5>
    		<h5 class="legend_h5" style="font-size:10px">
    			'.$selectval['legend'].'
    		</h5>';
        	$forms = $this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
        	if(!empty($forms))
        	{
        		$outputval = '';
        		foreach($forms as $key => $form)
        		{
        			$keycountval = $key + 1;
        			if($key == 0)
        			{
        				$outputval.= '<div style="page-break-before: always;">';
        			}
        			else{
        				$outputval.= '<div>';
        			}
        			$outputval.= '<table>';
            			$checkbox = '<td style="width:45%;padding:10px;min-height:30px">
                        	<h6>'.$keycountval.'. '.$form['section'].'</h6>
                        </td>';
        			
                        $outputval.='
                        	<tr style="margin-top:15px">
                                '.$checkbox.'
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['strong'].'</h6>
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['sufficient'].'</h6>
                                	
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['insufficient'].'</h6>
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">'.$form['na'].'</h6>
                                </td>
                                <td style="padding:10px;min-height:30px">
                                	<h6 style="text-align:center">Comments</h6>
                                	<h6 style="display:none">'.$form['comments'].'</h6>
                                </td>
                            </tr>';
                        $get_sub_inputs = $this->db->table('template_forms')->select('*')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
                        if(!empty($get_sub_inputs))
                        {
                        	foreach($get_sub_inputs as $keyvalinput => $input)
                        	{
                        		if($input['set_title'] == "1")
                				{
                					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                    	<h6>'.$input['section'].'</h6>
                                    </td>';
                				}
                				else{
                					if($input['priority'] == 1)
                					{
                						$priority_icon = '<strong class="priority_icon">√</strong>';
                					}
                					elseif($input['priority'] == 2)
                					{
                						$priority_icon = '<strong class="priority_icon">∆</strong>';
                					}
                					elseif($input['priority'] == 3)
                					{
                						$priority_icon = '<strong class="priority_icon">∑</strong>';
                					}
                					else{
                						$priority_icon = '';
                					}
                					$checkbox_sub = '<td style="width:45%;padding:10px;min-height:30px">
                                    	<h6>'.$priority_icon.' '.$input['section'].'</h6>
                                    </td>';
                				}
                                if($input['set_title'] == "1")
                    			{
                        			$outputval.='
                        			<tr style="margin-top:15px">
                                        '.$checkbox_sub.'
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	&nbsp;
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	<h6 style="display:none">'.$input['comments'].'</h6>
                                        </td>
                                    </tr>
                                    ';
                                }
                                else{
                                	if($input['strong'] == "1") { $strong_selected = '√'; } else { $strong_selected = '-';  }
                                	if($input['sufficient'] == "1") { $sufficient_selected = '√'; } else { $sufficient_selected = '-';  }
                                	if($input['insufficient'] == "1") { $insufficient_selected = '√'; } else { $insufficient_selected = '-';  }
                                	if($input['na'] == "1") { $na_selected = '√'; } else { $na_selected = '-';  }
                                	if($input['strong'] == "1") { $mark_value = 1; }
                                	elseif($input['sufficient'] == "1") { $mark_value = 2; }
                                	elseif($input['insufficient'] == "1") { $mark_value = 3; }
                                	elseif($input['na'] == "1") { $mark_value = 4; }
                                	else{$mark_value = 0; }
                                	if($selectval['status'] >= 3) { $disabled = 'disabled'; } else { $disabled = ''; }
                                	$outputval.='
                        			<tr>
                                        '.$checkbox_sub.'
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$strong_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$sufficient_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$insufficient_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	'.$na_selected.'
                                        </td>
                                        <td style="padding:10px;min-height:30px;text-align:center">
                                        	<h6>'.$input['comments'].'</h6>
                                        </td>
                                    </tr>';
                                }
                        	}
                        }
                    if($selectval['status'] == 4) { $outputval.='<tr>
                    	<td colspan="6">
                            <h5>Summary:</h5><br/>
                            <h6>'.$form['summary'].'</h6>
                        </td>
                    </tr>'; }
                    $outputval.='</table></div>
                    ';
        		}
        		$html.=$outputval;
        	}
        	else{
        		$html.='<div class="table_row">
            		<div class="col-md-12 inside_table_div main_div">
                        <div class="col-md-5">
                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">1.</span>
                        	<h6>1. Education Program</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Strong</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Sufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>Insufficient</h6>
                        </div>
                        <div class="col-md-1">
                        	<h6>N/A</h6>
                        </div>
                    </div>
                </div>';
        	}
		}
		$upload_dir = 'papers/admin/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/admin/".$name.".pdf","F");
		echo $name.".pdf";
	}
	public function manage_reviewed_surveys()
	{
		$data = $this->commonData();
		$school_id = $_GET['school_id'];
		$school_details = $this->commonModel->Select_Val_Id('go_schools',$school_id);
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'admin/manage_submitted_surveys/';
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',4)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('district_id',$school_details['district_id'])->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_reviewed_surveys',$data);
	}
	public function delete_survey($id)
	{
		$details = $this->commonModel->Select_Val_Id('master_templates',$id);
		$this->commonModel->Delete_Values('master_templates',$id);
		$districtid = $this->request->getVar('district_id');
		$schoolid = $this->request->getVar('school_id');
		session()->setFlashdata('notif_success', 'Survey Deleted Successfully');
		if($districtid != "")
		{
			if($details['status'] < 3)
			{
				return $this->response->redirect(site_url('admin/manage_surveys?district_id='.$districtid));
			}
			elseif($details['status'] == 3)
			{
				return $this->response->redirect(site_url('admin/manage_submitted_surveys?district_id='.$districtid));
			}
			else{
				return $this->response->redirect(site_url('admin/manage_reviewed_surveys?district_id='.$districtid));
			}
		}
		else{
			if($details['status'] < 3)
			{
				return $this->response->redirect(site_url('admin/manage_surveys?school_id='.$schoolid));
			}
			elseif($details['status'] == 3)
			{
				return $this->response->redirect(site_url('admin/manage_submitted_surveys?school_id='.$schoolid));
			}
			else{
				return $this->response->redirect(site_url('admin/manage_reviewed_surveys?school_id='.$schoolid));
			}
		}
	}
	public function manage_submitted_surveys()
	{
		$data = $this->commonData();
		$school_id = $_GET['school_id'];
		$school_details = $this->commonModel->Select_Val_Id('go_schools',$school_id);
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'admin/manage_submitted_surveys/';
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',3)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('district_id',$school_details['district_id'])->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_submitted_surveys',$data);
	}
	public function manage_school_reports()
	{
		$data = $this->commonData();
		$school_id = $_GET['school_id'];
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'admin/manage_school_reports/';
		$data['select_templates'] = $this->db->table('reports')->select('*')->where('school_id',$school_id)->get()->getResultArray();
		$data['select_attachments'] = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('reports')->select('*')->where('school_id',0)->where('district_id',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_school_reports',$data);
	}
	public function pages()
	{
		$data = $this->commonData();
		$data['pages'] = $this->db->table('pages')->select('*')->get()->getResultArray();
		$data['district']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getRowArray();
		$this->adminBodyTemplate('adminbody/pages',$data);
	}
	public function addpage($page_id=null)
	{
		$data = $this->commonData();
		if($this->request->getPost('register_page'))
		{
			$rules=[
                'page_name'=> ['label' => 'Page Name', 'rules' => 'required'],
            ];			
            if ($this->validate($rules)){
					$input['page_name']   = $this->request->getPost('page_name');
					$input['content']     = $this->request->getPost('content');
					
					if($page_id=='')
					{
						$resultadmin = $this->commonModel->Insert_Values('pages',$input);							
					}
					else
					{
						$resultadmin = $this->commonModel->Update_Values('pages',$input,$page_id);
					}
					session()->setFlashdata('notif_success', 'Page Saved Successfully');
					return $this->response->redirect(site_url('admin/pages'));
			}
			else{
				$data['selectval']=$this->request->getPost();
			}
		}
		if($page_id!='')
		{
		$data['title'] = 'Edit Page';
		$data['selectval']=$this->commonModel->Select_Val_Id('pages',$page_id);
		}
		else
		{
		$data['title'] = 'Add Page';
		$data['selectval']=$this->request->getPost();
		}
		$data['page_id']= $page_id;
		$this->adminBodyTemplate('adminbody/addpage',$data);
	}
	public function terms_of_use()
	{
		$data = $this->commonData();
		$data['page'] = $this->commonModel->Select_Val_Id('pages',1);
		$this->adminBodyTemplate('adminbody/page',$data);
	}
	public function privacy_policy()
	{
		$data = $this->commonData();
		$data['page'] = $this->commonModel->Select_Val_Id('pages',2);
		$this->adminBodyTemplate('adminbody/page',$data);
	}
	
	public function manage_report_template($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'Edit Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/addreport',$data);
	}
	public function view_report_template($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'View Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/viewreport',$data);
	}
	public function view_report_template_submitted($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'View Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/viewreport_submitted',$data);
	}
	public function manage_lcap_template($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'Edit Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/addlcapreport',$data);
	}
	public function view_lcap_template($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'View Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/viewlcapreport',$data);
	}
	public function view_lcap_template_submitted($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'View Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/viewlcapreport_submitted',$data);
	}
	public function manage_report_template_step2($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'Edit Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/addreport_page2',$data);
	}
	public function view_report_template_step2($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'View Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/viewreport_page2',$data);
	}
	public function view_report_template_step2_submitted($id = '')
	{
		$data = $this->commonData();
		if($id!='')
		{
		$data['title'] = 'View Report Template';
		$data['selectval']=$this->commonModel->Select_Val_Id('reports',$id);
		}
		else
		{
		$data['title'] = 'Add Report Template';
		$data['selectval']=$this->request->getPost();
		}
		$data['template_id']= $id;
		$this->adminBodyTemplate('adminbody/viewreport_page2_submitted',$data);
	}
	public function get_report_table_tr()
	{
		$data = $this->commonData();
		$data['template_id'] = $this->request->getPost('template_id');
		$data['content1'] = '';
		$data['content2'] = '';
		$data['yes_content'] = 'Yes';
		$data['no_content'] = 'No';
		$data['type'] = 0;
		$lastinsertId = $this->commonModel->Insert_Values('report_forms',$data);
		$ids = $lastinsertId;
		$output = '<tr class="content_tr" data-element="'.$ids.'">
            <td style="border:1px solid #dfdfdf">
                <input type="text" name="content1[]" class="form-control content1" value="">
                <p style="text-align: center;margin-top:10px;font-size:18px">Comply</p>
                <input type="text" name="yes_content[]" class="form-control yes_content" value="Yes" style="width:45%;float:left">
                <input type="text" name="no_content[]" class="form-control no_content" value="No" style="width:45%;margin-left:10px;float:left">
            </td>
            <td style="border:1px solid #dfdfdf"><textarea name="content2[]" class="form-control content2" style="height:150px"></textarea></td>
            <td style="border:1px solid #dfdfdf;vertical-align: bottom;">
                <a href="javascript:" class="fa fa-minus remove_content" data-element="'.$ids.'"></a>
                <a href="javascript:" class="fa fa-plus add_content"></a>
            </td>
        </tr>';
        echo $output;
	}
	public function get_report_table_tr_step2()
	{
		$data = $this->commonData();
		$data['template_id'] = $this->request->getPost('template_id');
		$data['content1'] = '';
		$data['content2'] = '';
		$data['type'] = 1;
		$lastinsertId = $this->commonModel->Insert_Values('report_forms',$data);
		$ids = $lastinsertId;
		$output = '<tr class="content_tr" data-element="'.$ids.'">
            <td style="border:1px solid #dfdfdf">
                <textarea name="content1[]" class="form-control content1" style="height:150px"></textarea>
            </td>
            <td style="border:1px solid #dfdfdf">
            	<textarea name="content2[]" class="form-control content2" style="height:150px"></textarea>
            </td>
            <td style="border:1px solid #dfdfdf;vertical-align: bottom;">
            	<label class="switch">
                    <input type="checkbox" class="attach_class" value="1">
                    <span class="slider round"></span>
                </label>
                <input type="hidden" name="attachment[]" class="attach_hidden" value="0">
                <a href="javascript:" class="fa fa-minus remove_content" data-element="'.$ids.'"></a>
                <a href="javascript:" class="fa fa-plus add_content"></a>
            </td>
        </tr>';
        echo $output;
	}
	public function remove_report_forms()
	{
		$template_id = $this->request->getPost('template_id');
		$report_id = $this->request->getPost('report_id');
		$this->commonModel->Delete_Related_Values('report_forms','id',$report_id);
	}
	public function save_template_name_report()
	{
		$template_id = $this->request->getPost('template_id');
		$type = $this->request->getPost('type');
		$inputData[$type] = $this->request->getPost('content');
		$this->commonModel->Update_Values('reports',$inputData,$template_id);
	}
	public function save_reportform_content()
	{
		$form_id = $this->request->getPost('form_id');
		$type = $this->request->getPost('type');
		$inputData[$type] = $this->request->getPost('content');
		$this->commonModel->Update_Values('report_forms',$inputData,$form_id);
	}
	public function manage_district_reports()
	{
		$data = $this->commonData();
		$district_id = isset($_GET['district_id'])?$_GET['district_id']:0;
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'admin/manage_district_reports/';
		$data['select_templates'] = $this->db->table('reports')->select('*')->where('school_id',0)->where('deletestatus',0)->get()->getResultArray();
		$data['select_attachments'] = $this->db->table('principal_attachments')->select('*')->where('school_id !=',0)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('reports')->select('*')->where('school_id',0)->where('district_id',0)->get()->getResultArray();
		$data['master_schools'] = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->get()->getResultArray();
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_district_reports',$data);
	}
	public function filter_by_district_search()
	{
		$category = $this->request->getVar('category');
		$school_id = $this->request->getVar('school_id');
		$district_id = $this->request->getVar('district_id');
		$year = $this->request->getVar('year');
		if($year == "")
		{
			$from = '';
			$to = '';
		}
		else{
			$curr_year = $year;
			$next_year = $year + 1;
			$from = $year.'-07-01 00:00:00';
			$to = $next_year.'-06-30 23:59:00';
		}
		if($category == "a" || $category == "b" || $category == "c" || $category == "d" || $category == "e" || $category == "f" || $category == "g" || $category == "h" || $category == "i" || $category == "j" || $category == "k" || $category == "l" || $category == "m" || $category == "n" || $category == "o") {
			if($category == "a") { $category = "1"; }
			elseif($category == "b") { $category = "2"; }
			elseif($category == "c") { $category = "3"; }
			elseif($category == "d") { $category = "4"; }
			elseif($category == "e") { $category = "5"; }
			elseif($category == "f") { $category = "6"; }
			elseif($category == "g") { $category = "7"; }
			elseif($category == "h") { $category = "8"; }
			elseif($category == "o") { $category = "9"; }
			elseif($category == "i") { $category = "11"; }
			elseif($category == "j") { $category = "12"; }
			elseif($category == "k") { $category = "13"; }
			elseif($category == "l") { $category = "14"; }
			elseif($category == "n") { $category = "15"; }
			elseif($category == "m") { $category = "16"; }
			$get_reports = array();
			if($school_id == "" || $school_id == "all")
			{
				if($year == "")
				{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('type',$category)->where('district_id',$district_id)->get()->getResultArray();
				}
				else{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('type',$category)->where('district_id',$district_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
				}
				
			}
			else{
				if($year == "")
				{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('type',$category)->where('school_id',$school_id)->get()->getResultArray();
				}
				else{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('type',$category)->where('school_id',$school_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
				}
			}
		}
		else{
			if($school_id == "" || $school_id == "all")
			{
				if($year == "")
				{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('district_id',$district_id)->get()->getResultArray();
				}
				else{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('district_id',$district_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
				}
				
			}
			else{
				if($year == "")
				{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->get()->getResultArray();
				}
				else{
					$get_attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
				}
			}
		}
		
		$output = '';
		$i = 1;
		if(count($get_attachments))
		{
			$i = $i++;
			foreach($get_attachments as $attach)
			{
				$school_details = $this->commonModel->Select_Val_Id('go_schools',$attach['school_id']);
				$explodefile = explode("||",$attach['filename']);
                if(!empty($explodefile))
                {
                    foreach($explodefile as $exp)
                    {
						$expfilename = explode(".",$exp);
						array_pop($expfilename);
						$impfilename = implode(" ",$expfilename);
						
						$output.='<tr class="attach_tr_'.$attach['id'].'">
							<td>'.$i.'</td>
							<td>'.$impfilename.'</td>
							<td>';
								if($attach['type'] == "1") { $output.='Principal attach (P 1)'; }
								elseif($attach['type'] == "2") { $output.='Principal attach (P 2)'; }
								elseif($attach['type'] == "3") { $output.='Principal attach (P 3)'; }
								elseif($attach['type'] == "4") { $output.='Annual Audit'; }
								elseif($attach['type'] == "5") { $output.='Report Review'; }
								elseif($attach['type'] == "6") { $output.='FCMAT Calculator'; }
								elseif($attach['type'] == "7") { $output.='Misc Report'; }
								elseif($attach['type'] == "8") { $output.='Misc Report'; }
								elseif($attach['type'] == "9") { $output.='Expanded Learning Opportunities Grant Plan'; }
								elseif($attach['type'] == "11") { $output.='Annual Adopted Budget'; }
								elseif($attach['type'] == "12") { $output.='Unaudited Actuals'; }
								elseif($attach['type'] == "13") { $output.='First Interim'; }
								elseif($attach['type'] == "14") { $output.='Second Interim'; }
								elseif($attach['type'] == "15") { $output.='LCAP'; }
								elseif($attach['type'] == "16") { $output.='Third Interim (Annual)'; }
							$output.='</td>
							<td>'.$school_details['school_name'].'</td>
							<td>
								<h6>Report Submitted By School <br/><br/><span class="change_date_span">'.date('m/d/Y',strtotime($attach['updatetime'])).'</span><a href="javascript:" class="fa fa-pencil edit_date" data-element="'.$attach['id'].'" data-date="'.date('m/d/Y',strtotime($attach['updatetime'])).'" style="margin-left:10px"></a></h6>
							</td>
							<td>';
								$exp_attachment = explode(".",$exp);
								if(end($exp_attachment) == "pdf")
								{
									$output.='<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="fa fa-eye view_pdf" title="View Report" style="font-size:23px"></a>';
								}
								else{
									$output.='<a href="'.BASE_URL.$attach['url'].'/'.$exp.'" class="fa fa-eye view_pdf" title="View Report" download style="font-size:23px"></a>';
								}
								$output.='
								<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="fa fa-comment link_to_task_specifics" data-element="'.$attach['id'].'" title="Comment Report" style="font-size:23px"></a>
								<a href="'.BASE_URL.'admin/delete_report_attachment/'.$attach['id'].'?district_id='.$attach['district_id'].'" class="fa fa-trash delete_report_attach" title="Delete Report" style="font-size:23px"></a>
							</td>
						</tr>';
						$i++;
					}
				}
			}
		}
		if($i == 1){
			$output.='<tr><td colspan="6">No Datas found</td></tr>';
		}
		echo $output;
	}
	public function filter_by_school_search()
	{
		$category = $this->request->getVar('category');
		$year = $this->request->getVar('year');
		$school_id = $this->request->getVar('school_id');
		if($year == "")
		{
			$from = '';
			$to = '';
		}
		else{
			$curr_year = $year;
			$next_year = $year + 1;
			$from = $year.'-07-01 00:00:00';
			$to = $next_year.'-06-30 23:59:00';
		}
		
		if($category == "a" || $category == "b" || $category == "c" || $category == "d" || $category == "e" || $category == "f" || $category == "g" || $category == "h" || $category == "i" || $category == "j" || $category == "k" || $category == "l" || $category == "m" || $category == "n" || $category == "o") {
			if($category == "a") { $category = "1"; }
			elseif($category == "b") { $category = "2"; }
			elseif($category == "c") { $category = "3"; }
			elseif($category == "d") { $category = "4"; }
			elseif($category == "e") { $category = "5"; }
			elseif($category == "f") { $category = "6"; }
			elseif($category == "g") { $category = "7"; }
			elseif($category == "h") { $category = "8"; }
			elseif($category == "o") { $category = "9"; }
			elseif($category == "i") { $category = "11"; }
			elseif($category == "j") { $category = "12"; }
			elseif($category == "k") { $category = "13"; }
			elseif($category == "l") { $category = "14"; }
			elseif($category == "n") { $category = "15"; }
			elseif($category == "m") { $category = "16"; }
			$get_reports = array();
			if($year == "")
			{
				$get_attachments = $this->db->table('principal_attachments')->select('*')->where('type',$category)->where('school_id',$school_id)->get()->getResultArray();
			}
			else{
				$get_attachments = $this->db->table('principal_attachments')->select('*')->where('type',$category)->where('school_id',$school_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
			}
		}
		else{
			if($year == "")
			{
				$get_attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->get()->getResultArray();
			}
			else{
				$get_attachments = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
			}
			
			$get_reports = array();
		}
		$output = '';
		$i = 1;
		if(count($get_attachments))
		{
			$i = $i++;
			foreach($get_attachments as $attach)
			{
				$school_details = $this->commonModel->Select_Val_Id('go_schools',$attach['school_id']);
				$explodefile = explode("||",$attach['filename']);
                if(!empty($explodefile))
                {
                    foreach($explodefile as $exp)
                    {
						$expfilename = explode(".",$exp);
						array_pop($expfilename);
						$impfilename = implode(" ",$expfilename);
						
						$output.='<tr class="attach_tr_'.$attach['id'].'">
							<td>'.$i.'</td>
							<td>'.$impfilename.'</td>
							<td>';
								if($attach['type'] == "1") { $output.='Principal attach (P 1)'; }
								elseif($attach['type'] == "2") { $output.='Principal attach (P 2)'; }
								elseif($attach['type'] == "3") { $output.='Principal attach (P 3)'; }
								elseif($attach['type'] == "4") { $output.='Annual Audit'; }
								elseif($attach['type'] == "5") { $output.='Report Review'; }
								elseif($attach['type'] == "6") { $output.='FCMAT Calculator'; }
								elseif($attach['type'] == "7") { $output.='Misc Report'; }
								elseif($attach['type'] == "8") { $output.='Misc Report'; }
								elseif($attach['type'] == "9") { $output.='Expanded Learning Opportunities Grant Plan'; }
								elseif($attach['type'] == "11") { $output.='Annual Adopted Budget'; }
								elseif($attach['type'] == "12") { $output.='Unaudited Actuals'; }
								elseif($attach['type'] == "13") { $output.='First Interim'; }
								elseif($attach['type'] == "14") { $output.='Second Interim'; }
								elseif($attach['type'] == "15") { $output.='LCAP'; }
								elseif($attach['type'] == "16") { $output.='Third Interim (Annual)'; }
							$output.='</td>
							<td>
								<h6>Report Submitted By School <br/><br/><span class="change_date_span">'.date('m/d/Y',strtotime($attach['updatetime'])).'</span><a href="javascript:" class="fa fa-pencil edit_date" data-element="'.$attach['id'].'" data-date="'.date('m/d/Y',strtotime($attach['updatetime'])).'" style="margin-left:10px"></a></h6>
							</td>
							<td>';
								$exp_attachment = explode(".",$exp);
								if(end($exp_attachment) == "pdf")
								{
									$output.='<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="fa fa-eye view_pdf" title="View Report" style="font-size:23px"></a>';
								}
								else{
									$output.='<a href="'.BASE_URL.$attach['url'].'/'.$exp.'" class="fa fa-eye view_pdf" title="View Report" download style="font-size:23px"></a>';
								}
								$output.='
								<a href="javascript:" data-src="'.$attach['url'].'/'.$exp.'" class="fa fa-comment link_to_task_specifics" data-element="'.$attach['id'].'" title="Comment Report" style="font-size:23px"></a>
								<a href="'.BASE_URL.'admin/delete_report_attachment/'.$attach['id'].'?district_id='.$attach['district_id'].'" class="fa fa-trash delete_report_attach" title="Delete Report" style="font-size:23px"></a>
							</td>
						</tr>';
						$i++;
					}
				}
			}
		}
		if($i == 1){
			$output.='<tr><td colspan="6">No Datas found</td></tr>';
		}
		echo $output;
	}
	public function principal_apportionment()
	{
		$data = $this->commonData();
		if(isset($_GET['notify']))
		{
			$id = $_GET['notify'];
			$dataval['status'] = 0;
			$this->commonModel->Update_Values('notifications',$dataval,$id);
		}
		$type = $this->request->getVar('type');
		$data['title']= 'ADMIN';
		$data['type']= $type;
		$config['base_url'] = BASE_URL.'admin/principal_apportionment/';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/principal_apportionment',$data);
	}
	public function take_a_copy()
	{
		$template_id = $this->request->getVar('template_id');
		if(isset($_POST['school_id']))
		{
			$school_id = $this->request->getVar('school_id');
		}
		else{
			$school_id = 0;
		}
		if(isset($_POST['district_id']))
		{
			$district_id = $this->request->getVar('district_id');
		}
		else{
			$district_id = 0;
		}
		$sub_id=0;
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		$forms = $this->db->table('template_forms')->select('*')->where('template_id',$template_id)->get()->getResultArray();
		if(count($template_details))
		{
			$data['template_name'] = $template_details['template_name'];
			$data['district_id'] = $district_id;
			$data['school_id'] = $school_id;
			$data['content'] = $template_details['content'];
			$data['addendum'] = $template_details['addendum'];
			$data['forms'] = $template_details['forms'];
			$data['legend'] = $template_details['legend'];
			$data['status'] = 0;
			$data['active_page'] = 0;
			$lastinsertId = $this->commonModel->Insert_Values('master_templates',$data);
			$new_id = $lastinsertId;
			if(count($forms))
			{
				foreach($forms as $form)
				{
					if($form['set_title'] == 2)
					{
						$datatemplate['template_id'] = $new_id;
						$datatemplate['sub_id'] = 0;
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['section'] = $form['section'];
						$datatemplate['strong'] = $form['strong'];
						$datatemplate['sufficient'] = $form['sufficient'];
						$datatemplate['insufficient'] = $form['insufficient'];
						$datatemplate['na'] = $form['na'];
						$datatemplate['set_title'] = 2;
						$datatemplate['priority'] = 0;
						$datatemplate['summary'] = $form['summary'];
						$lastinsertId = $this->commonModel->Insert_Values('template_forms',$datatemplate);
						$sub_id = $lastinsertId;
					}
					elseif($form['set_title'] == 1){
						$datatemplate['template_id'] = $new_id;
						$datatemplate['sub_id'] = $sub_id;
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['section'] = $form['section'];
						$datatemplate['strong'] = $form['strong'];
						$datatemplate['sufficient'] = $form['sufficient'];
						$datatemplate['insufficient'] = $form['insufficient'];
						$datatemplate['na'] = $form['na'];
						$datatemplate['set_title'] = 1;
						$datatemplate['priority'] = 0;
						$datatemplate['summary'] = '';
						$this->commonModel->Insert_Values('template_forms',$datatemplate);
					}
					else{
						$datatemplate['template_id'] = $new_id;
						$datatemplate['sub_id'] = $sub_id;
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['section'] = $form['section'];
						$datatemplate['strong'] = $form['strong'];
						$datatemplate['sufficient'] = $form['sufficient'];
						$datatemplate['insufficient'] = $form['insufficient'];
						$datatemplate['na'] = $form['na'];
						$datatemplate['set_title'] = 0;
						$datatemplate['priority'] = $form['priority'];
						$datatemplate['summary'] = '';
						$this->commonModel->Insert_Values('template_forms',$datatemplate);
					}
				}
			}
			echo $new_id;
		}
	}
	public function take_a_report_copy()
	{
		$template_id = $this->request->getVar('template_id');
		if(isset($_POST['school_id']))
		{
			$school_id = $this->request->getVar('school_id');
		}
		else{
			$school_id = 0;
		}
		if(isset($_POST['district_id']))
		{
			$district_id = $this->request->getVar('district_id');
		}
		else{
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$school_id);
			$district_id = $school_details['district_id'];
		}
		$template_details = $this->commonModel->Select_Val_Id('reports',$template_id);
		$forms = $this->db->select('*')->from('report_forms')->where('template_id',$template_id)->get()->getResultArray();
		if(count($template_details))
		{
			$data['template'] = $template_details['template'];
			$data['template_name'] = $template_details['template_name'];
			$data['district_id'] = $district_id;
			$data['school_id'] = $school_id;
			$data['title'] = $template_details['title'];
			$data['title_attachment_name'] = $template_details['title_attachment_name'];
			$data['title_attach_status'] = $template_details['title_attach_status'];
			$data['title_step2'] = $template_details['title_step2'];
			$data['step1_table_title_1'] = $template_details['step1_table_title_1'];
			$data['step1_table_title_2'] = $template_details['step1_table_title_2'];
			$data['step2_table_title_1'] = $template_details['step2_table_title_1'];
			$data['step2_table_title_2'] = $template_details['step2_table_title_2'];
			$data['step1_table_down_content'] = $template_details['step1_table_down_content'];
			$data['step2_table_up_content'] = $template_details['step2_table_up_content'];
			$data['step2_table_down_content'] = $template_details['step2_table_down_content'];
			$data['title1'] = $template_details['title1'];
			$data['title2'] = $template_details['title2'];
			$data['title3'] = $template_details['title3'];
			$data['attachment'] = $template_details['attachment'];
			$data['type'] = $template_details['type'];
			$lastinsertId = $this->commonModel->Insert_Values('reports',$data);
			$new_id = $lastinsertId;
			if(count($forms))
			{
				foreach($forms as $form)
				{
						$datatemplate['template_id'] = $new_id;
						$datatemplate['content1'] = $form['content1'];
						$datatemplate['content2'] = $form['content2'];
						$datatemplate['yes_content'] = $form['yes_content'];
						$datatemplate['no_content'] = $form['no_content'];
						$datatemplate['attachment'] = $form['attachment'];
						$datatemplate['type'] = $form['type'];
						$this->commonModel->Insert_Values('report_forms',$datatemplate);
				}
			}
			echo json_encode(array("template_id" => $new_id, "type" => $template_details['type']));
		}
	}

	public function show_existing_comments()
	{
		$task_id = $this->request->getVar('task_id');
		$output = '';
		$specifics = $this->db->table('report_specifics')->select('*')->where('report_id',$task_id)->orderBy('id','asc')->get()->getResultArray();
		if(count($specifics))
		{
			foreach($specifics as $specific)
			{
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specific['message']);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p>&nbsp;</p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				$specficsval = str_replace("<p></p>", "", $specficsval);
				if($specific['type'] == 2)
				{
					$district_details = $this->commonModel->Select_Val_Id('go_district_admin',$specific['user_id']);
					$output.='<p class="header_p">Message From '.$district_details['fullname'].' (District Admin):</p>';
				}
				elseif($specific['type'] == 3)
				{
					$school_details = $this->commonModel->Select_Val_Id('go_schools',$specific['user_id']);
					$output.='<p class="header_p">Message From '.$school_details['principal_name'].' (School Admin):</p>';
				}
				else{
					$output.='<p class="header_p">Message From Super Admin:</p>';
				}
				$output.='<strong style="width:100%;float:left;text-align:justify;font-weight:400;margin-bottom:20px">'.$specficsval.'</strong>';
			}
		}
		echo $output;
	}
	public function add_comment_specifics()
	{
		$task_id = $this->request->getVar('task_id');
		$comments = $this->request->getVar('comments');
		$data['report_id'] = $task_id;
		$data['message'] = $comments;
		$data['type'] = 1;
		$data['user_id'] = 0;
		$this->commonModel->Insert_Values('report_specifics',$data);

		$report = $this->commonModel->Select_Val_Id('principal_attachments',$task_id);
		$school_details = $this->commonModel->Select_Val_Id('go_schools',$report['school_id']);
		$type = $report['type'];

		if($type == "11") { $typeval = 'Annual Adopted Budget'; }
        elseif($type == "12") { $typeval = 'Unaudited Actuals'; }
        elseif($type == "13") { $typeval = 'First Interim'; }
        elseif($type == "14") { $typeval = 'Second Interim'; }
        elseif($type == "15") { $typeval = 'LCAP'; }
        elseif($type == "16") { $typeval = 'Third Interim (Annual)'; }
        elseif($type == "1") { $typeval = 'Principal attach (P 1)'; }
		elseif($type == "2") { $typeval = 'Principal attach (P 2)'; }
		elseif($type == "3") { $typeval = 'Principal attach (P 3)'; }
		elseif($type == "4") { $typeval = 'Annual Audit'; }
		elseif($type == "5") { $typeval = 'Report Review'; }
		elseif($type == "6") { $typeval = 'FCMAT Calculator'; }
		elseif($type == "7") { $typeval = 'Misc'; }
		elseif($type == "8") { $typeval = 'Misc'; }
		elseif($type == "9") { $typeval = 'Expanded Learning Opportunities Grant Plan'; }
        else { $typeval = ''; }

		$datanotify['report_id'] = $task_id;
		$datanotify['message'] = '<p style="margin-bottom:0px">Report: '.$typeval.' - Message From Super Admin</p><spam class="inner_message" style="font-size:12px;color:#009500">'.$comments.'</spam>';
		$datanotify['type'] = 1;
		$datanotify['created_by'] = 1;
		$datanotify['user_id'] = 1;
		$datanotify['admin'] = 0;
		$datanotify['district_id'] = $report['district_id'];
		$datanotify['school_id'] = $report['school_id'];
		$datanotify['status'] = 0;
		$datanotify['district_status'] = 1;
		$datanotify['school_status'] = 1;

		$this->commonModel->Insert_Values('notifications',$datanotify);

		$district_subject = 'Report: '.$typeval.' - Message From Super Admin';
		$school_subject = 'Report: '.$typeval.' - Message From Super Admin';

		$district_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Message From Super Admin for the '.$typeval.' Report to School '.$school_details['school_name'].'</p><p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">'.$comments.'</p>';
		$school_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Message From Super Admin for the '.$typeval.' Report </p><p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">'.$comments.'</p>';
		$this->send_email_to_district_school($report['district_id'],$report['school_id'],$district_subject,$school_subject,$district_message,$school_message);

		echo '<p class="header_p">Message From Super Admin:</p>'.$comments;
	}

	public function delete_report_template($id)
	{
		$this->commonModel->Delete_Values('reports',$id);
		$districtid = $this->request->getVar('district_id');
		$schoolid = $this->request->getVar('school_id');
		session()->setFlashdata('notif_success', 'Report Deleted Successfully');
		if($districtid != "")
		{
			return $this->response->redirect(site_url('admin/manage_district_reports?district_id='.$districtid.''));
		}
		else{
			return $this->response->redirect(site_url('admin/manage_school_reports?school_id='.$schoolid.''));
		}
	}
	public function delete_report_attachment($id)
	{
		$this->commonModel->Delete_Values('principal_attachments',$id);
		$districtid = $this->request->getVar('district_id');
		$schoolid = $this->request->getVar('school_id');
		session()->setFlashdata('notif_success', 'Survey Deleted Successfully');
		if($districtid != "")
		{
			return $this->response->redirect(site_url('admin/manage_district_reports?district_id='.$districtid.''));
		}
		else{
			return $this->response->redirect(site_url('admin/manage_school_reports?school_id='.$schoolid.''));
		}
	}

	public function manage_reports()
	{
		$data = $this->commonData();
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'admin/manage_reports/';
		$data['select_reports'] = $this->db->table('reports')->select('*')->where('master',1)->orderBy('order','asc')->get()->getResultArray();
		$this->adminBodyTemplate('adminbody/manage_reports',$data);
	}
	public function get_reports_from_school()
	{
		$school_id = $this->request->getVar('school_id');
		$year = $this->request->getVar('year');
		$type = $this->request->getVar('type');
		if($year == "")
		{
			$from = '';
			$to = '';
		}
		else{
			$curr_year = $year;
			$next_year = $year + 1;
			$from = $year.'-07-01 00:00:00';
			$to = $next_year.'-06-30 23:59:00';
		}
		$output = '';
		if($school_id == "all")
		{
			if($year == "")
			{
				$reports = $this->db->table('principal_attachments')->select('*')->where('type',$type)->where('school_id !=',0)->get()->getResultArray();
			}
			else{
				$reports = $this->db->table('principal_attachments')->select('*')->where('type',$type)->where('school_id !=',0)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
			}
		}
		else{
			if($year == "")
			{
				$reports = $this->db->table('principal_attachments')->select('*')->where('type',$type)->where('school_id',$school_id)->get()->getResultArray();
			}
			else{
				$reports = $this->db->table('principal_attachments')->select('*')->where('type',$type)->where('school_id',$school_id)->where('updatetime >=',$from)->where('updatetime <=',$to)->get()->getResultArray();
			}
		}
		
        $i = 1;
        if(!empty($reports))
        {
            foreach($reports as $report)
            {
                $school_details = $this->commonModel->Select_Val_Id('go_schools',$report['school_id']);
                $explodefile = explode("||",$report['filename']);
                if(!empty($explodefile))
                {
                    foreach($explodefile as $exp)
                    {
		                $expfilename = explode(".",$exp);
		                array_pop($expfilename);
		                $impfilename = implode(" ",$expfilename);
		                $output.='<tr class="report_tr_'.$report['id'].'">
		                    <td>'.$i.'</td>
		                    <td>'.$impfilename.'</td>
		                    <td>'.$school_details['school_name'].'</td>
		                    <td>
		                        <h6>Report Submitted By School <br/><br/><span class="change_date_span">'.date('m/d/Y',strtotime($report['updatetime'])).'</span><a href="javascript:" class="fa fa-pencil edit_date" data-element="'.$report['id'].'" data-date="'.date('m/d/Y',strtotime($report['updatetime'])).'" style="margin-left:10px"></a></h6>
		                    </td>
		                    <td>';
		                        $exp_attachment = explode(".",$exp);
		                        if(end($exp_attachment) == "pdf")
		                        {
		                            $output.='<a href="javascript:" data-src="'.$report['url'].'/'.$exp.'" class="fa fa-eye view_pdf" title="View Report" style="font-size:23px"></a>';
		                        }
		                        else{
		                            $output.='<a href="'.BASE_URL.$report['url'].'/'.$exp.'" class="fa fa-eye" title="View Report" download style="font-size:23px"></a>';
		                        }
		                        $output.='<a href="javascript:" data-src="'.$report['url'].'/'.$exp.'" class="fa fa-comment link_to_task_specifics" data-element="'.$report['id'].'" title="View Report" style="font-size:23px"></a>
		                        <a href="'.BASE_URL."admin/delete_report_attachment/".$report['id']."?school_id=".$report['school_id'].'" class="fa fa-trash delete_report_attach" title="Delete Report" style="font-size:23px"></a>
		                    </td>
		                </tr>';
		                $i++;
		            }
		        }
            }
        }
        else{
            $output.='<tr><td colspan="5">No Reports Found</td></tr>';
        }
        echo $output;
	}
	public function view_result_reports()
	{
		$data = $this->commonData();
		$data['title']= 'ADMIN';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$config['base_url'] = BASE_URL.'admin/view_result_reports/';
		$this->adminBodyTemplate('adminbody/view_result_reports',$data);
	}
	public function reports_result()
	{
		$school_id = $this->request->getVar('school_id');
		$year = $this->request->getVar('year');
		$output = '';
        $result = $this->db->table('report_result')->select('*')->where('school_id',$school_id)->where('year',$year)->get()->getRowArray();
        if(!empty($result))
        {
            $due_dates = unserialize($result['due_dates']);
        }
        else{
            $due_dates = array();
        }
        $prev_year = $year.'-07-01';
        $current_year = $year + 1;
        $current_year = $current_year.'-06-30';
        $report_1 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',11)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_2 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',12)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_3 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',13)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_4 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',14)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_5 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',16)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_6 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',15)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();


        $report_7 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',4)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_8 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',1)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_9 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',2)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_10 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',3)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_11 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',5)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_12 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',6)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_15 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',9)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_13 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',7)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $report_14 = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->where('type',8)->where('updatetime >=',$prev_year)->where('updatetime <=',$current_year)->orderBy('updatetime','desc')->get()->getRowArray();
        $output.='<tr>
            <td class="due_date_td_11">'; if(isset($due_dates[0])) { if($due_dates[0] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[0])); } } else { $output.='Optional'; } $output.='</td>
            <td>Annual Adopted Budget</td>
            <td>'; if(!empty($report_1)) { $output.=date('F d Y',strtotime($report_1['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_12">'; if(isset($due_dates[1])) { if($due_dates[1] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[1])); } } else { $output.='Optional'; } $output.='</td>
            <td>Unaudited Actuals</td>
            <td>'; if(!empty($report_2)) { $output.=date('F d Y',strtotime($report_2['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_13">'; if(isset($due_dates[2])) { if($due_dates[2] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[2])); } } else { $output.='Optional'; } $output.='</td>
            <td>First Interim</td>
            <td>'; if(!empty($report_3)) { $output.=date('F d Y',strtotime($report_3['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_14">'; if(isset($due_dates[3])) { if($due_dates[3] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[3])); } } else { $output.='Optional'; } $output.='</td>
            <td>Second Interim</td>
            <td>'; if(!empty($report_4)) { $output.=date('F d Y',strtotime($report_4['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_16">'; if(isset($due_dates[4])) { if($due_dates[4] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[4])); } } else { $output.='Optional'; } $output.='</td>
            <td>Third Interim(Annual)</td>
            <td>'; if(!empty($report_5)) { $output.=date('F d Y',strtotime($report_5['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_15">'; if(isset($due_dates[5])) { if($due_dates[5] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[5])); } } else { $output.='Optional'; } $output.='</td>
            <td>LCAP</td>
            <td>'; if(!empty($report_6)) { $output.=date('F d Y',strtotime($report_6['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_4">'; if(isset($due_dates[6])) { if($due_dates[6] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[6])); } } else { $output.='Optional'; } $output.='</td>
            <td>Annual Audit</td>
            <td>'; if(!empty($report_7)) { $output.=date('F d Y',strtotime($report_7['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_1">'; if(isset($due_dates[7])) { if($due_dates[7] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[7])); } } else { $output.='Optional'; } $output.='</td>
            <td>P 1</td>
            <td>'; if(!empty($report_8)) { $output.=date('F d Y',strtotime($report_8['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_2">'; if(isset($due_dates[8])) { if($due_dates[8] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[8])); } } else { $output.='Optional'; } $output.='</td>
            <td>P 2</td>
            <td>'; if(!empty($report_9)) { $output.=date('F d Y',strtotime($report_9['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_3">'; if(isset($due_dates[9])) { if($due_dates[9] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[9])); } } else { $output.='Optional'; } $output.='</td>
            <td>P 3</td>
            <td>'; if(!empty($report_10)) { $output.=date('F d Y',strtotime($report_10['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_5">'; if(isset($due_dates[10])) { if($due_dates[10] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[10])); } } else { $output.='Optional'; } $output.='</td>
            <td>Report Review</td>
            <td>'; if(!empty($report_11)) { $output.=date('F d Y',strtotime($report_11['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_6">'; if(isset($due_dates[11])) { if($due_dates[11] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[11])); } } else { $output.='Optional'; } $output.='</td>
            <td>FCMAT Calculator</td>
            <td>'; if(!empty($report_12)) { $output.=date('F d Y',strtotime($report_12['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_9">'; if(isset($due_dates[14])) { if($due_dates[14] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[14])); } } else { $output.='Optional'; } $output.='</td>
            <td>Expanded Learning Opportunities Grant Plan</td>
            <td>'; if(!empty($report_15)) { $output.=date('F d Y',strtotime($report_15['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_7">'; if(isset($due_dates[12])) { if($due_dates[12] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[12])); } } else { $output.='Optional'; } $output.='</td>
            <td>Misc Report</td>
            <td>'; if(!empty($report_13)) { $output.=date('F d Y',strtotime($report_13['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>
        <tr>
            <td class="due_date_td_8">'; if(isset($due_dates[13])) { if($due_dates[13] =="") { $output.='Optional'; } else { $output.=date('F d Y', strtotime($due_dates[13])); } } else { $output.='Optional'; } $output.='</td>
            <td>Misc Report</td>
            <td>'; if(!empty($report_14)) { $output.=date('F d Y',strtotime($report_14['updatetime'])); } else { $output.='-'; } $output.='</td>
        </tr>';
        echo $output;
	}

	public function school_lists_checkbox()
	{
		$district_id = $this->request->getVar('district_id');
		$schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->get()->getResultArray();
		$output = '';
		if(!empty($schools))
		{
			foreach($schools as $school)
			{
				$output.='<p><input type="checkbox" name="school_select[]" class="school_select" id="school_'.$school['id'].'" value="'.$school['id'].'"><label for="school_'.$school['id'].'" style="margin-left: 10px;font-size: 14px;font-weight: 600;">'.$school['school_name'].'</label></p>';
			}
		}
		else{
			$output.='<p>No Schools found in this district.</p>';
		}
		echo $output;
	}
	public function set_due_dates()
	{
		$district_id = $this->request->getVar('district_id');
		$school_ids = $this->request->getVar('school_ids');
		$year = $this->request->getVar('year');
		$exp_sch = explode(",",$school_ids);
		if(count($exp_sch))
		{
			foreach($exp_sch as $school_id)
			{
				$dates = $this->db->table('report_result')->select('*')->where('school_id',$school_id)->where('year',$year)->get()->getRowArray();
				if($dates!=null && count($dates))
				{
					$dataval['0'] = $this->request->getVar('due_date_11');
					$dataval['1'] = $this->request->getVar('due_date_12');
					$dataval['2'] = $this->request->getVar('due_date_13');
					$dataval['3'] = $this->request->getVar('due_date_14');
					$dataval['4'] = $this->request->getVar('due_date_16');
					$dataval['5'] = $this->request->getVar('due_date_15');
					$dataval['6'] = $this->request->getVar('due_date_4');
					$dataval['7'] = $this->request->getVar('due_date_1');
					$dataval['8'] = $this->request->getVar('due_date_2');
					$dataval['9'] = $this->request->getVar('due_date_3');
					$dataval['10'] = $this->request->getVar('due_date_5');
					$dataval['11'] = $this->request->getVar('due_date_6');
					$dataval['12'] = $this->request->getVar('due_date_7');
					$dataval['13'] = $this->request->getVar('due_date_8');
					$dataval['14'] = $this->request->getVar('due_date_9');
					$dates = serialize($dataval);
					$data['due_dates'] = $dates;
					$this->commonModel->Update_Values('report_result',$data,$dates['id']);
				}
				else{
					$dataval['0'] = $this->request->getVar('due_date_11');
					$dataval['1'] = $this->request->getVar('due_date_12');
					$dataval['2'] = $this->request->getVar('due_date_13');
					$dataval['3'] = $this->request->getVar('due_date_14');
					$dataval['4'] = $this->request->getVar('due_date_16');
					$dataval['5'] = $this->request->getVar('due_date_15');
					$dataval['6'] = $this->request->getVar('due_date_4');
					$dataval['7'] = $this->request->getVar('due_date_1');
					$dataval['8'] = $this->request->getVar('due_date_2');
					$dataval['9'] = $this->request->getVar('due_date_3');
					$dataval['10'] = $this->request->getVar('due_date_5');
					$dataval['11'] = $this->request->getVar('due_date_6');
					$dataval['12'] = $this->request->getVar('due_date_7');
					$dataval['13'] = $this->request->getVar('due_date_8');
					$dataval['14'] = $this->request->getVar('due_date_9');
					$dates = serialize($dataval);
					$data['due_dates'] = $dates;
					$data['district_id'] = $district_id;
					$data['school_id'] = $school_id;
					$data['year'] = $year;
					$this->commonModel->Insert_Values('report_result',$data);
				}
			}
		}
	}
	public function download_view_reports()
	{
		$district_id = $this->request->getVar('district');
		$year = $this->request->getVar('year');
		$schools_ids = explode(",",$this->request->getVar('school_ids'));
		$cat_ids = explode(",",$this->request->getVar('cat_ids'));
		$output = '';
		foreach($schools_ids as $school_id)
		{
			$curr_year = $year;
			$next_year = $year + 1;
			$from = $year.'-07-01 00:00:00';
			$to = $next_year.'-06-30 23:59:00';
			
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$school_id);
	        $result = $this->db->table('report_result')->select('*')->where('school_id',$school_id)->where('year',$curr_year)->get()->getRowArray();
	        if(!empty($result))
	        {
	            $due_dates = unserialize($result['due_dates']);
	        }
	        else{
	            $due_dates = array();
	        }
	        $output.='<h5>School Name: '.$school_details['school_name'].'</h5>
	        <table class="table" style="margin-top:10px;width:100%">
            <thead>
            	<tr>
	                <td style="width:20%;text-align:left;padding:5px;background:#dfdfdf">Due Date</td>
	                <td style="width:60%;text-align:left;padding:5px;background:#dfdfdf">Financial Reports</td>
	                <td style="width:20%;text-align:left;padding:5px;background:#dfdfdf">'.$curr_year.' - '.$next_year.'</td>
	            </tr>
            </thead>
            <tbody>';
	        foreach($cat_ids as $cat_id)
	        {
	        	$report = $this->db->query("SELECT * FROM (`principal_attachments`) WHERE `school_id` = '$school_id' AND `type` = '$cat_id' AND `updatetime` >= '$from' AND `updatetime` <= '$to' ORDER BY `updatetime` desc")->getRowArray();
	        	if($cat_id == 11) { $pval = 'Annual Adopted Budget'; $key = 0; }
	        	elseif($cat_id == 12) { $pval = 'Unaudited Actuals'; $key = 1; }
	        	elseif($cat_id == 13) { $pval = 'First Interim'; $key = 2; }
				elseif($cat_id == 14) { $pval = 'Second Interim'; $key = 3; }
				elseif($cat_id == 16) { $pval = 'Third Interim (Annual)'; $key = 4; }
				elseif($cat_id == 15) { $pval = 'LCAP'; $key = 5; }
	        	elseif($cat_id == 4) { $pval = 'ANNUAL AUDIT'; $key = 6; }
				elseif($cat_id == 1) { $pval = 'P 1'; $key = 7; }
				elseif($cat_id == 2) { $pval = 'P 2'; $key = 8; }
				elseif($cat_id == 3) { $pval = 'P 3'; $key = 9; }
				elseif($cat_id == 5) { $pval = 'REPORT REVIEW'; $key = 10; }
				elseif($cat_id == 6) { $pval = 'FCMAT CALCULATOR'; $key = 11; }
				elseif($cat_id == 9) { $pval = 'Expanded Learning Opportunities Grant Plan'; $key = 14; }
				elseif($cat_id == 7) { $pval = 'Misc Report'; $key = 12; }
				elseif($cat_id == 8) { $pval = 'Misc Report'; $key = 13; }
				
				$dueDate='Optional';
				$updatetime='-';

				if(isset($due_dates[$key]) && !empty($due_dates[$key])) { 
					$dueDate=date('F d Y', strtotime($due_dates[$key])); 
				}
				if(!empty($report)) { 
					$updatetime=date('F d Y',strtotime($report['updatetime'])); 
				}

	        	$output.='<tr>
		            <td class="due_date_td_11">'.$dueDate.'</td>
		            <td>'.$pval.'</td>
		            <td>'.$updatetime.'</td>
		        </tr>';
	        }
	        $output.='</tbody>
	        </table>';
		}
		$name = 'Fiscal Report for Year '.date("Y");

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($output);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/admin/".$name.".pdf","F");
		echo $name.".pdf";
	}
	public function send_email_to_district_school($district_id,$school_id,$district_subject,$school_subject,$district_message,$school_message)
	{
		$school_details = $this->db->table('go_schools')->select('*')->where('id',$school_id)->get()->getRowArray();
		if(!empty($school_details))
		{
			$district_details = $this->db->table('go_district_admin')->select('*')->where('id',$district_id)->get()->getRowArray();
			$district_email = $district_details['email'];
			$school_email = $school_details['email'];
			$adminemail = 'info@csos.com';
			
			$contactmsg = '<!DOCTYPE HTML>'.
			'<head>'.
			'<meta http-equiv="content-type" content="text/html">'.
			'<title>Email notification</title>'.
			'</head>'.
			'<body>'.
			'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.
				   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">
				   		<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><b>Dear '.$district_details['fullname'].',</b></p>
				   		'.$district_message.'
						<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Report was sent on '.date('l jS \of F Y h:i:s A').'</p>'.
						'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Sincerely,<br/>CSOS Team<br/>'.
				   '</div>'.
			'</div>'.
			'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #ffcd44; color:#fff;">'.
				'All rights reserved @ csos - '.date('Y').''.
			'</div>'.
			'</body>';
			$contactschoolmsg = '<!DOCTYPE HTML>'.
			'<head>'.
			'<meta http-equiv="content-type" content="text/html">'.
			'<title>Email notification</title>'.
			'</head>'.
			'<body>'.
			'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.
				   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">
				   		<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><b>Dear '.$school_details['principal_name'].',</b></p>
				   		'.$school_message.'
						<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Report was sent on '.date('l jS \of F Y h:i:s A').'</p>'.
						'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Sincerely,<br/>CSOS Team<br/>'.
				   '</div>'.
			'</div>'.
			'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #ffcd44; color:#fff;">'.
				'All rights reserved @ csos - '.date('Y').''.
			'</div>'.
			'</body>';
			$contactheaders  = "From: ".$adminemail."\r\n";
			$contactheaders .= "Reply-To: ".$adminemail."\r\n";
			$contactheaders .= "MIME-Version: 1.0\r\n";
			$contactheaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($district_email, $district_subject, $contactmsg, $contactheaders);
			mail($school_email, $school_subject, $contactschoolmsg, $contactheaders);
		}
	}
	public function is_session_available() {
		if(empty($this->session)){
			return redirect()->to(base_url('administrator'));
		}
	}
}
