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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
        $auth_key = bin2hex(random_bytes(256));

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
        if($this->login($input["email_addr"], $input["password"])["exists"]){ // user exists
            return [
                "success" => false,
                "msg" => "This email address is already taken."
            ];
        }

        $new_user = new UserEntity($input);

        $this->insert($new_user);

        return [
            "success" => true,
        ];
    }
}
