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

        if($result["status"]){
            return $this->respond([
                "status" => "success",
                "auth_key" => $result["auth_key"]
            ]);
        }
        else{
            return $this->failUnauthorized("Access denied.");
        }
    }
}
