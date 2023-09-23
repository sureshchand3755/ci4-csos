<?php

namespace App\Controllers;

class District extends BaseController
{
    public function __construct()
    {	
    }
    public function index()
    {
        return $this->districtTemplate('districtbody/login'); 
    }
    // public function login(){       
       
    //     // if ($this->request->getMethod() == "post") {
    //     //     $rules = [
    //     //         'email' => 'required',
    //     //     ];
    //     //     if (!$this->validate($rules)) {
    //     //         return $this->admintemplate('common/login'); 
    //     //     }else{
    //     //         // $inputEmail 		= 'Patrick';
    //     //         // $inputPassword 		= 'admin';
    //     //         $inputEmail 		= htmlspecialchars($this->request->getVar('email', FILTER_UNSAFE_RAW));
    //     //         $inputPassword 		= htmlspecialchars($this->request->getVar('password', FILTER_UNSAFE_RAW));
                
    //     //         $user= $this->adminModel->getUser(username: $inputEmail);
    //     //         if ($user) {
    //     //             $password		= $user['password'];
    //     //             $verify = password_verify($inputPassword, $password);                   
    //     //             if ($verify) {
    //     //                 session()->set([
    //     //                     'gowriteadmin_Userid'		=> $user['id'],
    //     //                     'gowriteadmin_Username'		=> $user['username'],
    //     //                     'gowriteadmin_Fullname'		=> $user['fullname'],
    //     //                     'isLoggedIn' 	=> TRUE
    //     //                 ]);
    //     //                 return redirect()->to(base_url('admin/dashboard'));
    //     //             } else {
    //     //                 session()->setFlashdata('notif_error', '<b>Your Username or Password is Wrong !</b> ');
    //     //                 return redirect()->to(base_url());
    //     //             }
    //     //         } else {
    //     //             session()->setFlashdata('notif_error', '<b>Your Username or Password is Wrong!</b> ');
    //     //             return redirect()->to(base_url());
    //     //         }                
    //     //     }
    //     // }
        
    // }
    public function commonData($title=null){ 
        $data = array_merge($this->data, [
			'title'         => $title,
            'district_user'		=> $this->adminModel->GetAdminDetail($this->session->get('gowritedistrictadmin_Userid'), 'go_district_admin'),
            
            'surveys'		=> $this->adminModel->getSurveys(),
            'notifications'		=> $this->adminModel->getNotifications(),
		]);
        return $data ;
    }
    public function dashboard()
	{
        $data = $this->commonData();
		$data['title']= 'District';
		$this->districtBodyTemplate('districtbody/dashboard',$data);
	}

    public function manage_schools()
	{
        $data = $this->commonData();
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'district/manage_schools/';
		$district_id = $this->session->get('gowritedistrictadmin_Userid');
		$data['select_schools'] = $this->db->table(SCHOOL_DETAILS)->select('*')->where('district_id',$district_id)->where('deletetime','')->get()->getResultArray();
		$data['select_district'] = $this->districtModel->GetDistrictadmin_activated();
		$this->districtBodyTemplate('districtbody/manage_schools',$data);
	}

    public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('administrator'));
	}
}
