<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    public function Select_Val_Id($table,$id){
		$query = $this->db->table($table)
        ->select('*')
		->where('id', $id)
        ->get()->getRowArray();
		return $query;
	}
    public function Select_District_Where_row($table,$districtname,$id=''){
        $query = $this->db->table($table)
		->select('*')
		->where('district_name =', $districtname)
		->where('id !=', $id);
		return $query->countAllResults();

	}
    public function Select_DistrictAdmin_Where_row($table,$districtadminname,$id=''){
        $query = $this->db->table($table)
        ->select('*')
		->where('username =', $districtadminname)
		->where('id !=', $id);
		return $query->countAllResults();

	}
    public function Select_DistrictAdmin_email_Where_row($table,$email,$id=''){
		$query = $this->db->table($table)
        ->select('*')
		->where('email =', $email)
		->where('id !=', $id);
		return $query->countAllResults();

	}

    public function Select_Schoolname_Where_row($table,$schoolname,$id=''){
        $query = $this->db->table($table)
        ->select('*')
        ->where('school_name =', $schoolname)
        ->where('id !=', $id);
		return $query->countAllResults();
	}
    public function Select_SchoolAdmin_Where_row($table,$schooladminname,$id=''){
		$query = $this->db->table($table)
        ->select('*')
		->where('username =', $schooladminname)
		->where('id !=', $id);
		return $query->countAllResults();
	}

    /**************CRUD OPERATIONS IN DATABASE************/
    public function Insert_Values($table,$data){
        $query = $this->db->table($table)->insert($data);
        return $this->db->insertID();//$this->db->affectedRows();
    }
    public function Update_Values($table,$data,$id){
        $query = $this->db->table($table)->where('id', $id)->update($data);
        return $this->db->affectedRows();
    }

    public function Update_Values_district_id($table,$data,$id){
        $query = $this->db->table($table)->where('district_id', $id)->update($data);
        return $this->db->affectedRows();
    }

    public function Delete_Values($table,$id){
		$query = $this->db->table($table)->where('id', $id)->delete();
		return $this->db->affectedRows();

	}
    public function Delete_Related_Values($table,$field,$id){
		$query = $this->db->table($table)->where($field, $id)->delete();
		return $this->db->affectedRows();
	}
}