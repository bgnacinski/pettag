<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\UserEntity;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = UserEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["email_address", "password", "phone_number", "auth_key", "permission_level"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        "email_address" => "required|is_unique[users.email_address]|valid_email",
        "password" => "required|min_length[8]",
        "password_conf" => "required|matches[password]",
        "phone_number" => "required|regex_match[^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$]" // todo: to re-consider
    ];
    protected $validationMessages   = [
        "email_address" => [
            "required" => "Email address is required.",
            "is_unique" => "This email address is already taken.",
            "valid_email" => "This email address isn't valid."
        ],
        "password" => [
            "required" => "Password is required.",
            "min_length" => "Minimum length of password is 8 characters."
        ],
        "password_conf" => [
            "required" => "Password confirmation is required.",
            "matches" => "Passwords do not match."
        ],
        "phone_number" => [
            "required" => "Phone number is required.",
            "regex_match" => "Phone number did not pass our validation."
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ["hashPassword", "generateAuthKey"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function hashPassword(array $data) :array{
        $data["data"]["password"] = password_hash($data["data"]["password"], PASSWORD_DEFAULT);
        
        return $data;
    }

    public function generateAuthKey(array $data) :array{
        $auth_key = hash("sha256", random_bytes(512));

        $data["data"]["auth_key"] = $auth_key;

        return $data;
    }

    public function login(string $email_addr, string $password) :array{
        $result = $this->where("email_address", $email_addr)->first();

        if($result){
            if(password_verify($password, $result->password)){
                return [
                    "success"=> true, 
                    "auth_key" => $result->auth_key,
                    "exists" => true // propably(~100%) will never be used
                ];
            }
            else{
                return [
                    "success" => false,
                    "exists" => true
                ];
            }
        }
        else{
            return [
                "success" => false, 
                "exists" => false
            ];
        }
    }

    public function newUser(array $input){
        $result = $this->validate($input);

        if(!$result){
            return [
                "success" => false,
                "errors" => $this->errors()
            ];
        }
        else{
            $new_user = new UserEntity($input);

            $this->insert($new_user);
            $new_user = $this->find($this->insertID);

            return [
                "success" => true,
                "user_data" => $new_user
            ];
        }
    }
}
