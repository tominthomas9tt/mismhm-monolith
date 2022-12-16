<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    private $authDirectory = "auth/";
    private $configData;

    function __construct()
    {
        $this->configData = array(
            "baseUrl" => base_url(),
            "assetsUrl" => base_url() . "/public/assets/"
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
        $this->session->remove("defaultProperty");
        return redirect()->to('auth/signin');
    }

    public function signin()
    {
        $isError = false;
        $title = "";
        $message = "";
        if ($this->request->getPost()) {
            $authModel = new AuthModel();
            $username = $this->request->getPost('form_username');
            $password = $this->request->getPost('form_password');
            $loginDetailsArray = $authModel->authUserDetails($username, $password);
            if ($loginDetailsArray) {
                $loginDetails = $loginDetailsArray[0];
                $user = array(
                    "userDetails" => $loginDetails,
                );
                $defaultPropertyArray = $authModel->getUserDefaultProperty($loginDetails->id);
                if ($defaultPropertyArray) {
                    $this->session->set("defaultProperty", $defaultPropertyArray[0]);
                }
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
        $this->view('signin', $data);
    }

    public function signup()
    {
        $isError = false;
        $title = "";
        $message = "";
        if ($this->request->getPost()) {
            $authModel = new AuthModel();
            $name = $this->request->getPost('form_name');
            $username = $this->request->getPost('form_username');
            $password = $this->request->getPost('form_password');
            $loginDetailsArray = $authModel->checkUserExist($username);
            if ($loginDetailsArray) {
                $isError = true;
                $title = "User already registered";
                $message = "Please sign in or try resetting password.";
            } else {
                $userData = array(
                    "firstname" => $name,
                    "username" => $username,
                    "password" => $password
                );
                $newUserCreated = $authModel->createUser($userData);
                if ($newUserCreated) {
                    return redirect()->to('auth/signin');
                }
            }
        }
        $data['isError'] = $isError;
        $data['title'] = $title;
        $data['message'] = $message;
        $this->view('signup', $data);
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
        $data['configData'] = $this->configData;
        echo view($this->authDirectory . $view, $data);
    }
}
