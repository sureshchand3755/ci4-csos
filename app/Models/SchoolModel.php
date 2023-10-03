<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    // public function SchoolValidateLogin($input){
    //     $row=array();
    //     $result=$this->db->table('go_schools')->select('*')
    //             ->where('id =',32)
    //             ->where('deletetime =','');
        
    //     if($result->countAllResults()>0){
    //         $row=$result->get()->getRowArray();
    //         $verify = password_verify($input['password'], $row['password']);  
    //         if($verify){
    //             return $row;
    //         }
    //     }else{
    //         return $row;
    //     }
    // }

    public function SchoolLogin($inputData){
        $row=array();
        $result=$this->db->table('go_schools')->select('*')->where('username',$inputData['username'])->where('deletetime =','')->get()->getRowArray(); 
        if(!empty($result) && count($result)>0){
            $verify = password_verify($inputData['password'], $result['password']);  
            if($verify){
                $row=$result;
                return $row;
            }
        }else{
            return $row;
        }
        return $row;
    }
}
