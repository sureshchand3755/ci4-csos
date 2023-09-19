<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        // $db = db_connect();
		helper(['url', 'form', 'array']);
		// $this->session 	= \Config\Services::session();
        // $this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        return $this->admintemplate('common/login'); 
    }
    public function login(){       
       
        if ($this->request->getMethod() == "post") {
            $rules = [
                'email' => 'required',
            ];
            if (!$this->validate($rules)) {
                return $this->admintemplate('common/login'); 
            }else{
                $inputEmail 		= 'Patrick';//htmlspecialchars($this->request->getVar('email', FILTER_UNSAFE_RAW));
                $inputPassword 		= 'admin';// htmlspecialchars($this->request->getVar('password', FILTER_UNSAFE_RAW));
                $user= $this->adminModel->getUser(username: $inputEmail);
                if ($user) {
                    $password		= $user['password'];
                    $verify = password_verify($inputPassword, $password);                   
                    if ($verify) {
                        session()->set([
                            'gowriteadmin_Userid'		=> $user['id'],
                            'gowriteadmin_Username'		=> $user['username'],
                            'gowriteadmin_Fullname'		=> $user['fullname'],
                            'isLoggedIn' 	=> TRUE
                        ]);
                        return redirect()->to(base_url('admin/dashboard'));
                    } else {
                        session()->setFlashdata('notif_error', '<b>Your Username or Password is Wrong !</b> ');
                        return redirect()->to(base_url());
                    }
                } else {
                    session()->setFlashdata('notif_error', '<b>Your Username or Password is Wrong!</b> ');
                    return redirect()->to(base_url());
                }
                d($user);
            }
        }
        
    }
}
