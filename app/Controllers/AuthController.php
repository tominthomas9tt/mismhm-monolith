<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    private $authDirectory = "auth/";
    private $configData;

    function __construct()
    {
        $this->configData = array(
            "baseUrl"=>base_url(),
            "assetsUrl"=>base_url()."/public/assets/"
        );

    }


    public function _remap($method, $param1 = null, $param2 = null, $param3 = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param1, $param2, $param3);
        } else {
            $this->index();
        }
    }

    public function signout()
    {
        $this->session->remove("loggedinuser");
        return redirect()->to('auth/siginin');
    }

    public function siginin()
    {
        $isError = false;
        $title = "";
        $message = "";
        if ($this->request->getPost()) {
            $username = $this->request->getPost('form_username');
            $password = $this->request->getPost('form_password');
            if ($username == 'tominthomas9.tt@gmail.com' && $password == 'password') {
                $user = array(
                    "firstname"=>"Tomin",
                    "lastname"=>"Thomas",
                    "username"=>$username,
                    "role"=>"Hotlier"
                );
                $this->session->set("loggedinuser", $user);
                return redirect()->to('console/dashboard');
            } else {
                $isError = true;
                $title = "invalid credentials";
                $message = "Please enter valid credentials.";
            }
        }
        $data['isError'] = $isError;
        $data['title'] = $title;
        $data['message'] = $message;
        $this->view('siginin', $data);
    }

    public function index()
    {
        $isError = false;
        $title = "";
        $message = "";
        if ($this->request->getMethod() == 'post') {

            if (!true) {
                if (false) {
                    $title = "Registration completed";
                    $message = "Thankyou for your particiation.";
                } else {
                    $isError = true;
                    $title = "Registration failed";
                    $message = "User registration failed.";
                }
            } else {
                $isError = true;
                $title = "Registration failed";
                $message = "User already registered with mobile, place and designation. Please use a different mobile/place/designation.";
            }
        }
        $data['isError'] = $isError;
        $data['title'] = $title;
        $data['message'] = $message;
        $this->view("login", $data);
    }

    private function view($view, $data = [])
    {
        $data['configData']=$this->configData;
        echo view($this->authDirectory . $view, $data);
    }
}