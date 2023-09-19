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
    public function commonData($title){ 
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
            // dd($this->request->getVar('district_name'));
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
		if($this->input->isAJAX()) {
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
		if($this->input->isAJAX()) {
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
}
