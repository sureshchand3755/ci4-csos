<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    // public function SchoolValidateLogin($input){
        // $row=array();
        // $result=$this->db->table('go_schools')->select('*')
        //         ->where('id =',32)
        //         ->where('deletetime =','');
        
        // if($result->countAllResults()>0){
        //     $row=$result->get()->getRowArray();
        //     // echo password_hash(trim($input['password']), PASSWORD_DEFAULT);
        //     // exit;

        //     // return password_verify(123456, '$2y$10$ID3KlxXMTbLhBn3UXibm6ujMOyFbTRb4q82FQOQhCfnWztK.RQQbu');  
        //     return $this->db->getLastQuery();//'$2y$10$ID3KlxXMTbLhBn3UXibm6ujMOyFbTRb4q82FQOQhCfnWztK.RQQbu'.'@@@@@'.$row['password'];  
        //     exit;
        //     $verify = password_verify($input['password'], $row['password']);  
        //     return $verify;
        //     if($verify){
        //         return $row;
        //     }
        // }else{
        //     return $row;
        // }
    // }

    public function SchoolLogin($inputData){
        $row=array();
        $result=$this->db->table('go_schools')->select('*')->where('username',$inputData['username'])->where('deletetime =','')->get()->getRowArray();
        if(!empty($result) && count($result)>0){
            $row=$result;
            $verify = password_verify($inputData['password'], $row['password']);  
            if($verify){
                return $row;
            }
        }else{
            return $row;
        }
        return $row;
    }
}
