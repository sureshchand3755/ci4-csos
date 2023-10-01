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
                // $inputEmail 		= 'Patrick';
                // $inputPassword 		= 'admin';
                $inputEmail 		= htmlspecialchars($this->request->getVar('email', FILTER_UNSAFE_RAW));
                $inputPassword 		= htmlspecialchars($this->request->getVar('password', FILTER_UNSAFE_RAW));
                
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
            }
        }
        
    }
    public function sdLogin(){       
        if ($this->request->getMethod() == "post") {
            $rules = [
                'email' => 'required',
            ];
            if (!$this->validate($rules)) {
                return $this->schoolTemplate('schoolbody/login'); 
            }else{
                // $inputData['username'] 		= 'Denice';
                // $inputData['password'] 		= '123456';
                $inputData['username'] 		= htmlspecialchars($this->request->getVar('email', FILTER_UNSAFE_RAW));
                $inputData['password'] 		= htmlspecialchars($this->request->getVar('password', FILTER_UNSAFE_RAW));
                $usertype =  $this->request->getVar('usertype');
                if($usertype == 1){
					$result = $this->schoolModel->SchoolLogin($inputData);
                    if(!empty($result) && count($result) > 0){
                        session()->set([
                            'gowriteschooladmin_Userid'		=> $result['id'],
                            'gowriteschooladmin_Username'		=> $result['username'],
                            'gowriteschooladmin_Fullname'		=> $result['principal_name'],
                            'isLoggedIn' 	=> TRUE
                        ]);
						
						// $remember_me = $this->input->post('remember_me');
						// if($remember_me=='1')
						// {
						// $year = time() + 31536000;
						// setcookie('ad_username',$this->input->post('username'),$year);
						// setcookie('ad_password',$this->encrypt->encode($this->input->post('password')),$year);
						// }
						return $this->response->redirect(site_url("school/dashboard"));
					}
					else{
						session()->setFlashdata('notif_error', 'invalid Username and Password');
						return $this->response->redirect(site_url("school/login"));
					}
                }else{
                    $result = $this->districtModel->DistrictValidateLogin($inputData);
                    if(!empty($result) && count($result) > 0){
                        session()->set([
                            'gowritedistrictadmin_Userid'		=> $result['id'],
                            'gowritedistrictadmin_Username'		=> $result['username'],
                            'gowritedistrictadmin_Fullname'		=> $result['fullname'],
                            'isLoggedIn' 	=> TRUE
                        ]);
						// $remember_me = $this->input->post('remember_me');
						// if($remember_me=='1')
						// {
                        //     $year = time() + 31536000;
                        //     setcookie('ad_username',$this->input->post('username'),$year);
                        //     setcookie('ad_password',$this->encrypt->encode($this->input->post('password')),$year);
						// }
						return $this->response->redirect(site_url("district/dashboard"));
					}
					else{
                        session()->setFlashdata('notif_error', 'invalid Username and Password');
						return $this->response->redirect(site_url("school/login"));
					}
                }              
            }
        }
        
    }
    public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('administrator'));
	}
}
