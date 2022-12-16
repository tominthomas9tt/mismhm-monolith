<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HotlierController extends BaseController
{
    private $consoleDirectory = "hotlier/";
    private $loggedInUser = null;

    private $configData;

    function __construct()
    {
        $this->configData = array(
            "baseUrl" => base_url(),
            "assetsUrl" => base_url() . "/public/assets/",
            "moduleHomeDir" => $this->consoleDirectory
        );
    }

    public function _remap($method, $param1 = null, $param2 = null, $param3 = null)
    {
        $this->loggedInUser = $this->session->get('loggedinuser');
        if (method_exists($this, $method) && !empty($this->loggedInUser)) {
            return $this->$method($param1, $param2, $param3);
        } else {
            return redirect()->to('auth/signout');
        }
    }

    public function index()
    {
        return redirect()->to($this->consoleDirectory . "dashboard");
    }

    public function dashboard()
    {
        $this->view("dashboard", []);
    }

    private function view($view, $data = [])
    {
        $data['loggedInUser'] = $this->loggedInUser;
        $data['configData'] = $this->configData;
        echo view($this->consoleDirectory . "header", $data);
        echo view($this->consoleDirectory . $view, $data);
        echo view($this->consoleDirectory . "footer", $data);
    }
}
