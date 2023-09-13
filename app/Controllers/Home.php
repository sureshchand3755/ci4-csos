<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $db = db_connect();
		helper(['url', 'form', 'array']);
		$this->session 	= \Config\Services::session();
    }
    public function index()
    {
        return $this->admintemplate('common/login'); 
    }
}
