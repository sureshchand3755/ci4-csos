<?php

namespace App\Controllers;

class School extends BaseController
{
    public function __construct()
    {	
    }
    public function index()
    {
        // echo password_hash(123456, PASSWORD_DEFAULT);
        // exit;
        $data['islogin'] = 'TRUE';
        $data['title'] = 'School Admin Login';
        return $this->schoolTemplate('schoolbody/login',$data); 
    }
    public function home()
    {
        $data['islogin'] = 'TRUE';
        $data['title'] = 'School Admin Login';
        $this->schoolTemplate('schoolbody/login',$data);
    }
    
    public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('administrator'));
	}
}
