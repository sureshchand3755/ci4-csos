<?php

namespace App\Controllers;
use MPDF;

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
		// $summary = $this->input->post('summary');
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
					'All rights reserved @ csos - '.date(Y).''.
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
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10, 'margin_top' => 10, 'margin_right' => 10, 'margin_bottom' => 1, 'orientation' => 'P' ]);

        $mpdf->WriteHTML('Testing');

        $this->response->setHeader('Content-Type', 'application/pdf');
        return redirect()->to($mpdf->Output('Cetak Peserta.pdf', 'I'));

		// $mpdf = new mPdf();
		// $html = view('html_to_pdf',[]);
		// $mpdf->WriteHTML($html);
		// $this->response->setHeader('Content-Type', 'application/pdf');
		// $mpdf->Output('arjun.pdf','I');
		exit;
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
		$mpdf->Output("papers/admin/".$name.".pdf","F");
		echo $name.".pdf";
	}
}
