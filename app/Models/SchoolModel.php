<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    public function getUser($username = false, $userID = false){
        return $this->db->table(ADMIN_DETAILS)
        ->select('*')
        ->where(['username' => $username])
        ->where(['deletetime'=>''])
        ->get()->getRowArray();
       
    }
    public function SchoolValidateLogin($input){
        $row=array();
        $result=$this->db->table('go_schools')
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
}
