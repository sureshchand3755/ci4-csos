<?php

namespace App\Models;

use CodeIgniter\Model;

class DistrictModel extends Model
{
    public function DistrictValidateLogin($input){
        $row=array();
        $result=$this->db->table('go_district_admin')
                ->select('*')
                ->where('username',$input['username'])
                ->where('deletetime =','');
        if($result->countAllResults()>0){
            $row=$result->get()->getRowArray();
            $verify = password_verify($input['password'], $row['password']);  
            if($verify){
                return $row;
            }
        }else{
            return $row;
        }
    }
    public function GetDistrictadmin_activated($first_name=''){
        $query = $this->db->table(DISTRICTADMIN_DETAILS)->select('*')
        ->where('deletetime =','')
        ->where('status',0)
        ->where('virtual_district !=',1);
        if(!empty($first_name))
        {
            $query = $query->orLike('fullname',$first_name);
        }
        $query = $query->orderBy('district_name','desc')->get();
        return $query->getResultArray();
    }
}
