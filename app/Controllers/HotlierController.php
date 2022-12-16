<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HotlierModel;

class HotlierController extends BaseController
{
    private $hotlierModel;
    private $basePath = 'console/';
    private $consoleDirectory = "hotlier/";
    private $loggedInUser = null;
    private $defaultProperty = null;

    private $configData;

    function __construct()
    {
        $this->hotlierModel = new HotlierModel();
        $this->configData = array(
            "baseUrl" => base_url(),
            "assetsUrl" => base_url() . "/public/assets/",
            "moduleHomeDir" => $this->consoleDirectory
        );
    }

    public function _remap($method, $param1 = null, $param2 = null, $param3 = null)
    {
        $this->loggedInUser = $this->session->get('loggedinuser');
        if (empty($this->loggedInUser)) {
            return redirect()->to('auth/signout');
        } else {
            $this->defaultProperty = $this->session->get('defaultProperty');
            if (empty($this->defaultProperty) and $method !== "properties") {
                return redirect()->to($this->basePath . 'properties');
            } else {
                if (method_exists($this, $method)) {
                    return $this->$method($param1, $param2, $param3);
                } else {
                    return redirect()->to('auth/signout');
                }
            }
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

    public function properties()
    {
        $properties = $this->hotlierModel->getUserproperties($this->loggedInUser["userDetails"]->id);
        $data["properties"]=$properties;
        $this->view("properties",$data);
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
