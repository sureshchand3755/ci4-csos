<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\AdminModel;
use App\Models\DistrictModel;
use App\Models\SchoolModel;
use App\Models\CommonModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['cookie', 'date', 'security', 'url', 'form', 'array'];
    protected $data 	= [];
    protected $adminModel;
    protected $commonModel;
    protected $districtModel;
    protected $schoolModel;
    protected $session;
	protected $segment;
	protected $db;
    protected $router;
	protected $validation;
	protected $encrypter;
	protected $language;
    protected $fetchmethod;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session 		= \Config\Services::session();
		$this->segment 	  	= \Config\Services::request();
		$this->db         	= \Config\Database::connect();
		$this->validation 	= \Config\Services::validation();
		$this->encrypter 	= \Config\Services::encrypter();
        $this->router 		= \Config\Services::router(); 
        $this->language     = \Config\Services::language();       
		$this->adminModel  	= new AdminModel();
		$this->commonModel  = new CommonModel();
		$this->districtModel  = new DistrictModel();
		$this->schoolModel  = new SchoolModel();
		$user 				= $this->adminModel->getUser(username: session()->get('gowriteadmin_Username'));
		$segment 			= $this->request->uri->getSegment(1);
		if ($segment) {
			$subsegment 	= $this->request->uri->getSegment(2);
            $this->fetchmethod 	= $this->request->uri->getSegment(2);
		} else {
			$subsegment 	= '';
		}
		$this->data			= [
			'segment' 		=> $segment,
			'subsegment' 	=> $subsegment,
			'user' 			=> $user,
		];

        // E.g.: $this->session = \Config\Services::session();
    }
    public function adminTemplate(string $page)
    {
        echo view('layouts/admin_template');
        echo view($page);
    }
    public function districtTemplate(string $page)
    {
        echo view('layouts/districtadmin_template');
        echo view($page);
    }
    public function schoolTemplate(string $page)
    {
        echo view('layouts/schooladmin_template');
        echo view($page);
    }
    
    public function adminBodyTemplate(string $page, $data)
    {
        echo view('layouts/admin_template', $data);
        echo view('layouts/admin/header', $data);
        echo view($page, $data);
        echo view('layouts/admin/footer', $data);
    }
    public function districtBodyTemplate(string $page, $data)
    {
        echo view('layouts/districtadmin_template', $data);
        echo view('layouts/district/header', $data);
        echo view($page, $data);
        echo view('layouts/district/footer', $data);
    }
    public function schoolBodyTemplate(string $page, $data)
    {
        echo view('layouts/schooladmin_template', $data);
        echo view('layouts/school/header', $data);
        echo view($page, $data);
        echo view('layouts/school/footer', $data);
    }
}
