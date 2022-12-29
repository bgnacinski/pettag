<?php

namespace App\Controllers\Api\V1;

use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $model = new UsersModel();

        $input = [
            "email_address" => $this->request->getVar("email_address"),
            "password" => $this->request->getVar("password")
        ];

        $result = $model->login($input["email_address"], $input["password"]);

        if($result["success"]){
            return $this->respond([
                "status" => "success",
                "auth_key" => $result["auth_key"]
            ]);
        }
        else{
            return $this->failUnauthorized("Access denied.");
        }
    }

    public function register(){
        $model = new UsersModel();

        $input = [
            "email_address" => $this->request->getVar("email_address"),
            "password" => $this->request->getVar("password"),
            "password_conf" => $this->request->getVar("password_conf"),
            "phone_number" => $this->request->getVar("phone_number")
        ];

        $result = $model->newUser($input);

        if($result["success"]){
            return $this->respond($result);
        }
        else{
            return $this->failValidationErrors($result["errors"]);
        }
    }
}
