<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    public function getUser($username = false, $userID = false){
        return $this->db->table(ADMIN_DETAILS)
        ->select('*')
        ->where(['username' => $username])
        ->where(['deletetime'=>''])
        ->get()->getRowArray();
       
    }
    public function GetAdminDetail($id,$table){
        $query = $this->db->table($table)
        ->select('*')
        ->where(['id' => $id])
        ->where(['deletetime'=>''])
        ->get()->getRowArray();
        return $query;
    }
    public function getSurveys(){
        $query = $this->db->table('master_templates')
        ->select('*')
        ->where('school_id !=', 0)
        ->where('school_status', 1)
        ->where('admin_status', 0)
        ->get()->getRowArray();
        return $query;
    }
    public function getNotifications(){
        $query = $this->db->table('notifications')
        ->select('*')
        ->where('status', 1)
        ->get()->getResultArray();
        return $query;
    }
    public function getDistrictCount(){
        $query = $this->db->table('go_district_admin')
        ->select('*')
        ->countAllResults();
        return $query;
    }
    public function getSchoolsCount(){
        $query = $this->db->table('go_schools')
        ->select('*')
        ->countAllResults();
        return $query;
    }
    public function getSchools($id=''){
        $query = $this->db->table('go_schools')
        ->select('*')
        ->where('district_id',$id)
        ->get()->getResultArray();
        return $query;
    }
    public function getTemplateCount(){
        $query = $this->db->table('master_templates')
        ->select('*')
        ->where('school_id',0)
        ->where('district_id',0)
        ->countAllResults();
        return $query;
    }
    public function getTemplate($id=''){
        $query = $this->db->table('master_templates')
        ->select('*')
        ->where('school_id',$id)
        ->get()->getResultArray();
        return $query;
    }
    public function getSurveysCount(){
        $query = $this->db->table('master_templates')
        ->select('*')
        ->where('school_id !=',0)
        ->countAllResults();
        return $query;
    }
    public function getReportCount(){
        $query = $this->db->table('reports')
        ->select('*')
        ->where('master',1)
        ->countAllResults();
        return $query;
    }
    public function GetDistrictadmin($first_name=''){
        $query = $this->db->table(DISTRICTADMIN_DETAILS)
        ->select('*')
        ->where('deletetime =','')
        ->where('virtual_district !=',1);
        if(!empty($first_name))
        {
            $query = $query->orLike('fullname',$first_name);
        }
        $query = $query->orderBy('id','desc')->get();
        return $query->getResultArray();
    }
    public function getSchoolsDetails($id=''){
        $query = $this->db->table(SCHOOL_DETAILS)
        ->select('*');
        if(!empty($id)){
            $query = $query->where('district_id',$id);
        }
        $query = $query->where('deletetime','')
        ->get()->getResultArray();
        return $query;
    }
    public function GetDistrictadmin_activated($first_name=''){
        $query = $this->db->table(DISTRICTADMIN_DETAILS)
        ->select('*')
        ->where('deletetime =','')
        ->where('status',0)
        ->where('virtual_district !=',1);
        if(!empty($first_name)){
            $query = $query->orLike('fullname',$first_name);
        }
        $query = $query->orderBy('district_name','desc')->get();
        return $query->getResultArray();
    }
}
