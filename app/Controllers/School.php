<?php

namespace App\Controllers;
use Mpdf\Mpdf;

class School extends BaseController
{
    public function __construct()
    {
		$this->is_session_available();	
    }
    public function index()
    {
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
    public function commonData($title=null){ 
	    $data = array_merge($this->data, [
			'title'         => $title,
            'users'		=> $this->adminModel->GetAdminDetail($this->session->get('gowriteschooladmin_Userid'), 'go_schools'),            
            'surveys'		=> $this->adminModel->getSurveys(),
            'notifications'		=> $this->adminModel->getNotifications(),
		]);
        return $data ;
    }
    public function dashboard(){
		if(isset($this->session) && $this->session->get('gowriteschooladmin_Userid')==null){
			return redirect()->to(base_url('/'));
		}else{
			$data = $this->commonData();
			$data['title'] = 'School Admin Settings';
			$data['admin_id']= $this->session->get('gowriteschooladmin_Userid');
			$data['selectval'] = $this->commonModel->Select_Val_Id('go_schools',$data['admin_id']);
			$this->schoolBodyTemplate('schoolbody/dashboard',$data);
		}
	}
	public function manage_dashboard_surveys()
	{
		$data = $this->commonData();
		$data['title'] = 'Dashboard';
		$data['admin_id']= $this->session->get('gowriteschooladmin_Userid');
		$data['selectval'] = $this->commonModel->Select_Val_Id('go_schools',$data['admin_id']);
		$this->schoolBodyTemplate('schoolbody/manage_dashboard_surveys',$data);
	}
	public function manage_surveys()
	{
		$data = $this->commonData();
		$school_id = $this->session->get('gowriteschooladmin_Userid');
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'school/manage_surveys/';
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',2)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->get()->getResultArray();
		$this->schoolBodyTemplate('schoolbody/manage_surveys',$data);
	}
	public function manage_submitted_surveys()
	{
		$data = $this->commonData();
		$school_id = $this->session->get('gowriteschooladmin_Userid');
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'school/manage_surveys/';
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',3)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->get()->getResultArray();
		$this->schoolBodyTemplate('schoolbody/manage_submitted_surveys',$data);
	}
	public function manage_reviewed_surveys()
	{
		$data = $this->commonData();
		$school_id = $this->session->get('gowriteschooladmin_Userid');
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'school/manage_surveys/';
		$data['select_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',$school_id)->where('status',4)->get()->getResultArray();
		$data['master_templates'] = $this->db->table('master_templates')->select('*')->where('school_id',0)->get()->getResultArray();
		$this->schoolBodyTemplate('schoolbody/manage_reviewed_surveys',$data);
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
		$this->schoolBodyTemplate('schoolbody/addtemplate',$data);
	}
	public function addtemplate_step2($template_id = '')
	{
		$data = $this->commonData();
		$data['title'] = 'Edit Master Template Step 2';
		$data['addendum']=$this->commonModel->Select_Val_Id('master_templates',$template_id);
		$data['template_id']= $template_id;
		$this->schoolBodyTemplate('schoolbody/addtemplate_step2',$data);
	}
	public function addtemplate_step3($template_id = '')
	{
		$data = $this->commonData();
		$data['title'] = 'Edit Master Template Step 2';
		$data['forms']=$this->db->table('template_forms')->select('*')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
		$data['template_id']= $template_id;
		$data['templates'] = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		$this->schoolBodyTemplate('schoolbody/addtemplate_step3',$data);
	}
	public function save_template_content()
	{
		$template_id = $this->request->getPost('hidden_template_id');
		return $this->response->redirect(site_url("school/addtemplate_step2/".$template_id));
	}
	public function save_template_content_step2()
	{
		$template_id = $this->request->getPost('hidden_template_id');
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		if($template_details['status'] != 3)
		{
			$data['school_name'] = $this->request->getPost('school_name');
			$data['location'] = $this->request->getPost('location');
			$data['contact_name'] = $this->request->getPost('contact_name');
			$data['home_address'] = $this->request->getPost('home_address');
			$data['email_address'] = $this->request->getPost('email_address');
			$data['phone'] = $this->request->getPost('phone');
			$data['school_phone'] = $this->request->getPost('school_phone');
			$data['fax'] = $this->request->getPost('fax');
			$serialize = serialize($data);
			$dataval['answers'] = $serialize;
			$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
		}
		return $this->response->redirect(site_url("school/addtemplate_step3/".$template_id));
				
	}
	public function save_template_content_step3()
	{
		$template_id = $this->request->getPost('hidden_template_id');
		$comments = $this->request->getPost('comments');
		$mark = $this->request->getPost('mark');
		$check_title = $this->db->select('*')->table('template_forms')->where('template_id',$template_id)->get()->getResultArray();
		
		if(count($check_title))
		{
			$sub_id = 0;
			$key_summary = 0;
			foreach($check_title as $key => $check)
			{
				if($check['set_title'] == 0)
				{
					if($mark[$key] == "1") { 
						$datatemplate['strong'] = "1"; 
						$datatemplate['sufficient'] = "X"; 
						$datatemplate['insufficient'] = "X"; 
						$datatemplate['na'] = "X"; 
					}
					elseif($mark[$key] == "2") { 
						$datatemplate['strong'] = "X"; 
						$datatemplate['sufficient'] = "1"; 
						$datatemplate['insufficient'] = "X"; 
						$datatemplate['na'] = "X"; 
					}
					elseif($mark[$key] == "3") { 
						$datatemplate['strong'] = "X"; 
						$datatemplate['sufficient'] = "X"; 
						$datatemplate['insufficient'] = "1"; 
						$datatemplate['na'] = "X"; 
					}
					elseif($mark[$key] == "4") { 
						$datatemplate['strong'] = "X"; 
						$datatemplate['sufficient'] = "X"; 
						$datatemplate['insufficient'] = "X"; 
						$datatemplate['na'] = "1"; 
					}
					else{
						$datatemplate['strong'] = "X";
						$datatemplate['sufficient'] = "X";
						$datatemplate['insufficient'] = "X";
						$datatemplate['na'] = "X";
					}
					$datatemplate['comments'] = $comments[$key];
					$this->commonModel->Update_Values('template_forms',$datatemplate,$check['id']);
				}
			}
		}
		$dataval['status'] = 3;
		$dataval['school_status'] = 1;
		$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		if(!empty($template_details))
		{
			$school_details = $this->db->select('*')->table('go_schools')->where('id',$template_details['school_id'])->get()->getRowArray();
			if(!empty($school_details))
			{
				$school_email = $school_details['email'];
				$admin_details = $this->db->select('*')->table('go_admin')->where('id',1)->get()->getRowArray();
				$adminemail = $admin_details['email'];
				$contactsubject = 'Survey submitted by school admin';
				
				$contactmsg = '<!DOCTYPE HTML>'.
				'<head>'.
				'<meta http-equiv="content-type" content="text/html">'.
				'<title>Email notification</title>'.
				'</head>'.
				'<body>'.
				'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.
						'<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'.
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><b>Dear Administrator,</b></p>'.
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">The Charter School Oversight Survey you recently completed and sent to the '.$school_details['school_name'].' has been completed by the School admin. Please login to the CSOS website to review the completed Survey and send your feedback.</p>'.
							
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Completed Survey was sent on '.date('l jS \of F Y h:i:s A').'</p>'.
							'<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Sincerely,<br/>CSOS Team<br/>'.
						'</div>'.
				'</div>'.
				'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #ffcd44; color:#fff;">'.
					'All rights reserved @ csos - '.date('Y').''.
				'</div>'.
				'</body>';
				$contactheaders  = "From: ".$school_email."\r\n";
				$contactheaders .= "Reply-To: ".$school_email."\r\n";
				$contactheaders .= "MIME-Version: 1.0\r\n";
				$contactheaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($adminemail, $contactsubject, $contactmsg, $contactheaders);
			}
		}
		$this->session->set_flashdata('sucess_msg', 'Survey Submitted Successfully');
		redirect(base_url()."school/manage_surveys");
	}
	public function ajax_create_master_template_step2()
	{
		parse_str($_POST['formdatas'], $searcharray);
		$template_id = $searcharray['hidden_template_id'];
		$template_details = $this->commonModel->Select_Val_Id('master_templates',$template_id);
		if($template_details['status'] != 3)
		{
			$data['school_name'] = $searcharray['school_name'];
			$data['location'] = $searcharray['location'];
			$data['contact_name'] = $searcharray['contact_name'];
			$data['home_address'] = $searcharray['home_address'];
			$data['email_address'] = $searcharray['email_address'];
			$data['phone'] = $searcharray['phone'];
			$data['school_phone'] = $searcharray['school_phone'];
			$data['fax'] = $searcharray['fax'];
			$serialize = serialize($data);
			$dataval['answers'] = $serialize;
			$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
		}
				
	}
	public function ajax_create_master_template_step3()
	{
		parse_str($_POST['formdatas'], $searcharray);
		$template_id = $searcharray['hidden_template_id'];
		$comments = $searcharray['comments'];
		$mark = $searcharray['mark'];
		$check_title = $this->db->select('*')->table('template_forms')->where('template_id',$template_id)->get()->getResultArray();
		if(count($check_title))
		{
			$sub_id = 0;
			$key_summary = 0;
			foreach($check_title as $key => $check)
			{
				if($check['set_title'] == 0)
				{
					if($mark[$key] == "1") { 
						$datatemplate['strong'] = "1"; 
						$datatemplate['sufficient'] = "X"; 
						$datatemplate['insufficient'] = "X"; 
						$datatemplate['na'] = "X"; 
					}
					elseif($mark[$key] == "2") { 
						$datatemplate['strong'] = "X"; 
						$datatemplate['sufficient'] = "1"; 
						$datatemplate['insufficient'] = "X"; 
						$datatemplate['na'] = "X"; 
					}
					elseif($mark[$key] == "3") { 
						$datatemplate['strong'] = "X"; 
						$datatemplate['sufficient'] = "X"; 
						$datatemplate['insufficient'] = "1"; 
						$datatemplate['na'] = "X"; 
					}
					elseif($mark[$key] == "4") { 
						$datatemplate['strong'] = "X"; 
						$datatemplate['sufficient'] = "X"; 
						$datatemplate['insufficient'] = "X"; 
						$datatemplate['na'] = "1"; 
					}
					else{
						$datatemplate['strong'] = "X";
						$datatemplate['sufficient'] = "X";
						$datatemplate['insufficient'] = "X";
						$datatemplate['na'] = "X";
					}
					$datatemplate['comments'] = $comments[$key];
					$this->commonModel->Update_Values('template_forms',$datatemplate,$check['id']);
				}
			}
		}
		$dataval['status'] = 3;
		$dataval['school_status'] = 1;
		$this->commonModel->Update_Values('master_templates',$dataval,$template_id);
	}
	public function delete_survey($id = '')
	{
		$template = $this->commonModel->Select_Val_Id('master_templates',$id);	
		$school_id = $template['school_id'];
		$this->commonModel->Delete_Values('master_templates',$id);
		$this->commonModel->Delete_Related_Values('template_forms','template_id',$id);
		$this->session->set_flashdata('sucess_msg', 'Survey Deleted Successfully');
		redirect(base_url('school/manage_surveys'));
	}
	public function print_pdf()
		{
			$template_id = $this->request->getPost('template_id');
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
			$upload_dir = 'papers/school/';
			if(!file_exists($upload_dir))
			{
				mkdir($upload_dir);
			}
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->WriteHTML($html);
			$this->response->setHeader('Content-Type', 'application/pdf');
			$mpdf->Output("papers/school/".$name.".pdf","F");
			echo $name.".pdf";
		}
	public function print_page_breaks()
	{
		$template_id = $this->request->getPost('template_id');
		$selectval = $this->db->select('*')->table('master_templates')->where('id',$template_id)->get()->getRowArray();
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
			$forms = $this->db->select('*')->table('template_forms')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
			if(!empty($forms))
			{
				$outputval = '';
				foreach($forms as $key => $form)
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
						$get_sub_inputs = $this->db->select('*')->table('template_forms')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
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
		$upload_dir = 'papers/school/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/school/".$name.".pdf","F");
		echo $name.".pdf";			
	}
	public function print_pdf_sections()
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
		$upload_dir = 'papers/school/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/school/".$name.".pdf","F");
		echo $name.".pdf";
	}
	public function download_pdf()
	{
		$template_id = $this->request->getpost('template_id');
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
		$upload_dir = 'papers/school/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/school/".$name.".pdf","F");
		echo $name.".pdf";
	}
	public function download_page_breaks()
	{
		$template_id = $this->request->getpost('template_id');
		$selectval = $this->db->select('*')->from('master_templates')->where('id',$template_id)->get()->getRowArray();
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
			$forms = $this->db->select('*')->from('template_forms')->where('template_id',$template_id)->where('sub_id',0)->get()->getResultArray();
			if(!empty($forms))
			{
				$outputval = '';
				foreach($forms as $key => $form)
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
						$get_sub_inputs = $this->db->select('*')->from('template_forms')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
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
		$upload_dir = 'papers/school/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/school/".$name.".pdf","F");
		echo $name.".pdf";
		
	}
	public function download_pdf_sections()
	{
		$template_id = $this->request->getPost('template_id');
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
		$upload_dir = 'papers/school/';
		if(!file_exists($upload_dir))
		{
			mkdir($upload_dir);
		}
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output("papers/school/".$name.".pdf","F");
		echo $name.".pdf";
		
	}
	public function terms_of_use()
	{
		$data = $this->commonData();
		$data['page'] = $this->commonModel->Select_Val_Id('pages',1);
		$this->schoolBodyTemplate('schoolbody/page',$data);
	}
	public function privacy_policy()
	{
		$data = $this->commonData();
		$data['page'] = $this->commonModel->Select_Val_Id('pages',2);
		$this->schoolBodyTemplate('schoolbody/page',$data);
	}
	public function view_result_reports()
	{
		$data = $this->commonData();
		$data['title']= 'ADMIN';
		$config['base_url'] = BASE_URL.'admin/view_result_reports/';
		$this->schoolBodyTemplate('schoolbody/view_result_reports',$data);
	}
	public function reports_result()
		{
			$school_id = $this->session->get('gowriteschooladmin_Userid');
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

	        // $output.='<tr>
	        //     <td class="due_date_td_11">'; if(isset($due_dates[0])) { $output.=date('F d Y', strtotime($due_dates[0])); } $output.='</td>
	        //     <td>Annual Adopted Budget</td>
	        //     <td>'; if(!empty($report_1)) { $output.=date('F d Y',strtotime($report_1['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_12">'; if(isset($due_dates[1])) { $output.=date('F d Y', strtotime($due_dates[1])); } $output.='</td>
	        //     <td>Unaudited Actuals</td>
	        //     <td>'; if(!empty($report_2)) { $output.=date('F d Y',strtotime($report_2['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_13">'; if(isset($due_dates[2])) { $output.=date('F d Y', strtotime($due_dates[2])); } $output.='</td>
	        //     <td>First Interim</td>
	        //     <td>'; if(!empty($report_3)) { $output.=date('F d Y',strtotime($report_3['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_14">'; if(isset($due_dates[3])) { $output.=date('F d Y', strtotime($due_dates[3])); } $output.='</td>
	        //     <td>Second Interim</td>
	        //     <td>'; if(!empty($report_4)) { $output.=date('F d Y',strtotime($report_4['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_16">'; if(isset($due_dates[4])) { $output.=date('F d Y', strtotime($due_dates[4])); } $output.='</td>
	        //     <td>Third Interim(Annual)</td>
	        //     <td>'; if(!empty($report_5)) { $output.=date('F d Y',strtotime($report_5['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_15">'; if(isset($due_dates[5])) { $output.=date('F d Y', strtotime($due_dates[5])); } $output.='</td>
	        //     <td>LCAP</td>
	        //     <td>'; if(!empty($report_6)) { $output.=date('F d Y',strtotime($report_6['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_4">'; if(isset($due_dates[6])) { $output.=date('F d Y', strtotime($due_dates[6])); } $output.='</td>
	        //     <td>Annual Audit</td>
	        //     <td>'; if(!empty($report_7)) { $output.=date('F d Y',strtotime($report_7['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_1">'; if(isset($due_dates[7])) { $output.=date('F d Y', strtotime($due_dates[7])); } $output.='</td>
	        //     <td>P 1</td>
	        //     <td>'; if(!empty($report_8)) { $output.=date('F d Y',strtotime($report_8['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_2">'; if(isset($due_dates[8])) { $output.=date('F d Y', strtotime($due_dates[8])); } $output.='</td>
	        //     <td>P 2</td>
	        //     <td>'; if(!empty($report_9)) { $output.=date('F d Y',strtotime($report_9['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_3">'; if(isset($due_dates[9])) { $output.=date('F d Y', strtotime($due_dates[9])); } $output.='</td>
	        //     <td>P 3</td>
	        //     <td>'; if(!empty($report_10)) { $output.=date('F d Y',strtotime($report_10['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_5">'; if(isset($due_dates[10])) { $output.=date('F d Y', strtotime($due_dates[10])); } $output.='</td>
	        //     <td>Report Review</td>
	        //     <td>'; if(!empty($report_11)) { $output.=date('F d Y',strtotime($report_11['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_6">'; if(isset($due_dates[11])) { $output.=date('F d Y', strtotime($due_dates[11])); } $output.='</td>
	        //     <td>FCMAT Calculator</td>
	        //     <td>'; if(!empty($report_12)) { $output.=date('F d Y',strtotime($report_12['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_9">'; if(isset($due_dates[14])) { $output.=date('F d Y', strtotime($due_dates[14])); } $output.='</td>
	        //     <td>Expanded Learning Opportunities Grant Plan</td>
	        //     <td>'; if(!empty($report_15)) { $output.=date('F d Y',strtotime($report_15['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_7">'; if(isset($due_dates[12])) { $output.=date('F d Y', strtotime($due_dates[12])); } $output.='</td>
	        //     <td>Misc Report</td>
	        //     <td>'; if(!empty($report_13)) { $output.=date('F d Y',strtotime($report_13['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>
	        // <tr>
	        //     <td class="due_date_td_8">'; if(isset($due_dates[13])) { $output.=date('F d Y', strtotime($due_dates[13])); } $output.='</td>
	        //     <td>Misc Report</td>
	        //     <td>'; if(!empty($report_14)) { $output.=date('F d Y',strtotime($report_14['updatetime'])); } else { $output.='-'; } $output.='</td>
	        // </tr>';
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
    public function admin_setting()
		{
			if($this->request->getPost('namesetting'))
			{
				$userid = $this->session->get('gowriteschooladmin_Userid');
				$inputData['username']   = $this->request->getPost('username');
				$inputData['email']= $this->request->getPost('adminemail');
				$inputData['principal_name'] = $this->request->getPost('principal_name');
				$inputData['phone'] = $this->request->getPost('phone');
				$inputData['contact_name'] = $this->request->getPost('contact_name');
				$inputData['phone_1'] = $this->request->getPost('phone_1');
				$inputData['contactemail'] = $this->request->getPost('contactemail');
				if($this->request->getPost('newpassword') != "")
				{
					$inputData['password']= password_hash(trim($this->request->getVar('newpassword')), PASSWORD_DEFAULT);
				}
				
				$inputData['school_name'] = $this->request->getPost('school_name');
				$inputData['address'] = $this->request->getPost('address');
				$inputData['school_email'] = $this->request->getPost('school_email');
				$inputData['school_phone'] = $this->request->getPost('school_phone');
				$inputData['school_fax'] = $this->request->getPost('school_fax');
				$inputData['cds_code'] = $this->request->getPost('cds_code');
				$inputData['charter'] = $this->request->getPost('charter');
				$inputData['from_school'] = $this->request->getPost('from_school');
				$inputData['to_school'] = $this->request->getPost('to_school');
				$inputData['from_one_school'] = $this->request->getPost('from_one_school');
				$inputData['to_one_school'] = $this->request->getPost('to_one_school');
				$inputData['from_two_school'] = $this->request->getPost('from_two_school');
				$inputData['to_two_school'] = $this->request->getPost('to_two_school');
				$inputData['from_three_school'] = $this->request->getPost('from_three_school');
				$inputData['to_three_school'] = $this->request->getPost('to_three_school');
				if($_FILES['adminimage']['name']!='')
				{
					$name = $_FILES['adminimage']['name'];
					$tmp_name = $_FILES['adminimage']['tmp_name'];
					$upload_dir = UPLOAD_PROFILEPICS.'principal/';
					$inputData['image'] = $name;
					move_uploaded_file($tmp_name,$upload_dir.$name);
				}
				if($_FILES['charter_school_petition']['name']!='')
				{
					$name = $_FILES['charter_school_petition']['name'];
					$tmp_name = $_FILES['charter_school_petition']['tmp_name'];
					$upload_dir = 'uploads/school_notes/';
					$inputData['charter_school_petition'] = $name;
					move_uploaded_file($tmp_name,$upload_dir.$name);
				}
				if($_FILES['material_revision']['name']!='')
				{
					$name = $_FILES['material_revision']['name'];
					$tmp_name = $_FILES['material_revision']['tmp_name'];
					$upload_dir = 'uploads/school_notes/';
					$inputData['material_revision'] = $name;
					move_uploaded_file($tmp_name,$upload_dir.$name);
				}
				if($_FILES['charter_school_mou']['name']!='')
				{
					$name = $_FILES['charter_school_mou']['name'];
					$tmp_name = $_FILES['charter_school_mou']['tmp_name'];
					$upload_dir = 'uploads/school_notes/';
					$inputData['charter_school_mou'] = $name;
					move_uploaded_file($tmp_name,$upload_dir.$name);
				}
				if($_FILES['mou_material_revision']['name']!='')
				{
					$name = $_FILES['mou_material_revision']['name'];
					$tmp_name = $_FILES['mou_material_revision']['tmp_name'];
					$upload_dir = 'uploads/school_notes/';
					$inputData['mou_material_revision'] = $name;
					move_uploaded_file($tmp_name,$upload_dir.$name);
				}
				$result = $this->commonModel->Update_Values('go_schools',$inputData,$userid);
				session()->setFlashdata('notif_success', 'Settings Updated Successfully');
				return $this->response->redirect(site_url('school/admin_setting'));
			}
			
			$data = $this->commonData();
			$data['title'] = 'School Admin Settings';
			$data['admin_id']= $this->session->get('gowriteschooladmin_Userid');
			$data['selectval'] = $this->commonModel->Select_Val_Id('go_schools',$data['admin_id']);
			$this->schoolBodyTemplate('schoolbody/admin_settings',$data);
	}
	public function user_documents_timeline(){
		$data = $this->commonData();
		$data['title']= 'USER';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$config['base_url'] = BASE_URL.'school/user_documents_timeline/';
		$this->schoolBodyTemplate('documents_timeline',$data);
	}
	public function user_school_lists()
		{
			$district_id = $this->request->getVar('district_id');
			$schools = $this->db->table('go_schools')->select('*')->where('district_id',$district_id)->get()->getResultArray();
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
		public function user_get_documents_timeline()
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
							$attachments = $this->db->table('principal_attachments')->select('*')->where('type',15)->like('updatetime',$currentmonthyear)->get()->getResultArray();
							
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
	public function principal_apportionment(){
		$data = $this->commonData();
		if(isset($_GET['notify']))
		{
			$id = $_GET['notify'];
			$dataval['school_status'] = 0;
			$this->commonModel->Update_Values('notifications',$dataval,$id);
		}
		$type = $this->request->getPost('type');
		$data['title']= 'School';
		$data['type']= $type;
		$config['base_url'] = BASE_URL.'school/principal_apportionment/';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->get()->getResultArray();
		$this->schoolBodyTemplate('schoolbody/principal_apportionment',$data);
	}
	public function show_existing_comments()
	{
		$task_id = $this->request->getPost('task_id');
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
		$data['type'] = 3;
		$data['user_id'] = $this->session->get('gowriteschooladmin_Userid');
		$school_id = $this->commonModel->Insert_Values('report_specifics',$data);

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
		$datanotify['message'] = '<p style="margin-bottom:0px">Message From School Admin</p><spam class="inner_message" style="font-size:12px;color:#009500">'.$comments.'</spam>';
		$datanotify['type'] = 1;
		$datanotify['created_by'] = 3;
		$datanotify['user_id'] = $this->session->get('gowriteschooladmin_Userid');
		$datanotify['admin'] = 1;
		$datanotify['district_id'] = $report['district_id'];
		$datanotify['school_id'] = 0;
		$datanotify['status'] = 1;
		$datanotify['district_status'] = 1;
		$datanotify['school_status'] = 0;
		$this->commonModel->Insert_Values('notifications',$datanotify);

		$admin_subject = 'Report: '.$typeval.' - Message From School Admin';
		$district_subject = 'Report: '.$typeval.' - Message From School Admin';

		$admin_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Message From School Admin for the '.$typeval.' Report to School '.$school_details['school_name'].'</p><p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">'.$comments.'</p>';
		$district_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">Message From School Admin for the '.$typeval.' Report to School '.$school_details['school_name'].'</p><p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">'.$comments.'</p>';
		$this->send_email_to_district_school($report['district_id'],$this->session->get('gowriteschooladmin_Userid'),$admin_subject,$district_subject,$admin_message,$district_message);

		$school_details = $this->commonModel->Select_Val_Id('go_schools',$school_id);
		echo '<p class="header_p">Message From '.$school_details['principal_name'].' (School Admin):</p>'.$comments;
	}
	public function update_principal_apportionment(){
			$school = $this->session->get('gowriteschooladmin_Userid');
			$school_details = $this->commonModel->Select_Val_Id('go_schools',$school);
			$type = $this->request->getPost('hidden_type');
			$total = count($_FILES['file']['name']);
			$upload_dir = 'uploads/admin';
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir);
			}
			$upload_dir = $upload_dir.'/'.time();
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir);
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
			
			$inputData['url'] = $upload_dir;
			$inputData['filename'] = $fname;
			$inputData['type'] = $type;
			$inputData['school_id'] = $school;
			$inputData['district_id'] = $school_details['district_id'];
			
			$lastinsertId = $this->commonModel->Insert_Values('principal_attachments',$inputData);
			$task_id = $lastinsertId;		

			$report = $this->commonModel->Select_Val_Id('principal_attachments',$task_id);
			$datanotify['report_id'] = $task_id;
			$datanotify['message'] = '<p>'.$typeval.' Report has been submitted from School Admin</p>';
			$datanotify['type'] = 1;
			$datanotify['created_by'] = 3;
			$datanotify['user_id'] = $this->session->get('gowriteschooladmin_Userid');
			$datanotify['admin'] = 1;
			$datanotify['district_id'] = $school_details['district_id'];
			$datanotify['school_id'] = 0;
			$datanotify['status'] = 1;
			$datanotify['district_status'] = 1;
			$datanotify['school_status'] = 0;
			$this->commonModel->Insert_Values('notifications',$datanotify);

			$admin_subject = $typeval.' Report has been submitted from School Admin';
			$district_subject = $typeval.' Report has been submitted from School Admin';

			$admin_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">The '.$typeval.' has been uploaded by School Admin for the school '.$school_details['school_name'].'. Please login to the CSOS website to view the submitted Report.</p>';
			$district_message = '<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">The '.$typeval.' has been uploaded by School Admin for the school '.$school_details['school_name'].'. Please login to the CSOS website to view the submitted Report.</p>';
			$this->send_email_to_district_school($school_details['district_id'],$this->session->get('gowriteschooladmin_Userid'),$admin_subject,$district_subject,$admin_message,$district_message);

			session()->setFlashdata('notif_success', 'File Attached Successfully');
			return $this->response->redirect(site_url('school/principal_apportionment?type='.$type.''));
	}
	
	public function documents_timeline(){
		$data = $this->commonData();
		$data['title']= 'ADMIN';
		$data['districts']= $this->db->table('go_district_admin')->select('*')->where('status',0)->get()->getResultArray();
		$config['base_url'] = BASE_URL.'admin/principal_apportionment/';
		$this->schoolBodyTemplate('schoolbody/documents_timeline',$data);
	}
	public function get_documents_timeline()
	{	
			$school = $this->session->get('gowriteschooladmin_Userid');
			$year = $this->request->getPost('year');
			$nxtyear = $year + 1;
			$current_year = $year.'-06-01 00:00:00';
			$next_year = $nxtyear.'-07-31 23:55:00';
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
	public function manage_reports()
	{
		$data = $this->commonData();
		$data['title']= 'School';
		$config['base_url'] = BASE_URL.'school/manage_reports/';
		$data['select_reports'] = $this->db->table('reports')->select('*')->where('master',1)->orderBy('order','asc')->get()->getResultArray();
		$this->schoolBodyTemplate('schoolbody/manage_reports',$data);
	}
	public function manage_all_reports()
	{
		$data = $this->commonData();
		$school_id = $this->session->get('gowriteschooladmin_Userid');
		$data['title']= 'School';
		$config['base_url'] = BASE_URL.'admin/manage_all_reports/';
		$data['select_attachments'] = $this->db->table('principal_attachments')->select('*')->where('school_id',$school_id)->get()->getResultArray();
		$this->schoolBodyTemplate('schoolbody/manage_all_reports',$data);
	}
	public function filter_by_school_search()
	{
        $category = $this->request->getVar('category');
		$year = $this->request->getVar('year');
		$school_id = $this->session->get('gowriteschooladmin_Userid');
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
			// $get_attachments = array();
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
								<h6>Report Submitted By School <br/><br/><span class="change_date_span">'.date('m/d/Y',strtotime($attach['updatetime'])).'</span></h6>
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
	public function send_email_to_district_school($district_id,$school_id,$admin_subject,$district_subject,$admin_message,$district_message)
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
					   		<p style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><b>Dear Admin,</b></p>
					   		'.$admin_message.'
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
				$contactheaders  = "From: ".$school_email."\r\n";
				$contactheaders .= "Reply-To: ".$school_email."\r\n";
				$contactheaders .= "MIME-Version: 1.0\r\n";
				$contactheaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($adminemail, $admin_subject, $contactmsg, $contactheaders);
				mail($district_email, $district_subject, $contactschoolmsg, $contactheaders);
			}
	}
	public function is_session_available() {
		if(isset($this->session) && $this->session->get('gowriteschooladmin_Userid')==null){
			return redirect('/');
		}
	}
    public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('/'));
	}
}
